<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: ../ins_con/login.php");
    exit();
}

if ($_SESSION['userRoleId'] == 1) {
    // Rediriger vers le dossier éditeur si l'utilisateur est un éditeur
    header("Location: ../editeur/catalogue-creation.php");
    exit();
} elseif ($_SESSION['userRoleId'] == 2) {
    // Rediriger vers le catalogue non éditeur si l'utilisateur est un non-éditeur
    header("Location: ../non_editeur/catalogue-list.php");
    exit();
}
?>
