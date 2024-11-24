<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "cafe"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sqlProduits = "SELECT id_produit, item, prix, type FROM produit";
$resultProduits = $conn->query($sqlProduits);
$sqlServeurs = "SELECT nom FROM serveur";
$resultServeurs = $conn->query($sqlServeurs);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المنتجات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .quantity-display {
            margin-top: 10px;
            font-weight: bold;
        }
.popup{
    color:black;
}
.card {
    min-height: 180px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
hr{
    background:white;
}
body{
    background:black;
    color:white;
}
.quantity-display {
    font-weight: bold;
    margin-top: 10px;
}

    </style>
</head>
<body>
<div class="container mt-5" style="text-align;center;"></br>
<div class="container mt-5 text-center">
    <h2 class="text-center">قائمة المنتجات</h2>
    <div class="form-group">
        <select class="form-control mx-auto" id="selectServeur" style="max-width: 200px;">
            <option value="">-- حدد الخادم --</option>
            <?php if ($resultServeurs->num_rows > 0): ?>
                <?php while ($serveur = $resultServeurs->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($serveur['nom']); ?>"><?php echo htmlspecialchars($serveur['nom']); ?></option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="d-flex justify-content-center mt-3 flex-wrap">
        <button class="btn btn-success mx-2" onclick="demarrerService()">ابدأ الخدمة</button>
        <button class="btn btn-danger mx-2" onclick="finirService()">نهاية الخدمة</button>
    </div>
</div>

<div class="row mt-4">
    <div class="container mt-4">
    <div class="row">
        <?php
        // Define categories with labels
        $categories = [
            'aboir' => ' (مشروبات)', 
            'dokhan' => ' (دخان)', 
            'manger' => ' (مأكولات)', 
            'autre' => ' (Other)'
        ];

        $categoryCount = 0; // Keep track of categories displayed

        foreach ($categories as $type => $label): ?>
            <div class="col-md-6"> <!-- Adjust for 2 categories per row -->
                <hr>
                <h4 class="text-center"><?php echo $label; ?></h4><hr>
                <div class="row"><hr>
                    <?php 
                    $resultProduits->data_seek(0); // Reset result pointer

                    $productCount = 0; // Counter for each product row

                    while ($row = $resultProduits->fetch_assoc()): 
                        if ($row['type'] === $type): 
                            if ($productCount > 0 && $productCount % 3 == 0): // Create a new row every 3 products
                                echo '</div><div class="row">';
                            endif; ?>

                            <div class="col-md-4 mb-3"> <!-- Adjust for 3 products per row -->
                                <div class="card">
                                    <div class="card-body" style="color:black;">
                                        <h6 class="card-title"><?php echo htmlspecialchars($row['item']); ?></h6>
                                        <p class="card-text"><?php echo htmlspecialchars($row['prix']); ?> مليم</p>

                                        <a href="#" class="btn btn-primary btn-sm" onclick="acheter('<?php echo htmlspecialchars($row['item']); ?>', <?php echo htmlspecialchars($row['prix']); ?>)">يشتري</a>


                                        <a href="#" class="btn btn-primary btn-danger" onclick="anulecommende('<?php echo htmlspecialchars($row['item']); ?>')">-</a>


                                        <div class="quantity-display" id="<?php echo htmlspecialchars($row['item']); ?>-quantity">كمية: 0</div>
                                    </div>
                                </div>
                            </div>

                            <?php 
                            $productCount++;
                        endif;
                    endwhile; ?>
                </div>
            </div>

            <?php
            $categoryCount++;
            if ($categoryCount % 2 == 0): ?>
                </div><div class="row"> <!-- New row for next two categories -->
            <?php 
            endif;
        endforeach; ?>
    </div>
</div>

   


</div>
<link rel="stylesheet" href="popup.css">
    <div id="popup" class="popup">
        <div class="popup-content">
            <p>برا ربي معاك إخدم علي روحك</p>
            <button id="closePopup">OK</button>
        </div>
    </div>
    <div id="popup1" class="popup">
        <div class="popup-content">
            <p>يرجى التحقق من الخدمة أولا.</p>
            <button id="closePopup1">OK</button>
        </div>
    </div>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <p>الرجاء تحديد الخادم قبل بدء الخدمة.</p>
            <button id="closePopup2">OK</button>
        </div>
    </div>
    <div id="popup3" class="popup">
        <div class="popup-content">
            <p>اكتملت الخدمة Bayyy </p>
            <button id="closePopup3">OK</button>
        </div>
    </div>
</div>
<?php $conn->close(); ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  function anulecommende(nomproduit) {
    console.log("Product name passed:", nomproduit); // Check if value is passed
    if (!nomproduit || nomproduit.trim() === "") {
        alert("Product name is required."); // Show error if empty
        return;
    }

        const data = { nomproduit: nomproduit };
        console.log(data)
        fetch('delete_recipe.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nomproduit: nomproduit }),
})
.then(response => response.json())
.then(data => {
    if (data.status === 'success') {
        console.log(data.message); // Debug: message de succès

        // Mettre à jour dynamiquement la quantité affichée
        const quantityElement = document.getElementById(nomproduit + '-quantity');
        const currentQuantity = parseInt(quantityElement.innerText.replace('كمية: ', ''), 10);
        if (!isNaN(currentQuantity) && currentQuantity > 0) {
            quantityElement.innerText = 'كمية: ' + (currentQuantity - 1);
        }

        // Afficher un message de succès
        alert('تم إلغاء الطلب بنجاح');
    } else {
        console.error('Erreur:', data.message);
        alert(data.message); // Message d'erreur retourné par le serveur
    }
})
.catch(error => {
    console.error('Erreur:', error);
    alert("Une erreur est survenue.");
});

    
}


</script>

<script>
let totalQuantities = {};
let totalPrice = 0;
let serviceStartTime = null;
let recipeId = null;
function acheter(produit, prix) {
    // Vérifie et met à jour la quantité de produit dans l'objet totalQuantities
    if (!totalQuantities[produit]) {
        totalQuantities[produit] = 0;
    }
    totalQuantities[produit] += 1;
    totalPrice += prix;

    // Affiche la quantité mise à jour du produit
    document.getElementById(produit + '-quantity').innerText = 'كمية: ' + totalQuantities[produit];
    console.log(`Total pour ${produit}: ${totalQuantities[produit]} unités, Prix total: ${totalPrice} DT`);

    // Envoie les données d'achat à l'API PHP pour l'enregistrement
    fetch('achete.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            produit: produit,
            prix: prix,
            quantite: totalQuantities[produit],
            recetteId: recipeId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); // Affiche la réponse du serveur
    })
    .catch(error => {
        console.error('Erreur lors de l\'enregistrement de l\'achat:', error);
    });
}

