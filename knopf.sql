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

-- Zrzut struktury tabela database.category
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_pl` varchar(50) DEFAULT '0',
  `category_it` varchar(50) DEFAULT '0',
  `category_en` varchar(50) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.category: ~1 rows (około)
DELETE FROM `category`;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `category_pl`, `category_it`, `category_en`) VALUES
	(1, 'none_category', 'none_category', 'none_category'),
	(14, 'Testowa', '0', '0');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Zrzut struktury tabela database.content
DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `description_pl` longtext,
  `description_en` longtext,
  `description_it` longtext,
  PRIMARY KEY (`id`),
  KEY `Indeks 2` (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.content: ~9 rows (około)
DELETE FROM `content`;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`id`, `menu_id`, `description_pl`, `description_en`, `description_it`) VALUES
	(4, 5, '<h3>Knopf vendita ed installazione</h3> \r\n<div class="form-group">\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Adress</label>\r\nvia Gelada 10  22070 Montano Lucino (co) \r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">&nbsp;</label>\r\nP.iva:02884300134\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Tel.</label>\r\ntel:+390314104220\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Tel.</label>\r\ncell:+393938190367\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">E-Mail</label>\r\n<a href="mailto:info@knopf.co.it">info@knopf.co.it</a>\r\n</div>\r\n</div>', NULL, '<h3>Knopf vendita ed installazione</h3> \r\n<div class="form-group">\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Adress</label>\r\nvia Gelada 10  22070 Montano Lucino (co) \r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">&nbsp;</label>\r\nP.iva:02884300134\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Tel.</label>\r\ntel:+390314104220\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">Tel.</label>\r\ncell:+393938190367\r\n</div>\r\n<div class="col-md-8 inputGroupContainer">\r\n<label class="col-md-3 control-label">E-Mail</label>\r\n<a href="mailto:info@knopf.co.it">info@knopf.co.it</a>\r\n</div>\r\n</div>'),
	(9, 1, '<div style="text-align: justify;">Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna. Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi. Aliquam erat ac ipsum. Integer aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id, eleifend justo vel bibendum sapien massa ac turpis faucibus orci luctus non, consectetuer lobortis quis, varius in, purus. Integer ultrices posuere cubilia Curae, Nulla ipsum dolor lacus, suscipit adipiscing. Cum sociis natoque penatibus et ultrices volutpat. Nullam wisi ultricies a, gravida vitae, dapibus risus ante sodales lectus blandit eu, tempor diam pede cursus vitae, ultricies eu, faucibus quis, porttitor eros cursus lectus, pellentesque eget, bibendum a, gravida ullamcorper quam. Nullam viverra consectetuer. Quisque cursus et, porttitor risus. Aliquam sem. In hendrerit nulla quam nunc, accumsan congue. Lorem ipsum primis in nibh vel risus. Sed vel lectus. Ut sagittis, ipsum dolor quam.</div>', NULL, NULL),
	(13, 0, '', NULL, NULL),
	(15, 0, '', NULL, NULL),
	(17, 4, '<p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">Knopf serramenti si occupa di progettazione,vendita ed installazione di serramenti nelle varie tipologie.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">Operiamo in zona di Como ed abbiamo prodotti di elevata qualità di aziende dalla decennale esperienza nella produzione si serramenti per esterni ed esterni.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">La nostra esperienza accumulata negli anni è a vostra disposizione in ogni momento.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">La qualità dei materiali prodotti è alla base della filosofia aziendale,non rincoriamo dinamiche di costo puntando invece su prodotti certificati,testati e all&#8217;avanguardia.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">In oltre offriamo un servizio completo dalla gestione dei rapporti al preventivo ed installazione.</span></p>', NULL, NULL),
	(37, 0, '', NULL, NULL),
	(38, 0, '', NULL, NULL),
	(39, 0, '', NULL, NULL),
	(40, 0, '', NULL, NULL);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;


-- Zrzut struktury tabela database.gallery
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `realization` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.gallery: ~11 rows (około)
DELETE FROM `gallery`;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` (`id`, `image`, `product_id`, `category_id`, `realization`) VALUES
	(12, '/data/images/upload/20121029_124519.jpg', 0, 1, 1),
	(13, '/data/images/upload/20121212_163726.jpg', NULL, 1, NULL),
	(14, '/data/images/upload/20130220_132226.jpg', NULL, 14, NULL),
	(15, '/data/images/upload/20151220_154750.jpg', NULL, 1, NULL),
	(16, '/data/images/upload/20160313_153837.jpg', NULL, 1, NULL),
	(17, '/data/images/upload/20160705_123224.jpg', NULL, 1, NULL),
	(18, '/data/images/upload/20160813_123343.jpg', NULL, 1, 1),
	(19, '/data/images/upload/2383f9ac773b45fb1f149ca304a45d77.jpg', 1, 1, NULL),
	(20, '/data/images/upload/5caa87673caf194a08d360160b6c4f14.jpg', 1, 1, NULL),
	(21, '/data/images/upload/8c03fe16e0a60bbb7120321092375fd5.jpg', NULL, 1, NULL),
	(22, '/data/images/upload/d1949d4672ce06d15b5de4871495787b.jpg', NULL, 1, NULL);
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;


