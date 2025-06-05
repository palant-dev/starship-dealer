<?php

class ProductController extends Controller {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }

    public function search() {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        $category = isset($_GET['category']) ? (int)$_GET['category'] : 0;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
        $tag = isset($_GET['tag']) ? trim($_GET['tag']) : null;
        
        error_log('Search request received: query="' . $query . '", category=' . $category . ', tag=' . ($tag ?? 'null'));

        if (empty($query)) {
            $data = [
                'title' => 'Search Products',
                'products_html' => '<div class="alert alert-info">Please enter a search term.</div>',
                'tags' => [],
                'query' => '',
                'selected_tag' => null
            ];
            $this->view('products/search', $data);
            return;
        }

        // Call the model's search method
        $search_results = $this->productModel->searchProducts($query, $category, $sort, $tag);
        $products = $search_results['products'];
        $tags = $search_results['tags'];
        
        // check if there's actually stuff in the DB
        $all_products = $this->productModel->getAllProducts();
        error_log('TOTAL PRODUCTS IN DATABASE: ' . count($all_products));
        if (count($all_products) > 0) {
            error_log('DATABASE HAS PRODUCTS - Sample product: ' . $all_products[0]->product_title);
        }
        
        // checking if we found anything
        error_log('Products found for "' . $query . '": ' . count($products));
        if (count($products) > 0) {
            error_log('First matching product: ' . print_r($products[0], true));
        } else {
            error_log('NO PRODUCTS FOUND FOR SEARCH QUERY: "' . $query . '"');
        }

        // make the HTML for showing products
        $products_html = '';
        if (!empty($products)) {
            foreach ($products as $product) {
                $products_html .= $this->generateProductCard($product);
            }
            $products_html = '<div class="row">' . $products_html . '</div>';
        } else {
            $products_html = '<div class="alert alert-warning">No products found for <strong>' . 
                             htmlspecialchars($query) . '</strong>' . 
                             ($tag ? ' with tag <strong>' . htmlspecialchars($tag) . '</strong>' : '') . 
                             '.</div>';
        }

        // grab categories for the dropdown
        $categories = $this->categoryModel->getAllCategories();

        $title = 'All Products';
        if (!empty($query)) {
            $title = 'Search Results for "' . htmlspecialchars($query) . '"';
            if ($tag) {
                $title .= ' (Tag: ' . htmlspecialchars($tag) . ')';
            }
        }

        $data = [
            'title' => $title,
            'query' => $query,
            'category' => $category,
            'sort' => $sort,
            'selected_tag' => $tag,
            'categories' => $categories,
            'products_html' => $products_html,
            'tags' => $tags
        ];

        $this->view('products/search', $data);
    }

    public function index() {
        // Get all products
        $data = [
            'title' => 'All Products',
            'products' => $this->productModel->getAllProducts(),
            'categories' => $this->categoryModel->getAllCategories()
        ];

        $this->view('products/index', $data);
    }

    public function show($id = null) {
        if ($id === null) {
            redirect('products');
        }

        // Get single product
        $product = $this->productModel->getProductById($id);
        
        if (!$product) {
            // Product not found
            $this->view('error/404');
            return;
        }

        // Get related products
        $relatedProducts = $this->productModel->getRelatedProducts($product->product_category_id, $id);

        $data = [
            'title' => $product->product_title,
            'product' => $product,
            'related_products' => $relatedProducts,
            'categories' => $this->categoryModel->getAllCategories()
        ];

        $this->view('products/show', $data);
    }
    
    /**
     * Make those product card that show up on the page
     * 
     * @param object $product The product from database
     * @return string The HTML code that shows the product
     */
    private function generateProductCard($product) {
        
        error_log('Processing product: ' . print_r($product, true));
        
        
        $isObject = is_object($product);
        
        
        $productId = $isObject ? ($product->product_id ?? 0) : ($product['product_id'] ?? 0);
        $productTitle = $isObject ? ($product->product_title ?? 'Unknown Product') : ($product['product_title'] ?? 'Unknown Product');
        $productPrice = $isObject ? ($product->product_price ?? 0) : ($product['product_price'] ?? 0);
        $categoryTitle = $isObject ? ($product->category_title ?? 'Uncategorized') : ($product['category_title'] ?? 'Uncategorized');
        
        // price with 2 decimal places
        $price = number_format((float)$productPrice, 2);
        $productUrl = URLROOT . '/products/show/' . $productId;
        
        $html = '<div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><a href="' . $productUrl . '">' . $productTitle . '</a></h5>
                    <p class="card-text text-muted">' . $categoryTitle . '</p>
                    <p class="card-text font-weight-bold">$' . $price . '</p>
                    <a href="' . $productUrl . '" class="btn btn-primary">View Details</a>
                    <a href="' . URLROOT . '/cart/add/' . $productId . '" class="btn btn-outline-success">Add to Cart</a>
                </div>
            </div>
        </div>';
        
        error_log('Generated HTML card: ' . substr($html, 0, 100) . '...');
        
        return $html;
    }
} 