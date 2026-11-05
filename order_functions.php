
<?php
// Start the session before sending anything to the browser.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function menuDesserts(): array {
    return [
        'Cheesecake' => 4.25,
        'Chocolate Cake' => 4.50,
        'Carrot Cake' => 4.00,
        'Tiramisu' => 4.75
    ];
}

function menuDrinks(): array {
    return [
        'Coffee' => 2.25,
        'Hot Chocolate' => 2.75,
        'Root Beer' => 2.50,
        'Tea' => 2.00,
        'Milk' => 1.75
    ];
}

function menuSizes(): array {
    return [
        'Small' => 0.00,
        'Medium' => 0.60,
        'Large' => 1.15
    ];
}

// Read a submitted choice and check that it is on our menu.
function validChoice(string $key, array $allowed): string {
    $value = $_POST[$key] ?? '';

    if (!is_string($value)) {
        return '(not selected)';
    }

    $value = trim($value);

    if ($value === '' || $value === 'none') {
        return '(not selected)';
    }

    return array_key_exists($value, $allowed)
        ? $value
        : '(not selected)';
}

// Save the order using the three required session variables.
function order(): string {
    $_SESSION['dessert'] = validChoice('dessert', menuDesserts());
    $_SESSION['drink'] = validChoice('drink', menuDrinks());
    $_SESSION['drinkSize'] = validChoice('drinkSize', menuSizes());

    return 'Dessert: ' . e(sessionValue('dessert')) . '<br>'
        . 'Drink: ' . e(sessionValue('drink')) . '<br>'
        . 'Drink size: ' . e(sessionValue('drinkSize'));
}

// Escape values before displaying them in HTML.
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function sessionValue(string $key): string {
    $allowed = ['dessert', 'drink', 'drinkSize'];

    if (!in_array($key, $allowed, true)) {
        return '(not selected)';
    }

    $value = $_SESSION[$key] ?? '(not selected)';

    return is_string($value) ? $value : '(not selected)';
}

// These helpers restore the previous form selections.
function dessertSelected(string $dessert): string {
    return sessionValue('dessert') === $dessert ? 'selected' : '';
}

function drinkSelected(string $drink): string {
    return sessionValue('drink') === $drink ? 'selected' : '';
}

function drinkSizeSelected(string $size): string {
    return sessionValue('drinkSize') === $size ? 'checked' : '';
}

// Count how many of the three choices have been completed.
function completedChoiceCount(): int {
    $count = 0;

    foreach (['dessert', 'drink', 'drinkSize'] as $key) {
        if (sessionValue($key) !== '(not selected)') {
            $count++;
        }
    }

    return $count;
}

function completionMessage(): string {
    $count = completedChoiceCount();

    if ($count === 3) {
        return 'All three choices are saved. Your order is complete!';
    }

    if ($count === 0) {
        return 'Choose a dessert, drink, and drink size to get started.';
    }

    return "You have completed {$count} out of 3 choices.";
}

function pairingSuggestion(): string {
    $dessert = sessionValue('dessert');
    $drink = sessionValue('drink');

    if ($dessert === '(not selected)' ||
        $drink === '(not selected)') {
        return 'Choose a dessert and drink to see a pairing suggestion.';
    }

    if ($dessert === 'Cheesecake' && $drink === 'Coffee') {
        return 'Nice choice! Cheesecake goes really well with coffee.';
    }

    if ($dessert === 'Chocolate Cake' && $drink === 'Milk') {
        return 'Chocolate cake and milk are a great combination.';
    }

    if ($dessert === 'Carrot Cake' && $drink === 'Tea') {
        return 'Carrot cake and tea make a relaxing dessert break.';
    }

    if ($dessert === 'Tiramisu' && $drink === 'Coffee') {
        return 'Tiramisu and coffee are a classic cafe pairing.';
    }

    return "Your {$dessert} and {$drink} combination sounds good!";
}

// Calculate the total using the selected menu items.
function dessertPrice(): float {
    return menuDesserts()[sessionValue('dessert')] ?? 0.0;
}

function drinkPrice(): float {
    $drink = sessionValue('drink');
    $size = sessionValue('drinkSize');

    $base = menuDrinks()[$drink] ?? 0.0;

    if ($base === 0.0) {
        return 0.0;
    }

    return $base + (menuSizes()[$size] ?? 0.0);
}

function estimatedTotal(): float {
    return dessertPrice() + drinkPrice();
}

function formattedTotal(): string {
    return '$' . number_format(estimatedTotal(), 2);
}

function pricingNote(): string {
    if (sessionValue('drink') !== '(not selected)' &&
        sessionValue('drinkSize') === '(not selected)') {
        return 'Select a drink size to finalize the drink price.';
    }

    return 'Prices are estimates based on your saved selections.';
}

function orderProfile(): string {
    $total = estimatedTotal();

    if ($total >= 6.50) {
        return 'Full cafe combo';
    }

    if ($total >= 4.00) {
        return 'Dessert break';
    }

    if ($total > 0) {
        return 'Light snack';
    }

    return 'No selections yet';
}

// Read the previous visit cookie for a returning customer.
function welcomeMessage(): string {
    $lastVisit = $_COOKIE['lastVisit'] ?? null;

    if (!is_string($lastVisit) || !ctype_digit($lastVisit)) {
        return 'Welcome to Chez Session! Ready for something sweet?';
    }

    return 'Welcome back! Your last order was on '
        . date('F j, Y \a\t g:i A', (int) $lastVisit) . '.';
}
