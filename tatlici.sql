-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 06 Nis 2026, 21:33:23
-- Sunucu sürümü: 8.4.7
-- PHP Sürümü: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tatlici`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

DROP TABLE IF EXISTS `ayarlar`;
CREATE TABLE IF NOT EXISTS `ayarlar` (
  `id` int NOT NULL,
  `site_basligi` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `site_aciklama` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `adres` text COLLATE utf8mb4_turkish_ci,
  `facebook` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `site_basligi`, `site_aciklama`, `logo`, `email`, `telefon`, `adres`, `facebook`, `instagram`, `twitter`) VALUES
(1, 'Tatlıcı E-Ticaret', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

DROP TABLE IF EXISTS `kategoriler`;
CREATE TABLE IF NOT EXISTS `kategoriler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori_adi` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `kategori_adi`) VALUES
(1, 'Sütlü Tatlılar'),
(2, 'Şerbetli Tatlılar'),
(3, 'Pastalar'),
(4, 'Dondurmalar');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int NOT NULL,
  `ad` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `soyad` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `eposta` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `telefon` varchar(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `cinsiyet` varchar(10) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `dogum_tarihi` date DEFAULT NULL,
  `kayit_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `eposta` (`eposta`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `rol_id`, `ad`, `soyad`, `eposta`, `sifre`, `telefon`, `cinsiyet`, `dogum_tarihi`, `kayit_tarihi`) VALUES
