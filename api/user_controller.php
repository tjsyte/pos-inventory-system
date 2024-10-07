<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = 'localhost';
$dbname = 'db_pos';
$username = 'root';
$db_password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

require_once __DIR__ . '/../_init.php';

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';
$password = $_POST['password'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

function addUser($pdo, $name, $email, $role, $password)
{
    $stmt = $pdo->prepare("INSERT INTO users (name, email, role, password) VALUES (:name, :email, :role, :password)");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'role' => $role,
        'password' => $password
    ]);

    $_POST = [];

    header("Location: ../admin_account.php");
    exit();
}

function editUser($pdo, $id, $name, $email, $role, $password)
{
    $query = "UPDATE users SET name = :name, email = :email, role = :role";
    $params = [
        'name' => $name,
        'email' => $email,
        'role' => $role,
    ];

    if (!empty($password)) {
        $query .= ", password = :password";
        $params['password'] = $password;
    }

    $query .= " WHERE id = :id";
    $params['id'] = $id;

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    header("Location: ../admin_account.php");
    exit();
}

switch ($action) {
    case 'add':
        addUser($pdo, $name, $email, $role, $password);
        break;
    case 'edit':
        editUser($pdo, $id, $name, $email, $role, $password);
        break;
    default:
        break;
}

$pdo = null;
