-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 04 sep. 2017 à 00:34
-- Version du serveur :  10.1.26-MariaDB
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `everyday_drinking`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `score` float NOT NULL,
  `establishment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `drink`
--

CREATE TABLE `drink` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` float NOT NULL,
  `establishment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `establishment`
--

CREATE TABLE `establishment` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `establishment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `user_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_establishment` (`establishment_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Index pour la table `drink`
--
ALTER TABLE `drink`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_establishment_drink` (`establishment_id`);

--
-- Index pour la table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_location` (`location_id`);

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_establishment` (`establishment_id`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT pour la table `drink`
--
ALTER TABLE `drink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_establishment` FOREIGN KEY (`establishment_id`) REFERENCES `establishment` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `drink`
--
ALTER TABLE `drink`
  ADD CONSTRAINT `fk_establishment_drink` FOREIGN KEY (`establishment_id`) REFERENCES `establishment` (`id`);

--
-- Contraintes pour la table `establishment`
--
ALTER TABLE `establishment`
  ADD CONSTRAINT `fk_location` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`);

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_establishment` FOREIGN KEY (`establishment_id`) REFERENCES `establishment` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
