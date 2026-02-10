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
2. [Contexte du Projet](#-contexte-du-projet)
3. [Exigences: Analyse Technique](#-exigences-analyse-technique)
4. [Stack Technique](#-stack-technique)
5. [Fonctionnalités Clés](#-fonctionnalités-clés)
6. [Analyse: Analyse Fonctionnelle](#-analyse-analyse-fonctionnelle)
7. [Conception](#-conception)

---

## la méthode Waterfall

![Waterfall](asses/Waterfall.webp)

---

# Exigences: Travail à faire

Développer l'Application Contact Management
Partie Publique: Interface permettant aux visiteurs de consulter les contacts. Fonctionnalités : Recherche par nom, filtre par ville, pagination (10 éléments/page).
Partie Admin: Tableau de bord sécurisé pour les opérations CRUD. Fonctionnalités Modales pour ajout/édition, AJAX pour les mises à jour asynchrones.

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
- **Alpine.js:** Interactivité fluide sans rechargement
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

## 💻 Sujets - Live Coding

| Version | Sujet                            | Tâches                                                                 |
| :------ | :------------------------------- | :--------------------------------------------------------------------- |
| **v1**  | Public Side                      | Création du portfolio personnel                                        |
| **v2**  | Admin Side                       | Gestion des articles (CRUD)                                            |
| **v3**  | Authentification / Authorization | -                                                                      |
| **v4**  | SPA / AJAX                       | - Bouton "Ajouter" (Modale)<br>- Barre de recherche (Filtre par titre) |
| **v5**  | SPA / Alpine.js                  | -                                                                      |
| **v6**  | Spatie / Authorization           | -                                                                      |
| **v7**  | API                              | -                                                                      |
| **v8**  | Mobile App                       | -                                                                      |
