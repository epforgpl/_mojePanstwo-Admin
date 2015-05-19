-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 19, 2015 at 09:35 AM
-- Server version: 5.5.32-log
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epf`
--

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_dzielnice`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_dzielnice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `numer` varchar(7) NOT NULL,
  `radni` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `radni_ts` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `radni_url` varchar(255) NOT NULL,
  `rady_posiedzenia_harmonogramy` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `rady_posiedzenia_harmonogramy_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rady_posiedzenia_harmonogramy_url` varchar(255) NOT NULL,
  `rady_uchwaly` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `rady_uchwaly_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rady_uchwaly_url` varchar(255) NOT NULL,
  `zarzady_uchwaly` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `zarzady_uchwaly_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zarzady_uchwaly_url` varchar(255) NOT NULL,
  `rady_posiedzenia_protokoly` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `rady_posiedzenia_protokoly_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `rady_posiedzenia_protokoly_url` varchar(255) NOT NULL,
  `zarzady_posiedzenia_protokoly` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `zarzady_posiedzenia_protokoly_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zarzady_posiedzenia_protokoly_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_dzielnice_rady_posiedzenia`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_dzielnice_rady_posiedzenia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dzielnica_id` mediumint(8) unsigned NOT NULL,
  `numer_str` varchar(63) NOT NULL,
  `data` date NOT NULL,
  `opis` varchar(1023) NOT NULL,
  `przedmiot_dokument_id` int(10) unsigned NOT NULL,
  `protokol_dokument_id` int(10) unsigned NOT NULL,
  `protokol_liczba_zalacznikow` mediumint(8) unsigned NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `akcept` enum('0','1') NOT NULL DEFAULT '0',
  `yt_video_id` varchar(127) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dzielnica_id` (`dzielnica_id`,`data`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=902 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_dzielnice_rady_posiedzenia_zalaczniki`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_dzielnice_rady_posiedzenia_zalaczniki` (
  `posiedzenie_id` int(10) unsigned NOT NULL,
  `ord` mediumint(8) unsigned NOT NULL,
  `dokument_id` int(10) unsigned NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  UNIQUE KEY `posiedzenie_id` (`posiedzenie_id`,`ord`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_dzielnice_rady_uchwaly_przedzialy`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_dzielnice_rady_uchwaly_przedzialy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dzielnica_id` smallint(5) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `href` varchar(511) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `latest` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dzielnica_id` (`dzielnica_id`,`label`),
  KEY `dzielnica_id_2` (`dzielnica_id`,`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_glosowania`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_glosowania` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `punkt_id` int(11) NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `druk_id` int(10) unsigned NOT NULL,
  `wynik_id` tinyint(3) unsigned NOT NULL,
  `wynik_str` varchar(127) NOT NULL,
  `data_start` date NOT NULL DEFAULT '0000-00-00',
  `data_stop` date NOT NULL DEFAULT '0000-00-00',
  `typ_str` varchar(127) NOT NULL,
  `status_str` varchar(127) NOT NULL,
  `rodzaj_str` varchar(127) NOT NULL,
  `liczba_glosow_za` smallint(5) unsigned NOT NULL,
  `liczba_glosow_przeciw` smallint(5) unsigned NOT NULL,
  `liczba_glosow_wstrzymanie` smallint(5) unsigned NOT NULL,
  `liczba_obecni` smallint(5) unsigned NOT NULL,
  `liczba_nieglosowali` smallint(5) unsigned NOT NULL,
  `liczba_nieobecni` smallint(5) unsigned NOT NULL,
  `wynik_count` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `punkt_id` (`punkt_id`),
  KEY `wynik_id` (`wynik_id`),
  KEY `druk_id` (`druk_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2399 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_glosowania_glosy`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_glosowania_glosy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `glosowanie_id` int(10) unsigned NOT NULL,
  `radny_str` varchar(255) NOT NULL,
  `glos_str` varchar(31) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `glos_id` tinyint(3) unsigned NOT NULL,
  `radny_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `glosowanie_id` (`glosowanie_id`,`radny_str`),
  KEY `radny_id` (`radny_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76921 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_glosowania_pola`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_glosowania_pola` (
  `pole` varchar(255) NOT NULL,
  PRIMARY KEY (`pole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_jednostki`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_jednostki` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `liczba_urzednikow` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazwa` (`nazwa`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=530 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_oswiadczenia`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_oswiadczenia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `href` varchar(255) NOT NULL,
  `nazwa` varchar(511) NOT NULL,
  `jednostka` varchar(511) NOT NULL,
  `rok` varchar(255) NOT NULL,
  `links_count` smallint(5) unsigned NOT NULL,
  `links_inner_count` smallint(5) unsigned NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `imie` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `dokument_id` int(10) unsigned NOT NULL,
  `urzednik_id` int(10) unsigned NOT NULL DEFAULT '0',
  `jednostka_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `href` (`href`),
  KEY `dokument_id` (`dokument_id`),
  KEY `urzednik_id` (`urzednik_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7756 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sesja_id` int(10) unsigned NOT NULL,
  `sid` varchar(15) NOT NULL,
  `href` varchar(511) NOT NULL,
  `numer` varchar(15) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `liczba_punktow` int(10) unsigned NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `porzadek_akcept` enum('0','1') NOT NULL DEFAULT '0',
  `folder_id` int(10) unsigned NOT NULL DEFAULT '0',
  `_ord` int(10) unsigned NOT NULL,
  `yt_playlist_id` varchar(128) NOT NULL,
  `yt_playlist` enum('0','1','2','3','4','5') NOT NULL DEFAULT '1',
  `yt_playlist_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `preview_yt_id` varchar(32) NOT NULL,
  `kadencja_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `zwolanie_url` varchar(255) NOT NULL,
  `porzadek_url` varchar(255) NOT NULL,
  `podsumowanie_url` varchar(255) NOT NULL,
  `wyniki_url` varchar(255) NOT NULL,
  `stenogram_url` varchar(255) NOT NULL,
  `protokol_url` varchar(255) NOT NULL,
  `zwolanie_dokument_id` int(10) unsigned NOT NULL,
  `porzadek_dokument_id` int(10) unsigned NOT NULL,
  `podsumowanie_dokument_id` int(10) unsigned NOT NULL,
  `wyniki_dokument_id` int(10) unsigned NOT NULL,
  `stenogram_dokument_id` int(10) unsigned NOT NULL,
  `protokol_dokument_id` int(10) unsigned NOT NULL,
  `podsumowanie_status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `podsumowanie_status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_url` varchar(255) NOT NULL,
  `video_status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `video_status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `sesja_id` (`sesja_id`),
  KEY `porzadek_akcept` (`porzadek_akcept`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slave_id` int(11) NOT NULL DEFAULT '0',
  `src` enum('bip','ext') NOT NULL DEFAULT 'bip',
  `posiedzenie_id` int(10) unsigned NOT NULL,
  `druk_id` int(10) unsigned NOT NULL,
  `nr` varchar(31) NOT NULL,
  `ord` int(11) NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `tytul_pelny` varchar(1023) NOT NULL,
  `glosowanie_id` int(10) unsigned NOT NULL,
  `href` varchar(511) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `html_size` int(10) unsigned NOT NULL,
  `wynik_id` tinyint(3) unsigned NOT NULL,
  `wynik_str` varchar(255) NOT NULL,
  `debata_id` int(10) unsigned DEFAULT NULL,
  `global_ord` bigint(20) unsigned NOT NULL,
  `czas` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `czas_start` int(10) unsigned NOT NULL,
  `czas_stop` int(10) unsigned NOT NULL,
  `czas_start_arkusz` int(10) unsigned NOT NULL,
  `czas_stop_arkusz` int(10) unsigned NOT NULL,
  `czas_akcept` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `wystapienia_akcept` enum('0','1','2') NOT NULL DEFAULT '0',
  `start_file_id` int(10) unsigned NOT NULL,
  `start_time` float unsigned NOT NULL,
  `stop_file_id` int(10) unsigned NOT NULL,
  `stop_time` float unsigned NOT NULL,
  `video` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0',
  `video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0',
  `yt_video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `yt_video_id` varchar(127) NOT NULL,
  `resetTimeFileId` int(11) NOT NULL DEFAULT '0',
  `ord_panel` int(11) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(2047) NOT NULL,
  `ext_id` int(10) unsigned DEFAULT NULL,
  `czas_str` varchar(31) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `glosowanie_id` (`glosowanie_id`),
  KEY `druk_id` (`druk_id`),
  KEY `wynik_id` (`wynik_id`),
  KEY `debata_id` (`debata_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4658 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_backup`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `src` enum('bip','ext') NOT NULL DEFAULT 'bip',
  `posiedzenie_id` int(10) unsigned NOT NULL,
  `druk_id` int(10) unsigned NOT NULL,
  `nr` varchar(31) NOT NULL,
  `ord` int(11) NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `tytul_pelny` varchar(1023) NOT NULL,
  `glosowanie_id` int(10) unsigned NOT NULL,
  `href` varchar(511) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `html_size` int(10) unsigned NOT NULL,
  `wynik_id` tinyint(3) unsigned NOT NULL,
  `wynik_str` varchar(255) NOT NULL,
  `debata_id` int(10) unsigned DEFAULT NULL,
  `global_ord` bigint(20) unsigned NOT NULL,
  `czas_start` int(10) unsigned NOT NULL,
  `czas_stop` int(10) unsigned NOT NULL,
  `czas_start_arkusz` int(10) unsigned NOT NULL,
  `czas_stop_arkusz` int(10) unsigned NOT NULL,
  `czas_akcept` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `wystapienia_akcept` enum('0','1','2') NOT NULL DEFAULT '0',
  `start_file_id` int(10) unsigned NOT NULL,
  `start_time` float unsigned NOT NULL,
  `stop_file_id` int(10) unsigned NOT NULL,
  `stop_time` float unsigned NOT NULL,
  `video` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0',
  `video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0',
  `yt_video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `yt_video_id` varchar(127) NOT NULL,
  `resetTimeFileId` int(11) NOT NULL DEFAULT '0',
  `ord_panel` int(11) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(2047) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `src` (`src`,`posiedzenie_id`,`nr`),
  KEY `glosowanie_id` (`glosowanie_id`),
  KEY `druk_id` (`druk_id`),
  KEY `wynik_id` (`wynik_id`),
  KEY `debata_id` (`debata_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4163 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_backup02`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_backup02` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `src` enum('bip','ext') NOT NULL DEFAULT 'bip',
  `posiedzenie_id` int(10) unsigned NOT NULL,
  `druk_id` int(10) unsigned NOT NULL,
  `nr` varchar(31) NOT NULL,
  `ord` int(11) NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `tytul_pelny` varchar(1023) NOT NULL,
  `glosowanie_id` int(10) unsigned NOT NULL,
  `href` varchar(511) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `html_size` int(10) unsigned NOT NULL,
  `wynik_id` tinyint(3) unsigned NOT NULL,
  `wynik_str` varchar(255) NOT NULL,
  `debata_id` int(10) unsigned DEFAULT NULL,
  `global_ord` bigint(20) unsigned NOT NULL,
  `czas_start` int(10) unsigned NOT NULL,
  `czas_stop` int(10) unsigned NOT NULL,
  `czas_start_arkusz` int(10) unsigned NOT NULL,
  `czas_stop_arkusz` int(10) unsigned NOT NULL,
  `czas_akcept` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `wystapienia_akcept` enum('0','1','2') NOT NULL DEFAULT '0',
  `start_file_id` int(10) unsigned NOT NULL,
  `start_time` float unsigned NOT NULL,
  `stop_file_id` int(10) unsigned NOT NULL,
  `stop_time` float unsigned NOT NULL,
  `video` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0',
  `video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0',
  `yt_video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `yt_video_id` varchar(127) NOT NULL,
  `resetTimeFileId` int(11) NOT NULL DEFAULT '0',
  `ord_panel` int(11) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(2047) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `src` (`src`,`posiedzenie_id`,`nr`),
  KEY `glosowanie_id` (`glosowanie_id`),
  KEY `druk_id` (`druk_id`),
  KEY `wynik_id` (`wynik_id`),
  KEY `debata_id` (`debata_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4325 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_backup03`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_backup03` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slave_id` int(11) NOT NULL DEFAULT '0',
  `src` enum('bip','ext') NOT NULL DEFAULT 'bip',
  `posiedzenie_id` int(10) unsigned NOT NULL,
  `druk_id` int(10) unsigned NOT NULL,
  `nr` varchar(31) NOT NULL,
  `ord` int(11) NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `tytul_pelny` varchar(1023) NOT NULL,
  `glosowanie_id` int(10) unsigned NOT NULL,
  `href` varchar(511) NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `html_size` int(10) unsigned NOT NULL,
  `wynik_id` tinyint(3) unsigned NOT NULL,
  `wynik_str` varchar(255) NOT NULL,
  `debata_id` int(10) unsigned DEFAULT NULL,
  `global_ord` bigint(20) unsigned NOT NULL,
  `czas` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `czas_start` int(10) unsigned NOT NULL,
  `czas_stop` int(10) unsigned NOT NULL,
  `czas_start_arkusz` int(10) unsigned NOT NULL,
  `czas_stop_arkusz` int(10) unsigned NOT NULL,
  `czas_akcept` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `wystapienia_akcept` enum('0','1','2') NOT NULL DEFAULT '0',
  `start_file_id` int(10) unsigned NOT NULL,
  `start_time` float unsigned NOT NULL,
  `stop_file_id` int(10) unsigned NOT NULL,
  `stop_time` float unsigned NOT NULL,
  `video` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0',
  `video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video_md5` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `yt_video` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0',
  `yt_video_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `yt_video_id` varchar(127) NOT NULL,
  `resetTimeFileId` int(11) NOT NULL DEFAULT '0',
  `ord_panel` int(11) NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(2047) NOT NULL,
  `ext_id` int(10) unsigned DEFAULT NULL,
  `czas_str` varchar(31) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `src` (`src`,`posiedzenie_id`,`nr`),
  KEY `glosowanie_id` (`glosowanie_id`),
  KEY `druk_id` (`druk_id`),
  KEY `wynik_id` (`wynik_id`),
  KEY `debata_id` (`debata_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4576 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_plan`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_plan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `posiedzenie_data` date NOT NULL,
  `nr` smallint(5) unsigned NOT NULL,
  `tytul` varchar(1023) NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `posiedzenie_data` (`posiedzenie_data`,`nr`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_wystapienia`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_wystapienia` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `punkt_id` int(11) unsigned NOT NULL,
  `ord` int(7) unsigned NOT NULL,
  `nazwa` varchar(63) NOT NULL,
  `stanowisko` varchar(63) NOT NULL,
  `czas` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `czas_str` varchar(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_posiedzenia_punkty_wystapienia_backup01`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_posiedzenia_punkty_wystapienia_backup01` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `punkt_id` int(11) unsigned NOT NULL,
  `ord` int(7) unsigned NOT NULL,
  `nazwa` varchar(63) NOT NULL,
  `stanowisko` varchar(63) NOT NULL,
  `czas` datetime NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  `czas_str` varchar(31) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_sesje`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_sesje` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sid` varchar(15) NOT NULL,
  `href` varchar(511) NOT NULL,
  `numer` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `liczba_posiedzen` int(10) unsigned NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `kadencja_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `numer` (`numer`,`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=126 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_urzednicy`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_urzednicy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(255) NOT NULL,
  `imie` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `opis` varchar(1023) NOT NULL,
  `radny_id` int(10) unsigned NOT NULL DEFAULT '0',
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `krs_akcept` enum('-1','0','1') NOT NULL DEFAULT '-1',
  `krs_osoba_id` int(10) unsigned NOT NULL DEFAULT '0',
  `mowca_id` int(10) unsigned DEFAULT NULL,
  `osoba_id` int(10) unsigned DEFAULT NULL,
  `osoba_fixed_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazwa` (`nazwa`),
  KEY `radny_id` (`radny_id`),
  KEY `mowca_id` (`mowca_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1358 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_urzednicy-krs_osoby`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_urzednicy-krs_osoby` (
  `urzednik_id` int(10) unsigned NOT NULL,
  `osoba_id` int(10) unsigned NOT NULL,
  `score` smallint(5) unsigned NOT NULL,
  UNIQUE KEY `urzednik_id` (`urzednik_id`,`osoba_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_zarzadzenia`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_zarzadzenia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rok` smallint(5) unsigned NOT NULL,
  `numer` mediumint(8) unsigned NOT NULL,
  `status` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `status_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `html_size` mediumint(8) unsigned NOT NULL,
  `analiza` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `analiza_ts` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(1023) NOT NULL,
  `data_podpisania` date NOT NULL DEFAULT '0000-00-00',
  `akcept` enum('0','1') NOT NULL DEFAULT '0',
  `liczba_aktow` smallint(5) unsigned NOT NULL,
  `liczba_zmienianych` smallint(5) unsigned NOT NULL,
  `liczba_zmieniajacych` smallint(5) unsigned NOT NULL,
  `liczba_powiazanych` smallint(5) unsigned NOT NULL,
  `dokument_id` int(10) unsigned NOT NULL,
  `status_str` varchar(127) NOT NULL,
  `realizacja_str` varchar(127) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rok` (`rok`,`numer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35265 ;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_zarzadzenia-zmiany`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_zarzadzenia-zmiany` (
  `akt_id` int(10) unsigned NOT NULL,
  `zmiana_id` int(10) unsigned NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  UNIQUE KEY `akt_id` (`akt_id`,`zmiana_id`),
  KEY `akt_id_2` (`akt_id`,`deleted`),
  KEY `zmiana_id` (`zmiana_id`,`deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pl_gminy_krakow_zarzadzenia_zalaczniki`
--

CREATE TABLE IF NOT EXISTS `pl_gminy_krakow_zarzadzenia_zalaczniki` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `akt_id` int(10) unsigned NOT NULL,
  `dokument_id` int(10) unsigned NOT NULL,
  `title` varchar(1023) NOT NULL,
  `ord` smallint(5) unsigned NOT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `akt_id` (`akt_id`,`dokument_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37136 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pl_gminy_krakow_posiedzenia`
--
ALTER TABLE `pl_gminy_krakow_posiedzenia`
  ADD CONSTRAINT `pl_gminy_krakow_posiedzenia_ibfk_1` FOREIGN KEY (`sesja_id`) REFERENCES `pl_gminy_krakow_sesje` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;