CREATE TABLE perros (
    id int not null AUTO_INCREMENT,
    idPerfil int not null DEFAULT 3,
    PRIMARY KEY (id),
    CONSTRAINT fk_idPerfil FOREIGN KEY (idPerfil) REFERENCES perfiles (id)
);