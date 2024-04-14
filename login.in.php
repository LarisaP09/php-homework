<?php
session_start();
$navbar_label="Login";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $navbar_link = "../php-connection/logout.php"; // Pagina de logout
    $navbar_label = "Logout";
} else {
    $navbar_link = "../php-connection/indexlog.php"; // Pagina de login
    $navbar_label="Sign up";
    
}
 
require_once "pdo.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT user_id, user_username, user_pwd FROM users WHERE user_username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                // Check if username exists
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["user_id"];
                        $username = $row["user_username"];
                        $hashed_password = $row["user_pwd"];
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["user_username"] = $username;                            
                            
                            header("location: ../pages/index.php");
                        } else{
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>