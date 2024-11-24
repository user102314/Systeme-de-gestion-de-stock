    <?php
    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "cafe"; 
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Exécution de la requête
    $sql = "SELECT idrecetes, nomserveur, dateentree, datesortie, prixtotale FROM recetes";
    $result = $conn->query($sql);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . $conn->error);
    }
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des Recettes</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container mt-5" style="text-align: center;">
        <h2 class="text-center">قائمة وصفات للطباعة</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Nom du Serveur</th>
                    <th>Date d'Entrée</th>
                    <th>Date de Sortie</th>
                    <th>Prix Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nomserveur']); ?></td>
                            <td><?php echo htmlspecialchars($row['dateentree']); ?></td>
                            <td><?php echo htmlspecialchars($row['datesortie']); ?></td>
                            <td><?php echo number_format($row['prixtotale'], 2, ',', ' ') . " Dt"; ?></td>
                            <td>
                                <button class="btn btn-info" onclick="showDetailsImprime(<?php echo $row['idrecetes']; ?>)">تحميل</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Aucune recette trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modale pour les détails -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Détails de la Recette</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom du Produit</th>
                                <th>Quantité</th>
                                <th>Prix Total</th>
                                <th>Stock Initial</th>
                                <th>Stock Final</th>
                                <th>Manque</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody id="detailsBody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="sendRecipeDetailsByEmail()">إرسال</button>
                </div>
            </div>
        </div>
    </div>

    <p id="demo"></p>
    <div id="popup3" class="popup">
        <div class="popup-content">
            <p id="resulta"></p>
            <button id="closePopup3" onclick="closePopup()">OK</button>
        </div>
    </div>

    <script>
    function closePopup() {
        document.getElementById("popup3").style.display = "none"; 
    }

    function showDetailsImprime(id) {
    fetch('get_recipe_details_imprime.php?id=' + id)
        .then(response => response.text()) 
        .then(text => {
            console.log(text); 

            const blob = new Blob([text], { type: "text/plain;charset=utf-8" });
            const url = URL.createObjectURL(blob);

            // Créer un lien temporaire pour déclencher le téléchargement
            const a = document.createElement("a");
            a.href = url;
            a.download = `Recette_Details_${id}.txt`; // Nom du fichier
            document.body.appendChild(a);
            a.click(); // Lancer le téléchargement
            document.body.removeChild(a);
            URL.revokeObjectURL(url);  // Libérer l'URL pour éviter les fuites de mémoire
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert("Une erreur s'est produite lors de la récupération des détails de la recette.");
        });
}

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
    $conn->close();
    ?>
