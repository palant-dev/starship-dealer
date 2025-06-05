<?php require APPROOT . '/views/templates/front/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Checkout</h1>
            <?php flash('checkout_error'); ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Order Summary</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['cart_items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo URLROOT; ?>/images/products/<?php echo $item->image; ?>" 
                                                 alt="<?php echo $item->name; ?>" 
                                                 class="img-fluid rounded" 
                                                 style="max-width: 50px;">
                                            <span class="ms-2"><?php echo $item->name; ?></span>
                                        </div>
                                    </td>
                                    <td>$<?php echo number_format($item->price, 2); ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td>$<?php echo number_format($item->price * $item->quantity, 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Cart Totals</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th>Items:</th>
                            <td><?php echo $data['total_quantity']; ?></td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>Free Shipping</td>
                        </tr>
                        <tr>
                            <th>Order Total:</th>
                            <td><strong>$<?php echo number_format($data['total_amount'], 2); ?></strong></td>
                        </tr>
                    </table>

                    <form action="<?php echo URLROOT; ?>/checkout/processOrder" method="post">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Place Order
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?php echo URLROOT; ?>/cart" class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i> Return to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>
