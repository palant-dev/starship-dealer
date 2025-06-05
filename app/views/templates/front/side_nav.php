<div class="col-md-3">
    <p class="lead">Categories</p>
    <div class="list-group">
        <?php
        $categories = $data['categories'] ?? [];
        $seen = [];
        foreach ($categories as $category) {
            // Skip if we've already seen this category
            if (isset($seen[$category->category_id])) {
                continue;
            }
            $seen[$category->category_id] = true;
            
            echo '<a href="' . URLROOT . '/categories/show/' . $category->category_id . '" class="list-group-item">' . 
                 htmlspecialchars($category->category_title) . '</a>';
        }
        ?>
    </div>
</div>