<?php require APPROOT . '/views/templates/front/header.php'; ?>

<div class="container text-center py-5">
    <i class="bi bi-rocket-takeoff" style="font-size: 5rem; color: #0d6efd;"></i>
    <h1 class="mt-4">Thank You for Your Purchase!</h1>
    <p class="lead">Your order has been received and is being prepared for intergalactic delivery.</p>
    <?php if(isset($data['order'])): ?>
        <p>Order #<?php echo $data['order']->order_id; ?> - Total: $<?php echo number_format($data['order']->order_amount, 2); ?></p>
    <?php endif; ?>
    <p>May the stars guide your new acquisition from <strong>Starship Dealer</strong> to your cosmic doorstep!</p>
    <hr>
    <p style="font-size: 0.9rem; color: #888;">&copy; <?php echo date('Y'); ?> Starship Dealer. All rights reserved. Space is our business.</p>
    <a href="<?php echo URLROOT; ?>/products" class="btn btn-primary mt-3">Continue Shopping</a>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>
