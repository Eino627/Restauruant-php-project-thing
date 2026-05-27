<?php
session_start();

include("includes/db.php");


// Remove item
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

// Fetch products in cart
$products = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(",", array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $p) {
        $total += $_SESSION['cart'][$p['id']]['price']
        * $_SESSION['cart'][$p['id']]['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Ostoskori</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/styles.css">

</head>
<body>

<header>

    <div class="logo">
        Ruoka<span>Talo</span>
    </div>

    <nav>

        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Etusivu</a>
        <a href="menu.php" class="<?= basename($_SERVER['PHP_SELF']) === 'menu.php' ? 'active' : '' ?>">Ruokalista</a>
        <a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cart.php' ? 'active' : '' ?>">Ostoskori <span id="cart-count"><?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?></span>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="profile.php">Profiili</a>
            <a href="logout.php">Kirjaudu ulos</a>

        <?php } else { ?>

            <a href="log_in.php" class="<?= basename($_SERVER['PHP_SELF']) === 'log_in.php' ? 'active' : '' ?>">Kirjaudu</a>
            <a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : '' ?>">Rekisteröidy</a>

        <?php } ?>

    </nav>

</header>


<div class="cart-wrapper">

    <!-- LEFT SIDEBAR -->
    <div class="sidebar">
        <h2>Ostoskori</h2>
        <p>Hallinnoi tilauksesi sisältöä.</p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="cart-area">

        <h2>Tuotteet korissa</h2>

        <?php if (empty($products)): ?>
            <p>Ostoskorisi on tyhjä.</p>
        <?php else: ?>

        <?php foreach ($products as $p): ?>
            <div class="cart-item" data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                <img src="images/menu/<?= $p['image'] ?>" alt="<?= $p['name'] ?>">

                <div class="cart-info">
                    <h3><?= $p['name'] ?></h3>
                    <p class="price">Yksikköhinta: <?= number_format($p['price'], 2) ?> €</p>

                    <label>Määrä:</label>
                    <input type="number" class="qty-input" value="<?= $_SESSION['cart'][$p['id']]['quantity'] ?>" min="1">

                    <p class="line-price">
                        <?= number_format($_SESSION['cart'][$p['id']]['price'] * $_SESSION['cart'][$p['id']]['quantity'], 2) ?> €
                    </p>

                    <a class="remove-btn" href="cart.php?remove=<?= $p['id'] ?>">Poista</a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="checkout-box">
            <h3>Yhteensä: <span class="total-price"><?= number_format($total, 2) ?> €</span></h3>
            <a href="checkout.php" class="checkout-btn">Tee tilaus</a>
        </div>

        <?php endif; ?>

    </div>

</div>

<!-- LIVE PRICE UPDATE SCRIPT -->
<script>
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', function() {

        let item = this.closest('.cart-item');
        let price = parseFloat(item.dataset.price);
        let qty = parseInt(this.value);
        let id = item.dataset.id;

        if (qty < 1) qty = 1;

        // Update line price visually
        let linePrice = (price * qty).toFixed(2);
        item.querySelector('.line-price').textContent = linePrice + " €";

        // Update total visually
        updateTotal();

        // Save to PHP session (AJAX)
     fetch("update_cart.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id=" + id + "&qty=" + qty
})
.then(response => response.text())
.then(count => {

    document.getElementById("cart-count").textContent = count;
});
    });
});

function updateTotal() {
    let total = 0;

    document.querySelectorAll('.cart-item').forEach(item => {
        let price = parseFloat(item.dataset.price);
        let qty = parseInt(item.querySelector('.qty-input').value);
        total += price * qty;
    });

    document.querySelector('.total-price').textContent = total.toFixed(2) + " €";
}
</script>


</body>
</html>
