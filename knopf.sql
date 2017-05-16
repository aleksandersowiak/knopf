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


-- Zrzut struktury tabela database.content
CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(25) DEFAULT NULL,
  `action` varchar(25) DEFAULT NULL,
  `translate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.content: ~3 rows (około)
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`id`, `controller`, `action`, `translate_id`) VALUES
	(1, 'home', 'contact', 1),
	(2, 'home', 'about', 0),
	(4, 'home', 'index', 3),
	(5, 'home', 'index', 2),
	(6, 'home', 'about', 4);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;


-- Zrzut struktury tabela database.gallery
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.gallery: ~2 rows (około)
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` (`id`, `image`) VALUES
	(1, '/data/images/upload/8c03fe16e0a60bbb7120321092375fd5.jpg'),
	(2, '/data/images/upload/d1949d4672ce06d15b5de4871495787b.jpg');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;


-- Zrzut struktury tabela database.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `description` longtext,
  `image` varchar(100) DEFAULT NULL,
  `pinned` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.products: ~2 rows (około)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title`, `description`, `image`, `pinned`) VALUES
	(1, 'REHAU Brillant Design 70', 'Il sistema a più camere REHAU Brillant-Design 70\r\nsi propone come soluzione conveniente e versatile\r\ngrazie alla ideale profondità del profilo da 70 mm.\r\nIl sistema si adatta all\'impiego in abitazioni\r\nunifamiliari e in edifici di grandi dimensioni. La\r\nstruttura perfezionata di questo sistema consente\r\ndi attribuire la massima importanza all\'isolamento\r\ntermico o a fattori di staticità.', '/data/images/upload/5caa87673caf194a08d360160b6c4f14.jpg', 0),
	(2, 'REHAU Brillant Design MD', 'REHAU Brillant-Design MD si basa sul successo del sistema\r\nREHAU Brillant-Design con guarnizione di battuta.\r\nMantenendo le stesse caratteristiche estetiche, REHAU\r\nBrillant-Design MD si è sviluppato come sistema di\r\nguarnizione centrale autonomo. REHAU Brillant-Design MD\r\nmette in primo piano l\'isolamento termico. Le ottime\r\ncaratteristiche isolanti della profondità profilo di 70 mm e\r\ndella tecnica di realizzazione a 5 camere vengono\r\nulteriormente potenziate attraverso la guarnizione centrale.', '/data/images/upload/2383f9ac773b45fb1f149ca304a45d77.jpg', 0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Zrzut struktury tabela database.top_menu
CREATE TABLE IF NOT EXISTS `top_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_element` varchar(25) DEFAULT NULL,
  `order` varchar(25) DEFAULT NULL,
  `link` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.top_menu: ~5 rows (około)
/*!40000 ALTER TABLE `top_menu` DISABLE KEYS */;
INSERT INTO `top_menu` (`id`, `menu_element`, `order`, `link`) VALUES
	(1, 'menu_home_page', '1', 'home/index'),
	(2, 'menu_product', '2', 'products'),
	(3, 'menu_gallery', '3', 'gallery'),
	(4, 'menu_about', '4', 'home/about'),
	(5, 'menu_contact', '5', 'home/contact');
/*!40000 ALTER TABLE `top_menu` ENABLE KEYS */;


-- Zrzut struktury tabela database.translate
CREATE TABLE IF NOT EXISTS `translate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pl` longtext,
  `en` longtext,
  `it` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.translate: ~2 rows (około)
/*!40000 ALTER TABLE `translate` DISABLE KEYS */;
INSERT INTO `translate` (`id`, `pl`, `en`, `it`) VALUES
	(1, '<h3>Knopf vendita ed installazione</h3> \r\n<div class="form-group">\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nvia Gelada 10  22070 Montano Lucino (co) \r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nP.iva:02884300134\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ntel:+390314104220\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ncell:+393938190367\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\n<a href="mailto:info@knopf.co.it">info@knopf.co.it</a>\r\n</div>\r\n</div>', '<h3>Knopf vendita ed installazione</h3> \r\n<div class="form-group">\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nvia Gelada 10  22070 Montano Lucino (co) \r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nP.iva:02884300134\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ntel:+390314104220\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ncell:+393938190367\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\n<a href="mailto:info@knopf.co.it">info@knopf.co.it</a>\r\n</div>\r\n</div>', '<h3>Knopf vendita ed installazione</h3> \r\n<div class="form-group">\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nvia Gelada 10  22070 Montano Lucino (co) \r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\nP.iva:02884300134\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ntel:+390314104220\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\ncell:+393938190367\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">%s</label>\r\n<a href="mailto:info@knopf.co.it">info@knopf.co.it</a>\r\n</div>\r\n</div>'),
	(2, 'Tekst na stronę główną', 'text for home page', '<p>KNOPF Serramenti è nata nel 2005 e si occupa di progettazione, vendita e installazione di serramenti nelle varie tipologie.</p>\r\n<p>Operiamo in zona di Como e abbiamo prodotti di elevata qualità di aziende nord europee dalla decennale esperienza nella produzione di serramenti per esterni ed interni.</p>\r\n<p>La nostra esperienza accumulata negli anni è a vostra disposizione in ogni momento.</p>\r\n<p>La qualità dei materiali prodotti è alla base della filosofia aziendale, non rincorriamo dinamiche di costo puntando invece su prodotti certificati, testati e all\'avanguardia.</p>\r\n<p>Inoltre offriamo un servizio completo dalla gestione dei rapporti al preventivo e installazione dei prodotti.</p>\r\n<legend>Siamo caratterizzati da.</legend>\r\n<ul>\r\n<li>Esperienza</li>\r\n<li>Elevata qualità dei materiali prodotti</li>\r\n<li>Gestione chiara e snella</li>\r\n</ul>'),
	(3, '<p>test</p>', NULL, NULL),
	(4, '<p>O nas by mogÅ‚o byÄ‡</p>', NULL, NULL);
/*!40000 ALTER TABLE `translate` ENABLE KEYS */;


-- Zrzut struktury tabela database.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `surname` varchar(50) NOT NULL DEFAULT '0',
  `city` varchar(50) NOT NULL DEFAULT '0',
  `street` varchar(50) NOT NULL DEFAULT '0',
  `postCode` varchar(50) NOT NULL DEFAULT '0',
  `userName` varchar(50) DEFAULT NULL,
  `userPassword` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Zrzucanie danych dla tabeli database.user: ~1 rows (około)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `surname`, `city`, `street`, `postCode`, `userName`, `userPassword`) VALUES
	(1, 'Aleksander', 'Sowiak', 'Strzelce opolskie', 'Mickiewicza 11', '47-100', 'test', '1e1ad796c570c44209d2c12d550215974578aa90');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
