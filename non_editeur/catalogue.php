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
    header("Location: ../editeur/access-refuse.php");
    exit();
}

if (isset($_GET['catalogId']) && is_numeric($_GET['catalogId'])) {
    $catalogId = intval($_GET['catalogId']);
} else {
    die("Erreur : ID de catalogue invalide ou non fourni.");
}

// Requête pour récupérer les images du catalogue
$query = "SELECT Image.id, Image.name 
            FROM CatalogImage 
            JOIN Image ON CatalogImage.imageId = Image.id 
            WHERE CatalogImage.catalogId = ? 
            ORDER BY CatalogImage.position";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $catalogId);
$stmt->execute();
$result = $stmt->get_result();

$images = [];
while ($row = $result->fetch_assoc()) {
    $images[] = $row;
}

// Requête pour récupérer les labels associés aux images
$queryLabels = "SELECT id, imageId, name, description, points 
                FROM label 
                WHERE catalogId = ?";
$stmtLabels = $conn->prepare($queryLabels);
$stmtLabels->bind_param("i", $catalogId);
$stmtLabels->execute();
$labelsResult = $stmtLabels->get_result();

$labels = [];
while ($label = $labelsResult->fetch_assoc()) {
    $labels[$label['imageId']][] = $label;
}

$stmt->close();
$stmtLabels->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue <?php echo htmlspecialchars($catalogId); ?></title>
    <link rel="stylesheet" href="css/catalogue.css">
</head>
<body>
    <header class="header">
        <a href="../non_editeur/catalogue-list.php">
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

    <main class="main-content">
        <h1>Catalogue <?php echo htmlspecialchars($catalogId); ?></h1>
        <p>Pour plus de details, passer la souris sur le point rouge :</p>
        <div id="image-gallery" class="gallery-container">
            <?php foreach ($images as $image) : ?>
                <div class="image-item">
                    <img src="../images/mi/<?php echo htmlspecialchars($image['name']); ?>" alt="Image" class="gallery-image" id="image-<?php echo $image['id']; ?>" data-image-id="<?php echo $image['id']; ?>">

                    <canvas id="canvas-<?php echo $image['id']; ?>" class="image-canvas" width="600" height="400"></canvas>

                    <?php if (isset($labels[$image['id']])) : ?>
                    <div class="labels-overlay">
                        <?php foreach ($labels[$image['id']] as $label) : ?>
                            <!-- boutton rouge -->
                            <div class="label" style="position: absolute; 
                                <?php 
                                    $points = json_decode($label['points']);
                                    if (isset($points[0])) {
                                        echo "left: {$points[0]->x}px; top: {$points[0]->y}px;";
                                    }
                                ?>">

                                <div class="label-hover-text">
                                    <span class="label-name"><?php echo htmlspecialchars($label['name']); ?></span>
                                    <span class="label-description"><?php echo htmlspecialchars($label['description']); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
