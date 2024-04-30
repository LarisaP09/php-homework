<?php
require_once "pdo.php";
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


                exit;
            } else {

                echo "Utilizatorul nu există în baza de date. Vă rugăm să introduceți informații valide.";
            }
        } catch (PDOException $e) {
            echo "Eroare la trimiterea mesajului: " . $e->getMessage();
        }
    }
}
?>