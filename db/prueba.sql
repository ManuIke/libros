------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS autores CASCADE;

CREATE TABLE autores
(
    id     bigserial    PRIMARY KEY
  , nombre varchar(255) NOT NULL
);

DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
    id       bigserial    PRIMARY KEY
  , isbn     varchar(13)  NOT NULL UNIQUE
  , titulo   varchar(255) NOT NULL
  , anyo     numeric(4)   CONSTRAINT ck_anyo_positivo CHECK (anyo >= 0)
  , autor_id bigint       NOT NULL REFERENCES autores (id)
);

INSERT INTO autores (nombre)
VALUES ('Antonio')
     , ('Juan')
     , ('Pepe')
     , ('María');

INSERT INTO libros (isbn, titulo, anyo, autor_id)
VALUES ('123123123', 'Cómo aprender PHP', 2020, 1)
     , ('121321321', 'Cómo olvidar PHP', 2017, 2)
     , ('221321321', 'Cómo olvidar PHP', 2017, 2)
     , ('421321321', 'Cómo olvidar PHP', 2017, 1)
     , ('521321321', 'Cómo olvidar PHP', 2017, 3)
     , ('621321321', 'Cómo olvidar PHP', 2017, 2)
     , ('721321321', 'Cómo olvidar PHP', 2017, 1)
     , ('821321321', 'Cómo olvidar PHP', 2017, 2)
     , ('921321321', 'Cómo olvidar PHP', 2017, 2)
     , ('331321321', 'Cómo olvidar PHP', 2017, 3)
     , ('341321321', 'Cómo olvidar PHP', 2017, 1)
     , ('351321321', 'Cómo olvidar PHP', 2017, 2)
     , ('361321321', 'Cómo olvidar PHP', 2017, 2);
