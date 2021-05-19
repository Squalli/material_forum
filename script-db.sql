-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 19 mai 2021 à 09:40
-- Version du serveur :  5.7.24
-- Version de PHP : 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `forum_10`
--

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `topic_list`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `topic_list` (
`id` int(11)
,`title` varchar(255)
,`created_at` datetime
,`user_id` int(11)
,`locked` tinyint(1)
,`nbposts` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(60) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_ban` datetime DEFAULT NULL,
  `role` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT 'ROLE_USER',
  `avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `user_list`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `user_list` (
`id` int(11)
,`username` varchar(60)
,`email` varchar(255)
,`password` varchar(255)
,`created_at` datetime
,`end_ban` datetime
,`role` varchar(40)
,`avatar` varchar(255)
,`nbtopics` bigint(21)
,`nbposts` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la vue `topic_list`
--
DROP TABLE IF EXISTS `topic_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `topic_list`  AS  select `t`.`id` AS `id`,`t`.`title` AS `title`,`t`.`created_at` AS `created_at`,`t`.`user_id` AS `user_id`,`t`.`locked` AS `locked`,count(`p`.`id`) AS `nbposts` from (`topic` `t` left join `post` `p` on((`t`.`id` = `p`.`topic_id`))) group by `t`.`id` ;

-- --------------------------------------------------------

--
-- Structure de la vue `user_list`
--
DROP TABLE IF EXISTS `user_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`Virgile`@`localhost` SQL SECURITY DEFINER VIEW `user_list`  AS  select `u`.`id` AS `id`,`u`.`username` AS `username`,`u`.`email` AS `email`,`u`.`password` AS `password`,`u`.`created_at` AS `created_at`,`u`.`end_ban` AS `end_ban`,`u`.`role` AS `role`,`u`.`avatar` AS `avatar`,count(distinct `t`.`id`) AS `nbtopics`,count(distinct `p`.`id`) AS `nbposts` from ((`user` `u` left join `topic` `t` on((`t`.`user_id` = `u`.`id`))) left join `post` `p` on((`p`.`user_id` = `u`.`id`))) group by `u`.`id` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_TOPIC_POST` (`topic_id`),
  ADD KEY `FK_USER_POST` (`user_id`);

--
-- Index pour la table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_USER_TOPIC` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_TOPIC_POST` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_USER_POST` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_USER_TOPIC` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
