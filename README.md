---
marp: true
---

# Application de gestion de Contacts

**Contact Management / Filtrage par Ville**

**Présentée par :** Ayoub jalyta  
**Encadré par :** M. Fouad Essarraj  
**Date :** 05/01/2026

---

## 📑 Sommaire

1. [la méthode Waterfall](#-la-méthode-waterfall)
2. [Choix de sujet](#-choix-de-sujet)
3. [Contexte du Projet](#-contexte-du-projet)
4. [Exigences: Analyse Technique](#-exigences-analyse-technique)
5. [Stack Technique](#-stack-technique)
6. [Fonctionnalités Clés](#-fonctionnalités-clés)
7. [Analyse: Analyse Fonctionnelle](#-analyse-analyse-fonctionnelle)
8. [Conception](#-conception)
9. [Sujet - Live Coding](#-sujet---live-coding)

---

## la méthode Waterfall

![Waterfall](asses/Waterfall.webp)

---
# Exigences: Travail à faire
Développer l'Application Contact Management
Partie Publique: Interface permettant aux visiteurs de consulter les contacts. Fonctionnalités : Recherche par nom, filtre par ville, pagination (10 éléments/page).
Partie Admin: Tableau de bord sécurisé pour les opérations CRUD. Fonctionnalités : Modales pour ajout/édition, AJAX pour les mises à jour asynchrones.
---


## Contexte du Projet

![2-tup](asses/La-methode-2TUP-6.png)

---

## Exigences: Analyse Technique

## Stack Technique

- **Base de données :** MySQL
- **Framework :** Laravel
- **Architecture N-tier :** Services
- **Architecture :** MVC
- **Moteur de vues :** Blade
- **AJAX :** Interactivité fluide sans rechargement
- **Gestion des Images :** Upload et stockage sécurisé

---

- **Internationalisation :** Support multilingue de l'interface
- **Vite :** Optimisation des performances
- **Preline UI :** Intégration d'un design système moderne
- **Lucide Library :** Icônes modernes

---

## Analyse: Analyse Fonctionnelle

### Diagramme de Cas d'Utilisation

![Use Case Diagram](asses/useCase.png)

---

## Conception

### Diagramme de Classe

<img src='./asses/DigrameClass.png' width='200'>

---

## Versions & Branches

| Version | Description                                   | Branche      |
| :------ | :-------------------------------------------- | :----------- |
| **v1**  | Public Side (Consultation, Recherche, Filtre) | `public`     |
| **v2**  | Admin Side (CRUD, Modales)                    | `admin`      |
| **v3**  | Authentification / Authorization (Gates)      | `gates`      |
| **v4**  | SPA / AJAX                                    | `spa-ajax`   |
| **v5**  | SPA / Alpine.js                               | `spa-alpine` |
| **v6**  | Spatie / Authorization                        | `spatie`     |
| **v7**  | API                                           | `api`        |
| **v8**  | Mobile App                                    | `mobile`     |

# v1 Public Side - Live Coding
## Creation du portfolio personnel

# v2 Admin Side - Live Coding
## Gestion des articles (CRUD)

# v3 Authentification / Authorization - Live Coding
 
# v4 SPA / AJAX - Live Coding
- Un bouton “Ajouter” qui ouvre une modale pour créer un nouvel élément.
- Une barre de recherche filtrant des éléments par titre.

# v5 SPA / Alpine.js - Live Coding

# v6 Spatie / Authorization - Live Coding

# v7 API - Live Coding

# v8 Mobile App - Live Coding
