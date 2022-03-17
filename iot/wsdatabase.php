<?php
    $dbhost = "localhost";
    $username = "root";
    $password = "";
    $dbname = "iot";

    try {
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $username,$password);
        echo "Verbinding gemaakt!<br/>";
    } catch (PDOException $ex) {
        echo "Er is iets fout gegaan met het maken van de verbinding!"."<br>";
    }

?>
    