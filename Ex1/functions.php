<?php

function Connect($servername, $username, $password, $dbname)
{
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully \n";
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage() . "\n";
    }
}

function Disconnect($conn){
    $conn = null;
    echo "Disconnected successfully \n";
    return $conn;
}



function addUser($conn, $nom, $prenom, $email, $password){
    try {
        $sql = "INSERT INTO User (id, nom, prenom, email, motdepasse) VALUES (0, '$nom', '$prenom', '$email', '$password')";
        $conn->exec($sql);
        echo "New record created successfully \n";
    } catch (PDOException $e) {
        echo $sql . "\n" . $e->getMessage() . "\n";
    }
}

function getAllOf($table, $conn ){

    try {
        $sql = "SELECT * FROM " . $table;
        $result = $conn->query($sql);

        $fields = array();
        for ($i = 0; $i < $result->columnCount(); $i++) {
            $meta = $result->getColumnMeta($i);
            array_push($fields, $meta['name']);
        }

        echo "<table border='1'>";
        echo "<tr>";
        foreach ($fields as $field){
            echo "<th>" . $field . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($fields as $field){
                echo "<td>" . $row[$field] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function addEvent($conn, $nom, $description, $echeance) {
    try {
        $sql = "INSERT INTO Event (id, nom, description, echeance) VALUES (0, '$nom', '$description', '$echeance')";
        $conn->exec($sql);
        echo "New record created successfully \n";
    } catch (PDOException $e) {
        echo $sql . "\n" . $e->getMessage() . "\n";
    }
}

function getResultFrom($request, $conn ){

    try {
        $result = $conn->query($request);

        $fields = array();
        for ($i = 0; $i < $result->columnCount(); $i++) {
            $meta = $result->getColumnMeta($i);
            array_push($fields, $meta['name']);
        }

        echo "<table border='1'>";
        echo "<tr>";
        foreach ($fields as $field){
            echo "<th>" . $field . "</th>";
        }
        echo "</tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($fields as $field){
                echo "<td>" . $row[$field] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function getTableSize($table, $conn){
    try {
        $sql = "SELECT COUNT(*) FROM " . $table;
        $result = $conn->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

function execute($request, $conn){
    try {
        $conn->exec($request);
        echo "Request executed successfully \n";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}


?>