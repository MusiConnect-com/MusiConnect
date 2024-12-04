CREATE VIEW VwVisualizarFotosGaleria
AS
SELECT U.UsuarioId, PM.MidiaTitulo, PM.MidiaDestino, M.MidiaNome, M.MidiaCaminho, TM.TipoMidiaNome
FROM TbUsuario U
INNER JOIN TbUsuarioMusico UM ON U.UsuarioId = UM.UsuarioId
INNER JOIN TbPerfilMidia PM ON U.UsuarioId = PM.UsuarioId
INNER JOIN TbMidia M ON PM.MidiaId = M.MidiaId
INNER JOIN TbTipoMidia TM ON M.TipoMidiaId = TM.TipoMidiaId;
