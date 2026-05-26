<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luigi's Spagheteria</title>
	<link rel="stylesheet" href="style.css" />
</head>
<body>

<header>
    <h1>Luigi's Spagheteria</h1>

    <nav>
        <a href="#">Home</a>
        <a href="menu.php">Menu</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </nav>
</header>

<section class="hero">
    <img src="images/M_img.webp" alt="Spaghetti">

    <div class="hero-text">
        <h2>Fresh Italian Pasta</h2>
        <p>Authentic recipes.</p>
    </div>
</section>

<div class="container">

    <section id="menu">
        <h2 class="section-title">Popular Dishes</h2>

        <div class="food-grid">

            <div class="food-card">
                <img src="images/img1.webp" alt="Spaghetti Bolognese">

                <div class="food-card-content">
                    <h3>Spaghetti Bolognese</h3>
                    <p>Classic meat sauce with parmesan cheese.</p>
                </div>
            </div>

            <div class="food-card">
                <img src="images/img2.jpg" alt="Carbonara">

                <div class="food-card-content">
                    <h3>Carbonara</h3>
                    <p>Creamy pasta with pancetta and black pepper.</p>
                </div>
            </div>

            <div class="food-card">
                <img src="images/img3.jpg" alt="Seafood Pasta">

                <div class="food-card-content">
                    <h3>Seafood Pasta</h3>
                    <p>Shrimp, mussels and garlic butter sauce.</p>
                </div>
            </div>

        </div>
    </section>

    <section id="about" style="margin-top:50px;">
        <h2 class="section-title">About Us</h2>

        <p style="text-align:center; max-width:800px; margin:auto;">
            Welcome to Luigi's Spagheteria. We serve fresh handmade pasta,
            homemade sauces and authentic Italian food made with quality ingredients.
        </p>
    </section>

</div>

<footer id="contact">
    <p>Luigi's Spagheteria - Turku, Finland</p>
    <p>Email: info@luigisspagheteria.com</p>
</footer>

</body>
</html>