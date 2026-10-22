<?php
session_start();
require_once "config.php";


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products Dashboard</h2>
        <div>
            <a href="addProduct.php" class="btn btn-success">Add Product</a>
            <a href="dashboard.php" class="btn btn-secondary">Back to Users Dashboard</a>
            <a href="logout.php" class="btn btn-danger">Log out</a>
        </div>
    </div>

    <table class="table table-striped table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td><?= htmlspecialchars($product['title']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= $product['quantity'] ?></td>
                <td><?= $product['price'] ?></td>
                <td
                    <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Update</a>
                    
                
                 <form action="deleteProduct.php" method="POST" class="d-inline" onsubmit="return confirm('Jeste li sigurni?')">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>