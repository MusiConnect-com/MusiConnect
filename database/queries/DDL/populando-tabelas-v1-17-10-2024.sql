-- Populando o Banco
INSERT INTO TbEstado (EstadoUf, EstadoNome)
VALUES
('SP', 'S�o Paulo'),
('RJ', 'Rio de Janeiro'),
('MG', 'Minas Gerais'),
('MS', 'Mato Grosso do Sul'),
('ES', 'Esp�rito Santo'),
('PR', 'Paran�'),
('SC', 'Santa Catarina'),
('RS', 'Rio Grande do Sul');

INSERT INTO TbCidade (CidadeNome, EstadoUf)
VALUES
('S�o Paulo', 'SP'),
('Rio de Janeiro', 'RJ'),
('Belo Horizonte', 'MG'),
('Campo Grande', 'MS'),
('Vit�ria', 'ES'),
('Curitiba', 'PR'),
('Florian�polis', 'SC'),
('Porto Alegre', 'RS');

INSERT INTO TbHabilidade (HabilidadeNome, HabilidadeDesc)
VALUES
('Canto', 'T�cnicas de canto e vocal'),
('Guitarra', 'Habilidade com guitarra'),
('Bateria', 'Execu��o de ritmos com bateria'),
('Teclado', 'Conhecimento em teclado e piano'),
('Viol�o', 'Tocar viol�o e instrumentos de corda ac�stica');

INSERT INTO TbGeneroMusical (GeneroMuNome, GeneroMuDesc)
VALUES
('Rock', 'Estilo musical baseado em guitarras e baterias'),
('Pop', 'G�nero musical popular e comercial'),
('Jazz', 'G�nero musical com improvisa��o e complexidade harm�nica'),
('Sertanejo', 'G�nero popular no Brasil com ra�zes rurais'),
('Funk', 'G�nero com batidas eletr�nicas e letras urbanas');

INSERT INTO TbTipoEvento (TipoEventoNome, TipoEventoDesc)
VALUES
('Casamento', 'Eventos matrimoniais e festas de casamento'),
('Show', 'Apresenta��es musicais ao vivo para grandes p�blicos'),
('Anivers�rio', 'Festas de comemora��o de anivers�rios'),
('Formatura', 'Celebra��es de conclus�o de curso'),
('Evento Corporativo', 'Eventos organizados por empresas para funcion�rios ou clientes');

INSERT INTO TbTipoMidia (TipoMidiaNome, TipoMidiaDesc)
VALUES
('Imagem', 'Fotos e imagens est�ticas'),
('V�deo', 'Grava��es audiovisuais de eventos ou performances'),
('Documento', 'Arquivos de documentos como contratos ou textos descritivos');