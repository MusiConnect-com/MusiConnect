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
UsuarioDesc TEXT,
UsuarioPreco DECIMAL(10,2),
UsuarioDataCad DATETIME NOT NULL DEFAULT GETDATE(),

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
RedeSocialNome VARCHAR(255) NOT NULL,
RedeSocialUrl TEXT NOT NULL,

CONSTRAINT PkRedeSocialId PRIMARY KEY (RedeSocialId),
CONSTRAINT FkUsuarioIdTbRedeSocial FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId)
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


CREATE TABLE TbTipoEvento (
    TipoEventoId SMALLINT IDENTITY(1,1),
    TipoEventoNome VARCHAR(255) NOT NULL,
    TipoEventoDesc TEXT,

    CONSTRAINT PkTipoEventoId PRIMARY KEY (TipoEventoId),
    CONSTRAINT UqTipoEventoNome UNIQUE (TipoEventoNome)
);

CREATE TABLE TbAnuncio (
    AnuncioId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioDataHr DATETIME NOT NULL DEFAULT GETDATE(),
    AnuncioValidade DATE NOT NULL,
	AnuncioTitulo VARCHAR(255) NOT NULL,
	AnuncioDataHrIncio DATETIME NOT NULL,
	AnuncioDataHrFim DATETIME NOT NULL,
    TipoEventoId SMALLINT NOT NULL,
    AnuncioEndLogra VARCHAR(255) NOT NULL,
    AnuncioEndNum SMALLINT NOT NULL,
    AnuncioEndComp VARCHAR(255) NOT NULL,
    AnuncioEndBai VARCHAR(255) NOT NULL,
    AnuncioEndCep CHAR(8) NOT NULL,
    CidadeId SMALLINT NOT NULL,
    AnuncioDesc TEXT NOT NULL,
	AnuncioBeneficios TEXT,
	AnuncioContato CHAR(11),
    AnuncioValor DECIMAL(10,2) NOT NULL,
	AnuncioStatus VARCHAR(50) NOT NULL DEFAULT 'ATIVO',

    CONSTRAINT PkAnuncioId PRIMARY KEY (AnuncioId),
    CONSTRAINT FkUsuarioIdTbAnuncio FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkTipoEventoIdTbAnuncio FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkCidadeIdTbAnuncio FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId),
	CONSTRAINT CkAnuncioStatus CHECK (AnuncioStatus IN ('ATIVO', 'DESATIVADO', 'VENCIDO', 'FINALIZADO')),
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
    MusicoId SMALLINT,
	ContratanteId SMALLINT,
    AnuncioId SMALLINT,
	ContratoTitulo VARCHAR(255) NOT NULL,
    ContratoDataHr DATETIME NOT NULL DEFAULT GETDATE(),
	ContratoDataHrInicio DATETIME NOT NULL,
	ContratoDataHrFim DATETIME NOT NULL,
    ContratoDescAtiv TEXT NOT NULL,
    TipoEventoId SMALLINT NOT NULL,
    ContratoEndLogra VARCHAR(255) NOT NULL,
    ContratoEndNum SMALLINT NOT NULL,
    ContratoEndComp VARCHAR(255) NOT NULL,
    ContratoEndBai VARCHAR(255) NOT NULL,
    ContratoEndCep CHAR(8) NOT NULL,
    CidadeId SMALLINT NOT NULL,
    ContratoValor DECIMAL(10,2) NOT NULL,
    ContratoPenalidade TEXT,
    ContratoStatus BIT NOT NULL, 

    CONSTRAINT PkContratoId PRIMARY KEY (ContratoId),
    CONSTRAINT FkMusicoIdTbContrato FOREIGN KEY (MusicoId) REFERENCES TbUsuario (UsuarioId),
	CONSTRAINT FkContratanteIdTbContrato FOREIGN KEY (ContratanteId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkAnuncioIdTbContrato FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkTipoEventoIdTbContrato FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkCidadeIdTbContrato FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

-- Tabela TbTipoMidia
CREATE TABLE TbTipoMidia (
    TipoMidiaId SMALLINT IDENTITY(1,1),
    TipoMidiaNome VARCHAR(255) NOT NULL,
    TipoMidiaDesc TEXT,
    
	CONSTRAINT UqTipoMidiaNome UNIQUE (TipoMidiaNome),
    CONSTRAINT PkTipoMidiaId PRIMARY KEY (TipoMidiaId)
);

-- Tabela TbMidia
CREATE TABLE TbMidia (
    MidiaId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    MidiaNome VARCHAR(255),
    TipoMidiaId SMALLINT NOT NULL,
    MidiaCaminho VARCHAR(255) NOT NULL,
    MidiaTitulo VARCHAR(255),
    MidiaDesc TEXT,
    MidiaDataUpload DATETIME NOT NULL DEFAULT GETDATE(),
    
    CONSTRAINT PkMidiaId PRIMARY KEY (MidiaId),
    CONSTRAINT FkUsuarioIdTbMidia FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkTipoMidiaIdTbMidia FOREIGN KEY (TipoMidiaId) REFERENCES TbTipoMidia (TipoMidiaId)
);

-- Tabela TbPerfilMidia
CREATE TABLE TbPerfilMidia (
    UsuarioId SMALLINT NOT NULL,
    MidiaId SMALLINT NOT NULL,
    
    CONSTRAINT PkTbPerfilMidia PRIMARY KEY (UsuarioId, MidiaId),
    CONSTRAINT FkUsuarioIdTbPerfilMidia FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkMidiaIdTbPerfilMidia FOREIGN KEY (MidiaId) REFERENCES TbMidia (MidiaId)
);

-- Tabela TbAnuncioMidia
CREATE TABLE TbAnuncioMidia (
    AnuncioId SMALLINT NOT NULL,
    MidiaId SMALLINT NOT NULL,
    
    CONSTRAINT PkTbAnuncioMidia PRIMARY KEY (AnuncioId, MidiaId),
    CONSTRAINT FkAnuncioIdTbAnuncioMidia FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkMidiaIdTbAnuncioMidia FOREIGN KEY (MidiaId) REFERENCES TbMidia (MidiaId)
);
