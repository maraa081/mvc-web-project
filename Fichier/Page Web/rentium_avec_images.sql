-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 déc. 2025 à 16:49
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
-- Base de données : `test`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom`, `email`, `mot_de_passe`, `created_at`) VALUES
(1, 'Admin1', 'admin1@rentium.com', 'rootpass', '2025-11-07 10:22:39'),
(2, 'SuperAdmin', 'super@rentium.com', 'superpass', '2025-11-07 10:22:39');

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
  `voiture_plaque` varchar(32) NOT NULL,
  `validated_by_admin_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description`, `date_publication`, `actif`, `id_concess`, `voiture_plaque`, `validated_by_admin_id`, `latitude`, `longitude`) VALUES
(1, 'Toyota Corolla à louer', 'Idéale pour la ville.', '2025-11-07 10:22:39', 1, 1, 'AA-123-AA', 1, NULL, NULL),
(2, 'Peugeot 208 urbaine', 'Compacte et économique.', '2025-11-07 10:22:39', 1, 1, 'BB-456-BB', 2, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `concessionnaire`
--

INSERT INTO `concessionnaire` (`id_concess`, `nom`, `adresse`, `email`, `latitude`, `longitude`) VALUES
(1, 'Auto Paris', '12 rue de Lyon, Paris', 'contact@autoparis.fr', 48.856600, 2.352200),
(2, 'Nice Cars', '45 avenue Jean Médecin, Nice', 'info@nicecars.fr', 43.703100, 7.266100),
(3, 'Luxembourg Cars', '3 Frontières Mont-Saint-Martin, Luxembourg', 'info@luxembourgcars.fr', 49.549654, 5.809480);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id_faq`, `question`, `reponse`, `is_published`, `created_at`, `updated_at`, `created_by_admin_id`) VALUES
(1, 'Comment réserver ?', 'Cliquez sur une annonce et choisissez vos dates.', 1, '2025-11-07 10:22:39', '2025-11-07 10:22:39', 1),
(2, 'Comment payer ?', 'Le paiement se fait par carte ou virement.', 1, '2025-11-07 10:22:39', '2025-11-07 10:22:39', 2);

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

