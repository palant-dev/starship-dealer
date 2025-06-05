<?php
require_once APPROOT . '/helpers/session_helper.php';

class UsersController extends Controller {
    private $userModel;
    private $orderModel;

    public function __construct() {
        if(!is_logged_in()) {
            redirect('auth/login');
        }
        $this->userModel = $this->model('User');
        $this->orderModel = $this->model('Order');
    }

    public function profile() {
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($user_id);
        $orders = $this->orderModel->getUserOrders($user_id);

        // Get order items for each order
        foreach ($orders as $order) {
            $order->items = $this->orderModel->getOrderItems($order->order_id);
        }

        $data = [
            'title' => 'Profile',
            'user' => $user,
            'orders' => $orders,
            'email_err' => '',
            'current_password_err' => '',
            'new_password_err' => '',
            'confirm_password_err' => ''
        ];

        $this->view('users/profile', $data);
    }

    public function updateProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user_id'];
            $user = $this->userModel->getUserById($user_id);

            $data = [
                'user' => $user,
                'email' => trim($_POST['email']),
                'current_password' => $_POST['current_password'],
                'new_password' => $_POST['new_password'],
                'confirm_password' => $_POST['confirm_password'],
                'email_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif($data['email'] !== $user->email) {
                if($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Validate password if being changed
            if(!empty($data['current_password']) || !empty($data['new_password']) || !empty($data['confirm_password'])) {
                if(empty($data['current_password'])) {
                    $data['current_password_err'] = 'Please enter current password';
                } elseif($data['current_password'] !== $user->password) {
                    $data['current_password_err'] = 'Current password is incorrect';
                }

                if(empty($data['new_password'])) {
                    $data['new_password_err'] = 'Please enter new password';
                } elseif(strlen($data['new_password']) < 6) {
                    $data['new_password_err'] = 'Password must be at least 6 characters';
                }

                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm new password';
                } elseif($data['new_password'] !== $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if(empty($data['email_err']) && 
               empty($data['current_password_err']) && 
               empty($data['new_password_err']) && 
               empty($data['confirm_password_err'])) {
                
                // Update email
                if($data['email'] !== $user->email) {
                    $this->userModel->updateEmail($user_id, $data['email']);
                    $_SESSION['user_email'] = $data['email'];
                }

                // Update password if provided
                if(!empty($data['new_password'])) {
                    $this->userModel->updatePassword($user_id, $data['new_password']);
                }

                flash('profile_success', 'Profile updated successfully');
                redirect('users/profile');
            } else {
                // Load view with errors
                $this->view('users/profile', $data);
            }
        } else {
            redirect('users/profile');
        }
    }
}
