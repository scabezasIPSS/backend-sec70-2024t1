CREATE DATABASE ciisa_backend_v1;
CREATE USER 'ciisa_backend_v1'@'localhost' IDENTIFIED BY 'l4cl4v3-c11s4';
GRANT ALL PRIVILEGES ON ciisa_backend_v1 . * TO 'ciisa_backend_v1'@'localhost';
FLUSH PRIVILEGES;

USE ciisa_backend_v1;

CREATE TABLE mantenedor (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE, -- COSTRAINT
    activo BOOLEAN NOT NULL DEFAULT FALSE
)

-- GET / ALL
SELECT id, nombre, activo FROM mantenedor;
-- GET / BY ID
SELECT id, nombre, activo FROM mantenedor WHERE id = 3;
-- POST
INSERT INTO mantenedor (id, nombre) VALUES (1, 'Ejemplo 1'),(2, 'Ejemplo 2'),(3, 'Ejemplo 3');
-- PATCH / ENABLE
UPDATE mantenedor SET activo = true WHERE id = 3;
-- PATCH / DISABLE
UPDATE mantenedor SET activo = false WHERE id = 3;
-- PUT
UPDATE mantenedor SET nombre = 'Example 3' WHERE id = 3;
-- DELETE
DELETE FROM mantenedor WHERE id = 3;

-- Evaluacion 1
-- mision y vision
-- titulo
-- ESP
-- ENG
-- descripcion
-- ESP
-- ENG
CREATE TABLE idiomas (
    id  INT PRIMARY KEY,
    corto VARCHAR(3) NOT NULL UNIQUE,
    nombre VARCHAR(10) NOT NULL UNIQUE,
    activo BOOLEAN DEFAULT FALSE
);
INSERT INTO idiomas (id, corto, nombre, activo) VALUES 
(1, 'esp', 'Español', true),
(2, 'eng', 'Inglés', true);


CREATE TABLE about_us (
    id  INT PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL UNIQUE,
    activo BOOLEAN DEFAULT FALSE
);
INSERT INTO about_us (id, titulo, activo) VALUES
(1, 'mision', true),
(2, 'vision', true);

CREATE TABLE about_us_idioma (
    id  INT PRIMARY KEY,
    idioma_id INT NOT NULL,
    about_us_id INT NOT NULL,
    valor_titulo VARCHAR(50) NOT NULL,
    valor_descripcion TEXT NOT NULL,
    activo BOOLEAN DEFAULT FALSE,
    CONSTRAINT fk_au_u FOREIGN KEY (idioma_id) REFERENCES idiomas (id),
    CONSTRAINT fk_au_au FOREIGN KEY (about_us_id) REFERENCES about_us (id)
);
INSERT INTO about_us_idioma (id, idioma_id, about_us_id, valor_titulo, valor_descripcion, activo) VALUES 
(1, 1, 1, 'Misión', 'Nuestra misión es ofrecer soluciones digitales innovadoras y de alta calidad que impulsen el éxito de nuestros clientes, ayudándolos a alcanzar sus objetivos empresariales a través de la tecnología y la creatividad.', true),
(2, 1, 2, 'Visión', 'Nos visualizamos como líderes en el campo de la consultoría y desarrollo de software, reconocidos por nuestra excelencia en el servicio al cliente, nuestra capacidad para adaptarnos a las necesidades cambiantes del mercado y nuestra contribución al crecimiento y la transformación digital de las empresas.', true);