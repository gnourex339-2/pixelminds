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

// Vérifier si l'utilisateur demande uniquement les données JSON
if (isset($_GET['catalogId']) && is_numeric($_GET['catalogId'])) {
    $catalogId = intval($_GET['catalogId']);
} else {
    // Si l'ID est manquant ou invalide, redirigez vers l'accueil
    die("Erreur : ID de catalogue invalide ou non fourni. Retournez à <a href='../editeur/catalogue-list.php'>l'accueil</a>.");
}

// Requête pour récupérer les images du catalogue
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

$stmt->close();
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

    <main class="main-content">
        <h1>Catalogue <?php echo htmlspecialchars($catalogId); ?></h1>
        <p>Explorez les images de ce catalogue :</p>
        <div id="image-gallery" class="gallery-container"></div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const catalogId = <?php echo json_encode($catalogId); ?>;

            function addImagesToGallery(images) {
                const gallery = document.getElementById('image-gallery');
                if (!gallery) {
                    console.error("Le conteneur de la galerie n'existe pas !");
                    return;
                }

                images.forEach((imageSrc, index) => {
                    const imageItem = document.createElement('div');
                    imageItem.classList.add('image-item');
                    const container = document.createElement('div');
                    container.classList.add('canvas-container');

                    const image = document.createElement('img');
                    image.src = '../images/mi/' + imageSrc; 
                    image.alt = 'Image';
                    image.classList.add('gallery-image');
                    container.appendChild(image);

                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    container.appendChild(canvas);
                    imageItem.appendChild(container);

                    image.onload = function() {
                        canvas.width = image.width;
                        canvas.height = image.height;
                    }

                    let drawing = false;
                    let points = [];
                    let labelTitle = '';
                    let labelDesc = '';

                    canvas.addEventListener('mousedown', function(event) {
                        drawing = true;
                        points = [{ x: event.offsetX, y: event.offsetY }];
                    });

                    canvas.addEventListener('mousemove', function(event) {
                        if (drawing) {
                            if (event.offsetX < 0 || event.offsetY < 0 || event.offsetX > canvas.width || event.offsetY > canvas.height) {
                                return;
                            }

                            points.push({ x: event.offsetX, y: event.offsetY });
                            context.clearRect(0, 0, canvas.width, canvas.height);
                            context.beginPath();
                            points.forEach((point, idx) => {
                                if (idx === 0) context.moveTo(point.x, point.y);
                                else context.lineTo(point.x, point.y);
                            });
                            context.stroke();
                        }
                    });

                    canvas.addEventListener('mouseup', function(event) {
                        drawing = false;
                        points.push({ x: event.offsetX, y: event.offsetY });
                    });

                    const titleInput = document.createElement('input');
                    titleInput.type = 'text';
                    titleInput.placeholder = 'Ajouter un titre de label';
                    titleInput.classList.add('label-input');
                    imageItem.appendChild(titleInput);

                    titleInput.addEventListener('change', function() {
                        labelTitle = titleInput.value;
                    });

                    const descInput = document.createElement('input');
                    descInput.type = 'text';
                    descInput.placeholder = 'Ajouter une description';
                    descInput.classList.add('label-input');
                    descInput.style.top = '40px';
                    imageItem.appendChild(descInput);

                    descInput.addEventListener('change', function() {
                        labelDesc = descInput.value;
                    });

                    const saveButton = document.createElement('button');
                    saveButton.textContent = 'Enregistrer le label';
                    saveButton.classList.add('save-button');
                    saveButton.addEventListener('click', function() {
                        if (!labelTitle || !labelDesc || points.length < 2) {
                            alert('Veuillez dessiner un label et fournir un titre et une description.');
                            return;
                        }
                        saveLabel(catalogId, imageSrc, labelTitle, labelDesc, points);
                    });
                    imageItem.appendChild(saveButton);

                    gallery.appendChild(imageItem);
                });
            }

            function fetchImages(catalogId) {
                fetch(`get_images.php?catalogId=${catalogId}`)
                    .then(response => response.json())
                    .then(images => {
                        if (images.length === 0) {
                            document.getElementById('image-gallery').innerHTML = `<p>Aucune image trouvée pour ce catalogue.</p>`;
                        } else {
                            addImagesToGallery(images);
                        }
                    })
                    .catch(error => console.error("Erreur lors de la récupération des images :", error));
            }

            function saveLabel(catalogId, imageSrc, labelTitle, labelDesc, points) {
                const labelHTML = `<div class="tooltip"><h3>${labelTitle}</h3><p>${labelDesc}</p></div>`;

                const labelData = {
                    catalogId,
                    imageName: imageSrc,
                    name: labelTitle,
                    description: labelDesc,
                    points: JSON.stringify(points),
                    html: labelHTML
                };

                fetch('save_label.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(labelData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Label sauvegardé avec succès !');
                        location.reload();
                    } else {
                        alert('Échec de la sauvegarde du label.');
                    }
                })
                .catch(error => console.error('Erreur lors de la sauvegarde du label:', error));
            }

            fetchImages(catalogId);
        });
    </script>
</body>
</html>
