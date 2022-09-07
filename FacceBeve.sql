DROP DATABASE IF EXISTS `faccebeve`;

CREATE DATABASE `faccebeve`;

GRANT ALL ON faccebeve.* TO root;

USE `faccebeve`;


/*Tabella relativa alle immagini utilizzate*/
DROP TABLE IF EXISTS `Immagine`;
CREATE TABLE `Immagine` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(50) NOT NULL,
    `size` varchar(25) NOT NULL,
    `type` varchar(25) NOT NULL,
    `immagine` blob NOT NULL,
    PRIMARY KEY (id)
);

/*Tabella relativa agli Utenti registrati*/
DROP TABLE IF EXISTS `Utente`;

CREATE TABLE `Utente` (
    `username` VARCHAR(24) NOT NULL,
    `nome` VARCHAR(26),
    `cognome` VARCHAR(26),    
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    `dataIscrizione` CHAR(11) NOT NULL,
    `idImg` int(11),
    `state` tinyint(1) NOT NULL,
    FOREIGN KEY (`idImg`) REFERENCES Immagine(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (`username`)
);

/*Tabella relativa ai Proprietari dei Locali*/
DROP TABLE IF EXISTS `Proprietario`;

CREATE TABLE `Proprietario` (
    `username` VARCHAR(24) NOT NULL,
    `nome` VARCHAR(26),
    `cognome` VARCHAR(26),    
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
     `idImg` int(11),
    FOREIGN KEY (`idImg`) REFERENCES Immagine(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (`username`)
);

/*Tabella relativa agli Admin del sito*/
DROP TABLE IF EXISTS `Admin`;

CREATE TABLE `Admin` (
    `username` VARCHAR(24) NOT NULL,
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`username`)
);

/*Tabella relativa alle Categorie a cui possono appartenere i locali(Bar, Ristorazione)*/
DROP TABLE IF EXISTS `Categoria`;

CREATE TABLE `Categoria` (
    `genere` VARCHAR(30) NOT NULL,
    `descrizione` VARCHAR(120),
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
    `id` INT(11) NOT NULL, 
    `giorno` VARCHAR(15),
    `OrarioApertura` CHAR(5),
    `OrarioChiusura` CHAR(5),
    PRIMARY KEY (`id`)
);

/*Tabella relativa ai Locali*/
DROP TABLE IF EXISTS `Locale`;

CREATE TABLE `Locale` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(26),
    `numtelefono` CHAR(9) UNIQUE,
    `descrizione` VARCHAR(120),
	`proprietario` VARCHAR(24),
	`localizzazione` INT(11),
    UNIQUE (`nome`,`localizzazione`),
    PRIMARY KEY (`id`),
    FOREIGN KEY (`proprietario`) REFERENCES Proprietario(`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`localizzazione`) REFERENCES Localizzazione(`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella relativa agli Eventi !!!POI RICONTROLLARE PER LE IMMAGINI */
DROP TABLE IF EXISTS `Evento`; /*Poi fare seconda tabella / aggiornamento evento*/

CREATE TABLE `Evento` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `nome` VARCHAR(26),
    `descrizione` VARCHAR(120),
	`data` DATE,
    PRIMARY KEY (`id`)
);


/*Tabella relativa alle Recensioni*/
DROP TABLE IF EXISTS `Recensione`;

CREATE TABLE `Recensione` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `titolo` VARCHAR(40) NOT NULL,
    `descrizione` VARCHAR(120),
    `voto` FLOAT(3) NOT NULL,
    `data` DATE NOT NULL,
    `segnalato` BOOLEAN  DEFAULT 0,
    `counter` BOOLEAN  DEFAULT 0, /*Conta il numero di segnalazioni alla recensione*/
    `utente` VARCHAR(24) NOT NULL,
    `locale` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`utente`) REFERENCES Utente(`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`locale`) REFERENCES Locale(`id`) ON DELETE CASCADE ON UPDATE CASCADE 
);

/*Tabella relativa alle Risposte alle recensioni*/
DROP TABLE IF EXISTS `Risposta`;

CREATE TABLE `Risposta` (
    `id` INT(11) NOT NULL,
    `descrizione` VARCHAR(120),
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

/*Tabella che mette in relazione il Locale con le immagini*/
DROP TABLE IF EXISTS `Locale_Immagini`;
CREATE TABLE `Locale_Immagini` (
	`ID_Locale` INT(11) NOT NULL,
	`ID_Immagine` INT(11) NOT NULL,
	CONSTRAINT Locale_Immagini_PK PRIMARY KEY ( `ID_Locale` ,`ID_Immagine`),
    FOREIGN KEY (`ID_Immagine`)
        REFERENCES Immagine (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);

/*Tabella che mette in relazione l'Evento con le immagini*/
DROP TABLE IF EXISTS `Evento_Immagini`;
CREATE TABLE `Evento_Immagini` (
	`ID_Evento` INT(11) NOT NULL,
	`ID_Immagine` INT(11) NOT NULL,
	CONSTRAINT Evento_Immagini_PK PRIMARY KEY ( `ID_Evento` ,`ID_Immagine`),
    FOREIGN KEY (`ID_Immagine`)
        REFERENCES Immagine (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Evento`)
        REFERENCES Evento (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
);