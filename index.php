
<?php
require_once 'order_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | Order</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="logo" href="index.php">Chez Session</a>
            <nav aria-label="Main navigation">
                <a href="index.php">Order</a>
                <a href="about.php">About</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <span class="eyebrow">A little dessert goes a long way</span>
            <h1>Welcome to Chez Session</h1>
            <p>Pick your favorite dessert, grab a drink, and enjoy
               a little break. We'll remember your order!</p>
        </section>

        <p class="welcome-note"><?= e(welcomeMessage()) ?></p>

        <div class="page-grid">
            <section class="card">
                <h2>Build Your Order</h2>
                <p class="muted">Choose what you'd like today.</p>

                <form action="process_order.php" method="post">
                    <div class="form-group">
                        <label for="dessert">Dessert</label>
                        <select id="dessert" name="dessert">
                            <option value="none">Choose a dessert</option>
                            <?php foreach (menuDesserts() as $name => $price): ?>
                                <option value="<?= e($name) ?>"
                                    <?= dessertSelected($name) ?>>
                                    <?= e($name) ?> - $<?= number_format($price, 2) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="drink">Drink</label>
                        <select id="drink" name="drink">
                            <option value="none">Choose a drink</option>
                            <?php foreach (menuDrinks() as $name => $price): ?>
                                <option value="<?= e($name) ?>"
                                    <?= drinkSelected($name) ?>>
                                    <?= e($name) ?> - $<?= number_format($price, 2) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <fieldset class="form-group">
                        <legend>Drink Size</legend>
                        <div class="radio-options">
                            <?php foreach (menuSizes() as $size => $extra): ?>
                                <label class="radio-option">
                                    <input type="radio" name="drinkSize"
                                        value="<?= e($size) ?>"
                                        <?= drinkSizeSelected($size) ?>>
                                    <?= e($size) ?>
                                    <?php if ($extra > 0): ?>
                                        (+$<?= number_format($extra, 2) ?>)
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>

                    <button class="btn btn-primary" type="submit">
                        Send to Kitchen
                    </button>
                </form>

                <a class="btn btn-outline" href="forget_order.php">
                    Forget My Order
                </a>
            </section>

            <aside class="sidebar">
                <section class="card">
                    <h2>Your Order Progress</h2>
                    <p class="progress-number">
                        <?= completedChoiceCount() ?> / 3
                    </p>
                    <p><?= e(completionMessage()) ?></p>
                    <progress value="<?= completedChoiceCount() ?>"
                        max="3">Order progress</progress>
                </section>

                <section class="card">
                    <h2>Estimated Total</h2>
                    <p class="price"><?= e(formattedTotal()) ?></p>
                    <p class="muted"><?= e(pricingNote()) ?></p>
                </section>

                <section class="card">
                    <h2>Today's Pairing</h2>
                    <p><?= e(pairingSuggestion()) ?></p>
                    <p class="muted">
                        Order type: <?= e(orderProfile()) ?>
                    </p>
                </section>
            </aside>
        </div>
    </main>

    <footer>
        <p>Chez Session | CSC 6370 Web Programming | Homework 03</p>
    </footer>
</body>
</html>
