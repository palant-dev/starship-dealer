<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">
    <h1 class="mb-4"><?php echo $title; ?></h1>

    <?php if(empty($cart_items)): ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="<?php echo URLROOT; ?>/products">Continue shopping</a>
        </div>
    <?php else: ?>
        <form action="<?php echo URLROOT; ?>/cart/update" method="POST">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($cart_items as $item): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo URLROOT; ?>/images/products/<?php echo $item->image; ?>" 
                                             alt="<?php echo $item->name; ?>" 
                                             class="img-thumbnail" 
                                             style="width: 100px; margin-right: 15px;">
                                        <?php echo $item->name; ?>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($item->price, 2); ?></td>
                                <td>
                                    <input type="number" 
                                           name="quantity[<?php echo $item->product_id; ?>]" 
                                           value="<?php echo $item->quantity; ?>" 
                                           min="0" 
                                           class="form-control" 
                                           style="width: 80px;">
                                </td>
                                <td>$<?php echo number_format($item->price * $item->quantity, 2); ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/cart/remove/<?php echo $item->product_id; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to remove this item?')">
                                        Remove
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <a href="<?php echo URLROOT; ?>/products" class="btn btn-secondary">Continue Shopping</a>
                <div>
                    <button type="submit" class="btn btn-primary">Update Cart</button>
                    <a href="<?php echo URLROOT; ?>/cart/clear" 
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to clear your cart?')">
                        Clear Cart
                    </a>
                    <a href="<?php echo URLROOT; ?>/checkout" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?> 