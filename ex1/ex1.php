<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>td5 ex1</title>
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <a href="index.php"><button> retour </button></a>

    <hr>

    <table>

        <?php

        $bdd = new PDO('mysql:host=localhost;dbname=td5;charset=utf8;', 'root', '');

        $data = null;
        $data = $bdd->query('SELECT * FROM departement');

        $result = $data->fetchAll();


        foreach ($result as $elm) {
            echo '<tr>';
            echo '<td>';
            echo $elm['departement_id'];
            echo '</td>';
            echo '<td>';
            echo $elm['departement_code'];
            echo '</td>';
            echo '<td>';
            echo $elm['departement_nom'];
            echo '</td>';
            echo '<td>';
            echo $elm['departement_nom_uppercase'];
            echo '</td>';
            echo '<td>';
            echo $elm['departement_slug'];
            echo '</td>';
            echo '<td>';
            echo $elm['departement_nom_soundex'];
            echo '</td>';
            echo '</tr>';
        }
        ?>

    </table>

</body>

</html>