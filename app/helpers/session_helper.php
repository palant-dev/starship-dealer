<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Display flash message with Bootstrap styling
function flash($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            $_SESSION[$name] = $message;
            $_SESSION[$name.'_class'] = $class;
        } else if (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : $class;
            echo '<div class="'.$class.'" role="alert">'.$_SESSION[$name].'</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name.'_class']);
        }
    }
}

// Set flash message
function set_flash($name, $message) {
    $_SESSION[$name] = $message;
}

// Get flash message
function get_flash($name) {
    if (isset($_SESSION[$name])) {
        $message = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $message;
    }
    return null;
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Get current user ID
function get_user_id() {
    return $_SESSION['user_id'] ?? null;
}

// Get current user role
function get_user_role() {
    return $_SESSION['user_role'] ?? null;
}

// Check if user is admin
function is_admin() {
    return get_user_role() === 'admin';
}

// Set success message
function set_success($message) {
    set_flash('success', $message);
}

// Set error message
function set_error($message) {
    set_flash('error', $message);
}

// Get success message
function get_success() {
    return get_flash('success');
}

// Get error message
function get_error() {
    return get_flash('error');
} 