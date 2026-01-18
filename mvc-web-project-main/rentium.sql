-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 18 jan. 2026 à 15:16
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
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom`, `email`, `mot_de_passe`, `created_at`) VALUES
(1, 'Admin Principal', NULL, NULL, '2025-12-19 00:44:16');

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_publication` datetime DEFAULT NULL,
  `actif` tinyint(1) DEFAULT 1,
  `id_concess` int(11) NOT NULL,
  `validated_by_admin_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description`, `date_publication`, `actif`, `id_concess`, `validated_by_admin_id`, `latitude`, `longitude`, `id_voiture`) VALUES
(1, 'Location Audi A6', 'Berline luxueuse et confortable pour vos déplacements professionnels', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 6),
(2, 'Location Audi X5', 'SUV spacieux idéal pour la famille', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 7),
(3, 'Location BMW Série 5', 'Berline premium avec équipements haut de gamme', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 8),
(4, 'Location Hyundai Ioniq Hybride', 'Véhicule hybride économique et écologique', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 9),
(5, 'Location Jaguar XF', 'Berline sportive et élégante', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 10),
(6, 'Location Lexus ES 300h', 'Hybride premium au confort exceptionnel', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 11),
(7, 'Location Mercedes Classe E', 'Berline allemande de prestige', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 12),
(8, 'Location Mercedes Viano', 'Monospace familial spacieux', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 13),
(9, 'Location Nissan Leaf', 'Véhicule 100% électrique et silencieux', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 14),
(10, 'Location Peugeot 508', 'Berline française élégante', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 15),
(11, 'Location Toyota Corolla Hybride', 'Compacte hybride fiable et économique', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 16),
(12, 'Location Toyota Prius', 'La référence des hybrides', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 17),
(13, 'Location Volvo S90', 'Berline suédoise luxueuse et sécurisée', '2026-01-13 10:19:09', 1, 1, NULL, NULL, NULL, 18);

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `accroche` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_url` varchar(255) DEFAULT 'assets/images/default_blog.jpg',
  `auteur` varchar(100) DEFAULT 'Équipe Rentium',
  `categorie` varchar(50) DEFAULT 'Actualité',
  `date_creation` datetime DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `titre`, `accroche`, `contenu`, `image_url`, `auteur`, `categorie`, `date_creation`, `likes`, `dislikes`) VALUES
(1, 'Pourquoi louer une voiture de luxe pour votre mariage ?', 'Découvrez comment une entrée spectaculaire peut transformer le plus beau jour de votre vie.', '<p>Le jour de votre mariage est unique. Chaque détail compte, de la fleur à la boutonnière jusqu\'au véhicule qui vous conduira à l\'autel. Louer une voiture de luxe n\'est pas seulement une question de transport, c\'est une déclaration de style.</p><h3>1. Le confort et l\'espace</h3><p>Les robes de mariée sont souvent volumineuses. Une berline de luxe comme notre Mercedes Classe S offre l\'espace nécessaire pour que la mariée voyage sans froisser sa tenue.</p><h3>2. Des photos inoubliables</h3><p>Imaginez les photos de couple avec en arrière-plan une carrosserie étincelante. C\'est un accessoire photogénique qui ajoute une touche glamour instantanée.</p>', 'assets/images/vehicles/voiture_luxe_marriage.jpeg', 'Équipe Rentium', 'Conseils', '2026-01-09 10:16:00', 1, 0),
(2, 'VTC vs Taxi : Le match du confort à Paris', 'Analyse comparative pour vos déplacements professionnels dans la capitale.', '<p>Se déplacer à Paris peut vite devenir un cauchemar. Entre les transports en commun bondés et les taxis parfois introuvables, le VTC s\'impose comme la solution sérénité.</p><h3>La transparence du prix</h3><p>Chez Rentium, pas de surprise : le prix est fixé à la commande. Que vous restiez bloqué 10 minutes ou 1 heure dans les bouchons, le tarif ne bouge pas.</p><h3>Le service à bord</h3><p>Bouteille d\'eau, chargeurs, musique de votre choix... Le VTC est un service hôtelier sur roues.</p>', 'assets/images/vehicles/VTC_VS_taxi.jpg', 'Équipe Rentium', 'Comparatif', '2026-01-09 10:16:00', 0, 0),
(3, 'Roadtrip en France : Les meilleures routes à faire en électrique', 'Partez à l\'aventure sans polluer avec notre flotte de véhicules électriques.', '<p>L\'électrique fait peur pour les longs trajets ? C\'est du passé. Avec des véhicules comme la Tesla Model 3, traverser la France est un plaisir silencieux.</p><h3>La Route des Vins d\'Alsace</h3><p>Une route magnifique ponctuée de bornes de recharge dans presque tous les villages touristiques. Profitez des paysages vallonnés dans un silence absolu.</p><h3>La Côte d\'Azur</h3><p>De Nice à Menton, longez la mer. L\'autonomie de nos véhicules vous permet de faire l\'aller-retour sans stress.</p>', 'assets/images/vehicles/roadtrip_voiture_electrique.jpg', 'Équipe Rentium', 'Voyage', '2026-01-09 10:16:00', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `article_votes`
--

CREATE TABLE `article_votes` (
  `id_vote` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `vote_type` enum('like','dislike') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article_votes`
