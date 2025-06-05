<?php

class HomeController extends Controller {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        error_log('Categories count: ' . count($categories));
        foreach ($categories as $category) {
            error_log('Category: ' . $category->category_id . ' - ' . $category->category_title);
        }

        $data = [
            'title' => 'Welcome to Our E-commerce Store',
            'description' => 'Find the best products at the best prices',
            'categories' => $categories,
            'featured_products' => $this->productModel->getFeaturedProducts(),
            'products' => $this->productModel->getAllProducts()
        ];

        $this->view('home/index', $data);
    }
} 