<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<!-- Page Content -->
<div class="container" style="margin-top: 80px;">
    <div class="row">
        <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

        <div class="col-md-9">
            <!-- Row For Image and Short Description/Form -->
            <div class="row mb-4">
                <div class="col-md-7 text-center">
                    <img class="img-fluid large-product-image" 
                         src="<?php echo URLROOT; ?>/images/products/<?php echo $product->product_image; ?>" 
                         alt="<?php echo $product->product_title; ?>">
                </div>

                <div class="col-md-5">
                    <div class="thumbnail">
                        <div class="caption-full">
                            <h4><?php echo $product->product_title; ?></h4>
                            <hr>
                            <h4>$<?php echo number_format($product->product_price, 2); ?></h4>

                            <div class="ratings">
                                <p>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star text-warning"></i>
                                    4.0 stars
                                </p>
                            </div>

                            <p><?php echo substr($product->product_description, 0, 200); ?></p>

                            <form action="<?php echo URLROOT; ?>/cart/add/<?php echo $product->product_id; ?>" method="GET">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="ADD TO CART">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Row for Tab Panel -->
            <div class="row">
                <div class="col-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p class="p-3"><?php echo $product->product_description; ?></p>
                        </div>
                        
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="col-md-6">
                                <h3>2 Reviews</h3>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star text-warning"></i>
                                        Anonymous
                                        <span class="pull-right">10 days ago</span>
                                        <p>This product was great in terms of quality. I would definitely buy another!</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-12">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star text-warning"></i>
                                        Anonymous
                                        <span class="pull-right">12 days ago</span>
                                        <p>I've already ordered another one!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Row for Related Products -->
            <?php if(!empty($related_products)): ?>
            <div class="row">
                <h2>Related Products</h2>
                <div class="row">
                    <?php foreach($related_products as $related): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo URLROOT; ?>/images/products/<?php echo $related->product_image; ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo $related->product_title; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $related->product_title; ?></h5>
                                    <p class="card-text"><?php echo substr($related->product_description, 0, 100) . '...'; ?></p>
                                    <p class="card-text"><strong>$<?php echo number_format($related->product_price, 2); ?></strong></p>
                                    <a href="<?php echo URLROOT; ?>/products/show/<?php echo $related->product_id; ?>" 
                                       class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?> 