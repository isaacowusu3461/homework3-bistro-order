
<?php
require_once 'order_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | About</title>
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
            <span class="eyebrow">Behind the scenes</span>
            <h1>About Chez Session</h1>
            <p>A small PHP project about remembering customer orders.</p>
        </section>

        <section class="card about-content">
            <h2>How It Works</h2>
            <p>
                Chez Session is a simple dessert ordering website
                that uses PHP sessions to remember what a customer
                selected.
            </p>

            <h3>1. Placing an Order</h3>
            <p>
                The customer selects a dessert, drink, and drink
                size on index.php. The form sends these values to
                process_order.php using the POST method.
            </p>

            <h3>2. Saving the Order</h3>
            <p>
                The order() function saves the three values in
                $_SESSION. If a choice is missing, the application
                saves "(not selected)" instead.
            </p>

            <h3>3. Remembering Selections</h3>
            <p>
                When the customer returns to the form, the helper
                functions restore the saved dropdown options and
                radio button selection.
            </p>

            <h3>4. Remembering Visits</h3>
            <p>
                A cookie named lastVisit stores the time of the
                customer's previous order. This is used for the
                welcome-back message, not for saving the order.
            </p>

            <h3>5. Forgetting the Order</h3>
            <p>
                The Forget Order link opens forget_order.php,
                which clears the session and returns the customer
                to a fresh order form.
            </p>

            <h2>What I Practiced</h2>
            <p>
                This homework helped me practice PHP sessions,
                cookies, form processing, reusable functions,
                and handling missing form values.
            </p>

            <a class="btn btn-primary" href="index.php">
                Back to Order Form
            </a>
        </section>
    </main>

    <footer>
        <p>Chez Session | CSC 6370 Web Programming | Homework 03</p>
    </footer>
</body>
</html>
