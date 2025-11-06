<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['userId'])) {
    // Si l'utilisateur est connecté, rediriger selon son rôle
    if ($_SESSION['userRoleId'] == 1) {
        // Redirection pour le mode Éditeur
        header("Location: ../editeur/catalogue-creation.php");
        exit();
    } elseif ($_SESSION['userRoleId'] == 2) {
        // Redirection pour le mode Non-Éditeur
        header("Location: ../non_editeur/catalogue.php");
        exit();
    } else {
        echo "Rôle utilisateur inconnu.";
        exit();
    }
}

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=pixelminds;charset=utf8;', 'root', 'root');

if (isset($_POST['envoi'])) {
    if (!empty($_POST['login']) && !empty($_POST['password'])) {

        $login = htmlspecialchars($_POST['login']);
        $password = sha1($_POST['password']);

        $recupuseraccount = $bdd->prepare('SELECT * FROM useraccount WHERE login = ? AND password = ?');
        $recupuseraccount->execute([$login, $password]);

        if ($recupuseraccount->rowCount() > 0) {
            // Récupérer le rôle utilisateur
            $user = $recupuseraccount->fetch();

            // Stocker les informations utilisateur dans la session
            $_SESSION['userId'] = $user['id']; // ID de l'utilisateur
            $_SESSION['userRoleId'] = $user['userRoleId']; // Rôle de l'utilisateur
            $_SESSION['userName'] = $user['login']; // Nom d'utilisateur

            // Redirection selon le rôle de l'utilisateur
            if ($_SESSION['userRoleId'] == 1) {
                header("Location: ../editeur/catalogue-creation.php");
            } elseif ($_SESSION['userRoleId'] == 2) {
                header("Location: ../non_editeur/catalogue-list.php");
            } else {
                echo "Rôle utilisateur inconnu.";
            }
            exit();

        } else {
            echo "Votre mot de passe ou login est incorrect.";
        }
    } else {
        echo "Veuillez compléter tous les champs...";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Connexion</h1>

            <!-- Afficher les erreurs -->
            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="login" placeholder="Login" autocomplete="off" required>
                <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>
                <input type="submit" name="envoi" value="Se connecter">
            </form>
            <p class="signup-link">
                Pas de compte ? <a href="/PixelMinds/ins_con/inscription.php">Vous inscrire</a>
            </p>
        </div>
    </div>
</body>
</html>
