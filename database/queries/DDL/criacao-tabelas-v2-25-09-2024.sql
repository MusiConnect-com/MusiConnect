CREATE TABLE TbEstado (
    EstadoUf CHAR(2),
    EstadoNome NVARCHAR(255) NOT NULL,

    CONSTRAINT PkEstadoUf PRIMARY KEY (EstadoUf),
    CONSTRAINT UqEstadoNome UNIQUE (EstadoNome)
);

CREATE TABLE TbCidade (
    CidadeId SMALLINT IDENTITY(1,1),
    CidadeNome NVARCHAR(255) NOT NULL,
    EstadoUf CHAR(2) NOT NULL,

    CONSTRAINT PkCidadeId PRIMARY KEY (CidadeId),
    CONSTRAINT FkEstadoUfTbCidade FOREIGN KEY (EstadoUf) REFERENCES TbEstado (EstadoUf)
);

CREATE TABLE TbUsuario (
    UsuarioId SMALLINT IDENTITY(1,1),
    UsuarioCpf CHAR(11) NOT NULL,
    UsuarioEmail NVARCHAR(255) NOT NULL,
    UsuarioTipo CHAR(1) NOT NULL,
    UsuarioNome NVARCHAR(255) NOT NULL,
    UsuarioSobrenome NVARCHAR(255) NOT NULL,
    UsuarioDataNasc DATE NOT NULL,
    UsuarioSexo CHAR(1) NOT NULL,
	CidadeId SMALLINT NOT NULL,
    UsuarioEnderecoLogra NVARCHAR(255),
    UsuarioEnderecoNum SMALLINT,
    UsuarioEnderecoComp NVARCHAR(255),
    UsuarioEnderecoBai NVARCHAR(255),
    UsuarioEnderecoCep CHAR(8),
    UsuarioDataCad DATETIME NOT NULL DEFAULT GETDATE(),

    CONSTRAINT PkUsuarioId PRIMARY KEY (UsuarioId),
    CONSTRAINT UqUsuarioCpf UNIQUE (UsuarioCpf),
    CONSTRAINT UqUsuarioEmail UNIQUE (UsuarioEmail),
    CONSTRAINT CkUsuarioTipo CHECK (UsuarioTipo IN ('M', 'C')),
    CONSTRAINT CkUsuarioSexo CHECK (UsuarioSexo IN ('M', 'F', 'N')),
    CONSTRAINT FkCidadeIdTbUsuario FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

CREATE TABLE TbUsuarioMusico (
    UsuarioMuId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
	UsuarioNomeArt NVARCHAR(255),
    UsuarioDesc NVARCHAR(255),
    UsuarioPreco DECIMAL(10,2),

    CONSTRAINT PkUsuarioMuId PRIMARY KEY (UsuarioMuId),
    CONSTRAINT FKUsuarioIdTbUsuarioMusico FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId)
);

CREATE TABLE TbSenha (
    SenhaId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    SenhaHash NVARCHAR(255) NOT NULL,
    SenhaDataAlt DATETIME NOT NULL DEFAULT GETDATE(),
    SenhaStatus BIT NOT NULL DEFAULT 1,

    CONSTRAINT PkSenhaId PRIMARY KEY (SenhaId),
    CONSTRAINT FKUsuarioIdTbSenha FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId)
);

CREATE TABLE TbTelefone (
    TelefoneId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    TelefoneNum CHAR(11) NOT NULL,

    CONSTRAINT PkTelefoneId PRIMARY KEY (TelefoneId),
    CONSTRAINT FkUsuarioIdTbTelefone FOREIGN KEY (UsuarioId) REFERENCES TbUsuario(UsuarioId),
    CONSTRAINT UqTelefoneNum UNIQUE (TelefoneNum)
);

CREATE TABLE TbRedeSocial (
    RedeSocialId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    RedeSocialNome NVARCHAR(255) NOT NULL,
    RedeSocialUrl NVARCHAR(850) NOT NULL,

    CONSTRAINT PkRedeSocialId PRIMARY KEY (RedeSocialId),
    CONSTRAINT FkUsuarioIdTbRedeSocial FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
	CONSTRAINT UqRedeSocialUrl UNIQUE (RedeSocialUrl)
); 

