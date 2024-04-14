<?php
require_once "pdo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obținerea datelor din formular
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $productName = $_POST['productName'];
    $color = $_POST['color'];
    $message = $_POST['message'];

    try {
        // Verificarea dacă utilizatorul există în baza de date
        $query = "SELECT user_id FROM users WHERE user_firstname = :firstName 
            AND user_lastname = :lastName AND user_email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':firstName' => $firstName, ':lastName' => $lastName, ':email' => $email));
        $userExists = ($stmt->rowCount() > 0);

        if ($userExists) {
            // Utilizatorul există în baza de date
            $userId = $stmt->fetchColumn();

            // Verificarea dacă produsul există în baza de date
            $query = "SELECT COUNT(*) FROM product WHERE product_name = :productName AND color = :color";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(':productName' => $productName, ':color' => $color));
            $productExists = ($stmt->fetchColumn() > 0);

            if (!$productExists) {
                // Produsul nu există în baza de date, așa că îl adăugăm
                $insertQuery = "INSERT INTO product (product_name, color) VALUES (:productName, :color)";
                $stmt = $pdo->prepare($insertQuery);
                $stmt->execute(array(':productName' => $productName, ':color' => $color));

                // Obținem ID-ul produsului nou adăugat
                $productId = $pdo->lastInsertId();
            } else {
                // Produsul există în baza de date
                $query = "SELECT product_id FROM product WHERE product_name = :productName AND color = :color";
                $stmt = $pdo->prepare($query);
                $stmt->execute(array(':productName' => $productName, ':color' => $color));
                $productId = $stmt->fetchColumn();
            }

            // Salvarea mesajului în tabela message
            $insertQuery = "INSERT INTO message (user_id, product_id, user_message) VALUES (:userId, :productId, :message)";
            $stmt = $pdo->prepare($insertQuery);
            $stmt->execute(array(':userId' => $userId, ':productId' => $productId, ':message' => $message));

            header("Location: ../pages/index.php");
            exit;
            
        } else {
            // Utilizatorul nu există în baza de date
            echo "Utilizatorul nu există în baza de date. Vă rugăm să introduceți informații valide.";
        }
    } catch (PDOException $e) {
        echo "Eroare la trimiterea mesajului: " . $e->getMessage();
    }
}
?>
