# Vite et Gourmand

Application web et web mobile de gestion de commandes de menus traiteur pour l'entreprise Vite & Gourmand.

## Description

Vite & Gourmand est une application e-commerce développée sous le framework Symfony. Son utilisation générale permet aux clients de consulter des menus, passer des commandes, suivre l'état de livraison, et laisser des avis. Les employés gèrent les menus, plats, horaires du traiteur et les commandes. L'administrateur consulte les statistiques et gère les comptes employés.

## Stack Technique

- **Framework** : Symfony 7.4
- **Langage** : PHP 8.2
- **Base de données relationnelle** : MySQL 8.0
- **Base de données NoSQL** : MongoDB 6.0
- **Frontend** : Twig, Bootstrap 5, JavaScript (ES6+)
- **Build tool** : Webpack Encore
- **Conteneurisation** : Docker & Docker Compose

## Prérequis

- PHP 8.2+
- Composer 2.0+
- Node.js 18+
- npm 9+
- Docker & Docker Compose (optionnel)

## Installation locale

### 1. Cloner le repository

```bash
git clone https://github.com/Hatenaa/vite-et-gourmand.git
cd vite-et-gourmand
```

### 2. Installer les dépendances

```bash
composer install
npm install
npm run build
```

### 3. Configurer l'environnement

```bash
cp .env .env.local
```

Éditer `.env.local` avec vos variables (DATABASE_URL, MAILER_DSN, etc.)

### 4. Base de données

```bash
php bin/console doctrine:migrations:migrate
```

### 5. Démarrer l'application

```bash
docker-compose up -d
```

Accès : http://localhost:8080

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | jose@example.com | u8jS5[#;mM2Dr5 |
| Employé | josette@example.com | +Ngpt@.25Ng4J9 |
| Client | marta.nowak@example.com | ^[epj?958AB5jG |

## Déploiement

L'application est déployée sur fly.io.

URL Production : https://vite-et-gourmand-bordeaux.fly.dev

Pour plus de détails, voir la documentation technique.
