# Eval Cyber

## Exo 1

En utilisant ' OR '1' = '1 on peut se connecter.
Alors en tapant dans les inputs de connexion utlisateur = user et mot de passe = ' OR '1' = '1 , cela nous connnecte 
Pourquoi ? Ma requête est de conenxion est : "SELECT * FROM connec WHERE nom_utilisateur = '$nom_utilisateur' AND mot_de_passe = '$mot_de_passe'"
Si dans requête je rajoute une condition OU je peux alors outre-passé la première condition qui requière une paire 'nom d'utlisateur/mot de passe"
ce qui donne : ```SELECT * FROM connec WHERE nom_utilisateur = '$nom_utilisateur' AND mot_de_passe = '$mot_de_passe' OR '1' = '1' ```
On peut traduire la requête par "Séléctionne tout dans ma table 'connec' OÙ le nom d'utilisateur ET le mot de passe correspondent aux inputs OU 1 = 1"
L'avantage de cette injection c'est que 1 sera toujours égal à 1 que ce soit une comparaison d'integer ou de string

Pour palier à cela après avoir changer mes identifiants de connexion à la base de données j'utilise une requête préparée :

C'est à dire que avant d'envoyer ma requête je vais utiliser une fonction PHP qui s'apelle bind_param. Cette fonction permet de lié des variables sur une 
requête SQL. Cette fonction prend en paramètre le typage, c'est a dire le type de données de mes variable (string, integer, float, etc..) et mes variables.
Cette fonction permet alors d'isoler les données utilisateur de la commande SQL et donc d'éviter une injection SQL.
Voici le résultat : 

```
$query = $conn->prepare("SELECT * FROM connec WHERE nom_utilisateur = ? AND mot_de_passe = ?");
$query->bind_param("ss", $nom_utilisateur, $mot_de_passe); 
```

##Exo 2

En utilisant dans mon URL : ``` http://localhost:8000/?search=<script>alert('Hello')</script> ```
Cela me renvoi alors une alerte avec écris Hello.
Pourquoi ? Le code dit que Si (if) il y a une "recherche" en GET qui est initialisée et qui n'est pas NULLE alors je stocke cette "recherche" dans une variable et je l'affiche 
Sinon (else) j'affiche autre chose. Le problème, c'est que dans ce code il n'y a aucune échappement de caractères spéciaux et les balises sont alors prise en compte
Pour palier a cela j'utilise la fonction ``` htmlspecialchars() ``` qui permet d'échapper les caractère spéciaux. Elle prend en paramètre une variable ( nous c'est la variables stockée ```$searchTerm``` ),
un 'flag' et l'encodage.

Ce qui donne : ```htmlspecialchars($searchTerm, ENT_QUOTE, UTF-8) ``` . ENT_QUOTE permet d'échapper les guillemets simples et double et l'encodage UTF-8 je sais pas comment l'expliquer

C'est a dire que lors de l'envoi de ma requête précédente : ```http://localhost:8000/?search=<script>alert('Hello')</script>``` 
Cela ne m'envoi plus d'alerte mais seulement : ```Résultats de la recherche pour : <script>alert("Hello")</script>```
