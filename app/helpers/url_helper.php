<?php
// URL Redirect
function redirect($page) {
    header('location: ' . URLROOT . '/' . $page);
    exit;
}

// Get current URL
function current_url() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

// Get base URL
function base_url() {
    return URLROOT;
}

// Sanitize URL
function sanitize_url($url) {
    return filter_var($url, FILTER_SANITIZE_URL);
}

// Check if URL is active
function is_active($url) {
    return current_url() == URLROOT . '/' . $url ? 'active' : '';
} 