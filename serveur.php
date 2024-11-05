<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sqlProduits = "SELECT id_produit, item, prix FROM produit";
$resultProduits = $conn->query($sqlProduits);
$sqlServeurs = "SELECT nom FROM serveur";
$resultServeurs = $conn->query($sqlServeurs);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .quantity-display {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Liste des Produits</h2>
        <div class="form-group">
        <label for="selectServeur">Choisissez un serveur :</label>
        <select class="form-control" id="selectServeur">
            <option value="">-- Sélectionnez un serveur --</option>
            <?php if ($resultServeurs->num_rows > 0): ?>
                <?php while ($serveur = $resultServeurs->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($serveur['nom']); ?>"><?php echo htmlspecialchars($serveur['nom']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>
    </div>
    <div style="display:flex;">
        <button class="btn btn-success" style="margin-left:40%" onclick="demarrerService()">Démarrer Service</button>
        <button class="btn btn-danger" onclick="finirService()">Fin de Service</button>
    </div>
    <div class="row mt-4">
        <?php if ($resultProduits->num_rows > 0): ?>
            <?php while($row = $resultProduits->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['item']); ?></h5>
                            <h5 class="card-title"><?php echo htmlspecialchars($row['prix']); ?> DT</h5>
                            <a href="#" class="btn btn-primary" onclick="acheter('<?php echo htmlspecialchars($row['item']); ?>', <?php echo htmlspecialchars($row['prix']); ?>)">Acheter</a>
                            <div class="quantity-display" id="<?php echo htmlspecialchars($row['item']); ?>-quantity">Quantité: 0</div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    Aucun produit trouvé.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $conn->close(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
let totalQuantities = {};
let totalPrice = 0;
let serviceStartTime = null;
let recipeId = null; // Initialize recipeId

function acheter(produit, prix) {
    if (!totalQuantities[produit]) {
        totalQuantities[produit] = 0;
    }
    totalQuantities[produit] += 1;
    totalPrice += prix;
    document.getElementById(produit + '-quantity').innerText = 'Quantité: ' + totalQuantities[produit];
    console.log(`Total pour ${produit}: ${totalQuantities[produit]} unités, Prix total: ${totalPrice} DT`);
}

function demarrerService() {
    const selectedServer = document.getElementById('selectServeur').value;
    if (!selectedServer) {
        alert("Veuillez sélectionner un serveur avant de démarrer le service.");
        return;
    }

    serviceStartTime = new Date();
    console.log("Service démarré à : " + serviceStartTime);
    alert("Service démarré par " + selectedServer + "!");

    fetch('saveservice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'startService',
            startTime: serviceStartTime,
            serverName: selectedServer
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            recipeId = data.recipeId;
            console.log("ID de la recette:", recipeId);
        } else {
            alert("Erreur lors de la création du service.");
        }
    })
    .catch(error => {
        alert("Erreur: " + error);
    });
}

function finirService() {
    if (serviceStartTime && recipeId) {
        const serviceEndTime = new Date();
        console.log("Service terminé à : " + serviceEndTime);
        console.log("Total à payer : " + totalPrice + " DT");

        fetch('saveservice.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                startTime: serviceStartTime,
                endTime: serviceEndTime,
                total: totalPrice,
                details: totalQuantities,
                recipeId: recipeId
            })
        })
        .then(response => {
            if (response.ok) {
                alert("Service enregistré avec succès !");
                resetService();
            } else {
                alert("Erreur lors de l'enregistrement du service.");
            }
        })
        .catch(error => {
            alert("Erreur: " + error);
        });
    } else {
        alert("Veuillez démarrer le service d'abord !");
    }
}

function resetService() {
    totalQuantities = {};
    totalPrice = 0;
    serviceStartTime = null;
    recipeId = null;
    document.querySelectorAll('.quantity-display').forEach(element => {
        element.innerText = 'Quantité: 0';
    });
}
</script>
</body>
</html>

