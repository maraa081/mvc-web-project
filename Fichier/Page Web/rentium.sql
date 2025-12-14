CREATE DATABASE IF NOT EXISTS rentium CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rentium;

SET NAMES utf8mb4;

CREATE TABLE concessionnaire (
  id_concess INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255),
  adresse VARCHAR(255),
  email VARCHAR(255),
  latitude DECIMAL(10,6),
  longitude DECIMAL(10,6)
);

CREATE TABLE user (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255),
  email VARCHAR(255),
  mot_de_passe VARCHAR(255),
  is_active BOOLEAN DEFAULT TRUE,
  avatar_url VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255),
  email VARCHAR(255),
  mot_de_passe VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE voiture (
  plaque VARCHAR(32) PRIMARY KEY,
  marque VARCHAR(100),
  modele VARCHAR(100),
  type VARCHAR(100),
  couleur VARCHAR(50),
  prix_journalier DECIMAL(10,2),
  id_concess INT NOT NULL,
  FOREIGN KEY (id_concess) REFERENCES concessionnaire(id_concess)
);

CREATE TABLE annonce (
  id_annonce INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255),
  description TEXT,
  date_publication DATETIME,
  actif BOOLEAN DEFAULT TRUE,
  id_concess INT NOT NULL,
  voiture_plaque VARCHAR(32) NOT NULL UNIQUE,
  validated_by_admin_id INT NULL,
  latitude DECIMAL(10,6),
  longitude DECIMAL(10,6),
  FOREIGN KEY (id_concess) REFERENCES concessionnaire(id_concess),
  FOREIGN KEY (voiture_plaque) REFERENCES voiture(plaque),
  FOREIGN KEY (validated_by_admin_id) REFERENCES admin(id_admin)
);

CREATE TABLE reservation (
  id_reservation INT AUTO_INCREMENT PRIMARY KEY,
  date_debut DATETIME,
  date_fin DATETIME,
  statut ENUM('PENDING','CONFIRMED','CANCELED') DEFAULT 'PENDING',
  id_annonce INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_annonce) REFERENCES annonce(id_annonce)
);

CREATE TABLE payment (
  id_payment INT AUTO_INCREMENT PRIMARY KEY,
  methode ENUM('CB','LIQUIDE','VIREMENT'),
  montant DECIMAL(10,2),
  paid_at DATETIME,
  reservation_id INT UNIQUE NULL,
  FOREIGN KEY (reservation_id) REFERENCES reservation(id_reservation)
);

CREATE TABLE role (
  id_role INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50)
);

CREATE TABLE user_role (
  id_user INT NOT NULL,
  id_role INT NOT NULL,
  assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user),
  FOREIGN KEY (id_role) REFERENCES role(id_role)
);

CREATE TABLE faq (
  id_faq INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT,
  reponse TEXT,
  is_published BOOLEAN DEFAULT TRUE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_by_admin_id INT,
  FOREIGN KEY (created_by_admin_id) REFERENCES admin(id_admin)
);

CREATE TABLE legal_page (
  id_legal INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(100),
  titre VARCHAR(255),
  contenu TEXT,
  is_published BOOLEAN DEFAULT TRUE,
  updated_by_admin_id INT,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (updated_by_admin_id) REFERENCES admin(id_admin)
);

CREATE TABLE favorite (
  id_fav INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  id_annonce INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user),
  FOREIGN KEY (id_annonce) REFERENCES annonce(id_annonce)
);

CREATE TABLE review (
  id_review INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  id_annonce INT,
  rating INT,
  comment TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user),
  FOREIGN KEY (id_annonce) REFERENCES annonce(id_annonce)
);

CREATE TABLE conversation (
  id_conv INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_concess INT NOT NULL,
  id_annonce INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user),
  FOREIGN KEY (id_concess) REFERENCES concessionnaire(id_concess),
  FOREIGN KEY (id_annonce) REFERENCES annonce(id_annonce)
);

CREATE TABLE message (
  id_message INT AUTO_INCREMENT PRIMARY KEY,
  id_conv INT NOT NULL,
  sender ENUM('USER','CONCESSIONNAIRE','ADMIN'),
  body TEXT,
  sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  read_at DATETIME,
  FOREIGN KEY (id_conv) REFERENCES conversation(id_conv)
);

CREATE TABLE support_ticket (
  id_ticket INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  email_contact VARCHAR(255),
  sujet VARCHAR(255),
  message TEXT,
  status ENUM('OPEN','IN_PROGRESS','RESOLVED','CLOSED') DEFAULT 'OPEN',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  handled_by_admin_id INT,
  handled_at DATETIME,
  FOREIGN KEY (id_user) REFERENCES user(id_user),
  FOREIGN KEY (handled_by_admin_id) REFERENCES admin(id_admin)
);

CREATE TABLE password_reset (
  id_reset INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT,
  token VARCHAR(255),
  expires_at DATETIME,
  used_at DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES user(id_user)
);
