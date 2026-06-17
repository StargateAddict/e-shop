<?php
require_once('files/functions.php');
protected_area();

$user_id = $_SESSION['user']['id'];
$cart_items = cart_get($user_id);
$cart_total = cart_total($user_id);
$cart_count = cart_count($user_id);

require_once('files/header.php');
?>

<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="<?= BASE_URL ?>"><i class="ci-home"></i>Home</a></li>
                    <li class="breadcrumb-item text-nowrap"><a href="shop.php">Shop</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Your Cart</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <?php if (empty($cart_items)): ?>
        <div class="text-center py-5">
            <i class="ci-cart" style="font-size: 4rem; color: #ccc;"></i>
            <h2 class="h4 mt-3 mb-2">Your cart is empty</h2>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php else: ?>
    <div class="row">
        <!-- Cart items -->
        <div class="col-lg-8">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="bg-secondary">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item):
                            $thumb = get_product_thumb($item['photos']);
                            $subtotal = $item['selling_price'] * $item['quantity'];
                        ?>
                        <tr class="border-bottom">
                            <td>
                                <div class="d-flex align-items-center py-2">
                                    <a href="product.php?id=<?= $item['product_id'] ?>" class="flex-shrink-0">
                                        <img src="<?= $thumb ?>" width="64" alt="<?= htmlspecialchars($item['name']) ?>">
                                    </a>
                                    <div class="ps-3">
                                        <h6 class="mb-0">
                                            <a href="product.php?id=<?= $item['product_id'] ?>" class="text-dark">
                                                <?= htmlspecialchars($item['name']) ?>
                                            </a>
                                        </h6>
                                        <?php if ($item['size']): ?>
                                            <small class="text-muted">Size: <?= $item['size'] ?></small>
                                        <?php endif; ?>
                                        <?php if ($item['color']): ?>
                                            <small class="text-muted ms-2">Color: <?= $item['color'] ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">$<?= number_format($item['selling_price'], 2) ?></td>
                            <td class="align-middle" style="width: 130px;">
                                <form method="post" action="cart-logic.php?action=update" class="d-flex align-items-center">
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                           min="1" max="99" class="form-control form-control-sm"
                                           style="width: 65px;"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="align-middle fw-medium text-accent">
                                $<?= number_format($subtotal, 2) ?>
                            </td>
                            <td class="align-middle">
                                <a href="cart-logic.php?action=remove&cart_id=<?= $item['id'] ?>"
                                   class="btn-close text-danger"
                                   onclick="return confirm('Remove this item?')"
                                   aria-label="Remove">
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
                <a href="shop.php" class="btn btn-outline-accent">
                    <i class="ci-arrow-left me-2"></i>Continue Shopping
                </a>
                <a href="cart-logic.php?action=clear"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Clear entire cart?')">
                    <i class="ci-trash me-2"></i>Clear Cart
                </a>
            </div>
        </div>

        <!-- Order summary -->
        <div class="col-lg-4 pt-4 pt-lg-0">
            <div class="bg-secondary rounded-3 p-4">
                <h2 class="h4 mb-4">Order Summary</h2>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Items (<?= $cart_count ?>):</span>
                    <span>$<?= number_format($cart_total, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Shipping:</span>
                    <span class="text-success">Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold">Total:</span>
                    <span class="fw-bold text-accent fs-lg">$<?= number_format($cart_total, 2) ?></span>
                </div>

                <!-- Coupon code -->
                <div class="mb-4">
                    <label class="form-label" for="coupon">Coupon Code</label>
                    <div class="input-group">
                        <input class="form-control" type="text" id="coupon" placeholder="Enter code">
                        <button class="btn btn-outline-secondary" type="button">Apply</button>
                    </div>
                </div>

                <a href="checkout.php" class="btn btn-primary btn-shadow d-block w-100">
                    <i class="ci-card me-2"></i>Proceed to Checkout
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require_once('files/footer.php'); ?>