<?php
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    echo "Résultats de la recherche pour : " . htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
} else {
    echo "Utiliser l'url pour afficher quelque chose";
}
?>
