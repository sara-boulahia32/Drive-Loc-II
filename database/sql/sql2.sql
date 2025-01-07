-- Création de la base de données
CREATE DATABASE IF NOT EXISTS DriveLoc;
USE DriveLoc;

-- Table users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Themes
CREATE TABLE Themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Articles
CREATE TABLE Articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    image_path VARCHAR(255),
    video_path VARCHAR(255),
    statut ENUM('en_attente', 'approuve', 'refuse') NOT NULL DEFAULT 'en_attente',
    user_id INT NOT NULL,
    theme_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (theme_id) REFERENCES Themes(id)
);

-- Table Tags
CREATE TABLE Tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) UNIQUE NOT NULL
);

-- Table ArticleTags (relation many-to-many entre Articles et Tags)
CREATE TABLE ArticleTags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES Articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES Tags(id) ON DELETE CASCADE
);

-- Table Commentaires
CREATE TABLE Commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT NOT NULL,
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (article_id) REFERENCES Articles(id)
);

-- Table Favoris (relation many-to-many entre users et Articles)
CREATE TABLE Favoris (
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    PRIMARY KEY (user_id, article_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES Articles(id) ON DELETE CASCADE
);

-- Table LikesCommentaires (relation many-to-many entre users et Commentaires)
CREATE TABLE LikesCommentaires (
    user_id INT NOT NULL,
    commentaire_id INT NOT NULL,
    type ENUM('like', 'dislike') NOT NULL,
    PRIMARY KEY (user_id, commentaire_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (commentaire_id) REFERENCES Commentaires(id) ON DELETE CASCADE
);

-- Table HistoriqueArticles (relation many-to-many entre users et Articles pour l'historique)
CREATE TABLE HistoriqueArticles (
    user_id INT NOT NULL,
    article_id INT NOT NULL,
    date_consultation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, article_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES Articles(id) ON DELETE CASCADE
);

-- Table Vehicules
CREATE TABLE Vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(255) NOT NULL,
    marque VARCHAR(255) NOT NULL,
    categorie_id INT NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    disponibilite BOOLEAN NOT NULL DEFAULT TRUE,
    annee_fabrication YEAR,
    kilometrage INT,
    type_carburant VARCHAR(50),
    boite_vitesse VARCHAR(50),
    puissance_moteur INT,
    couleur VARCHAR(50),
    equipements_standards TEXT,
    options_supplementaires TEXT,
    dates_disponibles TEXT,
    lieu_prise_en_charge VARCHAR(255),
    lieu_retour VARCHAR(255),
    image_path VARCHAR(255),
    FOREIGN KEY (categorie_id) REFERENCES Categories(id)
);


-- Table Reservations
CREATE TABLE Reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vehicule_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('en attente', 'approuvée', 'refusée') NOT NULL DEFAULT 'en attente',
    options_supplementaires TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    user_id INT,
    vehicule_id INT,
    note INT CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    deleted_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

-- Vue SQL pour la liste des véhicules
CREATE VIEW ListeVehicules AS
SELECT vehicules.id, vehicules.modele, vehicules.marque, categories.nom AS categorie, vehicules.description, vehicules.prix, vehicules.disponibilite, vehicules.annee_fabrication, vehicules.kilometrage, vehicules.type_carburant, vehicules.boite_vitesse, vehicules.puissance_moteur, vehicules.couleur, vehicules.equipements_standards, vehicules.options_supplementaires, vehicules.dates_disponibles, vehicules.lieu_prise_en_charge, vehicules.lieu_retour, vehicules.image_path
FROM Vehicules
JOIN Categories ON vehicules.categorie_id = categories.id;

-- Procédure stockée pour l'ajout d'une réservation
DELIMITER //
CREATE PROCEDURE AjouterReservation(
    IN p_user_id INT,
    IN p_vehicule_id INT,
    IN p_date_debut DATE,
    IN p_date_fin DATE,
    IN p_options_supplementaires TEXT
)
BEGIN
    INSERT INTO Reservations (user_id, vehicule_id, date_debut, date_fin, options_supplementaires)
    VALUES (p_user_id, p_vehicule_id, p_date_debut, p_date_fin, p_options_supplementaires);
END //
DELIMITER ;
