CREATE TABLE temas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    estilos_titulo TEXT DEFAULT NULL,
    clases_titulo TEXT DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE filas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    estilos_titulo TEXT DEFAULT NULL,
    clases_titulo TEXT DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    columnas INT(11) NOT NULL DEFAULT 4,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE columnas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    id_fila INT(11) DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    align VARCHAR(255) NOT NULL DEFAULT 'start',
    valign VARCHAR(255) NOT NULL DEFAULT 'start',
    distribution VARCHAR(255) NOT NULL DEFAULT 'wrap',
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE elements (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    id_fila INT(11) DEFAULT NULL,
    id_columna INT(11) DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    tag VARCHAR(255) DEFAULT NULL,
    content TEXT DEFAULT NULL,
    url TEXT DEFAULT NULL,
    link INT(11) DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE back_temas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    estilos_titulo TEXT DEFAULT NULL,
    clases_titulo TEXT DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE back_filas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    titulo VARCHAR(255) DEFAULT NULL,
    estilos_titulo TEXT DEFAULT NULL,
    clases_titulo TEXT DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    columnas INT(11) NOT NULL DEFAULT 4,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE back_columnas (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    id_fila INT(11) DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    align VARCHAR(255) NOT NULL DEFAULT 'start',
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE back_elements (
    id INT(11)  NOT NULL AUTO_INCREMENT,
    id_docente INT(11) DEFAULT NULL,
    id_curso INT(11) DEFAULT NULL,
    id_modulo INT(11) DEFAULT NULL,
    id_clase INT(11) DEFAULT NULL,
    id_tema INT(11) DEFAULT NULL,
    id_fila INT(11) DEFAULT NULL,
    id_columna INT(11) DEFAULT NULL,
    numero INT(11) DEFAULT NULL,
    clases TEXT DEFAULT NULL,
    estilos TEXT DEFAULT NULL,
    tag VARCHAR(255) DEFAULT NULL,
    content TEXT DEFAULT NULL,
    PRIMARY KEY(id)

)ENGINE=MyISAM DEFAULT CHARSET=utf8;





