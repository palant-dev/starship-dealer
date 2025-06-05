<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

        <div class="col-md-9">
            <h1 class="mb-4"><?php echo $title; ?></h1>
            
            <div class="row">
                <?php foreach($products as $product): ?>
                    <?php 
                        $productUrl = URLROOT . '/products/show/' . $product->product_id;
                        error_log("Generated product URL: " . $productUrl);
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo URLROOT; ?>/images/products/<?php echo $product->product_image; ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo $product->product_title; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product->product_title; ?></h5>
                                <p class="card-text"><?php echo substr($product->product_description, 0, 100) . '...'; ?></p>
                                <p class="card-text"><strong>$<?php echo number_format($product->product_price, 2); ?></strong></p>
                                <a href="<?php echo $productUrl; ?>" 
                                   class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?> 