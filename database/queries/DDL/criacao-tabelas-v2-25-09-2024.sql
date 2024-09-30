CREATE TABLE TbUsuario (
UsuarioId SMALLINT IDENTITY(1,1),
UsuarioCpf CHAR(11),
UsuarioEmail VARCHAR(100) NOT NULL,
SenhaId SMALLINT NOT NULL,
UsuarioTipo CHAR(1) NOT NULL,
UsuarioNome VARCHAR(50) NOT NULL,
UsuarioSobrenome VARCHAR(80) NOT NULL,
UsuarioDataNasc DATE,
UsuarioSexo CHAR(1),
UsuarioEndLogra VARCHAR(100),
UsuarioEndNum SMALLINT,
UsuarioEndComp VARCHAR(150),
UsuarioEndBai VARCHAR(100),
UsuarioEndCep CHAR(8),
CidadeId SMALLINT,
UsuarioDataCad DATETIME,

CONSTRAINT PkUsuario PRIMARY KEY (UsuarioId),
CONSTRAINT UqUsuarioCpf UNIQUE (UsuarioCpf),
CONSTRAINT UqUsuarioEmail UNIQUE (UsuarioEmail),
CONSTRAINT FkUsuarioSenha FOREIGN KEY (SenhaId) REFERENCES TbSenha (SenhaId),
CONSTRAINT CkUsuarioTipo CHECK (UsuarioTipo IN ('M', 'C')),
CONSTRAINT CkUsuarioSexo CHECK (UsuarioSexo IN ('M', 'F', 'N')),
CONSTRAINT FkUsuarioCidade FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
)

CREATE TABLE TbSenha (
SenhaId SMALLINT IDENTITY(1,1),
SenhaHash VARCHAR(255) NOT NULL,
SenhaDataAlt DATETIME,
SenhaStatus CHAR(1) NOT NULL,

CONSTRAINT PkSenhaId PRIMARY KEY (SenhaId),
CONSTRAINT CkSenhaStatus CHECK (SenhaStatus IN ('1', '0'))
)

CREATE TABLE TbCidade (
CidadeId SMALLINT IDENTITY(1,1),
CidadeNome VARCHAR(150) NOT NULL,
EstadoUf CHAR(2) NOT NULL,

CONSTRAINT PkCidadeId PRIMARY KEY (CidadeId),
CONSTRAINT FkCidadeUf FOREIGN KEY (EstadoUf) REFERENCES TbEstado (EstadoUf)
)

CREATE TABLE TbEstado (
EstadoUf CHAR(2),
EstadoNome VARCHAR(150) NOT NULL,

CONSTRAINT PkEstadoUf PRIMARY KEY (EstadoUf),
CONSTRAINT UqNomeEstado UNIQUE (EstadoNome)
)

CREATE TABLE TbTelefone (
TelefoneId SMALLINT IDENTITY(1,1),
UsuarioId SMALLINT NOT NULL,
TelefoneNum CHAR(11) NOT NULL,

CONSTRAINT PkTelefoneId PRIMARY KEY (TelefoneId),
CONSTRAINT FkTelefoneUsuario FOREIGN KEY (UsuarioId) REFERENCES TbUsuario(UsuarioId),
CONSTRAINT UqTelefoneNum UNIQUE (TelefoneNum)
)

CREATE TABLE TbHabilidade (
HabilidadeId SMALLINT IDENTITY(1,1),
HabilidadeNome VARCHAR(100) NOT NULL,
HabilidadeDesc VARCHAR(255),

CONSTRAINT PkHabilidadeId PRIMARY KEY (HabilidadeId),
CONSTRAINT UqHabilidadeNome UNIQUE (HabilidadeNome)
)

CREATE TABLE TbUsuarioHabilidade (
UsuarioId SMALLINT NOT NULL,
HabilidadeId SMALLINT NOT NULL,

CONSTRAINT PkUsuarioHabilidade PRIMARY KEY (UsuarioId, HabilidadeId),
CONSTRAINT FkHabUsuarioId FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
CONSTRAINT FkUsuHabilidadeId FOREIGN KEY (HabilidadeId) REFERENCES TbHabilidade (HabilidadeId)
)

CREATE TABLE TbGeneroMusical (
GeneroMuId SMALLINT IDENTITY(1,1),
GeneroMuNome VARCHAR(100) NOT NULL,
GeneroMuDesc VARCHAR(255),

CONSTRAINT PkGeneroMuId PRIMARY KEY (GeneroMuId),
CONSTRAINT UqGeneroMuNome UNIQUE (GeneroMuNome)
)

