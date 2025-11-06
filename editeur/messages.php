<?php
session_start();
include('../db/connexion.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    header('Location: ../ins_con/connexion.php');
    exit();
}

// Vérifier le rôle de l'utilisateur
if ($_SESSION['userRoleId'] != 1) {
    header("Location: ../editeur/access-refuse.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_message'])) {
    $messageId = $_POST['message_id'];

    $deleteQuery = "DELETE FROM messages WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $messageId, $_SESSION['userId']);

    if ($stmt->execute()) {
        echo "<script>alert('Message supprimé.'); window.location.href = 'messages.php';</script>";
    } else {
        echo "<script>alert('Error.');</script>";
    }

    $stmt->close();
}

// Exécuter la requête pour récupérer les messages
$query = "SELECT m.id, m.name, m.email, m.message FROM messages m WHERE m.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['userId']);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si des résultats sont retournés
if ($result->num_rows === 0) {
    $noMessages = "Aucun message trouvé.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="css/messages.css">
</head>
<body>
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
        <h1>Vos Messages</h1>

        <!-- Afficher les messages -->
        <div class="message-container">
            <?php
            while ($row = $result->fetch_assoc()) :
            ?>
                <div class="message-item">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>

                    <form method="POST" action="messages.php" onsubmit="return confirm('Etes vous sure de vouloir supprimer le message?');">
                        <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_message" class="delete-button">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>

    </main>

    <script src="acceuil.js"></script>
</body>
</html>

<?php
// Libérer les ressources
$stmt->free_result();
$stmt->close();
$conn->close();
?>