document.addEventListener('keydown', function(event) {
    if (event.key === " " || event.code === "Space") {  
        console.log("Touche Espace pressée !");
        miseenforme();
        imprimerTicket(); 
        
        // Utilisation de setTimeout pour attendre 2 secondes avant de vider le fichier
        setTimeout(function() {
            viderTicket(); // Appelle la fonction pour vider le fichier après un délai de 2 secondes
        }, 2000); // 2000 millisecondes = 2 secondes
    }
});

function imprimerTicket() {
    fetch('imprimerTicket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); 
    })
    .catch(error => {
        console.error('Erreur lors de l\'impression du ticket:', error);
    });
    
}

function viderTicket() {
    fetch('viderTicket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); // Affiche le message après avoir vidé le fichier
    })
    .catch(error => {
        console.error('Erreur lors du vidage du fichier:', error);
    });
}

function miseenforme() {
    fetch('miseenforme.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message); // Affiche le message après avoir vidé le fichier
    })
    .catch(error => {
        console.error('Erreur lors du miseenforme du fichier:', error);
    });
}

/////////////////////////

function demarrerService() {
    
document.getElementById("closePopup").onclick = function() {
    document.getElementById("popup").style.display = "none";
};
    const selectedServer = document.getElementById('selectServeur').value;
    if (!selectedServer) {
        document.getElementById("popup2").style.display = "flex";

        return;
    }
    serviceStartTime = new Date();
    console.log("Service démarré à : " + serviceStartTime);
    document.getElementById("popup").style.display = "flex";

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
.then(response => {
    if (!response.ok) {
        throw new Error('Erreur HTTP ' + response.status);
    }
    return response.json();
})
.then(data => {
    console.log("Données reçues:", data); // Ajoutez cette ligne pour inspecter la réponse
    if (data.success) {
        recipeId = data.recipeId;
        console.log("ID de la recette:", recipeId);
    } else {
        console.error("Erreur de réponse du serveur:", data.message || "Erreur inconnue");
        alert("Erreur lors de la création du service.");
    }
})
.catch(error => {
    console.error("Erreur de requête:", error);
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
                document.getElementById("popup3").style.display = "flex";

                resetService();
            } else {
                alert("Erreur lors de l'enregistrement du service.");
            }
        })
        .catch(error => {
            alert("Erreur: " + error);
        });
    } else {
        document.getElementById("popup1").style.display = "flex";



    }
}
document.getElementById("closePopup1").onclick = function() {
    document.getElementById("popup1").style.display = "none";
};
document.getElementById("closePopup2").onclick = function() {
    document.getElementById("popup2").style.display = "none";
};
document.getElementById("closePopup3").onclick = function() {
    document.getElementById("popup3").style.display = "none";
};
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

