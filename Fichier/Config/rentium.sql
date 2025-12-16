-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 déc. 2025 à 11:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rentium`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_users`
--

INSERT INTO `admin_users` (`id`, `nom`, `email`, `telephone`, `adresse`, `ville`, `code_postal`, `date_naissance`, `genre`, `photo_url`, `password`) VALUES
(1, 'Administrateur', 'vtcrentium@gmail.com', '0612345678', 'Issy, France', 'Issy-les-Moulineaux', '92290', '1995-12-07', 'Homme', 'https://ui-avatars.com/api/?name=Admin', 'password123');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom_complet` varchar(100) DEFAULT NULL,
  `client_id_ref` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `reservation_id` varchar(50) DEFAULT NULL,
  `statut` varchar(20) DEFAULT 'Inactive',
  `date_creation` datetime DEFAULT current_timestamp(),
  `type_abonnement` varchar(50) DEFAULT NULL,
  `est_connecte` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom_complet`, `client_id_ref`, `telephone`, `email`, `reservation_id`, `statut`, `date_creation`, `type_abonnement`, `est_connecte`) VALUES
(1, 'Pierre Durand', 'cac842cadaa', '(+33) 614524748', 'pierre@microsoft.com', '915159511659884', 'Active', '2025-07-21 17:26:14', 'Premium', 1),
(2, 'Sophie Martin', 'yad8449adzd', '(+33) 689218459', 'sophie@yahoo.com', '951188145486187', 'Inactive', '2025-09-01 20:30:14', 'Standard', 0),
(3, 'Jean Dupont', 'bba123zkda', '(+33) 755213344', 'jean.dup@gmail.com', '88441122556633', 'Active', '2025-12-01 11:57:14', 'Premium', 0),
(4, 'Marie Curie', 'radium88', '(+33) 699887766', 'marie.science@lab.fr', '11223344556677', 'Inactive', '2025-12-01 07:48:14', NULL, 1),
(5, 'Laurie Smith', 'ajnzda82bj', '(+33) 682764095', 'lauriesmith@gmail.com', '33773344556688', 'active', '2025-11-01 09:28:39', 'Premium', 1),
(6, 'Lucas Martin', 'lm882sq', '(+33) 612345678', 'lucas.martin@email.fr', '998877665544', 'Active', '2025-08-02 09:30:00', 'Premium', 1),
(7, 'Chloé Dubois', 'cd991ax', '(+33) 698765432', 'chloe.dubois@test.com', '112233445566', 'Active', '2025-12-03 14:15:00', 'Standard', 0),
(8, 'Manon Lefebvre', 'ml773bz', '(+33) 755667788', 'manon.l@provider.net', '556677889900', 'Inactive', '2025-12-05 18:45:00', NULL, 0),
(9, 'Thomas Leroy', 'tl445kp', '(+33) 611223344', 'thomas.leroy@web.fr', '223344556677', 'Active', '2025-09-06 08:20:00', 'Premium', 1),
(10, 'Camille Moreau', 'cm112qm', '(+33) 788990011', 'camille.m@live.com', '778899001122', 'Active', '2025-12-07 11:10:00', 'Premium', 1),
(11, 'Nicolas Fournier', 'nf339wl', '(+33) 600112233', 'nico.fournier@free.fr', '334455667788', 'Inactive', '2025-11-20 16:00:00', 'Standard', 0),
(12, 'Julie Girard', 'jg558tr', '(+33) 744556677', 'julie.g@orange.fr', '889900112233', 'Active', '2025-11-25 10:30:00', NULL, 0),
(13, 'Antoine Bonnet', 'ab221cv', '(+33) 622334455', 'antoine.b@sfr.fr', '445566778899', 'Inactive', '2025-10-15 13:45:00', 'Standard', 0),
(14, 'Sarah Mercier', 'sm994pl', '(+33) 799887766', 'sarah.mercier@gmail.com', '667788990011', 'Active', '2025-12-08 09:00:00', 'Premium', 1),
(15, 'Alexandre Blanc', 'ab776jh', '(+33) 633445566', 'alex.blanc@outlook.com', '110022993388', 'Active', '2025-09-10 15:20:00', NULL, 0),
(16, 'Laura Garnier', 'lg332mn', '(+33) 711223344', 'laura.garnier@yahoo.fr', '554433221100', 'Inactive', '2025-10-01 12:00:00', 'Standard', 0),
(17, 'Julien Faure', 'jf885ks', '(+33) 677889900', 'julien.faure@bbox.fr', '990011223344', 'Active', '2025-08-22 19:30:00', 'Premium', 0),
(18, 'Elodie Rousseau', 'er441vb', '(+33) 766554433', 'elodie.r@laposte.net', '221100998877', 'Active', '2025-12-04 17:15:00', NULL, 1),
(19, 'Maxime Gauthier', 'mg669xc', '(+33) 655443322', 'max.gauthier@club.fr', '776655443322', 'Inactive', '2025-11-05 08:45:00', 'Standard', 0),
(20, 'Pauline Perrin', 'pp113az', '(+33) 722334455', 'pauline.p@videotron.ca', '332211009988', 'Active', '2025-12-08 10:05:00', 'Premium', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
