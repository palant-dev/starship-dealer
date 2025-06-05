<?php

class CategoryController extends Controller {
    private $categoryModel;
    private $productModel;

    public function __construct() {
        $this->categoryModel = $this->model('Category');
        $this->productModel = $this->model('Product');
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        
        $data = [
            'title' => 'Product Categories',
            'categories' => $categories
        ];

        $this->view('categories/index', $data);
    }

    public function show($id) {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            redirect('');
            return;
        }

        $products = $this->productModel->getProductsByCategory($id);

        $data = [
            'title' => $category->category_title,
            'category' => $category,
            'products' => $products
        ];

        $this->view('categories/show', $data);
    }
}
