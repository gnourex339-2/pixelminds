<?php
$data = json_decode(file_get_contents('php://input'), true);

$catalogId = $data['catalogId'];
$imageName = $data['imageName'];
$name = $data['name'];
$points = $data['points'];
$description = $data['description'];
$html = $data['html'];


include('../db/connexion.php');

$query = "INSERT INTO label (catalogId, imageId, name, description, points, html) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

$imageId = getImageIdByName($imageName);

$stmt->bind_param("iissss", $catalogId, $imageId, $name, $description, $points, $html);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();

function getImageIdByName($name) {
    global $conn;
    $query = "SELECT id FROM Image WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($imageId);
    $stmt->fetch();
    return $imageId;
}
?>
