
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AjouterReservation` (IN `p_user_id` INT, IN `p_vehicule_id` INT, IN `p_date_debut` DATE, IN `p_date_fin` DATE, IN `p_options_supplementaires` TEXT)   BEGIN
    INSERT INTO Reservations (user_id, vehicule_id, date_debut, date_fin, options_supplementaires)
    VALUES (p_user_id, p_vehicule_id, p_date_debut, p_date_fin, p_options_supplementaires);
END$$

DELIMITER ;

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `statut` enum('en_attente','approuve','refuse') NOT NULL DEFAULT 'en_attente',
  `user_id` int NOT NULL,
  `theme_id` int NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `articletags` (
  `article_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `avis` (
  `id` int NOT NULL,
  `reservation_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `vehicule_id` int DEFAULT NULL,
  `note` int DEFAULT NULL,
  `commentaire` text,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;


CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `categories` (`id`, `nom`, `description`, `created_at`) VALUES
(1, 'Luxury', 'High-end luxury vehicles', '2025-01-02 01:15:08'),
(8, 'BouLahia', 'jhb', '2025-01-03 10:55:45'),
(9, 'wassim', 'gfrg', '2025-01-03 15:22:47'),
(10, 'asma', 'hbbn', '2025-01-04 20:58:18');

CREATE TABLE `commentaires` (
  `id` int NOT NULL,
  `contenu` text NOT NULL,
  `user_id` int NOT NULL,
  `article_id` int NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `favoris` (
  `user_id` int NOT NULL,
  `article_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `historiquearticles` (
  `user_id` int NOT NULL,
  `article_id` int NOT NULL,
  `date_consultation` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `likescommentaires` (
  `user_id` int NOT NULL,
  `commentaire_id` int NOT NULL,
  `type` enum('like','dislike') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `listevehicules` (
`id` int
,`modele` varchar(100)
,`marque` varchar(50)
,`categorie` varchar(100)
,`description` text
,`prix` decimal(10,2)
,`disponibilite` tinyint(1)
,`annee_fabrication` int
,`kilometrage` int
,`type_carburant` varchar(20)
,`boite_vitesse` varchar(20)
,`puissance_moteur` int
,`couleur` varchar(20)
,`equipements_standards` text
,`options_supplementaires` text
,`dates_disponibles` text
,`lieu_prise_en_charge` varchar(100)
,`lieu_retour` varchar(100)
,`image_path` varchar(100)
);

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `vehicule_id` int DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `statut` enum('en attente','approuvée','refusée') DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reservations` (`id`, `user_id`, `vehicule_id`, `date_debut`, `date_fin`, `statut`, `created_at`) VALUES
(1, 1, 1, '2023-04-01', '2023-04-05', 'approuvée', '2025-01-02 01:19:57'),
(25, 5, 1, '1988-09-23', '1984-11-27', 'en attente', '2025-01-04 20:55:29'),
(26, 6, 17, '2017-06-17', '1993-08-07', 'en attente', '2025-01-05 11:50:59');


CREATE TABLE `statistiques` (
  `id` int NOT NULL,
  `total_clients` int DEFAULT '0',
  `total_reservations` int DEFAULT '0',
  `reservations_approuvees` int DEFAULT '0',
  `reservations_en_attente` int DEFAULT '0',
  `reservations_refusees` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `statistiques` (`id`, `total_clients`, `total_reservations`, `reservations_approuvees`, `reservations_en_attente`, `reservations_refusees`, `created_at`) VALUES
(1, 5, 5, 2, 2, 1, '2025-01-02 01:17:32');

CREATE TABLE `tags` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `themes` (
  `id` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `users` (
  `id` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') DEFAULT 'client',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'John', 'Doe', 'john.doe@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client', '2024-12-30 16:30:20'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client', '2024-12-30 16:30:20'),
(3, 'Alice', 'Johnson', 'alice.johnson@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client', '2024-12-30 16:30:20'),
(4, 'Bob', 'Brown', 'bob.brown@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFX5GeY5K1x8i1uD1qK1x8i1uD1qK1x8i', 'client', '2024-12-30 16:30:20'),
(5, 'Charlie', 'Davis', 'charlie.davis@example.com', '$2y$10$CbueuD6uWkX5pqSUG44l4uaGQTMU2wX06lgnZYBN4xHMrRRND9/Nm', 'admin', '2024-12-30 16:30:20'),
(6, 'sunday', 'Bertha', 'foku@mailinator.com', '$2y$10$VP3ZKGeGuRMawwi8GpwVa.rKUd6s59IwWSsYi47BCkCDtbMwPCAhO', 'client', '2025-01-05 11:40:13');

CREATE TABLE `vehicules` (
  `id` int NOT NULL,
  `modele` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `disponibilite` tinyint(1) DEFAULT '1',
  `categorie_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(100) NOT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `description` text,
  `annee_fabrication` int DEFAULT NULL,
  `kilometrage` int DEFAULT NULL,
  `type_carburant` varchar(20) DEFAULT NULL,
  `boite_vitesse` varchar(20) DEFAULT NULL,
  `puissance_moteur` int DEFAULT NULL,
  `couleur` varchar(20) DEFAULT NULL,
  `equipements_standards` text,
  `options_supplementaires` text,
  `dates_disponibles` text,
  `lieu_prise_en_charge` varchar(100) DEFAULT NULL,
  `lieu_retour` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


INSERT INTO `vehicules` (`id`, `modele`, `prix`, `disponibilite`, `categorie_id`, `created_at`, `image_path`, `marque`, `description`, `annee_fabrication`, `kilometrage`, `type_carburant`, `boite_vitesse`, `puissance_moteur`, `couleur`, `equipements_standards`, `options_supplementaires`, `dates_disponibles`, `lieu_prise_en_charge`, `lieu_retour`) VALUES
(1, 'BMW M440i', '890.00', 1, 1, '2025-01-02 01:17:00', 'pexels-hassan-bouamoud-1857973307-29977321.jpg', 'Toyota', 'Une berline compacte fiable et économique.', 2020, 15000, 'Essence', 'Automatique', 132, 'Blanc', 'Climatisation, GPS intégré, Bluetooth', 'GPS portable, siège bébé', '2023-04-01 à 2023-04-10', 'Paris', 'Lyon'),
(2, 'Mercedes AMG GT', '1200.00', 1, 2, '2025-01-02 01:17:00', 'pexels-cristian-villafranco-1110680966-29965274.jpg', 'BMW', 'Un SUV de luxe avec des performances exceptionnelles.', 2019, 30000, 'Diesel', 'Automatique', 265, 'Noir', 'Climatisation, GPS intégré, Bluetooth, Caméra de recul', 'Siège bébé, chaîne à neige', '2023-04-15 à 2023-04-25', 'Marseille', 'Nice'),

(20, 'Cum itaque omnis lab', '27.00', 0, 5, '2025-01-05 16:51:18', 'image (2).png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Cum itaque omnis lab', '27.00', NULL, 5, '2025-01-05 16:52:16', 'image (2).png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure for view `listevehicules`
--
DROP TABLE IF EXISTS `listevehicules`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `listevehicules`  AS SELECT `vehicules`.`id` AS `id`, `vehicules`.`modele` AS `modele`, `vehicules`.`marque` AS `marque`, `categories`.`nom` AS `categorie`, `vehicules`.`description` AS `description`, `vehicules`.`prix` AS `prix`, `vehicules`.`disponibilite` AS `disponibilite`, `vehicules`.`annee_fabrication` AS `annee_fabrication`, `vehicules`.`kilometrage` AS `kilometrage`, `vehicules`.`type_carburant` AS `type_carburant`, `vehicules`.`boite_vitesse` AS `boite_vitesse`, `vehicules`.`puissance_moteur` AS `puissance_moteur`, `vehicules`.`couleur` AS `couleur`, `vehicules`.`equipements_standards` AS `equipements_standards`, `vehicules`.`options_supplementaires` AS `options_supplementaires`, `vehicules`.`dates_disponibles` AS `dates_disponibles`, `vehicules`.`lieu_prise_en_charge` AS `lieu_prise_en_charge`, `vehicules`.`lieu_retour` AS `lieu_retour`, `vehicules`.`image_path` AS `image_path` FROM (`vehicules` join `categories` on((`vehicules`.`categorie_id` = `categories`.`id`)))  ;


ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `theme_id` (`theme_id`);

ALTER TABLE `articletags`
  ADD PRIMARY KEY (`article_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

ALTER TABLE `avis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicule_id` (`vehicule_id`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `article_id` (`article_id`);

ALTER TABLE `favoris`
  ADD PRIMARY KEY (`user_id`,`article_id`),
  ADD KEY `article_id` (`article_id`);

ALTER TABLE `historiquearticles`
  ADD PRIMARY KEY (`user_id`,`article_id`),
  ADD KEY `article_id` (`article_id`);

ALTER TABLE `likescommentaires`
  ADD PRIMARY KEY (`user_id`,`commentaire_id`),
  ADD KEY `commentaire_id` (`commentaire_id`);

ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicule_id` (`vehicule_id`);

ALTER TABLE `statistiques`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `vehicules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`);

ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `avis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `commentaires`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

ALTER TABLE `statistiques`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `themes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `vehicules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`);

ALTER TABLE `articletags`
  ADD CONSTRAINT `articletags_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `articletags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

ALTER TABLE `avis`
  ADD CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`),
  ADD CONSTRAINT `avis_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `avis_ibfk_3` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);

ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);

ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

ALTER TABLE `historiquearticles`
  ADD CONSTRAINT `historiquearticles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `historiquearticles_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

ALTER TABLE `likescommentaires`
  ADD CONSTRAINT `likescommentaires_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likescommentaires_ibfk_2` FOREIGN KEY (`commentaire_id`) REFERENCES `commentaires` (`id`) ON DELETE CASCADE;

ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicules` (`id`);

ALTER TABLE `vehicules`
  ADD CONSTRAINT `vehicules_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);
COMMIT;
