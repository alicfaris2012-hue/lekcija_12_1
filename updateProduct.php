<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE products 
            SET title = :title, description = :description, quantity = :quantity, price = :price 
            WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':quantity' => $quantity,
        ':price' => $price,
        ':id' => $id
    ]);

    header("Location: productDashboard.php");
    exit();
}