CREATE TABLE TbHabilidade (
    HabilidadeId SMALLINT IDENTITY(1,1),
    HabilidadeNome NVARCHAR(255) NOT NULL,
    HabilidadeDesc NVARCHAR(255),

    CONSTRAINT PkHabilidadeId PRIMARY KEY (HabilidadeId),
    CONSTRAINT UqHabilidadeNome UNIQUE (HabilidadeNome)
);

CREATE TABLE TbUsuarioHabilidade (
    UsuarioId SMALLINT NOT NULL,
    HabilidadeId SMALLINT NOT NULL, 

    CONSTRAINT PkUsuarioIdHabilidadeId PRIMARY KEY (UsuarioId, HabilidadeId),
    CONSTRAINT FkUsuarioIdTbUH FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkHabilidadeIdTbUH FOREIGN KEY (HabilidadeId) REFERENCES TbHabilidade (HabilidadeId)
);

CREATE TABLE TbGeneroMusical (
    GeneroMuId SMALLINT IDENTITY(1,1),
    GeneroMuNome NVARCHAR(255) NOT NULL,
    GeneroMuDesc NVARCHAR(255),

    CONSTRAINT PkGeneroMuId PRIMARY KEY (GeneroMuId),
    CONSTRAINT UqGeneroMuNome UNIQUE (GeneroMuNome)
);

CREATE TABLE TbUsuarioGeneroMusical (
    UsuarioId SMALLINT NOT NULL,
    GeneroMuId SMALLINT NOT NULL,

    CONSTRAINT PkUsuarioIdGeneroMuId PRIMARY KEY (UsuarioId, GeneroMuId),
    CONSTRAINT FkUsuarioIdTbUGM FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkGeneroMuIdTbUGM FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
);

CREATE TABLE TbTipoEvento (
    TipoEventoId SMALLINT IDENTITY(1,1),
    TipoEventoNome NVARCHAR(255) NOT NULL,
    TipoEventoDesc NVARCHAR(255),

    CONSTRAINT PkTipoEventoId PRIMARY KEY (TipoEventoId),
    CONSTRAINT UqTipoEventoNome UNIQUE (TipoEventoNome)
);

CREATE TABLE TbAnuncio (
    AnuncioId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioDataHr DATETIME NOT NULL DEFAULT GETDATE(),
    AnuncioValidade DATE NOT NULL,
    AnuncioTitulo NVARCHAR(255) NOT NULL,
    AnuncioDataHrInicio DATETIME NOT NULL,
    AnuncioDataHrFim DATETIME NOT NULL,
    TipoEventoId SMALLINT NOT NULL,
    CidadeId SMALLINT NOT NULL,
    AnuncioEnderecoLogra NVARCHAR(255) NOT NULL,
    AnuncioEnderecoNum SMALLINT NOT NULL,
    AnuncioEnderecoComp NVARCHAR(255) NOT NULL,
    AnuncioEnderecoBai NVARCHAR(255) NOT NULL,
    AnuncioEnderecoCep CHAR(8) NOT NULL,
    AnuncioDesc NVARCHAR(255) NOT NULL,
    AnuncioBeneficios NVARCHAR(255),
    AnuncioContato CHAR(11) NOT NULL,
    AnuncioNomeContato NVARCHAR(255) NOT NULL,
    AnuncioValor DECIMAL(10,2) NOT NULL,
    AnuncioStatus NVARCHAR(50) NOT NULL DEFAULT 'ATIVO',

    CONSTRAINT PkAnuncioId PRIMARY KEY (AnuncioId),
    CONSTRAINT FkUsuarioIdTbAnuncio FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkTipoEventoIdTbAnuncio FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkCidadeIdTbAnuncio FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId),
    CONSTRAINT CkAnuncioStatus CHECK (AnuncioStatus IN ('ATIVO', 'DESATIVADO', 'VENCIDO', 'FINALIZADO'))
);

CREATE TABLE TbAnuncioLike (
    AnuncioId SMALLINT NOT NULL,
    UsuarioId SMALLINT NOT NULL,
    LikeData DATETIME NOT NULL DEFAULT GETDATE(),

    CONSTRAINT PkAnuncioLikeUsuarioId PRIMARY KEY (AnuncioId, UsuarioId), 
    CONSTRAINT FKUsuarioIdTbAnuncioLike FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FKAnuncioIdTbAnuncioLike FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT UqUsuarioAnuncio UNIQUE (UsuarioId, AnuncioId)
);

