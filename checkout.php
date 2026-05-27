<?php
session_start();
require_once "includes/db.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}


$user_id = $_SESSION['user_id'];


$cart = $_SESSION['cart'] ?? [];


$cart_total = 0;

foreach ($cart as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}


$stmt = $pdo->prepare("
    INSERT INTO orders (user_id, total, status)
    VALUES (?, ?, 'pending')
");
$stmt->execute([$user_id, $cart_total]);

$order_id = $pdo->lastInsertId();

foreach ($cart as $product_id => $item) {
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([
        $order_id,
        $product_id,
        $item['quantity'],
        $item['price']
    ]);
}


unset($_SESSION['cart']);
unset($_SESSION['cart_total']);


header("Location: order_success.php");
exit;
?>
