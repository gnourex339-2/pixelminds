<?php
$servername = "localhost";  // Serveur MySQL
$username = "root";         // Nom d'utilisateur de la base de données
$password = "root";             // Mot de passe de la base de données
$dbname = "pixelminds";     // Nom de la base de données

// Créer la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Vérifier la connexion
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}
?>