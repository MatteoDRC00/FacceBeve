DROP DATABASE IF EXISTS `my_faccebeve`;

CREATE DATABASE `my_faccebeve`;

GRANT ALL ON my_faccebeve.* TO faccebeve@localhost;

USE `my_faccebeve`;

/*Tabella relativa alle immagini utilizzate*/
DROP TABLE IF EXISTS `Immagine`;
CREATE TABLE `Immagine` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(50) NOT NULL,
    `size` varchar(25) NOT NULL,
    `type` varchar(25) NOT NULL,
    `immagine` longblob NOT NULL,
    PRIMARY KEY (id)
);

/*Tabella relativa agli Utenti registrati*/
DROP TABLE IF EXISTS `Utente`;

CREATE TABLE `Utente` (
    `username` VARCHAR(24) NOT NULL,
    `nome` VARCHAR(26),
    `cognome` VARCHAR(26),    
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    `dataIscrizione` CHAR(11) NOT NULL,
    `idImg` int(11) DEFAULT NULL,
    `state` tinyint(1) NOT NULL,
    FOREIGN KEY (`idImg`) REFERENCES Immagine(`id`),
    PRIMARY KEY (`username`)
);

/*Tabella relativa ai Proprietari dei Locali*/
DROP TABLE IF EXISTS `Proprietario`;

CREATE TABLE `Proprietario` (
    `username` VARCHAR(24) NOT NULL,
    `nome` VARCHAR(26),
    `cognome` VARCHAR(26),    
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    `idImg` int(11) DEFAULT NULL,
    FOREIGN KEY (`idImg`) REFERENCES Immagine(`id`),
    PRIMARY KEY (`username`)
);

/*Tabella relativa agli Admin del sito*/
DROP TABLE IF EXISTS `Admin`;

CREATE TABLE `Admin` (
    `username` VARCHAR(24) NOT NULL,
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(32) NOT NULL,
    PRIMARY KEY (`username`)
);
/*Inserimento dati Admin*/
INSERT INTO `Admin` (`username`,`email`,`password`) VALUES
('admin','admin@gmail.com','3f6e5d5e29654c022005048a11b07a40'); /**pw=Admin00*/


/*Tabella relativa alle Categorie a cui possono appartenere i locali(Bar, Ristorazione)*/
DROP TABLE IF EXISTS `Categoria`;

CREATE TABLE `Categoria` (
    `genere` VARCHAR(30) NOT NULL,
    `descrizione` VARCHAR(320),
    PRIMARY KEY (`genere`)
);

/*Tabella relativa alla Localizzazione*/
DROP TABLE IF EXISTS `Localizzazione`;

CREATE TABLE `Localizzazione` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `indirizzo` VARCHAR(40) NOT NULL,
    `numCivico` VARCHAR(7) NOT NULL, /*es: via xyz, num 57-A*/
    `citta` VARCHAR(30) NOT NULL,
    `CAP` INT(5) NOT NULL,
    PRIMARY KEY (`id`)
);

/*Tabella relativa agli Orari */
DROP TABLE IF EXISTS `Orario`;

CREATE TABLE `Orario` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `giorno` VARCHAR(15),
    `OrarioApertura` VARCHAR(7),
    `OrarioChiusura` VARCHAR(7),
    PRIMARY KEY (`id`)
);

/*Tabella relativa ai Locali*/
DROP TABLE IF EXISTS `Locale`;

CREATE TABLE `Locale` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(26),
    `numtelefono` CHAR(10) ,
    `descrizione` VARCHAR(320),
	`proprietario` VARCHAR(24),
	`localizzazione` INT(11),
    UNIQUE (`nome`,`localizzazione`),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`proprietario`) REFERENCES Proprietario(`username`) ON UPDATE CASCADE,
    FOREIGN KEY (`localizzazione`) REFERENCES Localizzazione(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella relativa agli Eventi*/
DROP TABLE IF EXISTS `Evento`;

CREATE TABLE `Evento` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `nome` VARCHAR(26),
    `descrizione` VARCHAR(320),
	`data` CHAR(11),
    `idImg` int(11) DEFAULT NULL,
    FOREIGN KEY (`idImg`) REFERENCES Immagine(`id`),
    PRIMARY KEY (`id`)
);

