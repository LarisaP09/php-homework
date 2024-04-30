<?php
require_once "pdo.php";
$errors = [];

// Verificarea prenumelui
$firstName = $_POST['firstName'] ?? '';
if (empty($firstName) || !preg_match("/^[A-Z][a-z]*$/", $firstName)) {
    $errors['firstName'] = "First name is required and must start with a capital letter";
}

// Verificarea numelui de familie
$lastName = $_POST['lastName'] ?? '';
if (empty($lastName) || !preg_match("/^[A-Z][a-z]*$/", $lastName)) {
    $errors['lastName'] = "Last name is required and must start with a capital letter";
}

// Verificarea adresei de email
$email = $_POST['email'] ?? '';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Email is required and must be valid";
}

// Verificarea numelui produsului
$productName = $_POST['productName'] ?? '';
if (empty($productName)) {
    $errors['productName'] = "Product name is required";
}

// Verificarea culorii
$color = $_POST['color'] ?? '';
if (empty($color) || !preg_match("/^[A-Za-z ]*$/", $color)) {
    $errors['color'] = "Color is required and must contain only letters and spaces";
}

// Verificarea mesajului
$message = $_POST['message'] ?? '';
if (empty($message) || strlen($message) < 10) {
    $errors['message'] = "Message is required and must be at least 10 characters long";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $productName = $_POST['productName'];
        $color = $_POST['color'];
        $message = $_POST['message'];

        try {

            $query = "SELECT user_id FROM users WHERE user_firstname = :firstName 
            AND user_lastname = :lastName AND user_email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(':firstName' => $firstName, ':lastName' => $lastName, ':email' => $email));
            $userExists = ($stmt->rowCount() > 0);

            if ($userExists) {

                $userId = $stmt->fetchColumn();


                $query = "SELECT COUNT(*) FROM product WHERE product_name = :productName AND color = :color";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(':productName' => $productName, ':color' => $color));
                $productExists = ($stmt->fetchColumn() > 0);

                if (!$productExists) {

                    $insertQuery = "INSERT INTO product (product_name, color) VALUES (:productName, :color)";
                    $stmt = $pdo->prepare($insertQuery);
                    $stmt->execute(array(':productName' => $productName, ':color' => $color));


                    $productId = $pdo->lastInsertId();
                } else {

                    $query = "SELECT product_id FROM product WHERE product_name = :productName AND color = :color";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute(array(':productName' => $productName, ':color' => $color));
                    $productId = $stmt->fetchColumn();
                }


                $insertQuery = "INSERT INTO message (user_id, product_id, user_message) VALUES (:userId, :productId, :message)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->execute(array(':userId' => $userId, ':productId' => $productId, ':message' => $message));

                
                header("location: ../pages/index.php");
                exit;
            } else {

                echo '<p style="color: red;">Utilizatorul nu există în baza de date. Vă rugăm să introduceți informații valide.</p>';
            }
        } catch (PDOException $e) {
            echo "Eroare la trimiterea mesajului: " . $e->getMessage();
        }
    }else{
        echo '<p style="color: red;">Utilizatorul trebuie să fie autentificat pentru a trimite acest formular.</p>';
        exit;
    }
}

?>