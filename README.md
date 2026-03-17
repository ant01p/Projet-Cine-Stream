# 🎬 CineStream+ — Vidéothèque

## 📌 Description

Projet PHP permettant de créer une vidéothèque personnelle.  
L’utilisateur peut rechercher des films via l’API TMDB, les ajouter, les modifier et les organiser.

---

## 🚀 Fonctionnalités

- Recherche de films (API TMDB)
- Ajout à la vidéothèque
- Affichage des films
- Filtre par genre et statut (vu / à voir)
- Fiche détaillée d’un film
- Modification (genre, description, vu / à voir)
- Suppression d’un film

---

## 🛠️ Technologies

- PHP 8
- MySQL
- HTML / CSS / JavaScript
- Docker
- API TMDB

---

## ⚙️ Installation

# 1. Cloner le projet


git clone <repo>
cd projet

---

# 2. lancer docker

docker compose up -d

---

# 3. Accéder au site

http://localhost:8080

---

# 4. Configurer l’environnement

Créer le fichier .env.php à la racine du projet :

<?php
define('TMDB_API_KEY', 'TA_CLE_API');

- Tu peux obtenir une clé ici : https://www.themoviedb.org/settings/api
⚠️ Ne jamais commit ce fichier


