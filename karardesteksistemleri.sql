-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 15 May 2022, 18:11:22
-- Sunucu sürümü: 5.7.31
-- PHP Sürümü: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `karardesteksistemleri`
--

DELIMITER $$
--
-- Yordamlar
--
DROP PROCEDURE IF EXISTS `1000uzeriMaasalanlar`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `1000uzeriMaasalanlar` ()  NO SQL
SELECT CONCAT(personel.per_ad," ",personel.per_soyad) as adSoyad, personel.per_maas
FROM personel
WHERE personel.per_maas>1000$$

DROP PROCEDURE IF EXISTS `10uzeriBasariliGorev`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `10uzeriBasariliGorev` ()  NO SQL
SELECT CONCAT(personel.per_ad," ",personel.per_soyad) as adSoyad, personel.basarili_gorev
FROM personel
WHERE personel.basarili_gorev>10$$

DROP PROCEDURE IF EXISTS `20gunUzeriCalisma`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `20gunUzeriCalisma` ()  NO SQL
SELECT CONCAT(personel.per_ad," ",personel.per_soyad) as adSoyad, personel.calisilanGun
FROM personel
WHERE personel.calisilanGun>20$$

DROP PROCEDURE IF EXISTS `farukYilmazinMusterileri`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `farukYilmazinMusterileri` ()  NO SQL
SELECT CONCAT(musteriler.mus_ad," ",musteriler.mus_soyad) as musteriADSOYAD
FROM musteriler, personel
WHERE musteriler.per_id=personel.per_id AND personel.per_ad="Faruk Yılmaz"$$

DROP PROCEDURE IF EXISTS `musteriEkle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `musteriEkle` (IN `musID` INT(11), IN `perID` INT(11), IN `musAD` VARCHAR(255), IN `musSOYAD` VARCHAR(255))  NO SQL
INSERT INTO musteriler(mus_id,per_id,mus_ad,mus_soyad)
VALUES(musID,perID,musAD,musSOYAD)$$

DROP PROCEDURE IF EXISTS `musteriGuncelle(ID'ye Göre)`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `musteriGuncelle(ID'ye Göre)` (IN `musID` INT(11), IN `perID` INT(11), IN `AD` VARCHAR(255), IN `SOYAD` VARCHAR(255))  NO SQL
UPDATE musteriler SET mus_ad=AD, mus_soyad=SOYAD, per_id=perID WHERE musteri_id=ID$$

DROP PROCEDURE IF EXISTS `musteriSil(ID'ye Göre)`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `musteriSil(ID'ye Göre)` (IN `ID` INT(11))  NO SQL
DELETE FROM musteriler WHERE mus_id=ID$$

DROP PROCEDURE IF EXISTS `personelEKLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `personelEKLE` (IN `perID` INT(11), IN `perAD` VARCHAR(255), IN `perSOYAD` VARCHAR(255), IN `basariliGOREV` INT(11), IN `perMAAS` INT(11), IN `calisilanGUN` INT(11))  NO SQL
INSERT INTO personel(per_id,per_ad,per_soyad,basarili_gorev,per_maas,calisilanGun)
VALUES(perID,perAD,perSOYAD,basariliGOREV,perMAAS,calisilanGUN)$$

DROP PROCEDURE IF EXISTS `personelSIL(ID'ye GORE)`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `personelSIL(ID'ye GORE)` (IN `ID` INT(11))  NO SQL
DELETE FROM personel WHERE per_id=ID$$

DROP PROCEDURE IF EXISTS `verimlilik99Asagisi`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `verimlilik99Asagisi` ()  NO SQL
SELECT CONCAT(personel.per_ad," ",personel.per_soyad) as adSoyad, puan.verimlilik_puan
FROM personel, puan
WHERE personel.per_id = puan.per_id AND puan.verimlilik_puan<99$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `aylar`
--

