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