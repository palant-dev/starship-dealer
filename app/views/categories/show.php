<?php require APPROOT . '/views/templates/front/header.php'; ?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo URLROOT; ?>/categories">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $data['category']->category_title; ?></li>
        </ol>
    </nav>

    <h1 class="mb-4"><?php echo $data['title']; ?></h1>

    <?php if(empty($data['products'])): ?>
        <div class="alert alert-info">
            No products found in this category.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach($data['products'] as $product): ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="<?php echo URLROOT; ?>/images/products/<?php echo $product->product_image; ?>" 
                             class="card-img-top" 
                             alt="<?php echo $product->product_title; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product->product_title; ?></h5>
                            <p class="card-text">$<?php echo number_format($product->product_price, 2); ?></p>
                            <?php if($product->product_quantity > 0): ?>
                                <a href="<?php echo URLROOT; ?>/cart/add/<?php echo $product->product_id; ?>" class="btn btn-success">Add to Cart</a>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Out of Stock</button>
                            <?php endif; ?>
                            <a href="<?php echo URLROOT; ?>/products/show/<?php echo $product->product_id; ?>" 
                               class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>
