<?php
require_once __DIR__.'/../_init.php';

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $id = $_GET['id'] ?? null;

    if ($id) {
        try {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $rowCount = $stmt->rowCount(); 
            
            if ($rowCount > 0) {
                $_SESSION[FLASH][FLASH_SUCCESS] = 'User deleted successfully.';
            } else {
                $_SESSION[FLASH][FLASH_ERROR] = 'Failed to delete user. No user found with this ID.';
            }
            
            header("Location: ../admin_account.php");
            exit(); 
            
        } catch (PDOException $e) {
            $_SESSION[FLASH][FLASH_ERROR] = 'Error deleting user: ' . $e->getMessage();
            header("Location: ../admin_account.php");
            exit(); 
        }
    } else {
        $_SESSION[FLASH][FLASH_ERROR] = 'No user ID provided.';
        header("Location: ../admin_account.php");
        exit(); 
    }
} else {
    $_SESSION[FLASH][FLASH_ERROR] = 'Invalid request method.';
    header("Location: ../admin_account.php");
    exit(); 
}
?>