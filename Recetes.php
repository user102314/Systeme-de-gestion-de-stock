<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$sql = "SELECT idrecetes, nomserveur, dateentree, datesortie, prixtotale FROM recetes";
$result = $conn->query($sql);
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
<div class="container mt-5">
    <h2 class="text-center">Liste des Recettes</h2>
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
                            <button class="btn btn-info" onclick="showDetails(<?php echo $row['idrecetes']; ?>)">Voir détails</button>
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
                            <th>StockInitial</th>
                            <th>StockFinal</th>
                            <th>Manque</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody id="detailsBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetails(id) {
    fetch('get_recipe_details.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Log data for debugging

            if (data.success) {
                const detailsBody = document.getElementById('detailsBody');
                detailsBody.innerHTML = ''; // Clear previous details

                data.details.forEach(detail => {
                    const row = `<tr>
                                    <td>${detail.nomproduit}</td>
                                    <td>${detail.quantity}</td>
                                    <td>${parseFloat(detail.prix_total).toFixed(2).replace('.', ',')} دينار</td>
                                    <td>${detail.stock_initial}</td>
                                    <td>${detail.stock_final}</td>
                                    <td>${detail.manque}</td>
                                    <td>
    <input id='${detail.nomproduit}' type="number" value='${detail.stock_initial}'>
    <button class="btn btn-warning" onclick="updateStock('${detail.nomproduit}')">Vérifier</button>
</td>

                                 </tr>`;
                    detailsBody.innerHTML += row;
                });

                // Show the modal
                $('#detailsModal').modal('show');
            } else {
                console.error("Data retrieval error:", data.error);
                alert('Erreur lors de la récupération des détails.');
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
            alert('Erreur: ' + error);
        });
}
function updateStock(productName) {
    const stockValue = document.getElementById(productName).value;
    console.log("Updating stock for:", productName, "with stock value:", stockValue);

    fetch('update_stock.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            productName: productName,
            stockValue: stockValue
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Stock mis à jour avec succès!');
            $('#detailsModal').modal('hide');
        } else {
            alert('Erreur lors de la mise à jour du stock: ' + data.error);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert('Erreur: ' + error);
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
