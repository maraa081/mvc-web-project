-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 04 jan. 2026 à 22:53
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
(1, 'Mercedes Classe A – Confort et élégance', 'Mercedes Classe A idéale pour vos trajets urbains et professionnels.', '2025-12-19 02:04:27', 1, 1, NULL, 48.856600, 2.352200, 1),
(2, 'BMW Série 3 – Dynamisme et performance', 'BMW Série 3 parfaite pour une conduite sportive et confortable.', '2025-12-19 02:04:27', 1, 1, NULL, 48.856600, 2.352200, 2),
(3, 'Audi A4 – Élégance allemande', 'Audi A4 alliant confort, style et fiabilité.', '2025-12-19 02:04:27', 1, 1, NULL, 48.856600, 2.352200, 3),
(4, 'Tesla Model 3 – 100% électrique', 'Tesla Model 3 pour une expérience de conduite moderne et écologique.', '2025-12-19 02:04:27', 1, 1, NULL, 48.856600, 2.352200, 4),
(5, 'Toyota RAV4 – SUV polyvalent', 'Toyota RAV4 spacieux et idéal pour les longs trajets.', '2025-12-19 02:04:27', 1, 1, NULL, 48.856600, 2.352200, 5);

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
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `id_conv` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_concess` int(11) NOT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(11) NOT NULL,
  `question` text DEFAULT NULL,
  `reponse` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by_admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

CREATE TABLE `favorite` (
  `id_fav` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `legal_page`
--

CREATE TABLE `legal_page` (
  `id_legal` int(11) NOT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `updated_by_admin_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `id_conv` int(11) NOT NULL,
  `sender` enum('USER','CONCESSIONNAIRE','ADMIN') DEFAULT NULL,
  `body` text DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset`
--

CREATE TABLE `password_reset` (
  `id_reset` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `statut` enum('PENDING','CONFIRMED','CANCELED') DEFAULT 'PENDING',
  `id_annonce` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_user`, `date_debut`, `date_fin`, `statut`, `id_annonce`, `created_at`) VALUES
(1, 1, '2025-12-20 00:00:00', '2025-12-22 00:00:00', 'PENDING', 1, '2025-12-19 02:22:39'),
(2, 2, '2025-12-12 00:00:00', '2026-01-09 00:00:00', 'PENDING', 1, '2025-12-19 02:27:04'),
(3, 3, '2025-12-03 00:00:00', '2025-12-11 00:00:00', 'PENDING', 1, '2025-12-19 09:34:52'),
(4, 3, '2025-12-13 00:00:00', '2025-12-27 00:00:00', 'PENDING', 1, '2025-12-19 09:35:19'),
(5, 3, '2025-12-12 00:00:00', '2025-12-18 00:00:00', 'PENDING', 3, '2025-12-19 10:01:43'),
(6, 4, '2025-12-20 00:00:00', '2025-12-12 00:00:00', 'PENDING', 2, '2025-12-19 10:45:52');

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

CREATE TABLE `review` (
  `id_review` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Structure de la table `support_ticket`
--

CREATE TABLE `support_ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `email_contact` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('OPEN','IN_PROGRESS','RESOLVED','CLOSED') DEFAULT 'OPEN',
  `created_at` datetime DEFAULT current_timestamp(),
  `handled_by_admin_id` int(11) DEFAULT NULL,
  `handled_at` datetime DEFAULT NULL
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
(4, 'max', 'max@maxiem', '$2y$10$1G2qBsSMaz1Fc7h4ujRsY.KZ5MV7vd9DRoW4879dzJpQvXz7RuFUK', 1, NULL, '2025-12-19 10:44:07', 1, NULL);

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
(1, 'AA-111-AA', 'Mercedes', 'Classe A', 'Berline', 'Noir', 50.00, 1, 'mercedes_a.jpg'),
(2, 'BB-222-BB', 'BMW', 'Série 3', 'Berline', 'Blanc', 60.00, 1, 'bmw_serie3.jpg'),
(3, 'CC-333-CC', 'Audi', 'A4', 'Berline', 'Gris', 55.00, 1, 'audi_a4.jpg'),
(4, 'DD-444-DD', 'Tesla', 'Model 3', 'Électrique', 'Rouge', 70.00, 1, 'tesla_model3.jpg'),
(5, 'EE-555-EE', 'Toyota', 'RAV4', 'SUV', 'Bleu', 65.00, 1, 'toyota_rav4.jpg');

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
  ADD KEY `annonce_ibfk_voiture` (`id_voiture`);

--
-- Index pour la table `concessionnaire`
--
ALTER TABLE `concessionnaire`
  ADD PRIMARY KEY (`id_concess`);

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id_conv`),
  ADD KEY `conversation_ibfk_1` (`id_user`),
  ADD KEY `conversation_ibfk_2` (`id_concess`),
  ADD KEY `conversation_ibfk_3` (`id_annonce`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `faq_ibfk_1` (`created_by_admin_id`);

--
-- Index pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `favorite_ibfk_1` (`id_user`),
  ADD KEY `favorite_ibfk_2` (`id_annonce`);

--
-- Index pour la table `legal_page`
--
ALTER TABLE `legal_page`
  ADD PRIMARY KEY (`id_legal`),
  ADD KEY `legal_page_ibfk_1` (`updated_by_admin_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `message_ibfk_1` (`id_conv`);

--
-- Index pour la table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id_reset`),
  ADD KEY `password_reset_ibfk_1` (`id_user`);

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
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `review_ibfk_1` (`id_user`),
  ADD KEY `review_ibfk_2` (`id_annonce`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `support_ticket`
--
ALTER TABLE `support_ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `support_ticket_ibfk_1` (`id_user`),
  ADD KEY `support_ticket_ibfk_2` (`handled_by_admin_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user`,`id_role`),
  ADD KEY `user_role_ibfk_2` (`id_role`);

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
  MODIFY `id_annonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `concessionnaire`
--
ALTER TABLE `concessionnaire`
  MODIFY `id_concess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id_conv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id_fav` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `legal_page`
--
ALTER TABLE `legal_page`
  MODIFY `id_legal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id_reset` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id_payment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `support_ticket`
--
ALTER TABLE `support_ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_concess`) REFERENCES `concessionnaire` (`id_concess`),
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`validated_by_admin_id`) REFERENCES `admin` (`id_admin`),
  ADD CONSTRAINT `annonce_ibfk_voiture` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `conversation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `conversation_ibfk_2` FOREIGN KEY (`id_concess`) REFERENCES `concessionnaire` (`id_concess`),
  ADD CONSTRAINT `conversation_ibfk_3` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`created_by_admin_id`) REFERENCES `admin` (`id_admin`);

--
-- Contraintes pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `legal_page`
--
ALTER TABLE `legal_page`
  ADD CONSTRAINT `legal_page_ibfk_1` FOREIGN KEY (`updated_by_admin_id`) REFERENCES `admin` (`id_admin`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_conv`) REFERENCES `conversation` (`id_conv`);

--
-- Contraintes pour la table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`id_reservation`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`),
  ADD CONSTRAINT `reservation_ibfk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `support_ticket`
--
ALTER TABLE `support_ticket`
  ADD CONSTRAINT `support_ticket_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `support_ticket_ibfk_2` FOREIGN KEY (`handled_by_admin_id`) REFERENCES `admin` (`id_admin`);

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