--

INSERT INTO `article_votes` (`id_vote`, `id_user`, `id_article`, `vote_type`, `created_at`) VALUES
(43, 5, 1, 'like', '2026-01-16 22:25:06');

-- --------------------------------------------------------

--
-- Structure de la table `concessionnaire`
--

CREATE TABLE `concessionnaire` (
  `id_concess` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `concessionnaire`
--

INSERT INTO `concessionnaire` (`id_concess`, `nom`, `adresse`, `email`, `latitude`, `longitude`) VALUES
(1, 'Concession Rentium Paris', '12 rue de la Location, Paris', 'contact@rentium.fr', 48.856600, 2.352200),
(2, 'Rentium Paris', '10 rue de Paris', 'contact@rentium.fr', 48.872000, 2.357000);

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE `payment` (
  `id_payment` int(11) NOT NULL,
  `methode` enum('CB','LIQUIDE','VIREMENT') DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_annonce` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `statut` enum('PENDING','CONFIRMED','CANCELED') DEFAULT 'PENDING',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_user`, `id_annonce`, `date_debut`, `date_fin`, `statut`, `created_at`) VALUES
(1, 7, 1, '2026-01-13 00:00:00', '2026-01-15 00:00:00', 'PENDING', '2026-01-13 10:47:31'),
(2, 13, 2, '2026-01-25 00:00:00', '2026-01-31 00:00:00', 'PENDING', '2026-01-16 22:46:48');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `avatar_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `email_verified` tinyint(1) DEFAULT 0,
  `email_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `email`, `mot_de_passe`, `is_active`, `avatar_url`, `created_at`, `email_verified`, `email_token`) VALUES
