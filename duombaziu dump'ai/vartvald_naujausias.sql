-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2022 at 01:31 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vartvald`
--

-- --------------------------------------------------------

--
-- Table structure for table `apmokejimas`
--

CREATE TABLE `apmokejimas` (
  `id` int(11) NOT NULL,
  `apmokejimo_budas` int(11) NOT NULL,
  `data` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apmokejimas`
--

INSERT INTO `apmokejimas` (`id`, `apmokejimo_budas`, `data`) VALUES
(1, 1, '2022-11-12 20:22:59'),
(2, 2, '2022-11-12 20:23:06'),
(3, 1, '2022-11-12 21:42:52'),
(18, 2, '2022-12-10 20:54:44'),
(19, 2, '2022-12-10 21:01:14'),
(20, 2, '2022-12-10 21:05:26'),
(21, 2, '2022-12-10 21:33:54'),
(22, 1, '2022-12-11 14:54:05'),
(23, 1, '2022-12-11 15:08:42'),
(24, 1, '2022-12-11 15:12:54'),
(25, 1, '2022-12-11 15:26:54'),
(26, 1, '2022-12-11 15:27:46'),
(27, 1, '2022-12-11 15:28:15'),
(28, 1, '2022-12-11 15:33:16'),
(30, 3, '2022-12-11 15:56:45'),
(31, 3, '2022-12-11 18:02:01'),
(32, 1, '2022-12-11 18:09:12'),
(33, 1, '2022-12-11 18:10:11'),
(34, 1, '2022-12-11 18:10:43'),
(35, 2, '2022-12-11 18:11:36'),
(36, 3, '2022-12-11 18:12:12'),
(37, 2, '2022-12-14 13:52:22');

-- --------------------------------------------------------

--
-- Table structure for table `apmokejimo_budai`
--

CREATE TABLE `apmokejimo_budai` (
  `id` int(11) NOT NULL,
  `budas` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `apmokejimo_budai`
--

INSERT INTO `apmokejimo_budai` (`id`, `budas`) VALUES
(1, 'Kortele'),
(2, 'Grynais'),
(3, 'Banko pavedimu');

-- --------------------------------------------------------

--
-- Table structure for table `inventorius`
--

CREATE TABLE `inventorius` (
  `id` int(11) NOT NULL,
  `Kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventorius`
--

INSERT INTO `inventorius` (`id`, `Kiekis`) VALUES
(7, 15),
(8, 108),
(26, 300),
(29, 4);

-- --------------------------------------------------------

--
-- Table structure for table `krepselis_pagalbinis`
--

CREATE TABLE `krepselis_pagalbinis` (
  `userid` varchar(32) CHARACTER SET utf8 NOT NULL,
  `visas_kiekis` int(11) NOT NULL,
  `visa_kaina` float NOT NULL,
  `fk_nuolaidos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `krepselis_pagalbinis`
--

INSERT INTO `krepselis_pagalbinis` (`userid`, `visas_kiekis`, `visa_kaina`, `fk_nuolaidos_id`) VALUES
('689e5b2971577d707becb97405ede951', 2, 2.99, NULL),
('bad596e6029596d4ef57c2a5f49a91ed', 1, 2.23, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nuolaidos`
--

CREATE TABLE `nuolaidos` (
  `id` int(11) NOT NULL,
  `nuolaida` float NOT NULL,
  `galiojimo_pradzia` datetime NOT NULL,
  `galiojimo_pabaiga` datetime NOT NULL,
  `panaudojimai` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nuolaidos`
--

INSERT INTO `nuolaidos` (`id`, `nuolaida`, `galiojimo_pradzia`, `galiojimo_pabaiga`, `panaudojimai`) VALUES
(1, 2.64, '2022-12-01 21:30:01', '2022-12-08 21:30:01', 0),
(2, 5.22, '2022-12-07 21:30:14', '2022-12-15 21:30:14', 0),
(3, 1.01, '2022-12-04 21:30:27', '2022-12-05 21:30:27', 0),
(10, 10, '2022-12-01 21:30:44', '2022-12-31 21:30:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pirkimai`
--

CREATE TABLE `pirkimai` (
  `id` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `kaina` float NOT NULL,
  `prekiu_kiekis` int(11) NOT NULL,
  `fk_vartotojas_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `fk_pristatymo_id` int(11) NOT NULL,
  `fk_apmokejimo_budo_id` int(11) NOT NULL,
  `fk_nuolaidos_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pirkimai`
--

INSERT INTO `pirkimai` (`id`, `data`, `kaina`, `prekiu_kiekis`, `fk_vartotojas_id`, `fk_pristatymo_id`, `fk_apmokejimo_budo_id`, `fk_nuolaidos_id`) VALUES
(1, '2022-11-10 18:42:52', 52.43, 5, '689e5b2971577d707becb97405ede951', 1, 1, 1),
(2, '2022-11-24 17:44:28', 22.11, 3, '689e5b2971577d707becb97405ede951', 2, 2, 2),
(3, '2022-11-12 21:37:19', 44, 6, '689e5b2971577d707becb97405ede951', 3, 3, 3),
(12, '2022-12-10 20:54:44', 4.28, 2, '689e5b2971577d707becb97405ede951', 20, 18, 10),
(13, '2022-12-10 21:01:14', 3.6, 1, '689e5b2971577d707becb97405ede951', 21, 19, 10),
(14, '2022-12-10 21:05:26', 2.36, 1, '689e5b2971577d707becb97405ede951', 22, 20, NULL),
(15, '2022-12-10 21:33:54', 3.6, 1, '689e5b2971577d707becb97405ede951', 23, 21, 10),
(16, '2022-12-11 14:54:05', 2.13, 1, '689e5b2971577d707becb97405ede951', 24, 22, 10),
(17, '2022-12-11 15:08:42', 2.13, 1, '689e5b2971577d707becb97405ede951', 25, 23, 10),
(18, '2022-12-11 15:12:54', 3.67, 1, '689e5b2971577d707becb97405ede951', 26, 24, NULL),
(19, '2022-12-11 15:26:54', 3.67, 1, '689e5b2971577d707becb97405ede951', 27, 25, NULL),
(20, '2022-12-11 15:27:46', 3.67, 1, '689e5b2971577d707becb97405ede951', 28, 26, NULL),
(21, '2022-12-11 15:28:15', 2.21, 1, '689e5b2971577d707becb97405ede951', 29, 27, NULL),
(22, '2022-12-11 15:33:16', 3.67, 1, '689e5b2971577d707becb97405ede951', 30, 28, NULL),
(24, '2022-12-11 15:56:45', 4.02, 1, '689e5b2971577d707becb97405ede951', 32, 30, NULL),
(25, '2022-12-11 18:02:01', 4.02, 1, '689e5b2971577d707becb97405ede951', 33, 31, NULL),
(26, '2022-12-11 18:09:12', 4.02, 1, '689e5b2971577d707becb97405ede951', 34, 32, NULL),
(27, '2022-12-11 18:10:11', 4.02, 1, '689e5b2971577d707becb97405ede951', 35, 33, NULL),
(28, '2022-12-11 18:10:43', 4.02, 1, '689e5b2971577d707becb97405ede951', 36, 34, NULL),
(29, '2022-12-11 18:11:36', 2.56, 1, '689e5b2971577d707becb97405ede951', 37, 35, NULL),
(30, '2022-12-11 18:12:12', 4.02, 1, '689e5b2971577d707becb97405ede951', 38, 36, NULL),
(31, '2022-12-14 13:52:22', 6.58, 3, '689e5b2971577d707becb97405ede951', 39, 37, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pratyboms`
--

CREATE TABLE `pratyboms` (
  `id` int(5) NOT NULL,
  `siuntejas` varchar(30) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `kam` varchar(30) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL,
  `zinute` text CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prekes`
--

CREATE TABLE `prekes` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `Pardavimo_kaina` float NOT NULL,
  `Savikaina` float NOT NULL,
  `Nuolaida` int(11) DEFAULT NULL,
  `Kilmes_vieta` varchar(20) NOT NULL,
  `Siuntimo_kaina` float DEFAULT NULL,
  `Papildoma_informacija` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prekes`
--

INSERT INTO `prekes` (`id`, `pavadinimas`, `Pardavimo_kaina`, `Savikaina`, `Nuolaida`, `Kilmes_vieta`, `Siuntimo_kaina`, `Papildoma_informacija`) VALUES
(7, 'Obuoliai (500 g)', 2.23, 2, 5, 'Kaunas', 0, 'Lietuvos'),
(8, 'Bananai (1 kg)', 0.76, 0, 0, '', 0, 'Afrikos'),
(26, 'Agurkai', 1.8, 0.9, 10, 'Alytus', 5, 'Lietuvos'),
(29, 'Ratai', 16, 9, 0, 'Alytus', 1, 'Vasariniai ratai');

-- --------------------------------------------------------

--
-- Table structure for table `preke_krepselis_pagalbinis`
--

CREATE TABLE `preke_krepselis_pagalbinis` (
  `fk_preke_id` int(11) NOT NULL,
  `fk_krepselis_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `preke_krepselis_pagalbinis`
--

INSERT INTO `preke_krepselis_pagalbinis` (`fk_preke_id`, `fk_krepselis_id`, `kiekis`) VALUES
(7, '689e5b2971577d707becb97405ede951', 1),
(7, 'bad596e6029596d4ef57c2a5f49a91ed', 1),
(8, '689e5b2971577d707becb97405ede951', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preke_pirkimai_tarpinis`
--

CREATE TABLE `preke_pirkimai_tarpinis` (
  `fk_preke_id` int(11) NOT NULL,
  `fk_pirkimas_id` int(11) NOT NULL,
  `pirktas_kiekis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preke_pirkimai_tarpinis`
--

INSERT INTO `preke_pirkimai_tarpinis` (`fk_preke_id`, `fk_pirkimas_id`, `pirktas_kiekis`) VALUES
(7, 1, 3),
(7, 3, 5),
(7, 12, 1),
(7, 13, 1),
(7, 15, 1),
(7, 18, 1),
(7, 19, 1),
(7, 20, 1),
(7, 22, 1),
(7, 24, 1),
(7, 25, 1),
(7, 26, 1),
(7, 27, 1),
(7, 28, 1),
(7, 30, 1),
(7, 31, 1),
(8, 2, 12),
(8, 3, 15),
(8, 12, 1),
(8, 14, 1),
(8, 16, 1),
(8, 17, 1),
(8, 21, 1),
(8, 29, 1),
(8, 31, 1),
(26, 31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pristatymai`
--

CREATE TABLE `pristatymai` (
  `id` int(11) NOT NULL,
  `adresas` text NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `statusas` int(11) NOT NULL,
  `fk_vartotojo_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `mokestis` float NOT NULL,
  `budas` varchar(32) CHARACTER SET utf8 NOT NULL,
  `atsiimantis_asmuo` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `komentaras` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pristatymai`
--

INSERT INTO `pristatymai` (`id`, `adresas`, `data`, `statusas`, `fk_vartotojo_id`, `mokestis`, `budas`, `atsiimantis_asmuo`, `komentaras`) VALUES
(1, 'Mažeikiai, Zeniaus g. 42', '2022-11-10 18:42:52', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', NULL, '-'),
(2, 'Alytus, Petro g. 22', '2022-11-24 17:44:28', 2, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', NULL, '-'),
(3, 'adresas', '2022-11-12 21:37:19', 3, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', NULL, '-'),
(20, 'Kaunas, Kauno g. 19', '2022-12-10 20:54:44', 1, '689e5b2971577d707becb97405ede951', 1.6, 'DPD', 'rimas rimauskas', 'Durų kodas 666'),
(21, 'Kaunas, Kauno g. 19', '2022-12-10 21:01:14', 1, '689e5b2971577d707becb97405ede951', 1.6, 'DPD', 'rimas rimauskas', 'Durų kodas 666'),
(22, 'Kaunas, Kauno g. 19', '2022-12-10 21:05:26', 1, '689e5b2971577d707becb97405ede951', 1.6, 'DPD', 'rimas rimauskas', 'Durų kodas 666'),
(23, 'Kaunas, Kauno g. 19', '2022-12-10 21:33:54', 1, '689e5b2971577d707becb97405ede951', 1.6, 'DPD', 'rimas rimauskas', 'Durų kodas 666'),
(24, 'Kaunas, Vilniaus g. 6', '2022-12-11 14:54:05', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(25, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:08:42', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(26, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:12:54', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(27, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:26:54', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(28, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:27:46', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(29, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:28:15', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(30, 'Kaunas, Vilniaus g. 6', '2022-12-11 15:33:16', 1, '689e5b2971577d707becb97405ede951', 1.45, 'LP EXPRESS', 'Tomas Tomauskas', 'Palikti prie durų'),
(32, 'Vilnius, Radviliškio g. 2', '2022-12-11 15:56:45', 4, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'Vėjas Špakas', '-'),
(33, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:02:01', 4, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(34, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:09:12', 1, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(35, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:10:11', 1, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(36, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:10:43', 1, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(37, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:11:36', 1, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(38, 'Kaunas, Vilniaus g. 9', '2022-12-11 18:12:12', 4, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-'),
(39, 'Kaunas, Vilniaus g. 9', '2022-12-14 13:52:22', 1, '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pristatymai_pagalbinis`
--

CREATE TABLE `pristatymai_pagalbinis` (
  `adresas` text NOT NULL,
  `fk_vartotojo_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `mokestis` float NOT NULL,
  `budas` varchar(32) CHARACTER SET utf8 NOT NULL,
  `atsiimantis_asmuo` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `komentaras` varchar(255) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pristatymai_pagalbinis`
--

INSERT INTO `pristatymai_pagalbinis` (`adresas`, `fk_vartotojo_id`, `mokestis`, `budas`, `atsiimantis_asmuo`, `komentaras`) VALUES
('Kaunas, Vilniaus g. 9', '689e5b2971577d707becb97405ede951', 1.8, 'LPASTAS', 'rimas rimauskas', '-');

-- --------------------------------------------------------

--
-- Table structure for table `saskaita`
--

CREATE TABLE `saskaita` (
  `client` varchar(32) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `saskaita`
--

INSERT INTO `saskaita` (`client`, `amount`, `id`) VALUES
('689e5b2971577d707becb97405ede951', '10.15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `statusai`
--

CREATE TABLE `statusai` (
  `id` int(11) NOT NULL,
  `statusas` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statusai`
--

INSERT INTO `statusai` (`id`, `statusas`) VALUES
(1, 'Užsakyta'),
(2, 'Pakeliui'),
(3, 'Atlikta'),
(4, 'Laukiama apmokėjimo');

-- --------------------------------------------------------

--
-- Table structure for table `tiekejai`
--

CREATE TABLE `tiekejai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(150) NOT NULL,
  `adresas` varchar(150) NOT NULL,
  `miestas` varchar(50) NOT NULL,
  `epastas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tiekejai`
--

INSERT INTO `tiekejai` (`id`, `pavadinimas`, `adresas`, `miestas`, `epastas`) VALUES
(1, 'Vičiūnai, UAB', 'Birutės g. 50, LT-90112', 'Plungė', 'info@vici.lt'),
(2, 'Žemaitijos pienas, AB', 'Sedos g. 35, LT-87101', 'Telšiai', 'info@zpienas.lt'),
(3, 'UAB \"SKYTECH.LT\"', 'Taikos pr. 17, LT-91140', 'Klaipėda', 'info@skytech.lt'),
(4, 'Senukai', 'Kareivių g. 11B, LT-09109', 'Vilnius', 'info@ksdigital.lt');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) NOT NULL,
  `userlevel` tinyint(1) UNSIGNED DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) NOT NULL DEFAULT '+37065432198',
  `position` varchar(20) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'klientas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `surname`, `username`, `password`, `userid`, `userlevel`, `email`, `timestamp`, `phone`, `position`, `type`) VALUES
('', '', 'darbuotojas', '16c354b68848cdbd8f54a226a0a55b21', '2721ae19d27ea5033cf23c6cd103ae10', 5, 'darbuotojas@demo.lt', '2022-11-14 23:39:13', '+37065432198', NULL, 'klientas'),
('', '', 'valdytojas', 'c2acd92812ef99acd3dcdbb746b9a434', '582e5be8aed3dcdb5d0cf740157e138a', 5, 'D@ltu.lt', '2022-11-21 11:24:11', '+37065432198', NULL, 'klientas'),
('Simonas', 'aasd', 'hmm', 'c2acd92812ef99acd3dcdbb746b9a434', '5f2f664dc9cbf6932cfd6246b584016c', 4, 'lol@gmail.com', '2022-11-13 01:41:49', '+37099999999', NULL, 'klientas'),
('rimas', 'rimauskas', 'rimas', 'c2acd92812ef99acd3dcdbb746b9a434', '689e5b2971577d707becb97405ede951', 9, 'vytas.sa12@gmail.com', '2022-12-14 12:27:28', '0', '', ''),
('kostas', 'kostauskas', 'kostas', '1c37511487d38c3ebc4c59650ce2d65a', '69986045e0925262d43addddaf76094f', 5, 'eeee@ll.lt', '2018-02-16 16:04:35', '0', '', ''),
('', '', 'klientas', '16c354b68848cdbd8f54a226a0a55b21', '703c4615ea4bdae8bb7eeeb07eacaabd', 4, 'klientas@demo.lt', '2022-11-14 01:01:48', '+37065432198', NULL, 'klientas'),
('jonas', 'jonauskas', 'jonas', '64067822105b320085d18e386f57d89a', '9c5ddd54107734f7d18335a5245c286b', 255, 'vytas.sa12@gmail.com', '2017-05-09 17:10:37', '0', '', ''),
('adminas', 'adminauskas', 'Administratorius', '16c354b68848cdbd8f54a226a0a55b21', 'a2fe399900de341c39c632244eaf8483', 9, 'demo@ktu.lt', '2022-11-14 12:19:52', '0', '', ''),
('Simonas', 'aasd', 'simonasasas', '1653754378ce92f8cded9854caf733cb', 'b134e7196c6b2a979e26a911c749bc8f', 4, 'siasd@gmail.com', '2022-11-12 21:09:47', '+370999999123', NULL, 'klientas'),
('', '', 'klie', 'c2acd92812ef99acd3dcdbb746b9a434', 'bad596e6029596d4ef57c2a5f49a91ed', 4, 'dad@ktu.da', '2022-12-14 12:16:52', '+37065432198', NULL, 'klientas'),
('PRANASLAVAS', 'ABUGELIS', 'PRANYS', '31c290ad43d6c7002b45df7e7a3286a1', 'd6dae04acf3129a632f712126486d867', 4, 'PRANAS@pranas.com', '2022-11-12 21:19:17', '+3765465465', NULL, 'klientas');

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymas`
--

CREATE TABLE `uzsakymas` (
  `id` int(11) NOT NULL,
  `sudaryta` datetime NOT NULL DEFAULT current_timestamp(),
  `pristatyta` datetime DEFAULT NULL,
  `suma` float NOT NULL,
  `pristatymo_kaina` float NOT NULL,
  `fk_darbuotojas_id` varchar(32) CHARACTER SET utf8 NOT NULL,
  `fk_statusas` int(11) NOT NULL,
  `fk_tiekejas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uzsakymas`
--

INSERT INTO `uzsakymas` (`id`, `sudaryta`, `pristatyta`, `suma`, `pristatymo_kaina`, `fk_darbuotojas_id`, `fk_statusas`, `fk_tiekejas`) VALUES
(1, '2022-11-14 14:14:34', '2022-11-14 14:14:34', 12.44, 2.49, 'd6dae04acf3129a632f712126486d867', 3, 3),
(2, '2022-11-14 14:14:34', '2022-11-14 14:14:34', 50.89, 10, '69986045e0925262d43addddaf76094f', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uzsakymo_preke`
--

CREATE TABLE `uzsakymo_preke` (
  `kiekis` int(11) NOT NULL,
  `vieneto_kaina` float NOT NULL,
  `fk_uzsakymas` int(11) NOT NULL,
  `fk_preke` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apmokejimas`
--
ALTER TABLE `apmokejimas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apmokejimo_budas` (`apmokejimo_budas`);

--
-- Indexes for table `apmokejimo_budai`
--
ALTER TABLE `apmokejimo_budai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventorius`
--
ALTER TABLE `inventorius`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_preke` (`id`);

--
-- Indexes for table `krepselis_pagalbinis`
--
ALTER TABLE `krepselis_pagalbinis`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `fk_nuolaidos_id` (`fk_nuolaidos_id`);

--
-- Indexes for table `nuolaidos`
--
ALTER TABLE `nuolaidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pirkimai`
--
ALTER TABLE `pirkimai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_apmokejimo_budo_id` (`fk_apmokejimo_budo_id`),
  ADD KEY `fk_nuolaidos_id` (`fk_nuolaidos_id`),
  ADD KEY `pirkimai_ibfk_3` (`fk_pristatymo_id`),
  ADD KEY `pirkimai_ibfk_4` (`fk_vartotojas_id`);

--
-- Indexes for table `pratyboms`
--
ALTER TABLE `pratyboms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prekes`
--
ALTER TABLE `prekes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preke_krepselis_pagalbinis`
--
ALTER TABLE `preke_krepselis_pagalbinis`
  ADD PRIMARY KEY (`fk_preke_id`,`fk_krepselis_id`),
  ADD KEY `fk_preke_id` (`fk_preke_id`),
  ADD KEY `fk_krepselis_id` (`fk_krepselis_id`);

--
-- Indexes for table `preke_pirkimai_tarpinis`
--
ALTER TABLE `preke_pirkimai_tarpinis`
  ADD PRIMARY KEY (`fk_preke_id`,`fk_pirkimas_id`),
  ADD KEY `fk_pirkimas_id` (`fk_pirkimas_id`,`fk_preke_id`) USING BTREE;

--
-- Indexes for table `pristatymai`
--
ALTER TABLE `pristatymai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `statusas` (`statusas`),
  ADD KEY `pristatymai_ibfk_2` (`fk_vartotojo_id`);

--
-- Indexes for table `pristatymai_pagalbinis`
--
ALTER TABLE `pristatymai_pagalbinis`
  ADD PRIMARY KEY (`fk_vartotojo_id`) USING BTREE,
  ADD KEY `pristatymai_ibfk_2` (`fk_vartotojo_id`);

--
-- Indexes for table `saskaita`
--
ALTER TABLE `saskaita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `klientas` (`client`);

--
-- Indexes for table `statusai`
--
ALTER TABLE `statusai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tiekejai`
--
ALTER TABLE `tiekejai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_statusas` (`fk_statusas`),
  ADD KEY `fk_darbuotojas` (`fk_darbuotojas_id`),
  ADD KEY `fk_tiekejas` (`fk_tiekejas`);

--
-- Indexes for table `uzsakymo_preke`
--
ALTER TABLE `uzsakymo_preke`
  ADD KEY `fk_preke` (`fk_preke`),
  ADD KEY `fk_uzsakymas` (`fk_uzsakymas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apmokejimas`
--
ALTER TABLE `apmokejimas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `apmokejimo_budai`
--
ALTER TABLE `apmokejimo_budai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inventorius`
--
ALTER TABLE `inventorius`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `nuolaidos`
--
ALTER TABLE `nuolaidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pirkimai`
--
ALTER TABLE `pirkimai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `pratyboms`
--
ALTER TABLE `pratyboms`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prekes`
--
ALTER TABLE `prekes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pristatymai`
--
ALTER TABLE `pristatymai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `saskaita`
--
ALTER TABLE `saskaita`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `statusai`
--
ALTER TABLE `statusai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tiekejai`
--
ALTER TABLE `tiekejai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzsakymas`
--
ALTER TABLE `uzsakymas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `apmokejimas`
--
ALTER TABLE `apmokejimas`
  ADD CONSTRAINT `apmokejimas_ibfk_1` FOREIGN KEY (`apmokejimo_budas`) REFERENCES `apmokejimo_budai` (`id`);

--
-- Constraints for table `krepselis_pagalbinis`
--
ALTER TABLE `krepselis_pagalbinis`
  ADD CONSTRAINT `fk_nuolaidos_id` FOREIGN KEY (`fk_nuolaidos_id`) REFERENCES `nuolaidos` (`id`),
  ADD CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `pirkimai`
--
ALTER TABLE `pirkimai`
  ADD CONSTRAINT `pirkimai_ibfk_1` FOREIGN KEY (`fk_apmokejimo_budo_id`) REFERENCES `apmokejimas` (`id`),
  ADD CONSTRAINT `pirkimai_ibfk_2` FOREIGN KEY (`fk_nuolaidos_id`) REFERENCES `nuolaidos` (`id`),
  ADD CONSTRAINT `pirkimai_ibfk_3` FOREIGN KEY (`fk_pristatymo_id`) REFERENCES `pristatymai` (`id`),
  ADD CONSTRAINT `pirkimai_ibfk_4` FOREIGN KEY (`fk_vartotojas_id`) REFERENCES `users` (`userid`);

--
-- Constraints for table `preke_krepselis_pagalbinis`
--
ALTER TABLE `preke_krepselis_pagalbinis`
  ADD CONSTRAINT `fk_krepselis_id` FOREIGN KEY (`fk_krepselis_id`) REFERENCES `krepselis_pagalbinis` (`userid`),
  ADD CONSTRAINT `fk_preke_id` FOREIGN KEY (`fk_preke_id`) REFERENCES `prekes` (`id`);

--
-- Constraints for table `preke_pirkimai_tarpinis`
--
ALTER TABLE `preke_pirkimai_tarpinis`
  ADD CONSTRAINT `fk_pirkimas_id` FOREIGN KEY (`fk_pirkimas_id`) REFERENCES `pirkimai` (`id`),
  ADD CONSTRAINT `fk_prekes_id` FOREIGN KEY (`fk_preke_id`) REFERENCES `prekes` (`id`);

--
-- Constraints for table `pristatymai`
--
ALTER TABLE `pristatymai`
  ADD CONSTRAINT `pristatymai_ibfk_1` FOREIGN KEY (`statusas`) REFERENCES `statusai` (`id`),
  ADD CONSTRAINT `pristatymai_ibfk_2` FOREIGN KEY (`fk_vartotojo_id`) REFERENCES `users` (`userid`);

--
-- Constraints for table `pristatymai_pagalbinis`
--
ALTER TABLE `pristatymai_pagalbinis`
  ADD CONSTRAINT `pagalbinis_pristatymai_vartotojas` FOREIGN KEY (`fk_vartotojo_id`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
