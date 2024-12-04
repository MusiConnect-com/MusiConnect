-- Populando o Banco
INSERT INTO TbEstado (EstadoUf, EstadoNome)
VALUES
('SP', 'São Paulo'),
('RJ', 'Rio de Janeiro'),
('MG', 'Minas Gerais'),
('MS', 'Mato Grosso do Sul'),
('ES', 'Espírito Santo'),
('PR', 'Paraná'),
('SC', 'Santa Catarina'),
('RS', 'Rio Grande do Sul');

INSERT INTO TbCidade (CidadeNome, EstadoUf)
VALUES
('São Paulo', 'SP'),
('Rio de Janeiro', 'RJ'),
('Belo Horizonte', 'MG'),
('Campo Grande', 'MS'),
('Vitória', 'ES'),
('Curitiba', 'PR'),
('Florianópolis', 'SC'),
('Porto Alegre', 'RS');

INSERT INTO TbHabilidade (HabilidadeNome, HabilidadeDesc)
VALUES
('Canto', 'Técnicas de canto e vocal'),
('Guitarra', 'Habilidade com guitarra'),
('Bateria', 'Execução de ritmos com bateria'),
('Teclado', 'Conhecimento em teclado e piano'),
('Violão', 'Tocar violão e instrumentos de corda acústica');

INSERT INTO TbHabilidade (HabilidadeNome, HabilidadeDesc)
VALUES
('Trompete', 'Habilidade com Trompete');

INSERT INTO TbGeneroMusical (GeneroMuNome, GeneroMuDesc)
VALUES
('Rock', 'Estilo musical baseado em guitarras e baterias'),
('Pop', 'Gênero musical popular e comercial'),
('Jazz', 'Gênero musical com improvisação e complexidade harmônica'),
('Sertanejo', 'Gênero popular no Brasil com raízes rurais'),
('Funk', 'Gênero com batidas eletrônicas e letras urbanas');

INSERT INTO TbTipoEvento (TipoEventoNome, TipoEventoDesc)
VALUES
('Casamento', 'Eventos matrimoniais e festas de casamento'),
('Show', 'Apresentações musicais ao vivo para grandes públicos'),
('Aniversário', 'Festas de comemoração de aniversários'),
('Formatura', 'Celebrações de conclusão de curso'),
('Evento Corporativo', 'Eventos organizados por empresas para funcionários ou clientes');

INSERT INTO TbTipoMidia (TipoMidiaNome, TipoMidiaDesc)
VALUES
('Imagem', 'Fotos e imagens estáticas'),
('Vídeo', 'Gravações audiovisuais de eventos ou performances'),
('Documento', 'Arquivos de documentos como contratos ou textos descritivos');