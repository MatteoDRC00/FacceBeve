-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.24-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database faccebeve
CREATE DATABASE IF NOT EXISTS `faccebeve` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `faccebeve`;

-- Dump della struttura di tabella faccebeve.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(24) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.admin: ~1 rows (circa)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`username`, `email`, `password`) VALUES
	('admin', 'admin@gmail.com', '3f6e5d5e29654c022005048a11b07a40');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `genere` varchar(30) NOT NULL,
  `descrizione` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`genere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.categoria: ~6 rows (circa)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`genere`, `descrizione`) VALUES
	('Bar', 'locale aperto al pubblico adibito alla somministrazione di bevande calde e fredde ed in alcuni casi di snacks'),
	('Birreria', 'Ambiente caratteristico che ricalca il pub inglese. Offre al cliente, oltre ad una vasta gamma di birre alla spina ed in bottiglia, anche la possibilità di consumare panini e piatti tipici'),
	('Disco Bar', 'Riflette l’ambientazione della discoteca, ma non è permesso il ballo. La musica ed il bere la fanno da padroni'),
	('Enoteca', '“negozio” a luogo nel quale godere al meglio della degustazione dei vini'),
	('Night Club', 'locale notturno caratterizzato da un\'atmosfera soffusa e musica generalmente dal vivo'),
	('Pub', 'locale pubblico dove sono servite bevande alcoliche (soprattutto birra) da consumarsi sul posto, in genere comodamente seduti');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.evento
CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(26) DEFAULT NULL,
  `descrizione` varchar(320) DEFAULT NULL,
  `data` char(11) DEFAULT NULL,
  `idImg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idImg` (`idImg`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idImg`) REFERENCES `immagine` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.evento: ~0 rows (circa)
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.immagine
CREATE TABLE IF NOT EXISTS `immagine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `size` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `immagine` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.immagine: ~0 rows (circa)
/*!40000 ALTER TABLE `immagine` DISABLE KEYS */;
/*!40000 ALTER TABLE `immagine` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale
CREATE TABLE IF NOT EXISTS `locale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(26) DEFAULT NULL,
  `numtelefono` char(10) DEFAULT NULL,
  `descrizione` varchar(320) DEFAULT NULL,
  `proprietario` varchar(24) DEFAULT NULL,
  `localizzazione` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`,`localizzazione`),
  KEY `proprietario` (`proprietario`),
  KEY `localizzazione` (`localizzazione`),
  CONSTRAINT `locale_ibfk_1` FOREIGN KEY (`proprietario`) REFERENCES `proprietario` (`username`) ON UPDATE CASCADE,
  CONSTRAINT `locale_ibfk_2` FOREIGN KEY (`localizzazione`) REFERENCES `localizzazione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale: ~0 rows (circa)
