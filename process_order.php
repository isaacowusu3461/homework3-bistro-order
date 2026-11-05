
<?php
require_once 'order_functions.php';

// Only allow the receipt to process submitted orders.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Save the order before displaying the receipt.
$orderSummary = order();

// Remember the visit for one day.
// The cookie is only used for recognition, not order storage.
setcookie('lastVisit', (string) time(), [
    'expires' => time() + 86400,
    'path' => '/',
    'secure' => !empty($_SERVER['HTTPS']) &&
        $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | Receipt</title>
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

    <main class="container receipt-page">
        <section class="hero">
            <span class="eyebrow">Fresh from the kitchen</span>
            <h1>Your Order Receipt</h1>
            <p>Thanks for stopping by! Here's what you ordered.</p>
        </section>

        <section class="card receipt-card">
            <h2>Order Summary</h2>

            <div class="receipt-details">
                <?= $orderSummary ?>
            </div>

            <div class="receipt-total">
                <span>Estimated Total</span>
                <strong><?= e(formattedTotal()) ?></strong>
            </div>

            <p class="muted"><?= e(pricingNote()) ?></p>
        </section>

        <section class="card">
            <h2>Order Feedback</h2>
            <p><?= e(completionMessage()) ?></p>
            <p><?= e(pairingSuggestion()) ?></p>
            <p class="muted">
                Order profile: <?= e(orderProfile()) ?>
            </p>
        </section>

        <div class="receipt-actions">
            <a class="btn btn-primary" href="index.php">
                Order Again!
            </a>
            <a class="btn btn-outline" href="forget_order.php">
                Forget Order
            </a>
        </div>
    </main>

    <footer>
        <p>Chez Session | CSC 6370 Web Programming | Homework 03</p>
    </footer>
</body>
</html>
