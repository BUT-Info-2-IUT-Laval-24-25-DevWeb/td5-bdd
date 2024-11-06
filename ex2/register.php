<?php
$pdo = new PDO('mysql:host=localhost;dbname=ex2_td5', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['motdepasse'], algo: PASSWORD_BCRYPT);

    $query = "INSERT INTO User (nom, prenom, email, motdepasse) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nom, $prenom, $email, $motdepasse]);

    echo "Inscription réussie !";
}
