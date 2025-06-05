<?php
require_once APPROOT . '/helpers/session_helper.php';

class CheckoutController extends Controller {
    private $cartModel;
    private $orderModel;

    public function __construct() {
        if(!is_logged_in()) {
            redirect('auth/login');
        }
        $this->cartModel = $this->model('Cart');
        $this->orderModel = $this->model('Order');
    }

    public function index() {
        $cart_items = $this->cartModel->getCartItems($_SESSION['user_id']);
        $total_quantity = 0;
        $total_amount = 0;

        foreach($cart_items as $item) {
            $total_quantity += $item->quantity;
            $total_amount += $item->price * $item->quantity;
        }

        $_SESSION['item_quantity'] = $total_quantity;
        $_SESSION['item_total'] = $total_amount;

        $data = [
            'cart_items' => $cart_items,
            'total_quantity' => $total_quantity,
            'total_amount' => $total_amount
        ];

        $this->view('checkout/index', $data);
    }

    public function processOrder() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $cart_items = $this->cartModel->getCartItems($user_id);
            
            if(empty($cart_items)) {
                flash('checkout_error', 'Your cart is empty');
                redirect('checkout');
                return;
            }

            // Calculate total
            $total = 0;
            foreach($cart_items as $item) {
                $total += $item->price * $item->quantity;
            }

            // Create order
            $order_id = $this->orderModel->createOrder($user_id, $total);

            if(!$order_id) {
                flash('checkout_error', 'Could not create order');
                redirect('checkout');
                return;
            }

            // Add order items
            foreach($cart_items as $item) {
                $this->orderModel->addOrderItem($order_id, $item->product_id, $item->quantity, $item->price);
            }

            // Clear cart
            $this->cartModel->clearCart($user_id);

            // Store order ID in session for thank you page
            $_SESSION['last_order_id'] = $order_id;
            redirect('checkout/thank-you');
        } else {
            redirect('');
        }
    }

    public function thankYou() {
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['last_order_id'])) {
            redirect('');
            return;
        }

        $order = $this->orderModel->getOrderById($_SESSION['last_order_id']);
        if(!$order || $order->user_id != $_SESSION['user_id']) {
            redirect('');
            return;
        }

        // Clear the last order ID from session
        unset($_SESSION['last_order_id']);

        $data = [
            'title' => 'Thank You',
            'order' => $order
        ];

        $this->view('checkout/thank_you', $data);
    }
}
