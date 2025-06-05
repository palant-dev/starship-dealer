<?php

function get_cart_count() {
    if(!isset($_SESSION['user_id'])) {
        return 0;
    }

    $cart = new Cart();
    $cartItems = $cart->getCartItems($_SESSION['user_id']);
    $itemCount = 0;
    
    if($cartItems) {
        foreach($cartItems as $item) {
            $itemCount += $item->quantity;
        }
    }
    
    return $itemCount;
}
