<?php
// Connexion à la base de données
include('../db/connexion.php');

if (isset($_GET['imageId']) && is_numeric($_GET['imageId'])) {
    $imageId = intval($_GET['imageId']);
} else {
    echo json_encode(["error" => "ID d'image invalide ou non fourni."]);
    exit;
}

// Requête pour récupérer les labels associés à une image
$query = "SELECT id, name, description, points, html FROM label WHERE imageId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $imageId);
$stmt->execute();
$result = $stmt->get_result();

$labels = [];
while ($row = $result->fetch_assoc()) {
    $labels[] = $row;
}

$stmt->close();
$conn->close();

// Retourner les labels en format JSON
header('Content-Type: application/json');
echo json_encode($labels);
?>
