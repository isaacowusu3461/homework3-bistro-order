
<?php
require_once 'order_functions.php';

// Remove the three saved order choices.
unset(
    $_SESSION['dessert'],
    $_SESSION['drink'],
    $_SESSION['drinkSize']
);

// Destroy the session data.
session_destroy();

// Remove the old session ID cookie as well.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => $params['path'],
        'domain' => $params['domain'],
        'secure' => $params['secure'],
        'httponly' => $params['httponly'],
        'samesite' => $params['samesite'] ?? 'Lax'
    ]);
}

// Return to a fresh form.
header('Location: index.php');
exit;
