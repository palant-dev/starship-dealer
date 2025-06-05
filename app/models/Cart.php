<?php

class Cart extends Model {
    protected $table = 'cart';

    public function getCartItems($user_id) {
        $this->db->query("SELECT c.*, p.product_title as name, p.product_price as price, p.product_image as image 
                         FROM {$this->table} c 
                         JOIN products p ON c.product_id = p.product_id 
                         WHERE c.user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addToCart($user_id, $product_id, $quantity) {
        // see if they already added this product before
        $this->db->query("SELECT * FROM {$this->table} 
                         WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        $existing_item = $this->db->single();

        if($existing_item) {
            // just add more of the same product
            $this->db->query("UPDATE {$this->table} 
                             SET quantity = quantity + :quantity 
                             WHERE user_id = :user_id AND product_id = :product_id");
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':product_id', $product_id);
        } else {
            // this is a new thing they're adding
            $this->db->query("INSERT INTO {$this->table} (user_id, product_id, quantity) 
                             VALUES (:user_id, :product_id, :quantity)");
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':product_id', $product_id);
            $this->db->bind(':quantity', $quantity);
        }
        
        return $this->db->execute();
    }

    public function updateQuantity($user_id, $product_id, $quantity) {
        $this->db->query("UPDATE {$this->table} 
                         SET quantity = :quantity 
                         WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
    }

    public function removeFromCart($user_id, $product_id) {
        $this->db->query("DELETE FROM {$this->table} 
                         WHERE user_id = :user_id AND product_id = :product_id");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
    }

    public function clearCart($user_id) {
        $this->db->query("DELETE FROM {$this->table} WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function getCartTotal($user_id) {
        $this->db->query("SELECT SUM(ci.quantity * p.product_price) as total 
                         FROM {$this->table} ci 
                         JOIN products p ON ci.product_id = p.product_id 
                         WHERE ci.user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result ? $result->total : 0;
    }
} 