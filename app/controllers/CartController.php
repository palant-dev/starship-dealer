<?php

class CartController extends Controller {
    private $productModel;
    private $cartModel;

    public function __construct() {
        if(!is_logged_in()) {
            redirect('auth/login');
        }
        $this->productModel = $this->model('Product');
        $this->cartModel = $this->model('Cart');
    }

    public function index() {
        $cart_items = $this->cartModel->getCartItems($_SESSION['user_id']);
        $total = $this->cartModel->getCartTotal($_SESSION['user_id']);

        $data = [
            'title' => 'Shopping Cart',
            'cart_items' => $cart_items,
            'total' => $total
        ];

        $this->view('cart/index', $data);
    }

    public function add($id) {
        $product = $this->productModel->getProductById($id);
        
        if ($product) {
            $this->cartModel->addToCart($_SESSION['user_id'], $product->product_id, 1);
            flash('cart_message', 'Product added to cart');
        }

        redirect('cart');
    }

    public function remove($id) {
        if($this->cartModel->removeFromCart($_SESSION['user_id'], $id)) {
            flash('cart_message', 'Product removed from cart');
        }

        redirect('cart');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($_POST['quantity'] as $id => $quantity) {
                if ($quantity > 0) {
                    $this->cartModel->updateQuantity($_SESSION['user_id'], $id, $quantity);
                } else {
                    $this->cartModel->removeFromCart($_SESSION['user_id'], $id);
                }
            }
            
            flash('cart_message', 'Cart updated');
        }

        redirect('cart');
    }

    public function clear() {
        if($this->cartModel->clearCart($_SESSION['user_id'])) {
            flash('cart_message', 'Cart cleared');
        }

        redirect('cart');
    }

    private function calculateTotal() {
        $total = 0;
        
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return $total;
    }
} 