-- Zrzut struktury tabela database.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title_pl` varchar(50) DEFAULT NULL,
  `title_it` varchar(50) DEFAULT NULL,
  `title_en` varchar(50) DEFAULT NULL,
  `description_pl` longtext,
  `description_it` longtext,
  `description_en` longtext,
  `pinned` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.products: ~2 rows (około)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title_pl`, `title_it`, `title_en`, `description_pl`, `description_it`, `description_en`, `pinned`) VALUES
	(1, 'REHAU Brillant Design 70', NULL, '', 'Il sistema a più camere REHAU Brillant-Design 70\r\nsi propone come soluzione conveniente e versatile\r\ngrazie alla ideale profondità del profilo da 70 mm.\r\nIl sistema si adatta all’impiego in abitazioni\r\nunifamiliari e in edifici di grandi dimensioni. La\r\nstruttura perfezionata di questo sistema consente\r\ndi attribuire la massima importanza all’isolamento\r\ntermico o a fattori di staticità.', NULL, NULL, 0),
	(2, 'REHAU Brillant Design MD', '', '', 'REHAU Brillant-Design MD si basa sul successo del sistema\r\nREHAU Brillant-Design con guarnizione di battuta.\r\nMantenendo le stesse caratteristiche estetiche, REHAU\r\nBrillant-Design MD si è sviluppato come sistema di\r\nguarnizione centrale autonomo. REHAU Brillant-Design MD\r\nmette in primo piano l’isolamento termico. Le ottime\r\ncaratteristiche isolanti della profondità profilo di 70 mm e\r\ndella tecnica di realizzazione a 5 camere vengono\r\nulteriormente potenziate attraverso la guarnizione centrale.', NULL, NULL, 0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Zrzut struktury tabela database.top_menu
DROP TABLE IF EXISTS `top_menu`;
CREATE TABLE IF NOT EXISTS `top_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_element` varchar(25) DEFAULT NULL,
  `order` varchar(25) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.top_menu: ~5 rows (około)
DELETE FROM `top_menu`;
/*!40000 ALTER TABLE `top_menu` DISABLE KEYS */;
INSERT INTO `top_menu` (`id`, `menu_element`, `order`, `controller`, `action`) VALUES
	(1, 'menu_home_page', '1', 'home', 'index'),
	(2, 'menu_product', '2', 'products', 'index'),
	(3, 'menu_gallery', '3', 'gallery', 'index'),
	(4, 'menu_about', '4', 'home', 'about'),
	(5, 'menu_contact', '5', 'home', 'contact');
/*!40000 ALTER TABLE `top_menu` ENABLE KEYS */;


-- Zrzut struktury tabela database.user
DROP TABLE IF EXISTS `user`;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli database.user: ~0 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `surname`, `city`, `street`, `postCode`, `userName`, `userPassword`) VALUES
	(1, 'Aleksander', 'Sowiak', 'Strzelce opolskie', 'Mickiewicza 11', '47-100', 'test', '1e1ad796c570c44209d2c12d550215974578aa90');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