DROP TABLE IF EXISTS `aylar`;
CREATE TABLE IF NOT EXISTS `aylar` (
  `ay_id` int(11) NOT NULL,
  `ay_ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`ay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `aylar`
--

INSERT INTO `aylar` (`ay_id`, `ay_ad`) VALUES
(1, 'Ocak'),
(2, 'Şubat'),
(3, 'Mart'),
(4, 'Nisan'),
(5, 'Mayıs'),
(6, 'Haziran'),
(7, 'Temmuz'),
(8, 'Ağustos'),
(9, 'Eylül'),
(10, 'Ekim'),
(11, 'Kasım'),
(12, 'Aralık');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `departmanlar`
--

DROP TABLE IF EXISTS `departmanlar`;
CREATE TABLE IF NOT EXISTS `departmanlar` (
  `dep_id` int(11) NOT NULL,
  `dep_ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `departmanlar`
--

INSERT INTO `departmanlar` (`dep_id`, `dep_ad`) VALUES
(100, 'Back-End'),
(101, 'Finans'),
(102, 'Front-End');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `depgid_ay`
--

DROP TABLE IF EXISTS `depgid_ay`;
CREATE TABLE IF NOT EXISTS `depgid_ay` (
  `dep_id` int(11) NOT NULL,
  `ay_id` int(11) NOT NULL,
  `gider` int(11) NOT NULL,
  KEY `dep_id` (`dep_id`),
  KEY `ay_id` (`ay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `depgid_ay`
--

INSERT INTO `depgid_ay` (`dep_id`, `ay_id`, `gider`) VALUES
(100, 1, 2000),
(101, 1, 3000),
(102, 1, 1000),
(100, 2, 1000),
(101, 2, 1000),
(102, 2, 2000),
(100, 3, 1000),
(101, 3, 2000),
(102, 3, 1000),
(100, 4, 2000),
(101, 4, 3000),
(102, 4, 1000),
(100, 5, 500),
(101, 5, 500),
(102, 5, 1000),
(100, 6, 500),
(101, 6, 1500),
(102, 6, 1000),
(100, 7, 2000),
(101, 7, 2500),
(102, 7, 2500),
(100, 8, 1500),
(101, 8, 2500),
(102, 8, 1000),
(100, 9, 1000),
(101, 9, 1000),
(102, 9, 1000),
(100, 10, 1500),
(101, 10, 500),
(102, 10, 2000),
(100, 11, 7000),
(101, 11, 3000),
(102, 11, 4000),
(100, 12, 500),
(101, 12, 500),
(102, 12, 10000);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dep_ay`
--

DROP TABLE IF EXISTS `dep_ay`;
CREATE TABLE IF NOT EXISTS `dep_ay` (
  `dep_id` int(11) NOT NULL,
  `ay_id` int(11) NOT NULL,
  `kar` int(11) NOT NULL,
  KEY `dep_id` (`dep_id`),
  KEY `ay_id` (`ay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `dep_ay`
--

INSERT INTO `dep_ay` (`dep_id`, `ay_id`, `kar`) VALUES
(100, 1, 1000),
(101, 1, 3000),
(102, 1, 3000),
(100, 2, 4000),
(101, 2, 2000),
(102, 2, 2000),
(100, 3, 3000),
(101, 3, 4000),
(102, 3, 5000),
(100, 4, 1000),
(101, 4, 1000),
(102, 4, 2000),
(100, 5, 2000),
(101, 5, 2000),
(102, 5, 2000),
(100, 6, 500),
(101, 6, 500),
(102, 6, 2000),
(100, 7, 2000),
(101, 7, 3000),
(102, 7, 1000),
(100, 8, 1500),
(101, 8, 3500),
(102, 8, 6000),
(100, 9, 3200),
(101, 9, 2300),
(102, 9, 1200),
(100, 10, 1250),
(101, 10, 3150),
(102, 10, 2300),
(100, 11, 1200),
(101, 11, 1120),
(102, 11, 3210),
(100, 12, 1220),
(101, 12, 3100),
(102, 12, 4100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gorev_ay`
--

DROP TABLE IF EXISTS `gorev_ay`;
CREATE TABLE IF NOT EXISTS `gorev_ay` (
  `ay_id` int(11) NOT NULL,
  `basariliGorevSayi` int(11) NOT NULL,
  `basarisizGorevSayi` int(11) NOT NULL,
  KEY `ay_id` (`ay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gorev_ay`
--

INSERT INTO `gorev_ay` (`ay_id`, `basariliGorevSayi`, `basarisizGorevSayi`) VALUES
(1, 10, 2),
(2, 12, 4),
(3, 8, 3),
(4, 5, 1),
(5, 9, 4),
(6, 12, 1),
(7, 11, 3),
(8, 10, 2),
(9, 21, 5),
(10, 18, 4),
(11, 15, 2),
(12, 13, 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteriler`
--

DROP TABLE IF EXISTS `musteriler`;
CREATE TABLE IF NOT EXISTS `musteriler` (
  `mus_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_id` int(11) NOT NULL,
  `mus_ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `mus_soyad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `degerlendirme` int(11) NOT NULL,
  PRIMARY KEY (`mus_id`),
  KEY `per_id` (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `musteriler`
--

INSERT INTO `musteriler` (`mus_id`, `per_id`, `mus_ad`, `mus_soyad`, `degerlendirme`) VALUES
(1, 1, 'Utku', 'ALTUN', 9),
(2, 1, 'Yaşar', 'KOKSAL', 7),
(3, 2, 'Kutlu', 'KOKSAL', 5),
(4, 6, 'Tunay', 'ÖZKAN', 5);

--
-- Tetikleyiciler `musteriler`
--
DROP TRIGGER IF EXISTS `musteri_buyuk_harf`;
DELIMITER $$
CREATE TRIGGER `musteri_buyuk_harf` BEFORE INSERT ON `musteriler` FOR EACH ROW SET new.mus_ad=
concat(upper(substring(new.mus_ad,1,1)),lower(substring(new.mus_ad,2))),
new.mus_soyad=Upper(new.mus_soyad)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mus_ay`
--

DROP TABLE IF EXISTS `mus_ay`;
CREATE TABLE IF NOT EXISTS `mus_ay` (
  `musteriSayi` int(11) NOT NULL,
  `ay_id` int(11) NOT NULL,
  KEY `ay_id` (`ay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mus_ay`
--

INSERT INTO `mus_ay` (`musteriSayi`, `ay_id`) VALUES
(10, 1),
(6, 2),
(3, 3),
(5, 4),
(7, 5),
(3, 6),
(7, 7),
(12, 8),
(11, 9),
(10, 10),
(3, 11),
(4, 12);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel`
--

DROP TABLE IF EXISTS `personel`;
CREATE TABLE IF NOT EXISTS `personel` (
  `per_id` int(11) NOT NULL,
  `dep_id` int(11) NOT NULL,
  `per_ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `per_soyad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `basarili_gorev` int(11) NOT NULL,
  `basarisiz_gorev` int(11) NOT NULL,
  `per_maas` int(11) NOT NULL,
  `calisilanGun` int(11) NOT NULL,
  PRIMARY KEY (`per_id`),
  KEY `dep_id` (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `personel`
--

INSERT INTO `personel` (`per_id`, `dep_id`, `per_ad`, `per_soyad`, `basarili_gorev`, `basarisiz_gorev`, `per_maas`, `calisilanGun`) VALUES
(1, 100, 'Eren', 'ALTUN', 30, 2, 3000, 289),
(2, 101, 'Süeda', 'CENGİZ', 30, 1, 5000, 289),
(3, 102, 'Arda', 'YILMAZ', 40, 1, 5000, 289),
(4, 101, 'Batur', 'YILMAZ', 30, 1, 2000, 250),
(5, 101, 'Fatma', 'YILMAZ', 30, 5, 2000, 289),
(6, 100, 'Tugay', 'ÖZTÜRK', 40, 2, 3400, 250),
(7, 101, 'Tayfun', 'DAĞCI', 35, 12, 3400, 232),
(8, 102, 'Koray', 'ALKAR', 23, 12, 5000, 120);

--
-- Tetikleyiciler `personel`
--
DROP TRIGGER IF EXISTS `personel_buyuk_harf`;
DELIMITER $$
CREATE TRIGGER `personel_buyuk_harf` BEFORE INSERT ON `personel` FOR EACH ROW SET new.per_ad=
concat(upper(substring(new.per_ad,1,1)),lower(substring(new.per_ad,2))),
new.per_soyad=Upper(new.per_soyad)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `verimlilikPuan`;
DELIMITER $$
CREATE TRIGGER `verimlilikPuan` AFTER INSERT ON `personel` FOR EACH ROW INSERT INTO puan(per_id, verimlilik_puan) VALUES(new.per_id, (new.calisilanGun+(select personel.basarili_gorev/personel.basarisiz_gorev FROM personel WHERE personel.per_id = new.per_id)*20)/10)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `puan`
--

DROP TABLE IF EXISTS `puan`;
CREATE TABLE IF NOT EXISTS `puan` (
  `per_id` int(11) NOT NULL,
  `verimlilik_puan` int(11) NOT NULL,
  KEY `per_id` (`per_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `puan`
--

INSERT INTO `puan` (`per_id`, `verimlilik_puan`) VALUES
(1, 59),
(2, 89),
(3, 109),
(4, 85),
(5, 41),
(6, 65),
(7, 29),
(8, 16);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yoneticiler`
--

DROP TABLE IF EXISTS `yoneticiler`;
CREATE TABLE IF NOT EXISTS `yoneticiler` (
  `yon_id` int(100) NOT NULL AUTO_INCREMENT,
  `yon_ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `yon_soyad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `dep_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` int(11) NOT NULL,
  `cepTelefonu` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `sabitTelefon` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `adres` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`yon_id`),
  KEY `dep_id` (`dep_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yoneticiler`
--

INSERT INTO `yoneticiler` (`yon_id`, `yon_ad`, `yon_soyad`, `dep_id`, `email`, `sifre`, `cepTelefonu`, `sabitTelefon`, `adres`) VALUES
(10, 'Arda', 'Yılmaz', 102, 'ardayilmaz@gmail.com', 1234, '05308687458', '02325874857', 'Ordu/İkizce Beylerce Mahallesi.'),
(11, 'Ahmet Eren', 'Yılmaz', 100, 'ahmeteren@gmail.com', 12345, '05308689471', '02325874785', 'Yaylacık Mahallesi/Buca');

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `depgid_ay`
--
ALTER TABLE `depgid_ay`
  ADD CONSTRAINT `depgid_ay_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departmanlar` (`dep_id`),
  ADD CONSTRAINT `depgid_ay_ibfk_2` FOREIGN KEY (`ay_id`) REFERENCES `aylar` (`ay_id`);

--
-- Tablo kısıtlamaları `dep_ay`
--
ALTER TABLE `dep_ay`
  ADD CONSTRAINT `dep_ay_ibfk_1` FOREIGN KEY (`ay_id`) REFERENCES `aylar` (`ay_id`),
  ADD CONSTRAINT `dep_ay_ibfk_2` FOREIGN KEY (`dep_id`) REFERENCES `departmanlar` (`dep_id`);

--
-- Tablo kısıtlamaları `gorev_ay`
--
ALTER TABLE `gorev_ay`
  ADD CONSTRAINT `gorev_ay_ibfk_1` FOREIGN KEY (`ay_id`) REFERENCES `aylar` (`ay_id`);

--
-- Tablo kısıtlamaları `musteriler`
--
ALTER TABLE `musteriler`
  ADD CONSTRAINT `musteriler_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `personel` (`per_id`);

--
-- Tablo kısıtlamaları `mus_ay`
--
ALTER TABLE `mus_ay`
  ADD CONSTRAINT `mus_ay_ibfk_1` FOREIGN KEY (`ay_id`) REFERENCES `aylar` (`ay_id`);

--
-- Tablo kısıtlamaları `personel`
--
ALTER TABLE `personel`
  ADD CONSTRAINT `personel_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departmanlar` (`dep_id`);

--
-- Tablo kısıtlamaları `puan`
--
ALTER TABLE `puan`
  ADD CONSTRAINT `puan_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `personel` (`per_id`);

--
-- Tablo kısıtlamaları `yoneticiler`
--
ALTER TABLE `yoneticiler`
  ADD CONSTRAINT `yoneticiler_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `departmanlar` (`dep_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
