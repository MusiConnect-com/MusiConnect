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
        -- Inser��o do usu�rio
        INSERT INTO TbUsuario (UsuarioCpf, UsuarioEmail, UsuarioTipo, UsuarioNome, UsuarioSobrenome, UsuarioDataNasc, UsuarioSexo, CidadeId, UsuarioEnderecoLogra, UsuarioEnderecoNum, UsuarioEnderecoComp, UsuarioEnderecoBai, UsuarioEnderecoCep)
        VALUES (@Cpf, @Email, @UsuarioTipo, @Nome, @Sobrenome, @DataNascimento, @Sexo, @CidadeId, @Logradouro, @Numero, @Complemento, @Bairro, @Cep);

        DECLARE @UsuarioId INT = SCOPE_IDENTITY();

        -- Inser��o da senha
        INSERT INTO TbSenha (UsuarioId, SenhaHash) VALUES (@UsuarioId, @SenhaHash);

        -- Inser��o de m�dia, se fornecida
        IF @FotoCaminho IS NOT NULL
        BEGIN
            INSERT INTO TbMidia (MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTamanho)
            VALUES (@FotoNome, 1, @FotoCaminho, @FotoTamanho);

            DECLARE @MidiaId INT = SCOPE_IDENTITY();
			
            INSERT INTO TbPerfilMidia (UsuarioId, MidiaId) VALUES (@UsuarioId, @MidiaId);
        END

        -- Inser��es espec�ficas para m�sicos
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
    @UsuarioCpf VARCHAR(20),                  -- Par�metro para CPF do usu�rio
    @UsuarioEmail VARCHAR(100),                -- Par�metro para o e-mail do usu�rio
    @cpfErrorMessage VARCHAR(255) OUTPUT,      -- Par�metro de sa�da para mensagem de erro de CPF
    @emailErrorMessage VARCHAR(255) OUTPUT     -- Par�metro de sa�da para mensagem de erro de e-mail
AS
BEGIN
    BEGIN TRY
        BEGIN TRANSACTION;  -- Inicia uma transa��o para garantir que as altera��es sejam at�micas

        -- Verifica se o CPF j� est� cadastrado
        IF EXISTS (SELECT 1 FROM TbUsuario WHERE UsuarioCpf = @UsuarioCpf)
        BEGIN
            SET @cpfErrorMessage = 'CPF j� cadastrado.';   -- Define a mensagem de erro para CPF
            THROW 50000, 'CPF j� cadastrado.', 1;           -- Lan�a um erro, interrompendo a execu��o e fazendo o rollback
        END

        -- Verifica se o e-mail j� est� cadastrado
        IF EXISTS (SELECT 1 FROM TbUsuario WHERE UsuarioEmail = @UsuarioEmail)
        BEGIN
            SET @emailErrorMessage = 'Email j� cadastrado'; -- Define a mensagem de erro para e-mail
            THROW 50001, 'Email j� cadastrado.', 1;          -- Lan�a um erro, interrompendo a execu��o e fazendo o rollback
        END

        -- Caso n�o haja erro, confirma a transa��o
        COMMIT TRANSACTION;   -- Finaliza a transa��o, aplicando todas as mudan�as
    END TRY
    BEGIN CATCH
        -- Se ocorrer algum erro, faz o rollback (desfaz as altera��es)
        ROLLBACK TRANSACTION;

        -- Trata erros espec�ficos de CPF e e-mail
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
            -- Se for um erro inesperado, define mensagens gen�ricas para CPF e e-mail
            SET @cpfErrorMessage = 'Ocorreu um erro inesperado.';
            SET @emailErrorMessage = 'Ocorreu um erro inesperado.';
        END
    END CATCH
END
