<?php
session_start();
require_once "includes/db.php";

if (!isset($_GET['id'])) {
    echo "ERROR";
    exit;
}

$id = intval($_GET['id']);

$stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch();

if (!$product) {
    echo "Product not found";
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {

    $_SESSION['cart'][$id]['quantity']++;

} else {

    $_SESSION['cart'][$id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => 1
    ];
}

echo array_sum(array_column($_SESSION['cart'], 'quantity'));
?>
