<?php require APPROOT . '/views/templates/front/header.php'; ?>

<div class="container py-4">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <form action="<?php echo URLROOT; ?>/products/search" method="GET" id="filterForm">
                
                <input type="hidden" name="q" value="<?php echo htmlspecialchars($data['query']); ?>">
                <?php if ($data['selected_tag']): ?>
                    <input type="hidden" name="tag" value="<?php echo htmlspecialchars($data['selected_tag']); ?>">
                <?php endif; ?>

                <!-- Categories -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Category</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" name="category">
                            <option value="0">All Categories</option>
                            <?php if (isset($data['categories'])): ?>
                                <?php foreach($data['categories'] as $category) : ?>
                                    <option value="<?php echo $category->category_id; ?>" 
                                            <?php echo ($data['category'] == $category->category_id) ? 'selected' : ''; ?>>
                                        <?php echo $category->category_title; ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Sort By</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select" name="sort">
                            <option value="name_asc" <?php echo ($data['sort'] === 'name_asc') ? 'selected' : ''; ?>>Name (A-Z)</option>
                            <option value="name_desc" <?php echo ($data['sort'] === 'name_desc') ? 'selected' : ''; ?>>Name (Z-A)</option>
                            <option value="price_asc" <?php echo ($data['sort'] === 'price_asc') ? 'selected' : ''; ?>>Price (Low-High)</option>
                            <option value="price_desc" <?php echo ($data['sort'] === 'price_desc') ? 'selected' : ''; ?>>Price (High-Low)</option>
                        </select>
                    </div>
                </div>

                <!-- Tag Filter -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filter by Tag</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (!empty($data['tags'])): ?>
                            <?php foreach ($data['tags'] as $tag): ?>
                                <a href="<?php echo URLROOT; ?>/products/search?q=<?php echo urlencode($data['query']); ?>&tag=<?php echo urlencode($tag); ?>" 
                                   class="list-group-item list-group-item-action <?php echo ($data['selected_tag'] === $tag) ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($tag); ?>
                                </a>
                            <?php endforeach; ?>
                            <?php if ($data['selected_tag']): ?>
                                <a href="<?php echo URLROOT; ?>/products/search?q=<?php echo urlencode($data['query']); ?>" 
                                   class="list-group-item list-group-item-action text-danger">
                                    <i class="fas fa-times"></i> Clear Tag Filter
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="list-group-item">No tags available</div>
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
            </form>
        </div>

        <!-- Search Results -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0"><?php echo $data['title']; ?></h1>
                <!-- Quick Search Form -->
                <form action="<?php echo URLROOT; ?>/products/search" method="GET" class="d-flex" style="width: 300px;">
                    <input type="text" class="form-control me-2" name="q" 
                           placeholder="Quick search..." 
                           value="<?php echo htmlspecialchars($data['query']); ?>" required>
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>

            <!-- Products Grid -->
            <?php 
            
            error_log('View received products_html: ' . substr($data['products_html'], 0, 100) . '...');
            echo $data['products_html']; 
            ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/templates/front/footer.php'; ?>