(1, 'max', 'maximelazurka@gmail.com', '$2y$10$KDJ2GGK6kFs8ok8EX.6VBuYbfQ/T6PBBODX8uCHYq0bbF9HQfTeyC', 1, NULL, '2025-12-19 01:46:57', 1, NULL),
(2, 'dscwxc', 'mma@gmail.com', '$2y$10$qRsw5X0jdbbt1iSMg5qYH.vUY84.pa/ALNe2QWcn8vXBi2re3INHO', 1, NULL, '2025-12-19 02:06:10', 1, NULL),
(3, 'osa', 'osa@sa', '$2y$10$vmzrb1s/rkfSVUkqcowKcusp4JzJ7GIi0OJfG7qMuAARHqCeNvFrW', 1, NULL, '2025-12-19 09:33:13', 1, NULL),
(4, 'max', 'max@maxiem', '$2y$10$1G2qBsSMaz1Fc7h4ujRsY.KZ5MV7vd9DRoW4879dzJpQvXz7RuFUK', 1, NULL, '2025-12-19 10:44:07', 1, NULL),
(5, 'Test test', 'test@gmail.com', 'xxx', 1, NULL, '2026-01-11 00:26:53', 1, NULL),
(6, 'ayman', 'ayman@gmail.com', 'xxx', 1, NULL, '2026-01-11 00:27:52', 1, NULL),
(7, 'Ayman', 'ay@gmail.com', '$2y$10$QJEMIS94x1MC9BPPH1087uti/c8PwxgtVZxLGlUz8e9f0YmTjV9PK', 1, NULL, '2026-01-13 10:46:44', 1, NULL),
(8, 'Ayman', 'aym@gmail.com', '$2y$10$Uu1bkOUjEVGMjxIrAIU/QezTdUm7Ghp//xDK1w3ZBzD.r/2JLy0WO', 1, NULL, '2026-01-13 10:48:08', 1, NULL),
(10, 'Malanda', 'lgm@gmail.com', '$2y$10$6.JYdSzY2eL2s7lLUqYuE.za/xuPrW7AcB9QNZSmi1Gk15nUn5pQC', 1, NULL, '2026-01-16 09:03:39', 1, NULL),
(11, 'mind', 'try@gmail.com', '$2y$10$IYf5w50qJrovlIdxVJvzhOLwuYlSiQCp3TGOgPy1bzkqL9XsH.EuS', 1, NULL, '2026-01-16 09:10:58', 1, NULL),
(12, 'Lyne', 'lyne@gmail.com', '$2y$10$mt/7CX3t1j4dzacTIVZjP.4p8AxvIZOLEmPZgifRuf2TJcbseM.S.', 1, 'assets/uploads/avatars/avatar_12_1768663011.jpg', '2026-01-16 22:32:25', 1, NULL),
(13, 'lgm', 'lynemalanda@gmail.com', '$2y$10$L.MdIh7NLY4h5tJJKhlNNucBsrhmK6S4VxikCWA9xirGtmUkf185W', 1, 'assets/uploads/avatars/avatar_13_1768675496.jpg', '2026-01-06 21:25:33', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user_details`
--

CREATE TABLE `user_details` (
  `id_detail` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `notif_email` tinyint(1) DEFAULT 1,
  `notif_sms` tinyint(1) DEFAULT 0,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `email_secours` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_details`
--

INSERT INTO `user_details` (`id_detail`, `id_user`, `prenom`, `telephone`, `bio`, `adresse`, `notif_email`, `notif_sms`, `ville`, `code_postal`, `date_naissance`, `genre`, `facebook`, `twitter`, `email_secours`, `linkedin`) VALUES
(1, 5, '', '', NULL, NULL, 1, 0, '', '', '0000-00-00', '', '', '', '', ''),
(6, 10, 'Lyne', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 11, 'dont', NULL, NULL, NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 12, NULL, '0681525298', NULL, NULL, 1, 1, 'Paris', '75009', NULL, 'Femme', '', '', '', ''),
(9, 13, NULL, '', NULL, NULL, 1, 1, '', '', '1998-03-06', 'Femme', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

CREATE TABLE `user_role` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id_voiture` int(11) NOT NULL,
  `plaque` varchar(32) NOT NULL,
  `marque` varchar(100) DEFAULT NULL,
  `modele` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `prix_journalier` decimal(10,2) DEFAULT NULL,
  `id_concess` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `plaque`, `marque`, `modele`, `type`, `couleur`, `prix_journalier`, `id_concess`, `image`) VALUES
(6, 'AA-611-AA', 'Audi', 'A6', 'Berline', 'Noir', 65.00, 1, 'Audi A6.png'),
(7, 'AA-612-AA', 'Audi', 'X5', 'SUV', 'Blanc', 75.00, 1, 'Audi X5.png'),
(8, 'BB-511-BB', 'BMW', 'Série 5', 'Berline', 'Gris', 70.00, 1, 'BMW Série 5.png'),
(9, 'HH-101-HH', 'Hyundai', 'Ioniq Hybride', 'Hybride', 'Bleu', 48.00, 1, 'Hyundai Ioniq Hybride.png'),
(10, 'JJ-101-JJ', 'Jaguar', 'XF', 'Berline', 'Noir', 85.00, 1, 'Jaguar XF.png'),
(11, 'LL-301-LL', 'Lexus', 'ES 300h', 'Hybride', 'Gris', 78.00, 1, 'Lexus ES 300h.png'),
(12, 'MM-401-MM', 'Mercedes', 'Classe E', 'Berline', 'Noir', 72.00, 1, 'Mercedes Classe E.png'),
(13, 'MM-402-MM', 'Mercedes', 'Viano', 'Monospace', 'Argent', 62.00, 1, 'Mercedes Viano.png'),
(14, 'NN-201-NN', 'Nissan', 'Leaf', 'Électrique', 'Blanc', 52.00, 1, 'Nissan Leaf.png'),
(15, 'PP-508-PP', 'Peugeot', '508', 'Berline', 'Gris', 58.00, 1, 'Peugeot 508.png'),
(16, 'TT-201-TT', 'Toyota', 'Corolla Hybride', 'Hybride', 'Blanc', 50.00, 1, 'Toyota Corolla Hybride.png'),
(17, 'TT-202-TT', 'Toyota', 'Prius', 'Hybride', 'Bleu', 54.00, 1, 'Toyota Prius.png'),
(18, 'VV-901-VV', 'Volvo', 'S90', 'Berline', 'Noir', 80.00, 1, 'Volvo S90.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `id_concess` (`id_concess`),
  ADD KEY `validated_by_admin_id` (`validated_by_admin_id`),
  ADD KEY `id_voiture` (`id_voiture`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`);

--
-- Index pour la table `article_votes`
--
ALTER TABLE `article_votes`
  ADD PRIMARY KEY (`id_vote`),
  ADD UNIQUE KEY `unique_vote` (`id_user`,`id_article`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `concessionnaire`
--
ALTER TABLE `concessionnaire`
  ADD PRIMARY KEY (`id_concess`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Index pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user`,`id_role`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id_voiture`),
  ADD UNIQUE KEY `plaque` (`plaque`),
  ADD KEY `id_concess` (`id_concess`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `article_votes`
--
ALTER TABLE `article_votes`
  MODIFY `id_vote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `concessionnaire`
--
ALTER TABLE `concessionnaire`
  MODIFY `id_concess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_concess`) REFERENCES `concessionnaire` (`id_concess`),
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`validated_by_admin_id`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `article_votes`
--
ALTER TABLE `article_votes`
  ADD CONSTRAINT `article_votes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_votes_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE;

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id_reservation`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`id_concess`) REFERENCES `concessionnaire` (`id_concess`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