/*!40000 ALTER TABLE `locale` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_categorie
CREATE TABLE IF NOT EXISTS `locale_categorie` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Categoria`),
  KEY `ID_Categoria` (`ID_Categoria`),
  CONSTRAINT `locale_categorie_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`genere`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_categorie_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_categorie: ~0 rows (circa)
/*!40000 ALTER TABLE `locale_categorie` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale_categorie` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_eventi
CREATE TABLE IF NOT EXISTS `locale_eventi` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Evento` int(11) NOT NULL,
  PRIMARY KEY (`ID_Evento`,`ID_Locale`),
  KEY `ID_Locale` (`ID_Locale`),
  CONSTRAINT `locale_eventi_ibfk_1` FOREIGN KEY (`ID_Evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_eventi_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_eventi: ~0 rows (circa)
/*!40000 ALTER TABLE `locale_eventi` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale_eventi` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_immagini
CREATE TABLE IF NOT EXISTS `locale_immagini` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Immagine` int(11) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Immagine`),
  KEY `ID_Immagine` (`ID_Immagine`),
  CONSTRAINT `locale_immagini_ibfk_1` FOREIGN KEY (`ID_Immagine`) REFERENCES `immagine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_immagini_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_immagini: ~0 rows (circa)
/*!40000 ALTER TABLE `locale_immagini` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale_immagini` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_orari
CREATE TABLE IF NOT EXISTS `locale_orari` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Orario` int(11) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Orario`),
  KEY `ID_Orario` (`ID_Orario`),
  CONSTRAINT `locale_orari_ibfk_1` FOREIGN KEY (`ID_Orario`) REFERENCES `orario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_orari_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_orari: ~0 rows (circa)
/*!40000 ALTER TABLE `locale_orari` DISABLE KEYS */;
/*!40000 ALTER TABLE `locale_orari` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.localizzazione
CREATE TABLE IF NOT EXISTS `localizzazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indirizzo` varchar(40) NOT NULL,
  `numCivico` varchar(7) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `CAP` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.localizzazione: ~0 rows (circa)
/*!40000 ALTER TABLE `localizzazione` DISABLE KEYS */;
/*!40000 ALTER TABLE `localizzazione` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.orario
CREATE TABLE IF NOT EXISTS `orario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `giorno` varchar(15) DEFAULT NULL,
  `OrarioApertura` varchar(7) DEFAULT NULL,
  `OrarioChiusura` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.orario: ~0 rows (circa)
/*!40000 ALTER TABLE `orario` DISABLE KEYS */;
/*!40000 ALTER TABLE `orario` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.proprietario
CREATE TABLE IF NOT EXISTS `proprietario` (
  `username` varchar(24) NOT NULL,
  `nome` varchar(26) DEFAULT NULL,
  `cognome` varchar(26) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  `idImg` int(11) DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `idImg` (`idImg`),
  CONSTRAINT `proprietario_ibfk_1` FOREIGN KEY (`idImg`) REFERENCES `immagine` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.proprietario: ~0 rows (circa)
/*!40000 ALTER TABLE `proprietario` DISABLE KEYS */;
/*!40000 ALTER TABLE `proprietario` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.recensione
CREATE TABLE IF NOT EXISTS `recensione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(40) NOT NULL,
  `descrizione` varchar(420) DEFAULT NULL,
  `voto` float NOT NULL,
  `data` char(11) NOT NULL,
  `segnalato` tinyint(1) DEFAULT 0,
  `utente` varchar(24) NOT NULL,
  `locale` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`),
  KEY `locale` (`locale`),
  CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.recensione: ~0 rows (circa)
/*!40000 ALTER TABLE `recensione` DISABLE KEYS */;
/*!40000 ALTER TABLE `recensione` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.risposta
CREATE TABLE IF NOT EXISTS `risposta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descrizione` varchar(420) DEFAULT NULL,
  `proprietario` varchar(24) NOT NULL,
  `recensione` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proprietario` (`proprietario`),
  KEY `recensione` (`recensione`),
  CONSTRAINT `risposta_ibfk_1` FOREIGN KEY (`proprietario`) REFERENCES `proprietario` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `risposta_ibfk_2` FOREIGN KEY (`recensione`) REFERENCES `recensione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.risposta: ~0 rows (circa)
/*!40000 ALTER TABLE `risposta` DISABLE KEYS */;
/*!40000 ALTER TABLE `risposta` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.utente
CREATE TABLE IF NOT EXISTS `utente` (
  `username` varchar(24) NOT NULL,
  `nome` varchar(26) DEFAULT NULL,
  `cognome` varchar(26) DEFAULT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  `dataIscrizione` char(11) NOT NULL,
  `idImg` int(11) DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`),
  KEY `idImg` (`idImg`),
  CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`idImg`) REFERENCES `immagine` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.utente: ~0 rows (circa)
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.utenti_locali
CREATE TABLE IF NOT EXISTS `utenti_locali` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Utente` varchar(24) NOT NULL,
  PRIMARY KEY (`ID_Utente`,`ID_Locale`),
  KEY `ID_Locale` (`ID_Locale`),
  CONSTRAINT `utenti_locali_ibfk_1` FOREIGN KEY (`ID_Utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `utenti_locali_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.utenti_locali: ~0 rows (circa)
/*!40000 ALTER TABLE `utenti_locali` DISABLE KEYS */;
/*!40000 ALTER TABLE `utenti_locali` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
