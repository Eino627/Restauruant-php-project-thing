<?php
session_start();
include("includes/db.php");

// Get selected category (default: first category)
$selectedCategory = isset($_GET['cat']) ? intval($_GET['cat']) : null;

// Fetch all categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

// If no category selected, use first one
if (!$selectedCategory && count($categories) > 0) {
    $selectedCategory = $categories[0]['id'];
}

// Fetch products for selected category
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
$stmt->execute([$selectedCategory]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Ruokalista</title>
<link rel="stylesheet" href="./css/styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


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


<div class="menu-wrapper">

    <!-- LEFT SIDEBAR -->
    <div class="sidebar">
        <h2>Kategoriat</h2>

        <?php foreach ($categories as $cat): ?>
            <a 
                href="menu.php?cat=<?= $cat['id'] ?>" 
                class="category-link <?= $selectedCategory == $cat['id'] ? 'category-active' : '' ?>"
            >
                <?= htmlspecialchars($cat['category_name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- RIGHT SIDE PRODUCTS -->
    <div class="products-area">
        

        <div class="products-grid">
            <?php foreach ($products as $p): ?>
                <div class="product-card">
                    <img src="images/menu/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                    <div class="product-info">
                        <h3><?= htmlspecialchars($p['name']) ?></h3>
                        <p><?= htmlspecialchars($p['description']) ?></p>
                        <p class="price"><?= number_format($p['price'], 2) ?> €</p>
                        <a href="#" class="add-btn" data-id="<?= $p['id'] ?>">Lisää koriin</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>
<script>
document.querySelectorAll('.add-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();

        let id = this.dataset.id;

        fetch("add_to_cart.php?id=" + id)
            .then(response => response.text())
            .then(count => {
                document.getElementById("cart-count").textContent = count;
            });
    });
});
</script>

</body>
</html>
