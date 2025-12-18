-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 18 déc. 2025 à 13:30
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `leonie`
--

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

CREATE TABLE `avatar` (
  `idAvatar` int(11) NOT NULL,
  `nameAvatar` varchar(50) NOT NULL,
  `imgAvatar` varchar(255) DEFAULT NULL,
  `modelAvatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `avatar`
--

INSERT INTO `avatar` (`idAvatar`, `nameAvatar`, `imgAvatar`, `modelAvatar`) VALUES
(1, 'mako', 'public/assets/avatars/requin_mako.jpg', 'public/assets/models/mako.glb'),
(2, 'chien', 'public/assets/avatars/chien_pug.jpg', 'public/assets/models/pug.glb'),
(3, 'Fitnessman', 'public/assets/avatars/fitness_man.jpg', 'public/assets/models/fitness.glb'),
(4, 'astronaute', 'public/assets/avatars/astronaute.jpg', 'public/assets/models/astronaut.glb'),
(5, 'aventurier', 'public/assets/avatars/aventurier.jpg', 'public/assets/models/adventurer.glb');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userRole` enum('user','admin') NOT NULL DEFAULT 'user',
  `idAvatar` int(11) DEFAULT NULL,
  `idWorld` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `userRole`, `idAvatar`, `idWorld`) VALUES
(1, 'admin', '$2y$10$pmhvb3zjoX/p38/s57V2I.P8GiNmRAbuk1cFH/SSnJ/Nq/zQy4ckS', 'admin', NULL, NULL),
(2, 'Leonie', '$2y$10$nwyXHA2w09uCsBCspfxE/e89cTsLHygErCJh7QNPcmllK/cKxqybG', 'user', 1, 1),
(3, 'test', '$2y$10$sHXhMuXbFLiPb9cHDZ/4HuwzjPJ8J.O32rfCvk9YyI0KsVqf9ETNe', 'user', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `world`
--

CREATE TABLE `world` (
  `idWorld` int(11) NOT NULL,
  `nameWorld` varchar(50) NOT NULL,
  `imgWorld` varchar(255) DEFAULT NULL,
  `urlWorld` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `world`
--

INSERT INTO `world` (`idWorld`, `nameWorld`, `imgWorld`, `urlWorld`) VALUES
(1, 'Laponie', 'public/assets/worlds/hiver.jpg', 'https://benaku.sio-chopin.fr/world'),
(2, 'Tron', 'public/assets/worlds/tron.jpg', 'https://forget-mandras.sio-chopin.fr/vr'),
(3, 'Prairie', 'public/assets/worlds/prairie.jpg', 'https://sellesfrancesconi.sio-chopin/Challenge2eVR'),
(4, 'Foret', 'public/assets/worlds/foret.jpg', 'https://bravo-dormont.sio-chopin.fr/ChopinVerse/game'),
(5, 'Desert', 'public/assets/worlds/desert.jpg', 'https://oukhira.sio-chopin.fr');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`idAvatar`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_avatar` (`idAvatar`),
  ADD KEY `fk_user_world` (`idWorld`);

--
-- Index pour la table `world`
--
ALTER TABLE `world`
  ADD PRIMARY KEY (`idWorld`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `idAvatar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `world`
--
ALTER TABLE `world`
  MODIFY `idWorld` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_avatar` FOREIGN KEY (`idAvatar`) REFERENCES `avatar` (`idAvatar`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_world` FOREIGN KEY (`idWorld`) REFERENCES `world` (`idWorld`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
