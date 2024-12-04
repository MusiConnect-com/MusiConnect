CREATE PROCEDURE SpInserirFotoGaleria
	@UsuarioId INT,
	@FotoNome NVARCHAR(255),
    @FotoCaminho NVARCHAR(255),
    @FotoTamanho INT
AS
BEGIN
	BEGIN TRY
		BEGIN TRANSACTION;

		-- inserção na tabela Midia
		INSERT INTO TbMidia (MidiaNome, TipoMidiaId, MidiaCaminho, MidiaTamanho)
        VALUES (@FotoNome, 1, @FotoCaminho, @FotoTamanho);

        DECLARE @MidiaId SMALLINT = SCOPE_IDENTITY();
        INSERT INTO TbPerfilMidia (UsuarioId, MidiaId, MidiaDestino) VALUES (@UsuarioId, @MidiaId, 'galeria');
		
		COMMIT TRANSACTION;
	END TRY
	BEGIN CATCH
		ROLLBACK TRANSACTION;
		THROW;
	END CATCH
END;