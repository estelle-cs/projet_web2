-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 22 juin 2022 à 15:57
-- Version du serveur : 10.4.14-MariaDB
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mesdocs`
--

-- --------------------------------------------------------

--
-- Structure de la table `docteur`
--

CREATE TABLE `docteur` (
  `id` int(11) NOT NULL,
  `userType` int(11) NOT NULL DEFAULT 2,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `tel` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `spe` varchar(30) NOT NULL,
  `horaires` varchar(100) NOT NULL,
  `mdp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `docteur`
--

INSERT INTO `docteur` (`id`, `userType`, `name`, `surname`, `tel`, `email`, `spe`, `horaires`, `mdp`) VALUES
(1, 2, 'a', 'a', 606060606, 'a@a.a', '', '', '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Structure de la table `dr`
--

CREATE TABLE `dr` (
  `idDocteur` int(11) NOT NULL,
  `idRdv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `userType` int(11) NOT NULL DEFAULT 3,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `birthDate` date NOT NULL,
  `tel` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `numSecu` varchar(100) NOT NULL,
  `genreBiologique` int(11) NOT NULL,
  `docRef` int(11) NOT NULL,
  `mdp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `userType`, `name`, `surname`, `birthDate`, `tel`, `email`, `numSecu`, `genreBiologique`, `docRef`, `mdp`) VALUES
(3, 3, 'Guyart', 'Yanis', '2022-06-22', 606060606, 'helloyanis@hotmail.com', '202cb962ac59075b964b07152d234b70', 0, 0, ''),
(4, 3, 'a', 'a', '2022-06-22', 606060606, 'a@a.a', '123', 0, 0, '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Structure de la table `pr`
--

CREATE TABLE `pr` (
  `idPatient` int(11) NOT NULL,
  `idRdv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `patientId` int(11) NOT NULL,
  `docteurId` int(11) NOT NULL,
  `horaires` varchar(100) NOT NULL,
  `compteRendu` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `sd`
--

CREATE TABLE `sd` (
  `idSecretariat` int(11) NOT NULL,
  `idDocteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `secretariat`
--

CREATE TABLE `secretariat` (
  `id` int(11) NOT NULL,
  `userType` int(11) NOT NULL DEFAULT 1,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(80) NOT NULL,
  `mdp` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `secretariat`
--

INSERT INTO `secretariat` (`id`, `userType`, `name`, `surname`, `email`, `mdp`) VALUES
(1, 1, 'a', 'a', 'a@a.a', '0cc175b9c0f1b6a831c399e269772661');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `userType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `docteur`
--
ALTER TABLE `docteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `secretariat`
--
ALTER TABLE `secretariat`
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
-- AUTO_INCREMENT pour la table `docteur`
--
ALTER TABLE `docteur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `secretariat`
--
ALTER TABLE `secretariat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
