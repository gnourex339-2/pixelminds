<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: /login.php");
    exit();
}

// Vérifier le rôle de l'utilisateur
if ($_SESSION['userRoleId'] != 1) {
    header("Location: ../editeur/access-refuse.php");
    exit();
}

// Inclure la connexion à la base de données
include('../db/connexion.php');

// Traitement du formulaire de création de catalogue
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_catalog'])) {
    $userAccoundId = $_SESSION['userId'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);

    // Préparer et exécuter la requête d'insertion dans le catalogue
    $query = "INSERT INTO Catalog (userAccoundId, name, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $userAccoundId, $name, $description);
    
    if ($stmt->execute()) {
        $catalogId = $stmt->insert_id;

        if (isset($_POST['images']) && isset($_POST['positions'])) {
            $positions = $_POST['positions'];
            $images = $_POST['images'];

            $positions = array_filter($positions, function($position) {
                return !empty($position) && in_array($position, [1, 2, 3, 4]);
            });

            // Eviter les duplication de positions
            $unique_positions = array_unique($positions);

            if (count($unique_positions) == count($positions)) {
                foreach ($images as $key => $imageId) {
                    $position = $positions[$key] ?? null;

                    if ($position) {
                        $query = "INSERT INTO catalogImage (catalogId, imageId, position) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("iii", $catalogId, $imageId, $position);
                        if (!$stmt->execute()) {
                            echo "<p>Erreur lors de l'ajout de l'image dans le catalogue : " . $stmt->error . "</p>";
                        }
                    } else {
                    }
                }

                echo "<p>Catalogue créé avec succès avec des images !</p>";
            } else {
                echo "<p>Erreur : Vous avez sélectionné la même position plusieurs fois.</p>";
            }
        } else {
            echo "<p>Erreur : Vous devez sélectionner des images et des positions valides.</p>";
        }
    } else {
        echo "<p>Erreur lors de la création du catalogue : " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Récupérer les images disponibles dans la banque d'images
$query = "SELECT id, name, bankId FROM image";
$stmt = $conn->prepare($query);
$stmt->execute();
$imagesResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catalogues</title>
    <link rel="stylesheet" href="css/catalogue-creation.css">
</head>
<body>
    <div id="app">
        <header class="header">
        <a href="../editeur/catalogue-creation.php">
            <img src="../images/PixelMinds.png" alt="Logo" class="logo">
        </a>
            <nav>
                <ul class="nav-list">
                    <li><a href="catalogue-creation.php">Accueil</a></li>
                    <li><a href="catalogue-list.php">Catalogues</a></li>
                    <li><a href="messages.php">Messages</a></li>
                    <li><a href="../ins_con/logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <!-- Formulaire de création de catalogue -->
            <form method="POST" action="catalogue-creation.php">
                <h2>Créer un nouveau catalogue</h2>
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" required>

                <label for="description">Description :</label>
                <textarea name="description" id="description" required></textarea>

                <h3>Choisir les images pour le catalogue (max 4 images) :</h3>
                <div class="gallery-container">
                    <?php
                    $imageCount = 0;
                    while ($row = $imagesResult->fetch_assoc()) :
                        $imageCount++;
                    ?>
                        <div class="image-item">
                            <img src="../images/mi/<?php echo $row['name']; ?>" alt="Image Preview">
                            
                            <label for="position-<?php echo $row['id']; ?>">Position :</label>
                            <select name="positions[]" id="position-<?php echo $row['id']; ?>">
                                <option value="">-- Choisir la position --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>

                            <input type="hidden" name="images[]" value="<?php echo $row['id']; ?>">
                        </div>
                    <?php endwhile; ?>
                </div>

                <button type="submit" name="create_catalog">Créer le catalogue</button>
            </form>
        </main>
    </div>
</body>
</html>