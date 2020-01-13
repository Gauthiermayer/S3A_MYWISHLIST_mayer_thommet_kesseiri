-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 13 Janvier 2020 à 20:38
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wishlist`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`username`, `password`, `pseudo`, `role`) VALUES
('admin', '$2y$12$sUM0h57wSfuIItP6W7YC1OLK5nK/.YkL0LZDPFo/MJP3i9U4na0JC', 'admin57', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `tokenListe` varchar(50) DEFAULT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text,
  `url` text,
  `tarif` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`id`, `tokenListe`, `nom`, `descr`, `img`, `url`, `tarif`) VALUES
(1, 'nosecure2', 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '', '20.00'),
(2, 'nosecure2', 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '', '25.00'),
(3, 'nosecure2', 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '', '14.00'),
(4, 'nosecure3', 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '', '20.00'),
(5, 'nosecure3', 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '', '10.00'),
(6, 'nosecure2', 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '', '16.00'),
(7, 'nosecure2', 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '', '60.00'),
(8, 'nosecure3', 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '', '12.00'),
(9, 'nosecure3', 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '', '24.00'),
(10, 'nosecure2', 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '', '59.00'),
(11, NULL, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '', '11.00'),
(12, 'nosecure2', 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '', '29.00'),
(19, NULL, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.jpg', '', '5.00'),
(22, NULL, 'Concert', 'Un concert à Nancy', 'concert.jpg', '', '17.00'),
(23, 'nosecure1', 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '', '56.00'),
(24, 'nosecure2', 'Hôtel d Haussonville', 'Hôtel d Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '', '169.00'),
(25, 'nosecure1', 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00'),
(26, 'nosecure1', 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00'),
(27, 'nosecure1', 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE `liste` (
  `token` varchar(50) NOT NULL,
  `titre` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `createur_pseudo` varchar(20) DEFAULT NULL,
  `expiration` date DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `liste`
--

INSERT INTO `liste` (`token`, `titre`, `description`, `createur_pseudo`, `expiration`, `private`) VALUES
('nosecure1', 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', NULL, '2021-06-27', 0),
('nosecure2', 'Liste de mariage d Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', NULL, '2021-06-30', 0),
('nosecure3', 'C est l anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', NULL, '2021-12-12', 0);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `tokenListe` varchar(15) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `message` varchar(240) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `idItem` int(11) NOT NULL,
  `tokenListe` varchar(50) NOT NULL,
  `message` varchar(250) NOT NULL,
  `tokenReserv` varchar(100) NOT NULL,
  `nomParticipant` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `PSEUDO_UNIQUE` (`pseudo`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Item_Liste` (`tokenListe`);

--
-- Index pour la table `liste`
--
ALTER TABLE `liste`
  ADD PRIMARY KEY (`token`),
  ADD KEY `FK_createur_liste` (`createur_pseudo`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idItem`,`tokenListe`),
  ADD KEY `FK_Reservation_Liste` (`tokenListe`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_Item_Liste` FOREIGN KEY (`tokenListe`) REFERENCES `liste` (`token`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liste`
--
ALTER TABLE `liste`
  ADD CONSTRAINT `FK_createur_liste` FOREIGN KEY (`createur_pseudo`) REFERENCES `compte` (`pseudo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `FK_Reservation_Item` FOREIGN KEY (`idItem`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Reservation_Liste` FOREIGN KEY (`tokenListe`) REFERENCES `liste` (`token`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