/*Tabella relativa alle Recensioni*/
DROP TABLE IF EXISTS `Recensione`;

CREATE TABLE `Recensione` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `titolo` VARCHAR(40) NOT NULL,
    `descrizione` VARCHAR(420),
    `voto` FLOAT(3) NOT NULL,
    `data` CHAR(11) NOT NULL,
    `segnalato` BOOLEAN  DEFAULT 0,
    `utente` VARCHAR(24) NOT NULL,
    `locale` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`utente`) REFERENCES Utente(`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`locale`) REFERENCES Locale(`id`) ON DELETE CASCADE ON UPDATE CASCADE 
);

/*Tabella relativa alle Risposte alle recensioni*/
DROP TABLE IF EXISTS `Risposta`;

CREATE TABLE `Risposta` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `descrizione` VARCHAR(420),
    `proprietario` VARCHAR(24) NOT NULL,
    `recensione` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`proprietario`) REFERENCES Proprietario(`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`recensione`) REFERENCES Recensione(`id`) ON DELETE CASCADE ON UPDATE CASCADE 
);

/*Tabella che mette in relazione l'Utente con i suoi Locali Preferiti*/
DROP TABLE IF EXISTS `Utenti_Locali`;

CREATE TABLE `Utenti_Locali` (
	`ID_Locale` INT(11) NOT NULL,
    `ID_Utente` VARCHAR(24) NOT NULL,
	CONSTRAINT Utenti_Locali_PK PRIMARY KEY (`ID_Utente` , `ID_Locale`),
    FOREIGN KEY (`ID_Utente`)
        REFERENCES Utente (`username`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella che mette in relazione il Locale con gli Eventi che organizza*/
DROP TABLE IF EXISTS `Locale_Eventi`;

CREATE TABLE `Locale_Eventi` (
	`ID_Locale` INT(11) NOT NULL,
    `ID_Evento` INT(11) NOT NULL,
	CONSTRAINT Locale_Eventi_PK PRIMARY KEY (`ID_Evento` , `ID_Locale`),
    FOREIGN KEY (`ID_Evento`)
        REFERENCES Evento (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella che mette in relazione il Locale con l'Orario settimanale*/
DROP TABLE IF EXISTS `Locale_Orari`;

CREATE TABLE `Locale_Orari` (
	`ID_Locale` INT(11) NOT NULL,
	`ID_Orario` INT(11) NOT NULL,
	CONSTRAINT Locale_Orari_PK PRIMARY KEY ( `ID_Locale` ,`ID_Orario`),
    FOREIGN KEY (`ID_Orario`)
        REFERENCES Orario (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella che mette in relazione il Locale con le attività svolte*/
DROP TABLE IF EXISTS `Locale_Categorie`;

CREATE TABLE `Locale_Categorie` (
	`ID_Locale` INT(11) NOT NULL,
	`ID_Categoria` VARCHAR(30) NOT NULL,
	CONSTRAINT Locale_Categorie_PK PRIMARY KEY ( `ID_Locale` ,`ID_Categoria`),
    FOREIGN KEY (`ID_Categoria`)
        REFERENCES Categoria (`genere`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella che mette in relazione il Locale con le attività svolte*/
DROP TABLE IF EXISTS `Locale_Immagini`;

CREATE TABLE `Locale_Immagini` (
    `ID_Locale` INT(11) NOT NULL,
    `ID_Immagine` INT(11) NOT NULL,
    CONSTRAINT Locale_Immagine_PK PRIMARY KEY ( `ID_Locale` ,`ID_Immagine`),
    FOREIGN KEY (`ID_Immagine`)
        REFERENCES Immagine (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);admincategoria