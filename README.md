# 🏨 Rambla Marrakech — Plateforme d'e-services hôteliers

Application web Laravel permettant à un hôtel de dématérialiser ses services
clients : réservation de chambres et de prestations, room service et gestion
des réclamations techniques — avec trois espaces dédiés (Client, Serveur,
Administration/Technique).

> Projet de fin d'année — Ingénierie Informatique et Réseaux, EMSI Marrakech

---

## ✨ Fonctionnalités

### Espace Client
- 🛏️ Consultation des chambres avec photos, équipements et caractéristiques
- 📅 Réservation avec calendrier interactif et vérification de disponibilité en temps réel
- ❌ Annulation de réservation (jusqu'à 24h avant l'arrivée)
- 🍽️ Commande de room service avec menu par catégorie
- 🛠️ Dépôt de réclamations techniques, avec priorisation automatique
- 🔐 Connexion classique ou via Google (OAuth)

### Espace Serveur / Restaurant
- 📋 Suivi des commandes de room service en temps réel
- 🔄 Mise à jour du statut : reçue → en préparation → en livraison → livrée

### Espace Administration / Technique
- 🚨 Tableau de bord avec alertes sur les réclamations urgentes
- ✅ Confirmation ou annulation des réservations en attente
- 🧑‍🔧 Assignation et résolution des réclamations

---

## 🛠️ Stack technique

| Catégorie | Technologies |
|---|---|
| Backend | Laravel 12, PHP 8.2 |
| Base de données | MySQL, Eloquent ORM |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Authentification | Laravel Breeze, Laravel Socialite (OAuth Google) |
| Sélecteur de dates | Flatpickr |
| Rôles & permissions | Middleware personnalisé (`CheckRole`) |

---

## 🏗️ Architecture

L'application repose sur une architecture en couches classique :

```
Présentation (Blade + Tailwind)
        ↓
Application (Contrôleurs + Modèles Laravel)
        ↓
Données (MySQL via Eloquent)
```

Chaque espace (Client / Staff / Admin) est protégé par un groupe de routes
dédié, sécurisé par le middleware de contrôle de rôle.

---

## 🚀 Installation

### Prérequis
- PHP >= 8.2
- Composer
- Node.js + npm
- MySQL (via Laragon, XAMPP, ou installation standalone)

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/Adil-efl2004/rambla-marrakech.git
cd rambla-marrakech

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate
```

Configurer la base de données dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_eservices
DB_USERNAME=root
DB_PASSWORD=
```

Pour la connexion Google (optionnel) :

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
```

```bash
# 4. Créer la base de données, puis lancer les migrations + données de test
php artisan migrate --seed

# 5. Démarrer l'application (2 terminaux)
php artisan serve
npm run dev
```

Ouvrir : **http://127.0.0.1:8000**

---

## 👤 Comptes de test

Après le seed, ces comptes sont disponibles (mot de passe : `password`) :

| Rôle | Email |
|---|---|
| Serveur (restaurant) | `serveur@hotel.test` |
| Technicien | `technicien@hotel.test` |
| Admin | `admin@hotel.test` |

Un compte client peut être créé via `/register`.

---

## 🗺️ Espaces de l'application

| Espace | URL de départ | Rôle requis |
|---|---|---|
| Client | `/client/dashboard` | `client` |
| Serveur / Restaurant | `/staff/orders` | `serveur` |
| Admin / Technique | `/admin/dashboard` | `technicien`, `admin` |

---

## 🧩 Problèmes fréquents

**Erreur de connexion à la base de données**
→ Vérifie que ton service MySQL (Laragon/XAMPP) est bien démarré avant de
lancer `php artisan migrate`.

**Page sans style (CSS manquant)**
→ Vérifie que `npm run dev` tourne bien dans un terminal actif.

**Erreur de version PHP à l'installation**
→ Le projet tourne sur Laravel 12 (compatible PHP 8.2+). Composer installera
automatiquement la version compatible avec ton PHP.

---

## 📄 Licence

Projet académique — EMSI Marrakech, 2025-2026.
