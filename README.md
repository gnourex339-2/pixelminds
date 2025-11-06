PixelMinds
PixelMinds est une application web interactive permettant aux utilisateurs de créer, gérer et visualiser des catalogues d'images enrichis. Le projet se distingue par sa gestion des rôles utilisateurs, offrant des fonctionnalités distinctes pour les "Éditeurs", qui peuvent définir des zones interactives sur les images, et les "Non-Éditeurs", qui peuvent explorer ces contenus.

Fonctionnalités Principales
Système de Rôles : Distinction claire entre les utilisateurs "Éditeur" et "Non-Éditeur".

Authentification : Inscription, connexion et déconnexion sécurisées.

Espace Éditeur :

Création et suppression de catalogues.

Ajout d'images aux catalogues avec positionnement personnalisé.

Création de zones interactives (labels) sur les images à l'aide d'un outil de dessin sur canvas HTML5.

Consultation et suppression des messages envoyés par les utilisateurs.

Espace Non-Éditeur :

Navigation dans la liste des catalogues disponibles.

Visualisation des images interactives : survol des zones définies pour afficher des info-bulles avec titre et description.

Formulaire de contact pour envoyer des messages aux administrateurs/éditeurs.

Structure du Projet
L'architecture du projet est organisée comme suit :

db/ : Contient le script de connexion à la base de données (connexion.php).

ins_con/ : Gère l'authentification des utilisateurs (inscription, connexion, déconnexion).

editeur/ : Dossier contenant toutes les pages et scripts réservés aux éditeurs (création de catalogue, gestion des labels, messagerie).

non_editeur/ : Dossier pour l'interface publique accessible aux non-éditeurs (liste des catalogues, visualisation).

contact/ : Contient le formulaire de contact.

images/ : Stocke les images utilisées dans les catalogues et les ressources graphiques du site.

projet2024.sql : Fichier de dump SQL pour initialiser la structure de la base de données et les données par défaut.

Installation et Configuration
Base de Données :

Créez une base de données MySQL (par exemple, nommée pixelminds).

Importez le fichier projet2024.sql pour créer les tables nécessaires (useraccount, catalog, image, label, messages, etc.) et insérer les données initiales.

Configuration :

Ouvrez le fichier db/connexion.php et mettez à jour les informations de connexion si nécessaire. La configuration par défaut est :

PHP

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pixelminds";
Déploiement :

Placez les fichiers du projet sur un serveur web compatible PHP (comme Apache ou Nginx).

Assurez-vous que le serveur a accès à votre base de données MySQL.

Utilisation
Inscription : Rendez-vous sur la page ins_con/inscription.php pour créer un compte. Vous pouvez choisir votre rôle (Éditeur ou Non-Éditeur) lors de l'inscription.

Connexion : Utilisez la page ins_con/connexion.php pour vous connecter. L'application vous redirigera automatiquement vers l'espace correspondant à votre rôle :

Les Éditeurs sont redirigés vers editeur/catalogue-creation.php.

Les Non-Éditeurs sont redirigés vers non_editeur/catalogue-list.php.

Technologies Utilisées
Backend : PHP

Base de données : MySQL / MariaDB

Frontend : HTML, CSS, JavaScript (API Canvas pour l'interactivité des images)
