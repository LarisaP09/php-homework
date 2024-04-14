<?php
//config file
    try{
        $pdo = new PDO('mysql:localhost;port=8889;dbname=registration', 'root','Bazededate2023');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
        }
?>
