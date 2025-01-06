# 📝 Système de Gestion de Blog
Bienvenue dans notre projet de blog interactif et dynamique ! Ce système a été conçu pour permettre aux utilisateurs de créer, gérer et interagir avec des articles, tout en offrant des fonctionnalités d'administration avancées.

## 🌟 Fonctionnalités
### 1. Exploration et Navigation
Navigation intuitive à travers des thèmes prédéfinis.
Recherche d'articles par titre.
Filtrage dynamique des articles par tags.
Affichage par lots (pagination) pour une expérience utilisateur fluide.
### 2. Création et Gestion d'Articles
Ajout d'articles avec support pour images et vidéos.
Gestion des articles par thèmes et tags.
Validation des données utilisateur.
### 3. Interactions avec le Blog
Ajout, modification et suppression de commentaires.
Possibilité de sauvegarder des articles comme favoris.
Historique des articles consultés.
### 4. Gestion Administrative
Tableau de bord pour gérer les thèmes, articles, tags et commentaires.
Statistiques avancées sur les articles les plus populaires.
Modération des commentaires et gestion des tags multiples.
### 5. Backend : SQL
Procédures stockées pour les actions clés (ajout de réservations, etc.).
Vues SQL pour des analyses rapides et personnalisées.
## 🔧 Technologies Utilisées
### Frontend :
HTML, CSS (avec Tailwind CSS), JavaScript (Vanilla).
### Backend :
PHP avec gestion des sessions et interactions SQL.
### Base de Données :
MySQL avec des vues, des procédures stockées et un modèle relationnel structuré.
Environnement de Développement :
Laragon pour un serveur local rapide et performant.
## 🚀 Installation
Clonez le projet depuis ce dépôt :

bash
Copier le code
git clone <url-du-repo>
cd <nom-du-repo>
Configurez votre environnement :

Installez et configurez Laragon ou un autre serveur local.
Importez la base de données depuis le fichier database.sql situé dans le dossier /db.
Lancez le serveur local et ouvrez le projet dans votre navigateur.

## 🐞 Bugs Connus
Pagination : Problèmes avec certains filtres par tags.
Tags : Sauvegarde incorrecte des tags associés à des articles.
Commentaires : Certains utilisateurs rencontrent des erreurs lors de la modification.
Favoris : Les articles supprimés peuvent encore apparaître dans les favoris.
Si vous rencontrez d'autres bugs, veuillez les signaler en créant une issue.

## 🛠️ Améliorations Futures
Ajout d'un système de notifications pour les nouvelles publications.
Intégration d'une API externe pour enrichir les articles avec des données supplémentaires.
Optimisation des requêtes SQL pour gérer des bases de données plus volumineuses.
Implémentation d'un système de recommandation basé sur les favoris des utilisateurs.
💻 Contributions
Les contributions sont les bienvenues ! Voici comment procéder :

Forkez ce dépôt.
Créez une branche pour votre fonctionnalité ou correction :
bash
Copier le code
git checkout -b feature/nouvelle-fonctionnalite
Faites vos modifications et commitez-les :
bash
Copier le code
git commit -m "Ajout d'une nouvelle fonctionnalité"
Envoyez vos modifications via une Pull Request.
