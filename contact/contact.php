<?php
session_start(); // Start the session

include('../db/connexion.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    header('Location: ../ins_con/connexion.php');
    exit();
}

if ($_SESSION['userRoleId'] != 2) {
    header("Location: ../editeur/access-refuse.php");
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $userId = $_SESSION['userId']; // Utiliser l'ID de l'utilisateur connecté

    // Vérifier que le message a au moins 10 caractères
    if (strlen($message) < 10) {
        $error_message = "Le message doit contenir au moins 10 caractères.";
    } else {
        // Préparer la requête SQL pour insérer les données dans la table
        $sql = "INSERT INTO messages (name, email, user_id, message) VALUES (?, ?, ?, ?)";

        // Préparer la déclaration
        if ($stmt = $conn->prepare($sql)) {
            // Lier les paramètres
            $stmt->bind_param("ssis", $name, $email, $userId, $message);

            // Exécuter la requête
            if ($stmt->execute()) {
                $success_message = "Message envoyé avec succès !"; // Message de succès
            } else {
                $error_message = "Erreur : " . $stmt->error; // Message d'erreur
            }

            // Fermer la déclaration
            $stmt->close();
        } else {
            $error_message = "Erreur de préparation de la requête : " . $conn->error;
        }
    }
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
    <!-- En-tête avec le logo et la navigation -->
    <header class="header">
        <a href="../editeur/catalogue-creation.php">
            <img src="../images/PixelMinds.png" alt="Logo" class="logo">
        </a>
        <nav>
            <ul class="nav-list">
                <li><a href="../non_editeur/catalogue-list.php">Catalogues</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="../ins_con/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenu principal -->
    <div class="main-container">
        <div class="left-section">
            <h1>Contactez-nous dès maintenant.</h1>
            <p class="catchphrase" id="catchphrase"></p>
        </div>

        <form method="POST" class="form-container">
            <div class="form-group">
                <input type="text" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Message" required></textarea>
            </div>

            <!-- Notification Messages -->
            <?php if (isset($success_message)): ?>
                <div class="notification success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="notification error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <div class="form-group">
                <input type="submit" name="envoi" value="Envoyer">
            </div>
        </form>
    </div>

    <script>
        // Fonction d'effet d'écriture pour la phrase d'accroche
        document.addEventListener("DOMContentLoaded", function() {
            var catchphraseText = "Nous sommes là pour vous écouter !";
            var catchphraseElement = document.getElementById('catchphrase');
            var index = 0;

            function typeWriter() {
                if (index < catchphraseText.length) {
                    catchphraseElement.textContent += catchphraseText.charAt(index);
                    index++;
                    setTimeout(typeWriter, 50); // Ajustez la vitesse ici
                }
            }
            typeWriter(); // Lance l'effet d'écriture
        });
    </script>
</body>

</html>