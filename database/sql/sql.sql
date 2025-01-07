CREATE DATABASE drive_loc;
USE drive_loc;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    vehicule_id INT,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('en attente', 'approuvée', 'refusée') DEFAULT 'en attente',
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

CREATE TABLE statistiques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_clients INT DEFAULT 0,
    total_reservations INT DEFAULT 0,
    reservations_approuvees INT DEFAULT 0,
    reservations_en_attente INT DEFAULT 0,
    reservations_refusees INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Create tables
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255),
    role VARCHAR(20)
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    description TEXT
);

CREATE TABLE vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(50),
    prix DECIMAL(10, 2),
    disponibilite TINYINT DEFAULT 1,
    categorie_id INT,
    image VARCHAR(255),
    FOREIGN KEY (categorie_id) REFERENCES categories(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    vehicule_id INT,
    date_debut DATE,
    date_fin DATE,
    statut VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    user_id INT,
    vehicule_id INT,
    note INT,
    commentaire TEXT,
    created_at DATE,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicules(id)
);

CREATE TABLE statistiques (
    total_clients INT,
    total_reservations INT,
    reservations_approuvees INT,
    reservations_en_attente INT,
    reservations_refusees INT
);

-- Insert data into tables
INSERT INTO users (nom, prenom, email, password, role) VALUES
('John', 'Doe', 'john.doe@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client'), -- Password: password123
('Jane', 'Smith', 'jane.smith@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client'), -- Password: password123
('Alice', 'Johnson', 'alice.johnson@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client'), -- Password: password123
('Bob', 'Brown', 'bob.brown@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client'), -- Password: password123
('Charlie', 'Davis', 'charlie.davis@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'admin'); -- Password: password123

INSERT INTO categories (nom, description) VALUES
('Luxury', 'High-end luxury vehicles'),
('Sports', 'High-performance sports cars'),
('SUV', 'Sport Utility Vehicles'),
('Electric', 'Electric vehicles'),
('Sedan', 'Comfortable sedans');

INSERT INTO vehicules (modele, prix, disponibilite, categorie_id, image) VALUES
('BMW M440i', 890, 1, 1, 'bmw_m440i.jpg'),
('Mercedes AMG GT', 1200, 1, 2, 'mercedes_amg_gt.jpg'),
('Porsche Cayenne', 950, 0, 3, 'porsche_cayenne.jpg'),
('Audi Q7', 800, 1, 1, 'audi_q7.jpg'),
('Tesla Model S', 1000, 1, 2, 'tesla_model_s.jpg');

INSERT INTO reservations (id, user_id, vehicule_id, date_debut, date_fin, statut) VALUES
(1, 1, 1, '2023-04-01', '2023-04-05', 'approuvée'),
(2, 2, 2, '2023-04-10', '2023-04-15', 'en attente'),
(3, 3, 3, '2023-04-20', '2023-04-25', 'refusée'),
(4, 4, 4, '2023-05-01', '2023-05-05', 'approuvée'),
(5, 5, 5, '2023-05-10', '2023-05-15', 'en attente');

INSERT INTO avis (reservation_id, user_id, vehicule_id, note, commentaire, created_at) VALUES
(1, 1, 1, 5, 'Amazing car, had a great experience!', '2023-04-06'),
(2, 2, 2, 4, 'Very good, but a bit expensive.', '2023-04-16'),
(3, 3, 3, 3, 'Average experience, car was not very clean.', '2023-04-26'),
(4, 4, 4, 5, 'Loved it! Will rent again.', '2023-05-06'),
(5, 5, 5, 4, 'Great car, but the battery life could be better.', '2023-05-16');

INSERT INTO statistiques (total_clients, total_reservations, reservations_approuvees, reservations_en_attente, reservations_refusees) VALUES
(5, 5, 2, 2, 1);
