CREATE PROCEDURE SpInserirUsuarioCompleto
    @Cpf NVARCHAR(11),
    @Email NVARCHAR(255),
    @UsuarioTipo CHAR(1),
    @Nome NVARCHAR(50),
    @Sobrenome NVARCHAR(50),
    @DataNascimento DATE,
    @Sexo CHAR(1),
    @CidadeId INT,
    @Logradouro NVARCHAR(100),
    @Numero NVARCHAR(10),
    @Complemento NVARCHAR(50),
    @Bairro NVARCHAR(50),
    @Cep NVARCHAR(8),
    @SenhaHash NVARCHAR(255),
    @FotoNome NVARCHAR(255),
    @FotoCaminho NVARCHAR(255),
    @FotoTamanho INT,
    @Descricao NVARCHAR(500) = NULL,
    @ValorServico DECIMAL(10, 2) = NULL,
    @HabilidadeId INT = NULL,
    @GeneroMusicalId INT = NULL
AS
BEGIN
    BEGIN TRANSACTION;

    BEGIN TRY
        -- Inserção do usuário
        INSERT INTO TbUsuario (UsuarioCpf, UsuarioEmail, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataNasc, UsuarioSexo, CidadeId, UsuarioEnderecoLogra, UsuarioEnderecoNum, UsuarioEnderecoComp, UsuarioEnderecoBai, UsuarioEnderecoCep)
        VALUES (@Cpf, @Email, @UsuarioTipo, @Nome, @Sobrenome, @DataNascimento, @Sexo, @CidadeId, @Logradouro, @Numero, @Complemento, @Bairro, @Cep);

        DECLARE @UsuarioId INT = SCOPE_IDENTITY();

        -- Inserção da senha
        INSERT INTO TbSenha (UsuarioId, SenhaHash) VALUES (@UsuarioId, @SenhaHash);

        -- Inserção de mídia, se fornecida
        IF @FotoCaminho IS NOT NULL
        BEGIN
            INSERT INTO TbMidia (MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTamanho)
            VALUES (@FotoNome, 1, @FotoCaminho, @FotoTamanho);

            DECLARE @MidiaId INT = SCOPE_IDENTITY();
			
            INSERT INTO TbPerfilMidia (UsuarioId, MidiaId) VALUES (@UsuarioId, @MidiaId);
        END

        -- Inserções específicas para músicos
        IF @UsuarioTipo = 'M'
        BEGIN
            INSERT INTO TbUsuarioMusico (UsuarioId, UsuarioDesc, UsuarioPreco) VALUES (@UsuarioId, @Descricao, @ValorServico);

            IF @HabilidadeId IS NOT NULL
                INSERT INTO TbUsuarioHabilidade (UsuarioId, HabilidadeId) VALUES (@UsuarioId, @HabilidadeId);

            IF @GeneroMusicalId IS NOT NULL
                INSERT INTO TbUsuarioGeneroMu (UsuarioId, GeneroMuId) VALUES (@UsuarioId, @GeneroMusicalId);
        END

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        ROLLBACK TRANSACTION;
        THROW;
    END CATCH
END;

CREATE PROCEDURE SpConsultarCadastro
    @UsuarioCpf VARCHAR(20),                  -- Parâmetro para CPF do usuário
    @UsuarioEmail VARCHAR(100),                -- Parâmetro para o e-mail do usuário
    @cpfErrorMessage VARCHAR(255) OUTPUT,      -- Parâmetro de saída para mensagem de erro de CPF
    @emailErrorMessage VARCHAR(255) OUTPUT     -- Parâmetro de saída para mensagem de erro de e-mail
AS
BEGIN
    BEGIN TRY
        BEGIN TRANSACTION;  -- Inicia uma transação para garantir que as alterações sejam atômicas

        -- Verifica se o CPF já está cadastrado
        IF EXISTS (SELECT 1 FROM TbUsuario WHERE UsuarioCpf = @UsuarioCpf)
        BEGIN
            SET @cpfErrorMessage = 'CPF já cadastrado.';   -- Define a mensagem de erro para CPF
            THROW 50000, 'CPF já cadastrado.', 1;           -- Lança um erro, interrompendo a execução e fazendo o rollback
        END

        -- Verifica se o e-mail já está cadastrado
        IF EXISTS (SELECT 1 FROM TbUsuario WHERE UsuarioEmail = @UsuarioEmail)
        BEGIN
            SET @emailErrorMessage = 'Email já cadastrado'; -- Define a mensagem de erro para e-mail
            THROW 50001, 'Email já cadastrado.', 1;          -- Lança um erro, interrompendo a execução e fazendo o rollback
        END

        -- Caso não haja erro, confirma a transação
        COMMIT TRANSACTION;   -- Finaliza a transação, aplicando todas as mudanças
    END TRY
    BEGIN CATCH
        -- Se ocorrer algum erro, faz o rollback (desfaz as alterações)
        ROLLBACK TRANSACTION;

        -- Trata erros específicos de CPF e e-mail
        IF ERROR_NUMBER() = 50000
        BEGIN
            -- Se o erro foi de CPF duplicado, atribui a mensagem de erro a @cpfErrorMessage
            SET @cpfErrorMessage = ERROR_MESSAGE();
        END
        ELSE IF ERROR_NUMBER() = 50001
        BEGIN
            -- Se o erro foi de e-mail duplicado, atribui a mensagem de erro a @emailErrorMessage
            SET @emailErrorMessage = ERROR_MESSAGE();
        END
        ELSE
        BEGIN
            -- Se for um erro inesperado, define mensagens genéricas para CPF e e-mail
            SET @cpfErrorMessage = 'Ocorreu um erro inesperado.';
            SET @emailErrorMessage = 'Ocorreu um erro inesperado.';
        END
    END CATCH
END
