<?php
header('Content-Type: application/json');

// Inclure la connexion à la base de données
include('../db/connexion.php');

// Vérifier si catalogId est fourni
if (isset($_GET['catalogId']) && is_numeric($_GET['catalogId'])) {
    $catalogId = intval($_GET['catalogId']);
    $query = "SELECT Image.name 
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
        $images[] = $row['name'];
    }

    echo json_encode($images);
    exit;
} else {
    echo json_encode(["error" => "ID de catalogue invalide ou non fourni."]);
    exit;
}
?>
