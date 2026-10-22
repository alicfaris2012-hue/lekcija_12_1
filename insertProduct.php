<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if (!empty($title) && !empty($description) && isset($quantity) && isset($price)) {
        $sql = "INSERT INTO products (title, description, quantity, price) VALUES (:title, :description, :quantity, :price)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':quantity' => $quantity,
            ':price' => $price
        ]);
    }

    header("Location: productDashboard.php");
    exit();
}