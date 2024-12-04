USE [DbMusicConnect]
GO

/****** Object:  View [dbo].[VwVisualizarPerfis]    Script Date: 28/11/2024 12:43:17 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

ALTER VIEW [dbo].[VwVisualizarPerfis]
AS
SELECT U.UsuarioId, U.UsuarioTipo, U.UsuarioNome, U.UsuarioSobrenome, U.UsuarioDataNasc, U.UsuarioSexo, C.CidadeNome, E.EstadoUf, UM.UsuarioMuId, UM.UsuarioNomeArt,
		UM.UsuarioDesc, UM.UsuarioPreco, T.TelefoneNum, RS.RedeSocialNome, RS.RedeSocialURL, H.HabilidadeNome, GM.GeneroMuNome, 
		M.MidiaNome, M.MidiaCaminho, TM.TipoMidiaNome, PM.MidiaDestino
FROM TbUsuario U
INNER JOIN TbUsuarioMusico UM ON U.UsuarioId = UM.UsuarioId
INNER JOIN TbCidade C ON U.CidadeId = C.CidadeId
INNER JOIN TbEstado E ON C.EstadoUf = E.EstadoUf
LEFT JOIN TbPerfilMidia PM ON U.UsuarioId = PM.UsuarioId
LEFT JOIN TbMidia M ON PM.MidiaId = M.MidiaId
LEFT JOIN TbTipoMidia TM ON M.TipoMidiaId = TM.TipoMidiaId
INNER JOIN TbTelefone T ON U.UsuarioId = T.UsuarioId
LEFT JOIN TbUsuarioHabilidade UH ON U.UsuarioId = UH.UsuarioId
LEFT JOIN TbHabilidade H ON UH.HabilidadeId = H.HabilidadeId
LEFT JOIN TbUsuarioGeneroMusical UGM ON U.UsuarioId = UGM.UsuarioId
LEFT JOIN TbGeneroMusical GM ON UGM.GeneroMuId = GM.GeneroMuId
LEFT JOIN TbRedeSocial RS ON U.UsuarioId = RS.UsuarioId;