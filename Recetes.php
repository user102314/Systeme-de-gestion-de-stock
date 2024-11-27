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
<div class="container mt-5 text-align:center;">
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
                        <td><?php echo number_format($row['prixtotale'], 2, ',', ' ') . " مليم"; ?></td>

                        
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
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="sendRecipeDetailsByEmail()">إرسال</button>
                <button class="btn btn-danger" onclick="Calculelemanque()">هل هناك نقص في البن</button>

            </div>
        </div>
    </div>
</div>
<p id="demo"></p>
<div id="popup3" class="popup">
    <div class="popup-content">
        <p id="resulta"></p>
        <button id="closePopup3" onclick="close()">OK</button>
    </div>
</div>
<script>
    function close ()
 {
    document.getElementById("popup3").style.display = "none"; 
}
</script>

<script>
    function Calculelemanque() {
        var idRecete = document.getElementById('demo').value; 
        var data = {
            idRecete: idRecete
        };
        fetch('calcule.php', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json()) 
        .then(data => {
            if (data.success) {
                //document.getElementById("popup3").style.display = "flex";
                //document.getElementById('resulta').innerHTML = 'القهوة تكلفت : ' + data.manque;
                alert('القهوة تكلفت : ' + data.manque +' G ')

            } else {
                alert('Erreur : ' + data.error); 
            }
        })
        .catch(error => {
            console.error('Erreur AJAX :', error);  
        });
    }

 


</script>

<script>

    function sendRecipeDetailsByEmail() {
    const details = [];
    document.querySelectorAll('#detailsBody tr').forEach(row => {
        const detail = {
            nomproduit: row.cells[0].textContent,
            quantity: row.cells[1].textContent,
            prix_total: row.cells[2].textContent.replace(' مليم', '').replace(',', '.'),
            stock_initial: row.cells[3].textContent,
            stock_final: row.cells[4].textContent,
            manque: row.cells[5].textContent
        };
        details.push(detail);
    });
    console.log("Détails envoyés:", details); 
    fetch('send_email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ details: details })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Les détails de la recette ont été envoyés par email avec succès!');
        } else {
            console.error("Erreur lors de l'envoi de l'email:", data.error);
            alert('Erreur lors de l\'envoi de l\'email: ' + data.error);
        }
    })
    .catch(error => {
        console.error("Erreur réseau:", error);  
        alert('Erreur: ' + error);
    });
}
</script>
<script>
    function showDetails(id) {
        document.getElementById('demo').value = id;
        fetch('get_recipe_details.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);  
                if (data.success) {
                    const detailsBody = document.getElementById('detailsBody');
                    detailsBody.innerHTML = '';
                    data.details.forEach(detail => {
                        const manque = detail.stock_initial - detail.stock_final; 
                        const row = `<tr>
                                        <td>${detail.nomproduit}</td>
                                        <td>${detail.quantity}</td>
                                        <td>${parseFloat(detail.prix_total).toFixed(2).replace('.', ',')} دينار</td>
                                        <td>${detail.stock_initial}</td>
                                        <td>${detail.stock_final}</td>
                                        <td id='manque_${detail.nomproduit}'>${manque}</td> <!-- Affichage de manque -->
                                        <td>
                                            <input id='${detail.nomproduit}' type="number" style="width:100px;"' oninput="calculateManque('${detail.nomproduit}', ${detail.stock_initial}, ${detail.stock_final})">
                                            <button class="btn btn-warning" onclick="updateStock('${detail.nomproduit}')">Vérifier</button>
                                        </td>
                                     </tr>`;
                        detailsBody.innerHTML += row;
                    });
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
    function calculateManque(productName, stockInitial, stockFinal) {
        const stockValue = document.getElementById(productName).value;
        const manqueValue = stockValue - stockInitial;
        const manqueStockFinal = stockFinal - stockValue;
        document.getElementById(`manque_${productName}`).textContent = manqueStockFinal;
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
