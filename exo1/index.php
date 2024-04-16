<?php
$servername = "localhost"; // Type de serveur
$username = "Maxence"; // Nom d'utilisateur pour toutes mes bases de données
$password = "password"; // Mot de passe de connexion
$dbname = "injectionsql"; // Nom de la base de données

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
  die("Échec de la connexion : " . $conn->connect_error);
}

// Récupération des données utilisateur
$nom_utilisateur = $_POST['nom_utilisateur'];
$mot_de_passe = $_POST['mot_de_passe'];

// Utilisation de requêtes préparées pour éviter les injections SQL
$query = $conn->prepare("SELECT * FROM connec WHERE nom_utilisateur = ? AND mot_de_passe = ?");
$query->bind_param("ss", $nom_utilisateur, $mot_de_passe); // 'ss' signifie que les deux paramètres sont des strings

// Exécution de la requête
$query->execute();
$result = $query->get_result();

// Vérification des résultats
if ($result->num_rows > 0) {
  echo "Utilisateur authentifié";
} else {
  echo "Nom d'utilisateur ou mot de passe incorrect";
}

// Fermeture de la requête préparée et de la connexion
$query->close();
$conn->close();
?>
