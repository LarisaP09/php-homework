<?php
require_once "pdo.php";
session_start();

$navbar_label = "Login";
$navbar_link = "../php-connection/indexlog.php"; // Pagina de login

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $navbar_link = "../php-connection/logout.php"; // Pagina de logout
    $navbar_label = "Logout";
}

$username_err = $password_err = $login_err = "";
$username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
        $username = trim($_POST["username"]);
    } else {
        $username_err = "Please enter username.";
    }

    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
    } else {
        $password_err = "Please enter your password.";
    }

    if (empty($username_err) && empty($password_err)) {
        // Verificăm dacă $pdo este definit
        if (isset($pdo)) {
            $sql = "SELECT user_id, user_username, user_pwd FROM users WHERE user_username = :username";

            if ($stmt = $pdo->prepare($sql)) {
                $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
                $param_username = $username;

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $row = $stmt->fetch();
                        $id = $row["user_id"];
                        $username = $row["user_username"];
                        $hashed_password = $row["user_pwd"];

                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["user_username"] = $username;

                            header("location: ../pages/index.php");
                            exit;
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                unset($stmt);
            }
        } else {
            echo "Database connection error. Please try again later.";
        }
    }
}
?>
