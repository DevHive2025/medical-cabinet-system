# 🏥 Système de Gestion de Cabinet Médical

![Laravel](https://img.shields.io/badge/Framework-Laravel%2012-red)
![MySQL](https://img.shields.io/badge/Database-MySQL-blue)
![Tailwind](https://img.shields.io/badge/Frontend-Tailwind%20CSS-06B6D4)
![License](https://img.shields.io/badge/License-Academic-green)

## 📌 Présentation du Projet
Ce projet consiste en la conception et le développement d'un **Système de Gestion de Cabinet Médical** complet. Réalisé dans le cadre du module **Programmation Backend PHP (S6)** à la Faculté des Sciences Semlalia (FSSM), Université Cadi Ayyad.

L'objectif est de centraliser et d'automatiser les processus clés d'un cabinet multi-praticiens, de la prise de rendez-vous à la génération d'ordonnances.

---

## 👥 Acteurs & Fonctionnalités
- **👨‍💼 Administrateur :** Configuration globale, gestion des utilisateurs/rôles et statistiques via un tableau de bord.
- **⚕️ Médecin :** Gestion du planning, consultations médicales, accès aux dossiers patients et génération d'ordonnances PDF.
- **👩‍💻 Secrétaire :** Gestion des fiches patients, prise et modification de rendez-vous.
- **👤 Patient :** Inscription, prise de RDV en ligne et consultation de son historique médical.

---

## 🛠️ Stack Technique
- **Backend :** Laravel 12 (Architecture MVC)
- **Frontend :** Blade Templates & Tailwind CSS
- **Base de données :** MySQL (Eloquent ORM)
- **Génération PDF :** DomPDF
- **E-mails :** Mailtrap (Environnement de test)
- **Tests :** PHPUnit
- **Gestion de projet :** Agile Scrum (Jira)

---

## 🚀 Installation et Configuration

### 1. Prérequis
Assurez-vous d'avoir installé **PHP >= 8.2**, **Composer**, et **Node.js**.

### 2. Cloner le dépôt

git clone [https://github.com/votre-username/votre-repo.git](https://github.com/votre-username/votre-repo.git)
cd votre-repo

### 3. Dépendances PHP & JS
composer install
npm install && npm run build

### 4. Configuration de l'environnement
cp .env.example .env
php artisan key:generate
Configurez votre base de données dans le fichier .env.

### 5. Base de données (Migrations & Seeders)
Pour créer les tables et insérer les données de test (comptes démo) :
php artisan migrate --seed

### 6. Lancer l'application
php artisan serve
Accès : http://127.0.0.1:8000

## Line de site web 
https://medical-cabinet-system-production.up.railway.app