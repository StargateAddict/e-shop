<?php
require_once('files/functions.php');
protected_area();

$user_id = $_SESSION['user']['id'];
$action = $_GET['action'] ?? '';

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)($_POST['quantity'] ?? 1);
    $size = $_POST['size'] ?? null;
    $color = $_POST['color'] ?? null;

    if (cart_add($user_id, $product_id, $quantity, $size, $color)) {
        alert('success', 'Product added to cart.');
    } else {
        alert('danger', 'Failed to add product to cart.');
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($action == 'remove') {
    $cart_id = (int)$_GET['cart_id'];
    cart_remove($cart_id, $user_id);
    header('Location: shop-cart.php');
    die();
}

if ($action == 'update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];
    cart_update($cart_id, $user_id, $quantity);
    header('Location: shop-cart.php');
    die();
}

if ($action == 'clear') {
    cart_clear($user_id);
    header('Location: shop-cart.php');
    die();
}

header('Location: shop-cart.php');
die();