<?php
session_start();

if (isset($_POST['id']) && isset($_POST['qty'])) {

    $id = intval($_POST['id']);
    $qty = intval($_POST['qty']);

    if ($qty < 1) {
        $qty = 1;
    }

    if (isset($_SESSION['cart'][$id])) {

        $_SESSION['cart'][$id]['quantity'] = $qty;
    }

    echo array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
