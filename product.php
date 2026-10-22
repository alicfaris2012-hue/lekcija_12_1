<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Product ID is missing!");
}

$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow p-4">
        <h2>Edit Product</h2>
        <hr>
        <form action="updateProduct.php" method="POST">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($product['description']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" value="<?= $product['quantity'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary w-100">Save Changes</button>
            <a href="productDashboard.php" class="btn btn-secondary w-100 mt-2">Back</a>
        </form>
    </div>
</div>
</body>
</html>