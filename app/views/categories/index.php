<?php require APPROOT . '/views/templates/front/header.php'; ?>

<div class="container py-4">
    <h1 class="mb-4"><?php echo $data['title']; ?></h1>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach($data['categories'] as $category): ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $category->category_title; ?></h5>
                        <a href="<?php echo URLROOT; ?>/categories/show/<?php echo $category->category_id; ?>" 
                           class="btn btn-primary">View Products</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>
