<?php

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // handle the form submission
            $data = [
                'email' => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)),
                'password' => $_POST['password'], // Don't trim or sanitize passwords
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // see if this email exists in our database
            if ($this->userModel->findUserByEmail($data['email'])) {
                // cool we found them in the database
            } else {
                $data['email_err'] = 'No user found';
            }

            // if no errors happened we can continue
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // try to login with these credentials
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // make the login session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('auth/login', $data);
                }
            } else {
                // show the form again with the errors
                $this->view('auth/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // show the login page
            $this->view('auth/login', $data);
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // this is where we get the form data from the user
            $data = [
                'username' => trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
                'email' => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)),
                'password' => $_POST['password'], // Don't trim or sanitize passwords
                'confirm_password' => $_POST['confirm_password'], // leave password as-is
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // check the username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } elseif ($this->userModel->findUserByUsername($data['username'])) {
                $data['username_err'] = 'Username is already taken';
            }

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif ($this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already taken';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // make sure they typed the password twice correctly
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if (empty($data['username_err']) && empty($data['email_err']) && 
                empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // add the user to our database
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can now login');
                    redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // show them the form again with error messages
                $this->view('auth/register', $data);
            }
        } else {
            
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            
            $this->view('auth/register', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->username;
        redirect('');
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('auth/login');
    }
}
