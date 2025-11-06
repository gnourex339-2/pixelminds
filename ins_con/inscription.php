<?php
$bdd = new PDO('mysql:host=localhost;dbname=pixelminds;charset=utf8;', 'root', 'root');
$errorMessage = '';

if (isset($_POST['envoi'])) {
    if (!empty($_POST['userRoleId']) && !empty($_POST['login']) && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        
        $userRoleId = (int)$_POST['userRoleId'];
        $login = htmlspecialchars($_POST['login']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']);

        // Verifier si l email utiliser pour s'inscrire est deja utilisé
        $checkUser = $bdd->prepare('SELECT * FROM useraccount WHERE email = ? OR login = ?');
        $checkUser->execute([$email, $login]);
        
        if ($checkUser->rowCount() > 0) {
            $errorMessage = "L'email ou le login est déjà utilisé.";
        } else {
            $insertuseraccount = $bdd->prepare('INSERT INTO useraccount(userRoleId, login, firstname, lastname, email, password) VALUES(?, ?, ?, ?, ?, ?)');
            $insertuseraccount->execute([$userRoleId, $login, $firstname, $lastname, $email, $password]);        
            echo "Compte créé avec succès.";
            header("refresh:1;url=connexion.php");
            exit();
        }
    } else {
        $errorMessage = "Veuillez compléter tous les champs...";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Inscription</h1>
            
            <!-- Afficher les erreurs -->
            <?php if (!empty($errorMessage)): ?>
                <p class="error-message"><?php echo $errorMessage; ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <select name="userRoleId" required>
                    <option value="" disabled selected>Sélectionnez un rôle</option>
                    <option value="1">Éditeur</option>
                    <option value="2">Non-Éditeur</option>
                </select>
                <input type="text" name="login" placeholder="Login" autocomplete="off" required>
                <input type="text" name="firstname" placeholder="Prénom" autocomplete="off" required>
                <input type="text" name="lastname" placeholder="Nom" autocomplete="off" required>
                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>
                <input type="submit" name="envoi" value="S'inscrire">
            </form>
            <p class="signup-link">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </div>
</body>
</html>
