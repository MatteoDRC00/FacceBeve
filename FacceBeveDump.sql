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
DROP DATABASE IF EXISTS `my_faccebeve`;
CREATE DATABASE IF NOT EXISTS `my_faccebeve` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
GRANT ALL ON my_faccebeve.* TO faccebeve@localhost;
USE `my_faccebeve`;

-- Dump della struttura di tabella faccebeve.admin
DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(24) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.admin: ~0 rows (circa)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`username`, `email`, `password`) VALUES
	('admin', 'admin@gmail.com', '3f6e5d5e29654c022005048a11b07a40');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.categoria
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `genere` varchar(30) NOT NULL,
  `descrizione` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`genere`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.categoria: ~8 rows (circa)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `Categoria` (`genere`, `descrizione`) VALUES
('Bar', 'locale aperto al pubblico adibito alla somministrazione di bevande calde e fredde ed in alcuni casi di snacks'),
('Birreria', 'Ambiente caratteristico che ricalca il pub inglese. Offre al cliente, oltre ad una vasta gamma di birre alla spina ed in bottiglia, anche la possibilità di consumare panini e piatti tipici'),
('Disco Bar', 'Riflette l’ambientazione della discoteca, ma non è permesso il ballo. La musica ed il bere la fanno da padroni'),
('Enoteca', '“negozio” a luogo nel quale godere al meglio della degustazione dei vini'),
('Gintoneria', 'locale in cui viene offerta alla clientela di abbinare le portate a un cocktail a base di gin'),
('Irish Pub', 'locale legnoso fatto di luci soffuse, pinte brillanti e un gradevole abbraccio di calore'),
('Night Club', 'locale notturno caratterizzato da un\'atmosfera soffusa e musica generalmente dal vivo'),
('Pub', 'locale pubblico dove sono servite bevande alcoliche (soprattutto birra) da consumarsi sul posto, in genere comodamente seduti'),
('Risto Pub', 'locale di tendenza in cui entrano in gioco entrambe le componenti che caratterizzano pub e ristorante');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.evento
DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(26) DEFAULT NULL,
  `descrizione` varchar(320) DEFAULT NULL,
  `data` char(11) DEFAULT NULL,
  `idImg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idImg` (`idImg`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idImg`) REFERENCES `immagine` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.evento: ~2 rows (circa)
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `Evento` (`id`, `nome`, `descrizione`, `data`, `idImg`) VALUES
(1, 'Oktoberfest', 'L’Oktoberfest rappresenta un tuffo nella tradizione pluri-secolare bavarese, amanti della birra oppure no, rappresenta un’ esperienza da vivere almeno una volta nella vita, vieni a viverla da noi!!', '22/10/2022', NULL),
(2, 'Halloween', 'Venite a vivere la serata di Halloween con noi, ci sarà da divertirsi!!', '31/10/2022', NULL),
(3, 'Aperitivo 2x1', 'Vieni a degustare il nostro FAVOLOSO aperitivo in coppia!!', '21/10/2022', NULL),
(4, 'The Billie Gin party', 'Festa per i 6 anni del locale, non mancate\r\n-Gin a 3 euro\r\n-Due vodka redbull e una pinta di birra a 12 euro\r\n-Astemi non vi temiamo', '29/10/2022', NULL),
(5, 'St. Patrick\'s Day', 'Vieni a festeggiarlo con noi... Ogni due BIRRE è in REGALO un cappello della festa!!', '29/10/2022', NULL),
(6, 'Erasmus Karaoke', 'Erasmus e Giacomo (ThSantacruz) fanno KARAOKE dalle 21 in poi... Vi aspettiamo ;)', '02/11/2022', NULL);
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.immagine
DROP TABLE IF EXISTS `immagine`;
CREATE TABLE IF NOT EXISTS `immagine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `size` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `immagine` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;


-- Dump della struttura di tabella faccebeve.locale
DROP TABLE IF EXISTS `locale`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale: ~3 rows (circa)
/*!40000 ALTER TABLE `locale` DISABLE KEYS */;
INSERT INTO `locale` (`id`, `nome`, `numtelefono`, `descrizione`, `proprietario`, `localizzazione`) VALUES
	(1, 'The Billie Gin Club', '3274422120', 'La prima GINTONERIA de L\' Aquila', 'Elvetico79', 1),
(2, 'Jayson\'s Irish Pub', '3334445566', 'Negli anni il Jayson’s è rimasto fedele alla sua impronta irish, con la massima attenzione alla selezione di birre e whiskey, i festeggiamenti in onore di San Patrizio e il controverso (ma caratterizzante) “ no table service”…ovvero si prende da bere al bancone !', 'Elvetico79', 2),
(3, 'Utopia Ristopub', '3382959980', 'La cucina italiana è sul menu del pub & bar Utopia Ristopub. Degusta gli ineguagliabili panini, coda di rospo e hamburger che offre questo locale. Se ti piace un delizioso cordiale, non perderle l\'opportunità di provarlo qui.', 'RastaTopo', 3),
(4, 'Morrison Wine & Cocktails', '3279071461', 'Siamo aperti solo per voi, vi aspettiamo tutti i giorni ma soprattutto il GIOVEDI\' UNIVERSITARIO per moltissime sorprese!!', 'RastaTopo', 5);
/*!40000 ALTER TABLE `locale` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_categorie
DROP TABLE IF EXISTS `locale_categorie`;
CREATE TABLE IF NOT EXISTS `locale_categorie` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Categoria`),
  KEY `ID_Categoria` (`ID_Categoria`),
  CONSTRAINT `locale_categorie_ibfk_1` FOREIGN KEY (`ID_Categoria`) REFERENCES `categoria` (`genere`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_categorie_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_categorie: ~4 rows (circa)
/*!40000 ALTER TABLE `locale_categorie` DISABLE KEYS */;
INSERT INTO `locale_categorie` (`ID_Locale`, `ID_Categoria`) VALUES
	(4, 'Disco Bar'),
(1, 'Gintoneria'),
(2, 'Irish Pub'),
(2, 'Pub'),
(3, 'Risto Pub');
/*!40000 ALTER TABLE `locale_categorie` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_eventi
DROP TABLE IF EXISTS `locale_eventi`;
CREATE TABLE IF NOT EXISTS `locale_eventi` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Evento` int(11) NOT NULL,
  PRIMARY KEY (`ID_Evento`,`ID_Locale`),
  KEY `ID_Locale` (`ID_Locale`),
  CONSTRAINT `locale_eventi_ibfk_1` FOREIGN KEY (`ID_Evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_eventi_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_eventi: ~2 rows (circa)
/*!40000 ALTER TABLE `locale_eventi` DISABLE KEYS */;
INSERT INTO `locale_eventi` (`ID_Locale`, `ID_Evento`) VALUES
	(1, 4),
(2, 5),
(4, 6);
/*!40000 ALTER TABLE `locale_eventi` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.locale_immagini
DROP TABLE IF EXISTS `locale_immagini`;
CREATE TABLE IF NOT EXISTS `locale_immagini` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Immagine` int(11) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Immagine`),
  KEY `ID_Immagine` (`ID_Immagine`),
  CONSTRAINT `locale_immagini_ibfk_1` FOREIGN KEY (`ID_Immagine`) REFERENCES `immagine` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_immagini_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Dump della struttura di tabella faccebeve.locale_orari
DROP TABLE IF EXISTS `locale_orari`;
CREATE TABLE IF NOT EXISTS `locale_orari` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Orario` int(11) NOT NULL,
  PRIMARY KEY (`ID_Locale`,`ID_Orario`),
  KEY `ID_Orario` (`ID_Orario`),
  CONSTRAINT `locale_orari_ibfk_1` FOREIGN KEY (`ID_Orario`) REFERENCES `orario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `locale_orari_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.locale_orari: ~21 rows (circa)
/*!40000 ALTER TABLE `locale_orari` DISABLE KEYS */;
INSERT INTO `locale_orari` (`ID_Locale`, `ID_Orario`) VALUES
	(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(4, 26),
(4, 27),
(4, 28);
/*!40000 ALTER TABLE `locale_orari` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.localizzazione
DROP TABLE IF EXISTS `localizzazione`;
CREATE TABLE IF NOT EXISTS `localizzazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `indirizzo` varchar(40) NOT NULL,
  `numCivico` varchar(7) NOT NULL,
  `citta` varchar(30) NOT NULL,
  `CAP` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.localizzazione: ~3 rows (circa)
/*!40000 ALTER TABLE `localizzazione` DISABLE KEYS */;
INSERT INTO `localizzazione` (`id`, `indirizzo`, `numCivico`, `citta`, `CAP`) VALUES
	(1, 'Corso Vittorio Emanuele', '137', 'L\'Aquila', 67100),
(2, 'Viale G. Marconi', '283', 'Pescara', 65126),
(3, 'Via G. Verrotti', '28', 'Montesilvano', 65015),
(4, 'Via Dei Sali', ' 9', 'L\'Aquila', 67100),
(5, 'Via Dei Sali', ' 9', 'L\'Aquila', 67100);
/*!40000 ALTER TABLE `localizzazione` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.orario
DROP TABLE IF EXISTS `orario`;
CREATE TABLE IF NOT EXISTS `orario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `giorno` varchar(15) DEFAULT NULL,
  `OrarioApertura` varchar(7) DEFAULT NULL,
  `OrarioChiusura` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.orario: ~21 rows (circa)
/*!40000 ALTER TABLE `orario` DISABLE KEYS */;
INSERT INTO `orario` (`id`, `giorno`, `OrarioApertura`, `OrarioChiusura`) VALUES
	(1, 'Lunedì', 'Chiuso', ''),
(2, 'Martedì', 'Chiuso', ''),
(3, 'Mercoledì', '17:00', '23:00'),
(4, 'Giovedì', '17:00', '02:00'),
(5, 'Venerdì', '17:00', '01:30'),
(6, 'Sabato', '17:00', '02:30'),
(7, 'Domenica', '17:00', '02:00'),
(8, 'Lunedì', '17:00', '02:00'),
(9, 'Martedì', '17:00', '02:00'),
(10, 'Mercoledì', '17:00', '02:00'),
(11, 'Giovedì', '17:00', '02:00'),
(12, 'Venerdì', '17:00', '02:00'),
(13, 'Sabato', '17:00', '02:00'),
(14, 'Domenica', '17:00', '02:00'),
(15, 'Lunedì', '18:00', '02:00'),
(16, 'Martedì', '18:00', '02:00'),
(17, 'Mercoledì', '18:00', '02:00'),
(18, 'Giovedì', '18:00', '02:00'),
(19, 'Venerdì', '18:00', '02:00'),
(20, 'Sabato', '18:00', '02:00'),
(21, 'Domenica', '18:00', '02:00'),
(22, 'Lunedì', 'Chiuso', ''),
(23, 'Martedì', 'Chiuso', ''),
(24, 'Mercoledì', '18:00', '02:00'),
(25, 'Giovedì', '18:00', '02:00'),
(26, 'Venerdì', '18:00', '02:00'),
(27, 'Sabato', '18:00', '02:00'),
(28, 'Domenica', 'Chiuso', '');
/*!40000 ALTER TABLE `orario` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.proprietario
DROP TABLE IF EXISTS `proprietario`;
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
INSERT INTO `proprietario` (`username`, `nome`, `cognome`, `email`, `password`, `idImg`) VALUES
	('Cicca00', 'Matteo', 'Ciccarelli', 'matteo.ciccarelli@gmail.com', '641ae56f8c079ed29d2b37debfa1365d', NULL),
('Elvetico79', 'William', 'Ciccarelli', 'emailprop1@gmail.com', '548fb6c4c4f7e2d48e8018cc78bc2c76', NULL),
('RastaTopo', 'Salvatore', 'Vitaliano', 'emaprop2@gmail.com', '0eba77cae68225f97442190177e8c926', NULL);
/*!40000 ALTER TABLE `proprietario` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.recensione
DROP TABLE IF EXISTS `recensione`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.recensione: ~4 rows (circa)
/*!40000 ALTER TABLE `recensione` DISABLE KEYS */;
INSERT INTO `recensione` (`id`, `titolo`, `descrizione`, `voto`, `data`, `segnalato`, `utente`, `locale`) VALUES
	(1, 'Ottimo', 'Locale ottimo ma prezzi poco accessibili :(', 4, '17/10/2022', 0, 'JustRamax', 1),
(2, 'Invitante', '', 3, '17/10/2022', 0, 'JustRamax', 2),
(3, 'Tanto di cappello', 'La prossima volta offro da bere al barista :p', 5, '17/10/2022', 0, 'FrancescoTotti', 1),
(4, 'Ma si dai carino', 'Personale poco preparato...', 3, '17/10/2022', 1, 'TittioAngel', 1),
(6, 'Storico', 'Vi do il massimo e auguro il meglio siete il mio locale preferito', 5, '20/10/2022', 0, 'ThiagoSantacruz', 2),
(7, 'Posto accogliente, lo consiglio', 'Lo staff è stato molto gentile e divertente, 10/10', 5, '20/10/2022', 0, 'ThiagoSantacruz', 3),
(8, 'Balordi', 'Mi avete dato na ipa invece che na lager....', 1, '20/10/2022', 0, 'SamanthaCristoforetti', 3),
(10, 'La cameriera', 'Datemi il numero della cameriera biondaaaa', 4, '21/10/2022', 0, 'CLZ_GOAT', 3),
(11, 'Accetabile', 'molto low-cost, poca qualità', 3, '24/10/2022', 0, 'CLZ_GOAT', 4),
(12, 'Clamorosi', '', 5, '29/10/2022', 0, 'DoggyMala', 2),
(13, 'Ottimo', 'sdftgyhuj', 3, '03/11/2022', 0, 'DRKing', 1),
(14, 'ottimo così', 'molto low cost, quindi perfeto', 5, '05/11/2022', 0, 'ilcompare', 4);
/*!40000 ALTER TABLE `recensione` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.risposta
DROP TABLE IF EXISTS `risposta`;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.risposta: ~1 rows (circa)
/*!40000 ALTER TABLE `risposta` DISABLE KEYS */;
INSERT INTO `risposta` (`id`, `descrizione`, `proprietario`, `recensione`) VALUES
	(1, 'Come sei accomodante... Se intuisce che la QUALITA\' si paga', 'Elvetico79', 1),
(2, 'Ti aspetto ;)', 'Elvetico79', 3),
(3, 'Ti aspettiamo ;)\r\n', 'Elvetico79', 2),
(4, 'esdrftgyhujik', 'Elvetico79', 13);
/*!40000 ALTER TABLE `risposta` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.utente
DROP TABLE IF EXISTS `utente`;
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

-- Dump dei dati della tabella faccebeve.utente: ~3 rows (circa)
/*!40000 ALTER TABLE `utente` DISABLE KEYS */;
INSERT INTO `utente` (`username`, `nome`, `cognome`, `email`, `password`, `dataIscrizione`, `idImg`, `state`) VALUES
	('CLZ_GOAT', 'Matteo', 'Colazilli', 'MatteoCLZ@gmail.com', '051deb66abc85c8ffe1599fe67c0783a', '21/10/2022', NULL, 1),
('DoggyMala', 'Francesco', 'De Sanctis', 'fradesanctis951@gmail.com', 'd1710ebb3c69b0f0f35f1a536852a921', '29/10/2022', NULL, 1),
('DRKing', 'Matteo', 'Di Russo-Ciccarelli', 'matteo.dirussociccarelli@student.univaq.it', '6da4a606a5a7bde6d2492b3c4645a6cd', '20/10/2022', NULL, 1),
('FrancescoTotti', 'Francesco', 'Totti', 'emailuser1@gmail.com', 'd1710ebb3c69b0f0f35f1a536852a921', '17/10/2022', NULL, 1),
('ilcompare', 'tommaso', 'lafuente', 'hecas89637@dmtubes.com', '4eefba0bc4ae09d607d9d27d3012deae', '05/11/2022', NULL, 1),
('JustRamax', 'Samuele', 'Ramassone', 'sam.ramax@gmail.com', '7f1b07b0b36fe2e09082e8be57d40325', '17/10/2022', NULL, 1),
('PanzadabirraBoss', 'Franco', 'Il King ', 'gintonic@vodka.com', 'd10627f02020464bacf7930eda10e57b', '30/10/2022', NULL, 1),
('SamanthaCristoforetti', 'Samuele', 'Ramassone', 'zanzaro197@gmail.com', '0c040c597814d1387a03d641e7835c3c', '20/10/2022', NULL, 1),
('tester', 'Elisa', 'asd', 'emailciaone@gmail.com', 'ab8b4723e15e3785897e19a7579ee6df', '21/10/2022', NULL, 0),
('ThiagoSantacruz', 'Giacomo', 'Santacroce', 'thiagosantacruz@gmail.com', 'e02e3ad3698ec1c186775fa80a258840', '20/10/2022', NULL, 1),
('TittioAngel', 'Matteo', 'Angelucci', 'matteo.angelucci@gmail.com', '005ebe0785baf32bdc5d964f1c52953b', '17/10/2022', NULL, 0);
/*!40000 ALTER TABLE `utente` ENABLE KEYS */;

-- Dump della struttura di tabella faccebeve.utenti_locali
DROP TABLE IF EXISTS `utenti_locali`;
CREATE TABLE IF NOT EXISTS `utenti_locali` (
  `ID_Locale` int(11) NOT NULL,
  `ID_Utente` varchar(24) NOT NULL,
  PRIMARY KEY (`ID_Utente`,`ID_Locale`),
  KEY `ID_Locale` (`ID_Locale`),
  CONSTRAINT `utenti_locali_ibfk_1` FOREIGN KEY (`ID_Utente`) REFERENCES `utente` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `utenti_locali_ibfk_2` FOREIGN KEY (`ID_Locale`) REFERENCES `locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella faccebeve.utenti_locali: ~3 rows (circa)
/*!40000 ALTER TABLE `utenti_locali` DISABLE KEYS */;
INSERT INTO `utenti_locali` (`ID_Locale`, `ID_Utente`) VALUES
	(1, 'DRKing'),
(1, 'FrancescoTotti'),
(1, 'JustRamax'),
(1, 'ThiagoSantacruz'),
(2, 'CLZ_GOAT'),
(2, 'DoggyMala'),
(2, 'JustRamax'),
(2, 'ThiagoSantacruz'),
(3, 'CLZ_GOAT'),
(3, 'SamanthaCristoforetti'),
(4, 'DRKing');

/*!40000 ALTER TABLE `utenti_locali` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
