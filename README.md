# Système de Gestion de Bibliothèque

Un système de gestion de bibliothèque développé en PHP permettant de gérer une collection de livres.

## Fonctionnalités

- Affichage de la liste des livres
- Ajout de nouveaux livres
- Modification des informations des livres existants
- Suppression de livres
- Visualisation détaillée des informations d'un livre

## Structure du Projet

- `index.php` - Page principale affichant la liste des livres
- `ajouter.php` - Formulaire d'ajout de nouveaux livres
- `modifier.php` - Page de modification des livres existants
- `supprimer.php` - Gestion de la suppression des livres
- `voir.php` - Affichage détaillé d'un livre
- `config.php` - Configuration de la base de données

## Prérequis

- PHP 7.0 ou supérieur
- Serveur MySQL/MariaDB
- Serveur Web (Apache/Nginx)

## Installation

1. Clonez ce dépôt dans votre répertoire web
2. Configurez votre base de données dans le fichier `config.php`
3. Importez la structure de la base de données
4. Accédez à l'application via votre navigateur web

## Utilisation

1. Accédez à la page d'accueil via `index.php`
2. Utilisez les différents boutons pour naviguer dans l'application :
   - "Ajouter" pour créer un nouveau livre
   - "Modifier" pour mettre à jour les informations
   - "Supprimer" pour retirer un livre
   - "Voir" pour consulter les détails

## Sécurité

- Les entrées utilisateur sont validées et nettoyées
- Protection contre les injections SQL
- Gestion des erreurs

## Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
1. Fork le projet
2. Créer une branche pour votre fonctionnalité
3. Soumettre une pull request

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.

---
Développé avec ❤️ pour le cours de Virtualisation des données
