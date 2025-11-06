-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 08 déc. 2024 à 16:02
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
-- Base de données : `projet2024`
--

-- --------------------------------------------------------

--
-- Structure de la table `bank`
--

CREATE TABLE `bank` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dir` varchar(30) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `bank`
--

INSERT INTO `bank` (`id`, `name`, `dir`, `description`) VALUES
(1, 'PixelMinds Images', 'htdocs/PixelMinds/images', 'Banque d\'images pour le projet PixelMinds'),
(2, 'Banque Nature', 'dir1', 'Images de paysages naturels'),
(3, 'Banque Urbaine', 'dir2', 'Images de paysages urbains');

-- --------------------------------------------------------

--
-- Structure de la table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `userAccoundId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `catalog`
--

INSERT INTO `catalog` (`id`, `userAccoundId`, `name`, `description`) VALUES
(1, 1, 'Catalogue 1', 'Explorez le premier catalogue interactif'),
(2, 1, 'Catalogue 2', 'Découvrez notre deuxième collection !'),
(42, 11, 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `catalogimage`
--

CREATE TABLE `catalogimage` (
  `id` int(11) NOT NULL,
  `catalogId` int(11) NOT NULL,
  `imageId` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `catalogimage`
--

INSERT INTO `catalogimage` (`id`, `catalogId`, `imageId`, `position`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2),
(3, 1, 3, 3),
(4, 1, 4, 4),
(5, 2, 5, 1),
(6, 2, 6, 2),
(7, 2, 7, 3),
(8, 2, 8, 4),
(38, 42, 1, 1),
(39, 42, 2, 2),
(40, 42, 3, 3),
(41, 42, 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `bankId` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `bankId`, `name`) VALUES
(1, 2, 'img1.jpg'),
(2, 2, 'img2.jpg'),
(3, 2, 'img3.jpg'),
(4, 2, 'img4.jpg'),
(5, 3, 'img5.jpg'),
(6, 3, 'img6.jpg'),
(7, 3, 'img7.jpg'),
(8, 3, 'img8.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `label`
--

CREATE TABLE `label` (
  `id` int(11) NOT NULL,
  `catalogId` int(11) NOT NULL,
  `imageId` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `points` varchar(2000) DEFAULT NULL,
  `html` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `label`
--

INSERT INTO `label` (`id`, `catalogId`, `imageId`, `name`, `description`, `points`, `html`) VALUES
(1, 1, 1, 'Statue Stanislas', 'La célèbre statue située sur la place Stanislas.', '[{\"x\": 470, \"y\": 350}]', '<div class=\"tooltip\"><h3>Statue Stanislas</h3><p>La célèbre statue de Stanislas au centre de la place.</p></div>'),
(2, 1, 2, 'Fontaine de Neptune', 'La majestueuse fontaine en or ornée de sculptures.', '[{\"x\": 350, \"y\": 500}]', '<div class=\"tooltip\"><h3>Fontaine d\\\'Art</h3><p>Une magnifique fontaine au centre de la place.</p></div>'),
(3, 1, 3, 'Exposition de sculptures', 'Un espace dédié aux sculptures modernes.', '[{\"x\": 380, \"y\": 500}]', '<div class=\"tooltip\"><h3>Musée Principal</h3><p>Une collection d\\\'art moderne et ancien.</p></div>'),
(4, 1, 4, 'Portrait féminin', 'Un portrait célèbre du XVIIIe siècle.', '[{\"x\": 150, \"y\": 200}]', '<div class=\"tooltip\"><h3>Bustes d\\\'Artistes</h3><p>Une exposition de bustes de célèbres artistes.</p></div>'),
(5, 2, 5, 'Grand aquarium', 'Un immense aquarium avec des coraux et des poissons exotiques.', '[{\"x\": 600, \"y\": 400}]', '<div class=\"tooltip\"><h3>Grand Aquarium</h3><p>Un immense aquarium avec des coraux et des poissons tropicaux.</p></div>'),
(6, 2, 6, 'Canoës', 'Un espace où les visiteurs peuvent faire du canoë sur le lac.', '[{\"x\": 370, \"y\": 450}]', '<div class=\"tooltip\"><h3>Canoës</h3><p>Un espace où les visiteurs peuvent faire du canoë sur le lac.</p></div>'),
(7, 2, 7, 'Bain intérieur', 'Un espace où les visiteurs peuvent se détendre.', '[{\"x\": 350, \"y\": 550}]', '<div class=\"tooltip\"><h3>Canoës</h3><p>Un espace où les visiteurs peuvent faire du canoë sur le lac.</p></div>'),
(8, 2, 8, 'Structures en bois', 'Des structures artistiques en bois dans le parc.', '[{\"x\": 800, \"y\": 670}]', '<div class=\"tooltip\"><h3>Canoës</h3><p>Un espace où les visiteurs peuvent faire du canoë sur le lac.</p></div>'),
(30, 42, 1, 'test', 'test', '[{\"x\":362,\"y\":145},{\"x\":360,\"y\":148},{\"x\":358,\"y\":151},{\"x\":354,\"y\":159},{\"x\":352,\"y\":168},{\"x\":349,\"y\":184},{\"x\":349,\"y\":205},{\"x\":350,\"y\":212},{\"x\":351,\"y\":218},{\"x\":354,\"y\":224},{\"x\":357,\"y\":226},{\"x\":360,\"y\":229},{\"x\":362,\"y\":233},{\"x\":365,\"y\":235},{\"x\":365,\"y\":236},{\"x\":367,\"y\":237},{\"x\":370,\"y\":239},{\"x\":372,\"y\":240},{\"x\":378,\"y\":241},{\"x\":379,\"y\":241},{\"x\":382,\"y\":242},{\"x\":383,\"y\":243},{\"x\":386,\"y\":243},{\"x\":387,\"y\":243},{\"x\":389,\"y\":242},{\"x\":391,\"y\":241},{\"x\":393,\"y\":237},{\"x\":396,\"y\":234},{\"x\":399,\"y\":228},{\"x\":401,\"y\":223},{\"x\":402,\"y\":217},{\"x\":406,\"y\":202},{\"x\":406,\"y\":190},{\"x\":406,\"y\":178},{\"x\":402,\"y\":166},{\"x\":400,\"y\":161},{\"x\":399,\"y\":157},{\"x\":396,\"y\":153},{\"x\":395,\"y\":151},{\"x\":393,\"y\":148},{\"x\":390,\"y\":145},{\"x\":387,\"y\":144},{\"x\":385,\"y\":141},{\"x\":381,\"y\":137},{\"x\":378,\"y\":135},{\"x\":376,\"y\":133},{\"x\":373,\"y\":133},{\"x\":370,\"y\":133},{\"x\":368,\"y\":133},{\"x\":363,\"y\":133},{\"x\":361,\"y\":134},{\"x\":358,\"y\":136},{\"x\":355,\"y\":137},{\"x\":354,\"y\":138},{\"x\":353,\"y\":139},{\"x\":351,\"y\":140},{\"x\":350,\"y\":141},{\"x\":350,\"y\":141},{\"x\":349,\"y\":142},{\"x\":349,\"y\":143},{\"x\":349,\"y\":144},{\"x\":349,\"y\":144}]', '<div class=\"tooltip\"><h3>test</h3><p>test</p></div>'),
(31, 42, 1, 'test', 'test', '[{\"x\":86,\"y\":99},{\"x\":85,\"y\":98}]', '<div class=\"tooltip\"><h3>test</h3><p>test</p></div>'),
(32, 42, 1, 'test', 'test', '[{\"x\":396,\"y\":146},{\"x\":396,\"y\":146},{\"x\":396,\"y\":145},{\"x\":396,\"y\":144},{\"x\":395,\"y\":143},{\"x\":395,\"y\":142},{\"x\":395,\"y\":142},{\"x\":394,\"y\":141},{\"x\":394,\"y\":140},{\"x\":394,\"y\":139},{\"x\":394,\"y\":138},{\"x\":394,\"y\":138},{\"x\":393,\"y\":138},{\"x\":392,\"y\":137},{\"x\":392,\"y\":136},{\"x\":391,\"y\":136},{\"x\":390,\"y\":135},{\"x\":390,\"y\":134},{\"x\":390,\"y\":134},{\"x\":389,\"y\":134},{\"x\":388,\"y\":134},{\"x\":387,\"y\":134},{\"x\":386,\"y\":134},{\"x\":386,\"y\":134},{\"x\":385,\"y\":134},{\"x\":383,\"y\":135},{\"x\":382,\"y\":136},{\"x\":382,\"y\":136},{\"x\":381,\"y\":137},{\"x\":380,\"y\":137},{\"x\":380,\"y\":138},{\"x\":379,\"y\":138},{\"x\":378,\"y\":138},{\"x\":378,\"y\":138},{\"x\":378,\"y\":139},{\"x\":377,\"y\":140},{\"x\":376,\"y\":142},{\"x\":375,\"y\":142},{\"x\":375,\"y\":143},{\"x\":374,\"y\":143},{\"x\":374,\"y\":145},{\"x\":374,\"y\":146},{\"x\":373,\"y\":146},{\"x\":373,\"y\":147},{\"x\":373,\"y\":149},{\"x\":373,\"y\":150},{\"x\":373,\"y\":150},{\"x\":373,\"y\":151},{\"x\":373,\"y\":152},{\"x\":373,\"y\":154},{\"x\":373,\"y\":154},{\"x\":374,\"y\":155},{\"x\":374,\"y\":155},{\"x\":375,\"y\":155},{\"x\":375,\"y\":156},{\"x\":376,\"y\":156},{\"x\":377,\"y\":157},{\"x\":378,\"y\":158},{\"x\":379,\"y\":158},{\"x\":380,\"y\":158},{\"x\":381,\"y\":158},{\"x\":382,\"y\":158},{\"x\":382,\"y\":158},{\"x\":383,\"y\":159},{\"x\":384,\"y\":159},{\"x\":385,\"y\":159},{\"x\":386,\"y\":159},{\"x\":387,\"y\":159},{\"x\":388,\"y\":159},{\"x\":389,\"y\":159},{\"x\":390,\"y\":159},{\"x\":391,\"y\":159},{\"x\":392,\"y\":159},{\"x\":393,\"y\":159},{\"x\":394,\"y\":159},{\"x\":394,\"y\":159},{\"x\":395,\"y\":159},{\"x\":396,\"y\":159},{\"x\":397,\"y\":159},{\"x\":398,\"y\":158},{\"x\":398,\"y\":158},{\"x\":398,\"y\":158},{\"x\":399,\"y\":158},{\"x\":399,\"y\":157},{\"x\":399,\"y\":156},{\"x\":399,\"y\":155},{\"x\":399,\"y\":154},{\"x\":399,\"y\":154},{\"x\":399,\"y\":153},{\"x\":399,\"y\":152},{\"x\":399,\"y\":151},{\"x\":399,\"y\":150},{\"x\":399,\"y\":150},{\"x\":399,\"y\":149},{\"x\":399,\"y\":148},{\"x\":399,\"y\":147},{\"x\":399,\"y\":146},{\"x\":398,\"y\":146},{\"x\":398,\"y\":146},{\"x\":398,\"y\":146}]', '<div class=\"tooltip\"><h3>test</h3><p>test</p></div>');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `user_id`, `message`, `created_at`) VALUES
(1, 'Mazen', 'mazen@gmail.com', 1, 'Salut, j\'adore votre catalogue', '2024-12-02 09:33:16'),
(9, 'amine', 'amine@gmail.com', 12, 'azenazennanzenuuaze', '2024-12-04 13:39:49');

-- --------------------------------------------------------

--
-- Structure de la table `useraccount`
--

CREATE TABLE `useraccount` (
  `id` int(11) NOT NULL,
  `userRoleId` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(320) DEFAULT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `useraccount`
--

INSERT INTO `useraccount` (`id`, `userRoleId`, `login`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 1, 'mazen', 'mazen', 'mazen', 'mazen@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
(2, 2, 'JJ', 'Zak', 'Amirou', 'jj@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
(9, 1, 'maz', 'maz', 'maz', 'maz@gmail.com', 'f0ee73f698464d9b24960cfd983e278ecc504ba8'),
(10, 2, 'ma', 'ma', 'ma', 'ma@gmail.com', '1382244e1784be148fb78b24983c206ebc95928f'),
(11, 1, 'a', 'a', 'a', 'a@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(12, 2, 'b', 'b', 'b', 'b@gmail.com', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98'),
(13, 1, 'amine', 'amine', 'amine', 'amine@gmail.com', '23bc6df7647b818d79ce7fc43fa0f460c188205a');

-- --------------------------------------------------------

--
-- Structure de la table `userrole`
--

CREATE TABLE `userrole` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `userrole`
--

INSERT INTO `userrole` (`id`, `name`, `description`) VALUES
(1, 'editor', 'Droits de création, suppression, édition et visualisation de catalogues'),
(2, 'non-editor', 'Droits de visualisation de catalogues');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UC_dir` (`dir`);

--
-- Index pour la table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userAccoundId` (`userAccoundId`);

--
-- Index pour la table `catalogimage`
--
ALTER TABLE `catalogimage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catalogId` (`catalogId`),
  ADD KEY `imageId` (`imageId`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`,`bankId`),
  ADD UNIQUE KEY `UC_ImgBaName` (`bankId`,`name`);

--
-- Index pour la table `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catalogId` (`catalogId`),
  ADD KEY `imageId` (`imageId`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UC_UserIdEmail` (`login`,`email`),
  ADD KEY `userRoleId` (`userRoleId`);

--
-- Index pour la table `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bank`
--
ALTER TABLE `bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `catalogimage`
--
ALTER TABLE `catalogimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `label`
--
ALTER TABLE `label`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `userrole`
--
ALTER TABLE `userrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `catalog`
--
ALTER TABLE `catalog`
  ADD CONSTRAINT `catalog_ibfk_1` FOREIGN KEY (`userAccoundId`) REFERENCES `useraccount` (`id`);

--
-- Contraintes pour la table `catalogimage`
--
ALTER TABLE `catalogimage`
  ADD CONSTRAINT `catalogimage_ibfk_1` FOREIGN KEY (`catalogId`) REFERENCES `catalog` (`id`),
  ADD CONSTRAINT `catalogimage_ibfk_2` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`bankId`) REFERENCES `bank` (`id`);

--
-- Contraintes pour la table `label`
--
ALTER TABLE `label`
  ADD CONSTRAINT `label_ibfk_1` FOREIGN KEY (`catalogId`) REFERENCES `catalog` (`id`),
  ADD CONSTRAINT `label_ibfk_2` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`);

--
-- Contraintes pour la table `useraccount`
--
ALTER TABLE `useraccount`
  ADD CONSTRAINT `useraccount_ibfk_1` FOREIGN KEY (`userRoleId`) REFERENCES `userrole` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
