<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

        <div class="col-md-9">
            <div class="row carousel-holder">
                <div class="col-md-12">
                    <?php include(TEMPLATE_FRONT . DS . "slider.php"); ?>
                </div>
            </div>

            <div class="row">
                <h2>Featured Starships</h2>
                <div class="row">
                    <?php foreach($featured_products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo URLROOT; ?>/images/products/<?php echo $product->product_image; ?>" class="card-img-top" alt="<?php echo $product->product_title; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->product_title; ?></h5>
                                    <p class="card-text"><?php echo $product->product_description; ?></p>
                                    <p class="card-text"><strong>$<?php echo number_format($product->product_price, 2); ?></strong></p>
                                    <a href="<?php echo URLROOT; ?>/products/show/<?php echo $product->product_id; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="row">
                <h2>Available Parts & Equipment</h2>
                <div class="row">
                    <?php foreach($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo URLROOT; ?>/images/products/<?php echo $product->product_image; ?>" class="card-img-top" alt="<?php echo $product->product_title; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product->product_title; ?></h5>
                                    <p class="card-text"><?php echo $product->product_description; ?></p>
                                    <p class="card-text"><strong>$<?php echo number_format($product->product_price, 2); ?></strong></p>
                                    <a href="<?php echo URLROOT; ?>/products/show/<?php echo $product->product_id; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?> 