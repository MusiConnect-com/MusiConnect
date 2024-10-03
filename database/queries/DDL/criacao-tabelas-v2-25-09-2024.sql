CREATE TABLE TbEstado (
EstadoUf CHAR(2),
EstadoNome VARCHAR(150) NOT NULL,

CONSTRAINT PkEstadoUf PRIMARY KEY (EstadoUf),
CONSTRAINT UqEstadoNome UNIQUE (EstadoNome)
);

CREATE TABLE TbCidade (
CidadeId SMALLINT IDENTITY(1,1),
CidadeNome VARCHAR(255) NOT NULL,
EstadoUf CHAR(2) NOT NULL,

CONSTRAINT PkCidadeId PRIMARY KEY (CidadeId),
CONSTRAINT FkEstadoUfTbCidade FOREIGN KEY (EstadoUf) REFERENCES TbEstado (EstadoUf)
);

CREATE TABLE TbUsuario (
UsuarioId SMALLINT IDENTITY(1,1),
UsuarioCpf CHAR(11) NOT NULL,
UsuarioEmail VARCHAR(255) NOT NULL,
UsuarioTipo CHAR(1) NOT NULL,
UsuarioNome VARCHAR(100) NOT NULL,
UsuarioSobrenome VARCHAR(100) NOT NULL,
UsuarioDataNasc DATE,
UsuarioSexo CHAR(1),
UsuarioEndLogra VARCHAR(255),
UsuarioEndNum SMALLINT,
UsuarioEndComp VARCHAR(255),
UsuarioEndBai VARCHAR(255),
UsuarioEndCep CHAR(8),
CidadeId SMALLINT,
UsuarioDataCad DATETIME NOT NULL,

CONSTRAINT PkUsuarioId PRIMARY KEY (UsuarioId),
CONSTRAINT UqUsuarioCpf UNIQUE (UsuarioCpf),
CONSTRAINT UqUsuarioEmail UNIQUE (UsuarioEmail),
CONSTRAINT CkUsuarioTipo CHECK (UsuarioTipo IN ('M', 'C')),
CONSTRAINT CkUsuarioSexo CHECK (UsuarioSexo IN ('M', 'F', 'N')),
CONSTRAINT FkCidadeIdTbUsuario FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

CREATE TABLE TbSenha (
SenhaId SMALLINT IDENTITY(1,1),
UsuarioId SMALLINT NOT NULL,
SenhaHash VARCHAR(255) NOT NULL,
SenhaDataAlt DATETIME NOT NULL,
SenhaStatus BIT NOT NULL,

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

CREATE TABLE TbHabilidade (
HabilidadeId SMALLINT IDENTITY(1,1),
HabilidadeNome VARCHAR(255) NOT NULL,
HabilidadeDesc TEXT,

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
GeneroMuNome VARCHAR(255) NOT NULL,
GeneroMuDesc TEXT,

CONSTRAINT PkGeneroMuId PRIMARY KEY (GeneroMuId),
CONSTRAINT UqGeneroMuNome UNIQUE (GeneroMuNome)
);

CREATE TABLE TbUsuarioGeneroMu (
UsuarioId SMALLINT NOT NULL,
GeneroMuId SMALLINT NOT NULL,

CONSTRAINT PkUsuarioIdGeneroMuId PRIMARY KEY (UsuarioId, GeneroMuId),
CONSTRAINT FkUsuarioIdTbUGM FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
CONSTRAINT FkGeneroMuIdTbUGM FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
);

CREATE TABLE TbRedeSocial (
RedeSocialId SMALLINT IDENTITY(1,1),
UsuarioId SMALLINT NOT NULL,
RedeSocialNome VARCHAR(255) NOT NULL,
RedeSocialUrl TEXT NOT NULL,

CONSTRAINT PkRedeSocialId PRIMARY KEY (RedeSocialId),
CONSTRAINT FkUsuarioIdTbRedeSocial FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId)
);

CREATE TABLE TbTipoEvento (
    TipoEventoId SMALLINT IDENTITY(1,1),
    TipoEventoNome VARCHAR(255) NOT NULL,
    TipoEventoDescricao TEXT,

    CONSTRAINT PkTipoEventoId PRIMARY KEY (TipoEventoId),
    CONSTRAINT UqTipoEventoNome UNIQUE (TipoEventoNome)
);

CREATE TABLE TbAnuncio (
    AnuncioId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioDataHora DATETIME NOT NULL,
    AnuncioValidade DATE NOT NULL,
    TipoEventoId SMALLINT NOT NULL,
    AnuncioLogradouro VARCHAR(255),
    AnuncioNumero SMALLINT,
    AnuncioComplemento VARCHAR(255),
    AnuncioBairro VARCHAR(255),
    AnuncioCep CHAR(8),
    CidadeId SMALLINT NOT NULL,
    AnuncioDescricao TEXT,
    AnuncioValor DECIMAL(10,2) NOT NULL,

    CONSTRAINT PkAnuncioId PRIMARY KEY (AnuncioId),
    CONSTRAINT FkUsuarioIdTbAnuncio FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkTipoEventoIdTbAnuncio FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkCidadeIdTbAnuncio FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
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

    CONSTRAINT PkAnuncioIdGeneroMusId PRIMARY KEY (AnuncioId, GeneroMuId),
    CONSTRAINT FkAnuncioIdTbAGM FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkGeneroMuIdTbAGM FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
);

CREATE TABLE TbContrato (
    ContratoId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioId SMALLINT,
    ContratoDataHora DATETIME NOT NULL,
    ContratoDataHoraAtividade DATETIME NOT NULL,
    ContratoDescricaoAtividade TEXT,
    TipoEventoId SMALLINT NOT NULL,
    ContratoLogradouro VARCHAR(255),
    ContratoNumero SMALLINT,
    ContratoComplemento VARCHAR(255),
    ContratoBairro VARCHAR(255),
    ContratoCep CHAR(8),
    CidadeId SMALLINT NOT NULL,
    ContratoValor DECIMAL(10,2) NOT NULL,
    ContratoPenalidade TEXT,
    ContratoStatus BIT NOT NULL, 

    CONSTRAINT PkContratoId PRIMARY KEY (ContratoId),
    CONSTRAINT FkUsuarioIdTbContrato FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkAnuncioIdTbContrato FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkTipoEventoIdTbContrato FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkCidadeIdTbContrato FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

