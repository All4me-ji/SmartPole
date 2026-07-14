# SmartPole

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8-blue)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-blue)
![License](https://img.shields.io/badge/Academic-Project-orange)

## Présentation

SmartPole est une application web développée dans le cadre d'un stage chez **BS International**. Elle permet de centraliser les données des différents pôles d'une entreprise afin de faciliter le suivi des performances et d'améliorer la prise de décision.

L'application intègre un tableau de bord interactif, un système de gestion des ventes, de la production et des objectifs, ainsi qu'un module de prédiction des ventes basé sur une régression linéaire simple.

---

## Fonctionnalités principales

- Authentification des utilisateurs
- Gestion des utilisateurs (CRUD)
- Gestion des pôles (CRUD)
- Gestion des ventes (CRUD)
- Gestion des objectifs (CRUD)
- Gestion de la production (CRUD)
- Tableau de bord avec indicateurs de performance (KPI)
- Génération de rapports PDF et Excel
- Module de prédiction des ventes basé sur une régression linéaire
- Alertes automatiques selon les performances des pôles

---

## Module d'intelligence artificielle

Le module de prédiction repose sur une **régression linéaire simple** implémentée directement en PHP au sein de Laravel.

Les données utilisées proviennent de la base PostgreSQL de l'application. Les ventes sont agrégées par mois afin d'estimer la tendance et de prédire les ventes des périodes futures.

Le modèle fournit notamment :

- la tendance observée ;
- les ventes prévisionnelles ;
- le coefficient de détermination (R²) ;
- la MAE (Mean Absolute Error) ;
- la RMSE (Root Mean Square Error).

---

## Technologies utilisées

### Backend

- Laravel 12
- PHP 8
- Eloquent ORM

### Frontend

- Blade
- HTML5
- CSS3
- JavaScript

### Base de données

- PostgreSQL

### Bibliothèques

- Chart.js
- DomPDF
- Laravel Excel

---

## Architecture

Le projet suit l'architecture **MVC (Model – View – Controller)** proposée par Laravel.

```
Vue (Blade)
      │
Contrôleur
      │
Modèle
      │
PostgreSQL
      │
Module IA
```

---

## Installation

```bash
git clone https://github.com/All4me-ji/SmartPole.git
cd SmartPole

composer install
npm install
```

Créez un fichier `.env` à partir de `.env.example`, puis configurez votre connexion PostgreSQL.

```bash
php artisan key:generate
php artisan migrate
php artisan serve
```
---



## Auteur

**Yasmine COMPAORE**

Étudiante en Génie Informatique – HESTIM

Projet réalisé dans le cadre d'un stage chez **BS International**.
