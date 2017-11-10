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
-- Zrzucanie danych dla tabeli database.category: ~2 rows (około)
DELETE FROM `category`;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `category_pl`, `category_it`, `category_en`) VALUES
	(1, 'none_category', 'none_category', 'none_category'),
	(2, 'Produkty', NULL, NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- Zrzucanie danych dla tabeli database.content: ~2 rows (około)
DELETE FROM `content`;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` (`id`, `menu_id`, `description_pl`, `description_en`, `description_it`) VALUES
	(1, 4, NULL, NULL, '<p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">Knopf serramenti si occupa di progettazione,vendita ed installazione di serramenti nelle varie tipologie.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">Operiamo in zona di Como ed abbiamo prodotti di elevata qualità di aziende dalla decennale esperienza nella produzione si serramenti per esterni ed esterni.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">La nostra esperienza accumulata negli anni è a vostra disposizione in ogni momento.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">La qualità dei materiali prodotti è alla base della filosofia aziendale,non rincoriamo dinamiche di costo puntando invece su prodotti certificati,testati e all’avanguardia.</span></p><p style="font-family: arial; font-size: 12px;"><span style="font-size: medium;">In oltre offriamo un servizio completo dalla gestione dei rapporti al preventivo ed installazione.</span></p>'),
	(2, 1, '<p>Strona startowa..</p>', NULL, NULL);
/*!40000 ALTER TABLE `content` ENABLE KEYS */;

-- Zrzucanie danych dla tabeli database.gallery: ~6 rows (około)
DELETE FROM `gallery`;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` (`id`, `image`, `image_thumb`, `product_id`, `category_id`, `realization`) VALUES
	(1, '/data/images/upload/1002f496c7cec09ac0d2d942dc397a4fe70947c4.jpg', '/data/images/upload/thumb_1002f496c7cec09ac0d2d942dc397a4fe70947c4.jpg', NULL, 2, NULL),
	(2, '/data/images/upload/b0b82d9ef3aa2633033a0dab093df529af2aae13.jpg', '/data/images/upload/thumb_b0b82d9ef3aa2633033a0dab093df529af2aae13.jpg', 4, 2, NULL),
	(3, '/data/images/upload/f87b3553414bf66d3b45e401704746da22b135a5.jpg', '/data/images/upload/thumb_f87b3553414bf66d3b45e401704746da22b135a5.jpg', NULL, 2, NULL),
	(4, '/data/images/upload/0f0a12357c39bb4c17280c7f8ebe678e828803d4.jpg', '/data/images/upload/thumb_0f0a12357c39bb4c17280c7f8ebe678e828803d4.jpg', NULL, 2, NULL),
	(5, '/data/images/upload/48a8d522f546ff59a28e5954f5f08d60b67ab5b4.jpg', '/data/images/upload/thumb_48a8d522f546ff59a28e5954f5f08d60b67ab5b4.jpg', NULL, 2, NULL),
	(6, '/data/images/upload/487ef169e2a8b9586387484cdea1d9ccdd7202db.jpg', '/data/images/upload/thumb_487ef169e2a8b9586387484cdea1d9ccdd7202db.jpg', NULL, 2, NULL);
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;

-- Zrzucanie danych dla tabeli database.products: ~1 rows (około)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title_pl`, `title_it`, `title_en`, `description_pl`, `description_it`, `description_en`, `pinned`) VALUES
	(4, 'Prime', NULL, NULL, '<h2><span style="color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif;">Opis</span></h2><p><span style="color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif;">Okna w systemie PRIME to ekskluzywne połączenie doskonałych parametrów termicznych z eleganckim klasycznym wzornictwem oraz nowatorską technologią. Zaprojektowany z troską o środowisko, komfort użytkowania i bezpieczeństwo, przy zastosowaniu najlepszych rozwiązań obniżających zużycie energii.</span></p><p><span style="color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif;"><br></span></p><h2><span style="color: rgb(51, 51, 51); font-family: &quot;Open Sans&quot;, sans-serif;">Charakterystyka</span></h2><h2><ul style="list-style: none; padding: 0px; margin-right: 0px; margin-bottom: 9px; margin-left: 7px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;"><li style="list-style: none; padding: 0px; margin: 0px 0px 0px 22px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; background: transparent; line-height: 23px;">głębokość zabudowy 93 mm, to najszerszy system z dostępnych na rynku o współczynniku izolacyjności Uf=0,98 W/m<span style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 10px; vertical-align: baseline; background: transparent; height: 0px; line-height: 1; position: relative; bottom: 1ex;">2</span>K</li><li style="list-style: none; padding: 0px; margin: 0px 0px 0px 22px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; background: transparent; line-height: 23px;">7 komorowy profil klasy A z wysokogatunkowego, bezołowiowego PVC, zapewnia najlepszą izolacją termiczną i akustyczną oraz bezpieczeństwo użytkowania</li><li style="list-style: none; padding: 0px; margin: 0px 0px 0px 22px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; background: transparent; line-height: 23px;">potrójny system uszczelnienia z uszczelką środkową idealnie chroni przed wilgocią i chłodem</li><li style="list-style: none; padding: 0px; margin: 0px 0px 0px 22px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; background: transparent; line-height: 23px;">barwiona w masie ścianka profilu w okleinach zewnętrznych to estetyka i trwałość na długie lata</li><li style="list-style: none; padding: 0px; margin: 0px 0px 0px 22px; border: 0px; outline: 0px; font-size: 14px; vertical-align: baseline; background: transparent; line-height: 23px;">doskonałe parametry termiczne o charakterystyce odpowiadającej wymogom budownictwa pasywnego</li><li></li></ul><div class="one_full" style="margin: 0px; padding: 0px; border: 0px; outline: 0px; font-size: 13px; vertical-align: baseline; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; width: 788.688px; color: rgb(51, 51, 51); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; display: inline-block;"></div></h2>', NULL, NULL, 0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

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

-- Zrzucanie danych dla tabeli database.user: ~2 rows (około)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `surname`, `city`, `street`, `postCode`, `userName`, `userPassword`) VALUES
	(1, 'Aleksander', 'Sowiak', 'Strzelce opolskie', 'Mickiewicza 11', '47-100', 'asowiak', 'd59b27fca9e562d57959bfe644d214536ac4b561'),
	(2, 'Rober', 'Guzik', NULL, NULL, '4HbJv9', 'rguzik', 'ef3eacbde8e0eb434b74f3f9329c74e1f3267772');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
