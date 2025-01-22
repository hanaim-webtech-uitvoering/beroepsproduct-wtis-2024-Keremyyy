<?php
session_start();
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_name"]) && isset($_POST["price"]) && isset($_SESSION["gebruiker_ingelogd"]) &&$_SESSION["gebruiker_ingelogd"] == true) {
    $product = [
        "name" => $_POST["product_name"],
        "price" => $_POST["price"]
    ];
    if (!isset($_SESSION["Winkelmandje"])) {
        $_SESSION["Winkelmandje"] = [];
    }
    $_SESSION["Winkelmandje"][] = $product;
}

?>
<?php echo renderHeader(); ?>

<main>
    <h1>Welkom bij de Pizzaria</h1>
    <div class="Producten">
        <div class="product-item">
            <img src="Peperoni.jpg" alt="peperoni">
            <h3>Pepperoni Pizza</h3>
            <div class="price">€11.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Pepperoni Pizza">
                <input type="hidden" name="price" value="11.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="margherita.webp" alt="margherita">
            <h3>Margherita pizza</h3>
            <div class="price">€9.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Margherita pizza">
                <input type="hidden" name="price" value="9.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="cola.jpg" alt="Coca Cola">
            <h3>Coca Cola</h3>
            <div class="price">€2.49</div>
            <form method="post" action="">
<!--                <input type="hidden" name="product_name" value="Coca Cola">-->
<!--                <input type="hidden" name="price" value="2.49">-->
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="knoflook.jpg" alt="kip">
            <h3>Knoflookbrood</h3>
            <div class="price">€4.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Knoflookbrood">
                <input type="hidden" name="price" value="4.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="combi.jpg" alt="combi">
            <h3>Combinatiemaaltij</h3>
            <div class="price">€15.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Combinatiemaaltijd">
                <input type="hidden" name="price" value="15.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="discussie.jpg" alt="discussie">
            <h3>Hawaiian Pizza</h3>
            <div class="price">€12.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Hawaiian Pizza">
                <input type="hidden" name="price" value="12.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="vega.jpg" alt="vega">
            <h3>Vegetarische Pizza</h3>
            <div class="price">€10.99</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Vegetarische Pizza">
                <input type="hidden" name="price" value="10.99">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
        <div class="product-item">
            <img src="Sprite.webp" alt="sprite">
            <h3>Sprite</h3>
            <div class="price">€2.49</div>
            <form method="post" action="">
                <input type="hidden" name="product_name" value="Sprite">
                <input type="hidden" name="price" value="2.49">
                <button type="submit">Toevoegen aan winkelmandje</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>