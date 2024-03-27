<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
    $name= $_POST['name'];
    $email= $_POST['email'];
    $phone= $_POST['phone'];

  try{
    require_once "pdo.php";

    $query="INSERT INTO users (name,email,phone) VALUES (?, ?, ?);";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$name,$email,$phone]);

    $pdo = null;//close a connection
    $stmt = null;

    header("Location: ../form.php");
    die();//exit 

  }catch(PDOException $e){
    die("Query failed: " . $e->getMessage());
  }

}
else{
    header("Location: ../form.php");
}