CREATE TABLE TbAnuncioHabilidade (
    AnuncioId SMALLINT NOT NULL,
    HabilidadeId SMALLINT NOT NULL,

    CONSTRAINT PkAnuncioIdHabilidadeId PRIMARY KEY (AnuncioId, HabilidadeId),
    CONSTRAINT FkAnuncioIdTbAH FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkHabilidadeIdTbAH FOREIGN KEY (HabilidadeId) REFERENCES TbHabilidade (HabilidadeId)
);

CREATE TABLE TbAnuncioGeneroMusical (
    AnuncioId SMALLINT NOT NULL,
    GeneroMuId SMALLINT NOT NULL,

    CONSTRAINT PkAnuncioIdGeneroMuId PRIMARY KEY (AnuncioId, GeneroMuId),
    CONSTRAINT FkAnuncioIdTbAGM FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkGeneroMuIdTbAGM FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
);

-- Tabela TbTipoMidia
CREATE TABLE TbTipoMidia (
    TipoMidiaId SMALLINT IDENTITY(1,1),
    TipoMidiaNome NVARCHAR(255) NOT NULL,
    TipoMidiaDesc NVARCHAR(255),
    
    CONSTRAINT UqTipoMidiaNome UNIQUE (TipoMidiaNome),
    CONSTRAINT PkTipoMidiaId PRIMARY KEY (TipoMidiaId)
);

-- Tabela TbMidia
CREATE TABLE TbMidia (
    MidiaId SMALLINT IDENTITY(1,1),
    MidiaNome NVARCHAR(255) NOT NULL,
    TipoMidiaId SMALLINT NOT NULL,
    MidiaCaminho NVARCHAR(255) NOT NULL,
    MidiaTamanho INT NOT NULL,
    MidiaDataUpload DATETIME NOT NULL DEFAULT GETDATE(),
    
    CONSTRAINT PkMidiaId PRIMARY KEY (MidiaId),
    CONSTRAINT FkTipoMidiaIdTbMidia FOREIGN KEY (TipoMidiaId) REFERENCES TbTipoMidia (TipoMidiaId),
	CONSTRAINT UqMidiaCaminho UNIQUE (MidiaCaminho)
);

-- Tabela TbPerfilMidia
CREATE TABLE TbPerfilMidia (
    UsuarioId SMALLINT NOT NULL,
    MidiaId SMALLINT NOT NULL,
    MidiaTitulo NVARCHAR(255),
	MidiaDestino NVARCHAR(255) NOT NULL DEFAULT 'perfil',
    MidiaDataUpload DATETIME NOT NULL DEFAULT GETDATE(),
    
    CONSTRAINT PkPerfilMidia PRIMARY KEY (UsuarioId, MidiaId),
    CONSTRAINT FkUsuarioIdTbPerfilMidia FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkMidiaIdTbPerfilMidia FOREIGN KEY (MidiaId) REFERENCES TbMidia (MidiaId),
	CONSTRAINT CkMidiaDestino CHECK (MidiaDestino IN ('perfil', 'galeria'))
);

-- Tabela TbAnuncioMidia
CREATE TABLE TbAnuncioMidia (
    AnuncioId SMALLINT NOT NULL,
    MidiaId SMALLINT NOT NULL,

    CONSTRAINT PkAnuncioMidia PRIMARY KEY (AnuncioId, MidiaId),
    CONSTRAINT FkAnuncioIdTbAnuncioMidia FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkMidiaIdTbAnuncioMidia FOREIGN KEY (MidiaId) REFERENCES TbMidia (MidiaId)
);

SELECT * FROM TbUsuario;
SELECT * FROM TbUsuarioMusico;
SELECT * FROM TbSenha;
SELECT * FROM TbUsuarioHabilidade;
SELECT * FROM TbUsuarioGeneroMusical;
SELECT * FROM TbMidia;
SELECT * FROM TbPerfilMidia;
SELECT * FROM TbTipoMidia;
SELECT * FROM TbTelefone;

SELECT * FROM TbAnuncio;
SELECT * FROM TbAnuncioMidia;
SELECT * FROM TbAnuncioGeneroMusical;
SELECT * FROM TbAnuncioHabilidade;
