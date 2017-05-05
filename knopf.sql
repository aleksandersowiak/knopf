-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               10.1.9-MariaDB - mariadb.org binary distribution
-- Serwer OS:                    Win32
-- HeidiSQL Wersja:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury bazy danych database
CREATE DATABASE IF NOT EXISTS `database` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `database`;


-- Zrzut struktury tabela database.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `description` longtext,
  `image` varchar(50) DEFAULT NULL,
  KEY `Indeks 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.products: ~2 rows (około)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title`, `description`, `image`) VALUES
	(1, 'REHAU Brillant Design 70', 'Il sistema a più camere REHAU Brillant-Design 70\r\nsi propone come soluzione conveniente e versatile\r\ngrazie alla ideale profondità del profilo da 70 mm.\r\nIl sistema si adatta all\'impiego in abitazioni\r\nunifamiliari e in edifici di grandi dimensioni. La\r\nstruttura perfezionata di questo sistema consente\r\ndi attribuire la massima importanza all\'isolamento\r\ntermico o a fattori di staticità.', NULL),
	(2, 'REHAU Brillant Design MD', 'REHAU Brillant-Design MD si basa sul successo del sistema\r\nREHAU Brillant-Design con guarnizione di battuta.\r\nMantenendo le stesse caratteristiche estetiche, REHAU\r\nBrillant-Design MD si è sviluppato come sistema di\r\nguarnizione centrale autonomo. REHAU Brillant-Design MD\r\nmette in primo piano l\'isolamento termico. Le ottime\r\ncaratteristiche isolanti della profondità profilo di 70 mm e\r\ndella tecnica di realizzazione a 5 camere vengono\r\nulteriormente potenziate attraverso la guarnizione centrale.', NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Zrzut struktury tabela database.top_menu
CREATE TABLE IF NOT EXISTS `top_menu` (
  `menu_element` varchar(25) DEFAULT NULL,
  `order` varchar(25) DEFAULT NULL,
  `link` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.top_menu: ~5 rows (około)
/*!40000 ALTER TABLE `top_menu` DISABLE KEYS */;
INSERT INTO `top_menu` (`menu_element`, `order`, `link`) VALUES
	('menu_home_page', '1', ''),
	('menu_product', '2', 'products'),
	('menu_gallery', '3', 'gallery'),
	('menu_about', '4', 'home/about'),
	('menu_contact', '5', 'home/contact');
/*!40000 ALTER TABLE `top_menu` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
