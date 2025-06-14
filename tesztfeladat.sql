-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2025. Jún 14. 10:01
-- Kiszolgáló verziója: 9.1.0
-- PHP verzió: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `tesztfeladat`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `group`
--

INSERT INTO `group` (`id`, `name`, `parent_id`, `is_deleted`) VALUES
(1, 'Network', NULL, 0),
(2, 'IT', NULL, 0),
(3, 'Finance', NULL, 0),
(4, 'HR', 1, 0),
(5, 'Support', 1, 0),
(6, 'Marketing', NULL, 0),
(7, 'Sales', NULL, 0),
(8, 'Production', 7, 0),
(9, 'PPC', 6, 0),
(10, 'Old Group', NULL, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb4_hungarian_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_hungarian_ci NOT NULL DEFAULT 'student',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `auth_key`, `role`) VALUES
(1, 'admin', '$2y$12$P9HCgJkFg4GibkiGcGjOZ.iJWnaIfBvKOA9dTG0Uyz7Kc6Zip0xTm', 'adminkey', 'admin'),
(2, 'student', '$2y$12$TE2GMCT835b/xYuW1l3QYeb0orVZTGfBQoAmc0cNDSj0zflxu8eDG', 'studentkey', 'student');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