CREATE TABLE `favorite` (
  `id_fav` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_annonce` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `statut` enum('PENDING','CONFIRMED','CANCELED') DEFAULT 'PENDING',
  `id_annonce` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `name`) VALUES
(1, 'USER'),
(2, 'ADMIN'),
(3, 'CONCESSIONNAIRE');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `email`, `mot_de_passe`, `is_active`, `avatar_url`, `created_at`) VALUES
(1, 'Thomas Dupont', 'thomas.dupont@gmail.com', 'hash123', 1, NULL, '2025-11-07 10:22:39'),
(2, 'Sarah Leroy', 'sarah.leroy@gmail.com', 'hash456', 1, NULL, '2025-11-07 10:22:39'),
(3, 'Tim Schoulmann-Doré', 'timdore2705@gmail.com', '$2y$10$pcoArPv7Wh9h6xBC5zy9n.KG4B/2JAf17wnrYAXpO.PI.lJUyFEOe', 1, NULL, '2025-11-25 15:23:00'),
(4, 'max schur', 'maxshur234@gmail.com', '$2y$10$NpOZziacIY4MvzcaL2G23uzFsf1VBsPaU7biZrkpv5Hwuw/cTBkPG', 1, NULL, '2025-11-25 15:33:37'),
(5, 'Osama oss', 'osama@gmail.com', '$2y$10$fE7Rh7cPu/cEO2e9FDFoauQm9KuEIuvMe7t5KCMxbigFTEv8LUIZC', 1, NULL, '2025-11-28 08:49:16'),
(6, 'Maxime Lafdfgzd', 'max@gmail.com', '$2y$10$cFVKcL0rEmT9ZLdUm29uTe6jNyRJQ32pvrcxmKqku/RpovRElh/VG', 1, NULL, '2025-11-28 10:27:08');

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

CREATE TABLE `user_role` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`id_user`, `id_role`, `assigned_at`) VALUES
(1, 1, '2025-11-07 10:22:39'),
(2, 1, '2025-11-07 10:22:39');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `plaque` varchar(32) NOT NULL,
  `marque` varchar(100) DEFAULT NULL,
  `modele` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `prix_journalier` decimal(10,2) DEFAULT NULL,
  `id_concess` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`plaque`, `marque`, `modele`, `type`, `couleur`, `prix_journalier`, `id_concess`, `image`) VALUES
('AA-119-JF', 'Kia', 'EV6', 'SUV', 'Grise', 90.00, 1, NULL),
('AA-123-AA', 'Toyota', 'Corolla', 'Berline', 'Blanche', 50.00, 1, NULL),
('AB-472-NK', 'Mercedes', 'Classe E', 'Berline', 'Noire', 95.00, 1, NULL),
('BB-456-BB', 'Peugeot', '208', 'Citadine', 'Rouge', 45.00, 1, NULL),
('BB-774-SQ', 'Hyundai', 'Ioniq 6', 'Berline', 'Noire', 88.00, 2, NULL),
('CC-654-CD', 'Renault', 'Clio IV', 'Citadine', 'Noire', 38.00, 1, NULL),
('CP-983-LS', 'BMW', 'Série 5', 'Berline', 'Grise', 90.00, 3, NULL),
('DE-876-KJ', 'Renault', 'Clio III', 'Citadine', 'Blanche', 32.00, 1, NULL),
('DL-621-ZF', 'Audi', 'A6', 'Berline', 'Blanche', 88.00, 2, NULL),
('EZ-150-RV', 'Tesla', 'Model S', 'Berline', 'Noire', 110.00, 1, NULL),
('FG-505-GF', 'Mercedes', 'A35', 'Citadine', 'Noire', 42.00, 2, NULL),
('FK-744-MP', 'Mercedes', 'Classe V', 'Van', 'Noire', 130.00, 2, NULL),
('GH-319-WT', 'Volkswagen', 'Sharan', 'Van', 'Grise', 80.00, 3, NULL),
('JK-857-QA', 'Audi', 'Q5', 'SUV', 'Noire', 105.00, 1, NULL),
('LM-204-HG', 'Mercedes', 'GLC', 'SUV', 'Blanche', 108.00, 2, NULL),
('PN-668-BR', 'BMW', 'X3', 'SUV', 'Grise', 102.00, 3, NULL),
('RT-590-VE', 'Skoda', 'Superb', 'Berline', 'Noire', 75.00, 1, NULL),
('SA-742-NG', 'Mercedes', 'Classe A', 'Citadine', 'Grise', 45.00, 2, NULL),
('SA-821-KP', 'Lexus', 'ES300h', 'Berline', 'Noire', 92.00, 2, NULL),
('TB-349-NM', 'Toyota', 'Camry Hybrid', 'Berline', 'Blanche', 70.00, 3, NULL),
('UC-452-RD', 'Tesla', 'Model 3', 'Berline', 'Grise', 85.00, 1, NULL),
('VD-714-XA', 'Mercedes', 'Classe S', 'Berline', 'Noire', 160.00, 3, NULL),
('WE-532-LQ', 'Audi', 'A8', 'Berline', 'Noire', 155.00, 2, NULL),
('XF-903-TB', 'BMW', 'Série 7', 'Berline', 'Grise', 150.00, 1, NULL),
('YG-287-CH', 'Mercedes', 'C180', 'Berline', 'Blanche', 120.00, 2, NULL),
('ZH-660-PV', 'Tesla', 'Model Y', 'SUV', 'Noire', 95.00, 3, NULL);

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
  ADD UNIQUE KEY `voiture_plaque` (`voiture_plaque`),
  ADD KEY `id_concess` (`id_concess`),
  ADD KEY `validated_by_admin_id` (`validated_by_admin_id`);

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
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_concess` (`id_concess`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `created_by_admin_id` (`created_by_admin_id`);

--
-- Index pour la table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id_fav`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `legal_page`
--
ALTER TABLE `legal_page`
  ADD PRIMARY KEY (`id_legal`),
  ADD KEY `updated_by_admin_id` (`updated_by_admin_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_conv` (`id_conv`);

--
-- Index pour la table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id_reset`),
  ADD KEY `id_user` (`id_user`);

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
  ADD KEY `id_annonce` (`id_annonce`);

--
-- Index pour la table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id_review`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_annonce` (`id_annonce`);

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
  ADD KEY `id_user` (`id_user`),
  ADD KEY `handled_by_admin_id` (`handled_by_admin_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_role` (`id_role`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`plaque`),
  ADD KEY `id_concess` (`id_concess`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `concessionnaire`
--
ALTER TABLE `concessionnaire`
  MODIFY `id_concess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id_conv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `review`
--
ALTER TABLE `review`
  MODIFY `id_review` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `support_ticket`
--
ALTER TABLE `support_ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_concess`) REFERENCES `concessionnaire` (`id_concess`),
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`voiture_plaque`) REFERENCES `voiture` (`plaque`),
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`validated_by_admin_id`) REFERENCES `admin` (`id_admin`);

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
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);

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