(1, 1, 'Feyza', 'Nur', 'feyza@gmail.com', '$2y$10$pfqpzIMOYl6DWILjaz93WO8JWQngbcEzMJXTMeki7a5cgFXTMb7jO', NULL, NULL, NULL, '2026-04-06 17:48:21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `loglar`
--

DROP TABLE IF EXISTS `loglar`;
CREATE TABLE IF NOT EXISTS `loglar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `hata_mesaji` text COLLATE utf8mb4_turkish_ci,
  `ip_adresi` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menuler`
--

DROP TABLE IF EXISTS `menuler`;
CREATE TABLE IF NOT EXISTS `menuler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu_adi` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sira_no` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roller`
--

DROP TABLE IF EXISTS `roller`;
CREATE TABLE IF NOT EXISTS `roller` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_adi` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `roller`
--

INSERT INTO `roller` (`id`, `rol_adi`) VALUES
(1, 'Süper Admin'),
(2, 'Editör'),
(3, 'Moderatör'),
(4, 'Müşteri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

DROP TABLE IF EXISTS `siparisler`;
CREATE TABLE IF NOT EXISTS `siparisler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kullanici_id` int NOT NULL,
  `toplam_tutar` decimal(10,2) DEFAULT NULL,
  `durum` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT 'Beklemede',
  `tarih` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kullanici_id` (`kullanici_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`id`, `kullanici_id`, `toplam_tutar`, `durum`, `tarih`) VALUES
(1, 1, 550.00, 'Beklemede', '2026-04-06 19:41:13'),
(2, 1, 950.00, 'Beklemede', '2026-04-06 19:43:38'),
(3, 1, 950.00, 'Beklemede', '2026-04-06 19:50:15'),
(4, 1, 770.00, 'Beklemede', '2026-04-06 20:39:03');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparis_urunler`
--

DROP TABLE IF EXISTS `siparis_urunler`;
CREATE TABLE IF NOT EXISTS `siparis_urunler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siparis_id` int NOT NULL,
  `urun_id` int NOT NULL,
  `adet` int NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_siparis` (`siparis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `siparis_urunler`
--

INSERT INTO `siparis_urunler` (`id`, `siparis_id`, `urun_id`, `adet`, `fiyat`) VALUES
(1, 1, 1, 1, 550.00),
(2, 2, 2, 1, 400.00),
(3, 2, 1, 1, 550.00),
(4, 3, 2, 1, 400.00),
(5, 3, 1, 1, 550.00),
(6, 4, 15, 1, 500.00),
(7, 4, 9, 1, 150.00),
(8, 4, 6, 1, 120.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `slider`
--

DROP TABLE IF EXISTS `slider`;
CREATE TABLE IF NOT EXISTS `slider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `resim` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `baslik` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `aciklama` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `sira_no` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori_id` int NOT NULL,
  `baslik` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8mb4_turkish_ci,
  `fiyat` decimal(10,2) NOT NULL,
  `resim` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `stok` int DEFAULT '0',
  `aktif_mi` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `kategori_id`, `baslik`, `aciklama`, `fiyat`, `resim`, `stok`, `aktif_mi`) VALUES
(1, 2, 'Fıstıklı Baklava (1Kg)', 'Gerçek Gaziantep fıstığı ile hazırlanan, tereyağlı kat kat çıtırlık. Taş fırında özenle pişirilmiş, geleneksel lezzetin modern sunumu.', 550.00, '69d3f5d7b6563-Fbaklava.webp', NULL, 1),
(2, 2, 'Cevizli Ev Baklavası (1 Kg)', 'İncecik 40 kat yufka ve bol ceviz içi. Anne eli değmiş gibi doğal ve taze.', 400.00, '69d3fdcb32165-Cbaklava.png', 10, 1),
(3, 1, 'Fırın Sütlaç', 'Pirinç, süt ve şekerin muhteşem uyumu. Özellikle fırınlanmış hali (Fırın Sütlaç) üzerindeki yanık katmanla ayrı bir lezzet sunar.', 120.00, '69d41008bcbf0-firinsutlac.jpg', 10, 1),
(4, 1, 'Kazandibi', 'Tavukgöğsü veya muhallebinin dibinin hafifçe yakılmasıyla elde edilen, karamelize tadıyla öne çıkan geleneksel bir lezzet.', 120.00, '69d410991447e-kazandibi.jpg', 10, 1),
(5, 1, 'Keşkül', 'Osmanlı mutfağından günümüze gelen, içinde dövülmüş badem bulunan yoğun kıvamlı ve aromatik bir sütlü tatlı.', 120.00, '69d4112e2e3fa-keskul.webp', 10, 1),
(6, 1, 'Magnolia', 'Akışkan bir krema, bisküvi parçaları ve taze meyvelerin kat kat dizilmesiyle hazırlanır.', 120.00, '69d411eb657cd-magnolia.jpg', 10, 1),
(7, 2, 'Şekerpare (1Kg)', 'İrmikli hamurdan yapılan, fırından çıkar çıkmaz şerbetle buluşan, ağızda dağılan yumuşak bir kurabiye tatlısı', 300.00, '69d412b5c96ea-sekerpare.png', 10, 1),
(8, 2, 'Tulumba (1Kg)', 'Kızgın yağda kızartılan hamur parçalarının soğuk şerbetle buluşmasıyla oluşan, dışı çıtır içi bol şerbetli bir sokak lezzeti.', 300.00, '69d4133c58298-tulumba.webp', 10, 1),
(9, 2, 'Künefe', 'Kadayıf telleri arasına özel tuzsuz peynir konularak pişirilen ve sıcak servis edilen, peyniri uzayan Hatay yöresine ait sıcak bir şerbetli tatlı.', 150.00, '69d413b9e6fdc-kunefe.jpg', 10, 1),
(10, 3, 'Kara Orman', 'Yoğun bitter çikolatalı kek katmanları arasına gizlenmiş mayhoş vişne taneleri ve taptaze krema. Hem tatlı hem ferah bir pasta arayanlar için ormanın en lezzetli sırrı burada.', 750.00, '69d414b01ea2e-karaorman-pastasi.jpg', 10, 1),
(11, 3, 'Red Velvet', 'Aşkın ve zarafetin pasta hali! Hafif kakaolu, kadifemsi kırmızı keki ve rüya gibi yumuşak peynir kremasıyla her dilimde sofistike bir deneyim sunuyor.', 750.00, '69d41589531dd-redvelvet.jpg', 10, 1),
(12, 3, 'Ekler (1Kg)', 'Küçük bir hamur, dev bir mutluluk! İçi enfes pastacı kremasıyla dolu, dışı ise parlak çikolata ganajıyla mühürlenmiş bu Fransız efsanesi, tek lokmada bağımlılık yaratıyor.', 450.00, '69d4160f440e2-ekler.jpg', 10, 1),
(13, 4, 'Hakiki Maraş Dondurması (1Kg)', 'Kaşığa direnç gösteren o meşhur doku! Ahır Dağı’nın yabani orkidelerinden gelen saf salep ve keçi sütünün sakız gibi uzayan kıvamı... Geleneksel dövme dondurmanın gerçek ustalığı her lokmada.', 550.00, '69d416d84e11b-maras-dondurmasi.webp', 10, 1),
(14, 4, 'Venedik Usulü Vanilya (1Kg)', 'Madagaskar\'ın gerçek vanilya çubuklarından gelen siyah tanecikli dokusuyla, sadeliğin ne kadar ihtişamlı olabileceğinin kanıtı. Kremamsı yapısıyla her tatlının yanına en çok yakışan asil bir eşlikçi.', 500.00, '69d4184814a75-vanilyalı-dondurma.avif', 10, 1),
(15, 4, 'İtalyan Karameli (1Kg)', 'Yavaşça karamelize edilen şekerin, özel doğal aromalarla kristal mavisine dönüştüğü bu özel karışım, damakta bıraktığı kadifemsi hisle fark yaratıyor.', 500.00, '69d419bdf0e11-italyankarameli.webp', 10, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

DROP TABLE IF EXISTS `yorumlar`;
CREATE TABLE IF NOT EXISTS `yorumlar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `urun_id` int NOT NULL,
  `kullanici_id` int NOT NULL,
  `puan` int NOT NULL,
  `yorum` text COLLATE utf8mb4_turkish_ci NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aktif_mi` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_urun` (`urun_id`),
  KEY `fk_kullanici` (`kullanici_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD CONSTRAINT `kullanicilar_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roller` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `siparisler`
--
ALTER TABLE `siparisler`
  ADD CONSTRAINT `siparisler_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`);

--
-- Tablo kısıtlamaları `siparis_urunler`
--
ALTER TABLE `siparis_urunler`
  ADD CONSTRAINT `fk_siparis` FOREIGN KEY (`siparis_id`) REFERENCES `siparisler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `urunler`
--
ALTER TABLE `urunler`
  ADD CONSTRAINT `urunler_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategoriler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD CONSTRAINT `fk_kullanici` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_urun` FOREIGN KEY (`urun_id`) REFERENCES `urunler` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
