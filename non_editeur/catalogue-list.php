<?php
session_start();
include('../db/connexion.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    header('Location: ../ins_con/connexion.php');
    exit();
}

// Vérifier le rôle de l'utilisateur
if ($_SESSION['userRoleId'] != 2) {
    header("Location: ../non_editeur/access-refuse.php");
    exit();
}

// Exécuter la requête pour récupérer les catalogues
$query = "SELECT id, name, description FROM Catalog";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si des résultats sont retournés
if ($result->num_rows === 0) {
    die("Aucun catalogue trouvé.");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogues</title>
    <link rel="stylesheet" href="css/catalogue-list.css">
</head>
<body>
    <header class="header">
        <a href="../editeur/catalogue-creation.php">
            <img src="../images/PixelMinds.png" alt="Logo" class="logo">
        </a>
        <nav>
            <ul class="nav-list">
                <li><a href="catalogue-list.php">Catalogues</a></li>
                <li><a href="../contact/contact.php">Contact</a></li>
                <li><a href="../ins_con/logout.php">Déconnexion</a></li>
                </ul>
        </nav>
    </header>

    <main>
        <h1>Liste des Catalogues</h1>

        <!-- Afficher les catalogues -->
        <div class="catalog-container">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="catalog-item">
                    <a href="../non_editeur/catalogue.php?catalogId=<?php echo htmlspecialchars($row['id']); ?>">
                        <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                        <p><?php echo htmlspecialchars($row['description']); ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <script src="acceuil.js"></script>
</body>
</html>
