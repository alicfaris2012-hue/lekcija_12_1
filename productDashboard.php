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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light">Sign out</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        
        <div class="col-md-2 sidebar">
            <h5 class="mt-4 ms-3">Menu</h5>
            <a href="dashboard.php">Dashboard</a>
            <a href="productDashboard.php">Products Dashboard</a>
            <a href="profile.php">Edit Profile</a>
        </div>

          <div class="col-md-10 main-content">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <a href="addProduct.php" class="btn btn-success">Add Product</a>
            </div>

            <hr>

            <table class="table table-striped table-bordered">
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
                        <td>
                            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Update</a>
                            
                            <form action="deleteProduct.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>