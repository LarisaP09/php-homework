<?php
// Include config file
require_once "pdo.php";
 
// Define variables and initialize with empty values
$username =$lastname = $firstname =$email = $password  = "";
$username_err = $lastname_err =$firstname_err = $email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate user_username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE user_username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address.";
    } elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Invalid email format.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE user_email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email address is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
}

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    }else{
        $password = trim($_POST["password"]);
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (user_username, user_lastname, user_firstname, user_email, user_pwd) VALUES (:username, :lastname, :firstname, :email, :password)";
 
if($stmt = $pdo->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
    $stmt->bindParam(":lastname", $param_lastname, PDO::PARAM_STR);
    $stmt->bindParam(":firstname", $param_firstname, PDO::PARAM_STR);
    $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
    $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
    
    // Set parameters
    $param_username = $_POST["username"];
    $param_lastname = $_POST["lastname"];
    $param_firstname = $_POST["firstname"];
    $param_email = $_POST["email"];
    $param_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Redirect to login page
        header("location: login_form.php");
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    unset($stmt);
}
    }
    
    // Close connection
    unset($pdo);
}
?>