DROP DATABASE IF EXISTS `FacceBeve`;

CREATE DATABASE `FacceBeve`;

/*DROP USER IF EXISTS 'website'@'localhost';
CREATE USER 'website'@'localhost' IDENTIFIED BY 'webpass';
GRANT ALL ON collection_site.* TO 'website'@'localhost';*/

USE `FacceBeve`;

/*Tabella relativa agli Utenti registrati*/
DROP TABLE IF EXISTS `Utente`;

CREATE TABLE `Utente` (
    `username` VARCHAR(24) NOT NULL,
    `nome` VARCHAR(26),
    `cognome` VARCHAR(26),    
    `email` VARCHAR(40) NOT NULL,
    `password` VARCHAR(30) NOT NULL,
    `dataIscrizione` DATE NOT NULL,
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
    `codiceluogo` INT(11) NOT NULL, --va aggiunto a entity e a foundation
    `indirizzo` VARCHAR(40) NOT NULL,
    `numCivico` VARCHAR(7) NOT NULL, /*es: via xyz, num 57-A*/
    `citta` VARCHAR(30) NOT NULL,
    `nazione` VARCHAR(20) NOT NULL,
    `CAP` INT(5) NOT NULL,
    PRIMARY KEY (`codiceluogo`)
);

/*Tabella relativa agli Orari */
DROP TABLE IF EXISTS `Orario`;

CREATE TABLE `Orario` (
    `codicegiorno` INT(11) NOT NULL, --va aggiunto a entity e a foundation
    `giorno` VARCHAR(15),
    `OrarioApertura` CHAR(5),
    `OrarioChiusura` CHAR(5),
    PRIMARY KEY (`ID`)
);

/*Tabella relativa ai Locali*/
DROP TABLE IF EXISTS `Locale`;

CREATE TABLE `Locale` (
    `nome` VARCHAR(26),
    `numTelefono` CHAR(9),
    `descrizione` VARCHAR(120),
    `valutazione` FLOAT(3) DEFAULT NULL,
	`proprietario` INT(11),
    `categoria` INT(11),
	`localizzazione` INT(11),
	`orario` INT(11),
    PRIMARY KEY (`nome`,`localizzazione`),/*
    FOREIGN KEY (`proprietario`) REFERENCES Proprietario(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`categoria`) REFERENCES Categoria(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`localizzazione`) REFERENCES Localizzazione(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`orario`) REFERENCES Orario(`ID`) ON DELETE CASCADE ON UPDATE CASCADE*/
);

/*Tabella relativa agli Eventi !!!POI RICONTROLLARE PER LE IMMAGINI */
DROP TABLE IF EXISTS `Evento`; /*Poi fare seconda tabella / aggiornamento evento*/

CREATE TABLE `Evento` (
    `codiceevento` INT(11) NOT NULL, --va aggiunto a entity e a foundation
    `nome` VARCHAR(26),
    `descrizione` VARCHAR(120),
	 `data` DATE,   
    PRIMARY KEY (`ID`)
);



/*Tabella relativa alle Recensioni*/
DROP TABLE IF EXISTS `Recensione`;

CREATE TABLE `Recensione` (
    `codicerecensione` INT(11) NOT NULL, --va aggiunto a entity e a foundation
    `titolo` VARCHAR(40) NOT NULL,
    `descrizione` VARCHAR(120),
    `voto` FLOAT(3) NOT NULL,
    `data` DATE NOT NULL,
    `segnalato` BOOLEAN  DEFAULT 0,
    `counter` BOOLEAN  DEFAULT 0, /*Conta il numero di segnalazioni alla recensione*/
    `utente` INT(11) NOT NULL,
    `nomelocale` VARCHAR(26) NOT NULL,
	`luogolocale` INT(11) NOT NULL,
    PRIMARY KEY (`ID`),
    FOREIGN KEY (`utente`) REFERENCES Utente(`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`nomelocale`,`luogolocale`) REFERENCES Locale(`nome`,`localizzazione`) ON DELETE CASCADE ON UPDATE CASCADE 
);

/*Tabella relativa alle Risposte alle recensioni*/
DROP TABLE IF EXISTS `Risposta`;

CREATE TABLE `Risposta` (
    `codicerisposta` INT(11) NOT NULL, --va aggiunto a entity e a foundation
    `descrizione` VARCHAR(120),
    `proprietario` INT(11) NOT NULL,
    `recensione` INT(11) NOT NULL,
    PRIMARY KEY (`ID`),
   /* FOREIGN KEY (`proprietario`) REFERENCES Proprietario(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`recensione`) REFERENCES Recensione(`ID`) ON DELETE CASCADE ON UPDATE CASCADE /**Boh, controllare*/ */
);

/*Tabella che mette in relazione l'Utente con i suoi Locali Preferiti*/
DROP TABLE IF EXISTS `Utenti_Locali`;

CREATE TABLE `Utenti_Locali` (
	`ID_Utente` INT(11) NOT NULL,
	`ID_Locale` INT(11) NOT NULL,
	CONSTRAINT Utenti_Locali_PK PRIMARY KEY (`ID_Utente` , `ID_Locale`),
    FOREIGN KEY (`ID_Utente`)
        REFERENCES Utente (`username`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale (`nome`,`localizzazione`)
        ON DELETE CASCADE ON UPDATE CASCADE
); 

/*Tabella che mette in relazione il Locale con gli Eventi che organizza*/
DROP TABLE IF EXISTS `Locale_Eventi`;

CREATE TABLE `Locale_Eventi` (
	`ID_Evento` INT(11) NOT NULL,
	`ID_Locale` INT(11) NOT NULL,
	CONSTRAINT Locale_Eventi_PK PRIMARY KEY (`ID_Evento` , `ID_Locale`),
    FOREIGN KEY (`ID_Evento`)
        REFERENCES Evento (`ID`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale ((`nome`,`localizzazione`))
        ON DELETE CASCADE ON UPDATE CASCADE
); 

/*Tabella che mette in relazione il Locale con l'Orario settimanale*/
DROP TABLE IF EXISTS `Locale_Orari`;

CREATE TABLE `Locale_Orari` (
	`ID_Locale` INT(11) NOT NULL,
	`ID_Orario` INT(11) NOT NULL,
	CONSTRAINT Locale_Orari_PK PRIMARY KEY ( `ID_Locale` ,`ID_Orario`),
    FOREIGN KEY (`ID_Orario`)
        REFERENCES Orario (`codicegiorno`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`ID_Locale`)
        REFERENCES Locale ((`nome`,`localizzazione`))
        ON DELETE CASCADE ON UPDATE CASCADE
); 