-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 04. 02 2019 kl. 04:40:34
-- Serverversion: 10.1.29-MariaDB
-- PHP-version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dimselab`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `name` varchar(10000) NOT NULL,
  `tray_number` char(4) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `on_loan` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `fk_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `articles`
--

INSERT INTO `articles` (`id`, `name`, `tray_number`, `barcode`, `on_loan`, `quantity`, `fk_category_id`) VALUES
(1, 'Samsung Galaxy S8', '7', 'ROD5.SGS8.0007', 0, 50, 1),
(2, 'Samsung Galaxy S9', '5', 'ROD5.SGS9.0005', 0, 10, 1),
(3, 'Samsung Galaxy S7', '4', 'ROD5.SGS7.0004', 0, 15, 1),
(4, 'Mors boobies', '7', 'ROD5.MOBO.0007', 0, 3, 2);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `article_projects`
--

CREATE TABLE `article_projects` (
  `fk_article_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Phone'),
(2, 'Fruit'),
(3, 'Trees');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fk_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `created`, `fk_user_id`) VALUES
(1, 'Ebbes robot', 'asdasd', '2019-02-02 02:54:59', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`id`, `name`, `permission`) VALUES
(1, 'administrator', 100),
(2, 'låner', 10);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `statistics`
--

CREATE TABLE `statistics` (
  `id` int(11) NOT NULL,
  `fk_article_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_project_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `statistics`
--

INSERT INTO `statistics` (`id`, `fk_article_id`, `fk_user_id`, `fk_project_id`, `created`) VALUES
(6, 4, 1, 1, '2019-02-02 02:58:20');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `fk_role_id` int(11) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `barcode`, `fk_role_id`) VALUES
(1, 'Ebbe Vang', 'ebva', 'ebva@zealand.dk', '1234', 'ADMIN_EBVA_DIMSELAB', 1),
(2, 'Michael Hammel', 'miha', 'miha@zealand.dk', '1234', 'ADMIN_MIHA_DIMSELAB', 1);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Article_Category` (`fk_category_id`);

--
-- Indeks for tabel `article_projects`
--
ALTER TABLE `article_projects`
  ADD KEY `Article_Project` (`fk_article_id`),
  ADD KEY `Project_Article` (`fk_project_id`);

--
-- Indeks for tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Project_User` (`fk_user_id`);

--
-- Indeks for tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Statistic_User` (`fk_user_id`),
  ADD KEY `Statistic_Project` (`fk_project_id`),
  ADD KEY `Statistic_Article` (`fk_article_id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User_Role` (`fk_role_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tilføj AUTO_INCREMENT i tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tilføj AUTO_INCREMENT i tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tilføj AUTO_INCREMENT i tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tilføj AUTO_INCREMENT i tabel `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `Article_Category` FOREIGN KEY (`fk_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `article_projects`
--
ALTER TABLE `article_projects`
  ADD CONSTRAINT `Article_Project` FOREIGN KEY (`fk_article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Project_Article` FOREIGN KEY (`fk_project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `Project_User` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `Statistic_Article` FOREIGN KEY (`fk_article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Statistic_Project` FOREIGN KEY (`fk_project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Statistic_User` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `User_Role` FOREIGN KEY (`fk_role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
