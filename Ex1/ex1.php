<doctype html>
    <html>
    <head>
        <title>Lecteur de BD</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>

    <?php
    require 'functions.php';
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "villes_fr";

    $db = Connect($servername, $username, $password, $dbname);

    getAllOf("departement", $db);

    $db = Disconnect($db);
    ?>

    </body>
    </html>