CREATE TABLE TbUsuarioGeneroMu (
UsuarioId SMALLINT NOT NULL,
GeneroMuId SMALLINT NOT NULL,

CONSTRAINT PkUsuarioGeneroMusical PRIMARY KEY (UsuarioId, GeneroMuId),
CONSTRAINT FkGeneroMusicalUsuarioId FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
CONSTRAINT FkUsuarioGeneroMusicalId FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
)

CREATE TABLE TbRedeSocial (
RedeSocialId SMALLINT IDENTITY(1,1),
UsuarioId SMALLINT NOT NULL,
RedeSocialNome VARCHAR(100) NOT NULL,
RedeSocialUrl VARCHAR(1000) NOT NULL,

CONSTRAINT PkRedeSocialId PRIMARY KEY (RedeSocialId),
CONSTRAINT FkRedeSocialUsuarioId FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId)
)

CREATE TABLE TbAnuncio (
    AnuncioId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioDataHora DATETIME NOT NULL,
    AnuncioValidade DATE NOT NULL,
    TipoEventoId SMALLINT NOT NULL,
    AnuncioLogradouro VARCHAR(100),
    AnuncioNumero SMALLINT,
    AnuncioComplemento VARCHAR(150),
    AnuncioBairro VARCHAR(100),
    AnuncioCep CHAR(8),
    CidadeId SMALLINT NOT NULL,
    AnuncioDescricao VARCHAR(255),
    AnuncioValor DECIMAL(10,2) NOT NULL,

    CONSTRAINT PkAnuncioId PRIMARY KEY (AnuncioId),
    CONSTRAINT FkAnuncioUsuarioId FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkAnuncioTipoEventoId FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkAnuncioCidadeId FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

CREATE TABLE TbAnuncioHabilidade (
    AnuncioId SMALLINT NOT NULL,
    HabilidadeId SMALLINT NOT NULL,

    CONSTRAINT PkAnuncioHabilidadeId PRIMARY KEY (AnuncioId, HabilidadeId),
    CONSTRAINT FkAnuncioHabilidadeAnuncioId FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkAnuncioHabilidadeHabilidadeId FOREIGN KEY (HabilidadeId) REFERENCES TbHabilidade (HabilidadeId)
);

CREATE TABLE TbAnuncioGeneroMusical (
    AnuncioId SMALLINT NOT NULL,
    GeneroMuId SMALLINT NOT NULL,

    CONSTRAINT PkAnuncioGeneroMusicalId PRIMARY KEY (AnuncioId, GeneroMuId),
    CONSTRAINT FkAnuncioGeneroMusicalAnuncioId FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkAnuncioGeneroMusicalGeneroId FOREIGN KEY (GeneroMuId) REFERENCES TbGeneroMusical (GeneroMuId)
);

CREATE TABLE TbContrato (
    ContratoId SMALLINT IDENTITY(1,1),
    UsuarioId SMALLINT NOT NULL,
    AnuncioId SMALLINT,
    ContratoDataHora DATETIME NOT NULL,
    ContratoDataHoraAtividade DATETIME NOT NULL,
    ContratoDescricaoAtividade VARCHAR(255),
    TipoEventoId SMALLINT NOT NULL,
    ContratoLogradouro VARCHAR(100),
    ContratoNumero SMALLINT,
    ContratoComplemento VARCHAR(150),
    ContratoBairro VARCHAR(100),
    ContratoCep CHAR(8),
    CidadeId SMALLINT NOT NULL,
    ContratoValor DECIMAL(10,2) NOT NULL,
    ContratoPenalidade VARCHAR(255),
    ContratoStatus CHAR(1) NOT NULL, 

    CONSTRAINT PkContratoId PRIMARY KEY (ContratoId),
    CONSTRAINT FkContratoUsuarioId FOREIGN KEY (UsuarioId) REFERENCES TbUsuario (UsuarioId),
    CONSTRAINT FkContratoAnuncioId FOREIGN KEY (AnuncioId) REFERENCES TbAnuncio (AnuncioId),
    CONSTRAINT FkContratoTipoEventoId FOREIGN KEY (TipoEventoId) REFERENCES TbTipoEvento (TipoEventoId),
    CONSTRAINT FkContratoCidadeId FOREIGN KEY (CidadeId) REFERENCES TbCidade (CidadeId)
);

CREATE TABLE TbTipoEvento (
    TipoEventoId SMALLINT IDENTITY(1,1),
    TipoEventoNome VARCHAR(100) NOT NULL,
    TipoEventoDescricao VARCHAR(255),

    CONSTRAINT PkTipoEventoId PRIMARY KEY (TipoEventoId),
    CONSTRAINT UqTipoEventoNomeId UNIQUE (TipoEventoNome)
);
