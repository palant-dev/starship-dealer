<?php

class Order extends Model {
    protected $table = 'orders';

    public function createOrder($user_id, $total_amount) {
        $this->db->query("INSERT INTO {$this->table} (user_id, order_amount, order_date) 
                         VALUES (:user_id, :total_amount, NOW())");
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':total_amount', $total_amount);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function addOrderItems($order_id, $items) {
        foreach($items as $item) {
            $this->db->query("INSERT INTO order_items (order_id, product_id, product_price, quantity) 
                             VALUES (:order_id, :product_id, :product_price, :quantity)");
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':product_id', $item['product_id']);
            $this->db->bind(':product_price', $item['product_price']);
            $this->db->bind(':quantity', $item['quantity']);
            
            if(!$this->db->execute()) {
                return false;
            }
        }
        return true;
    }

    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $this->db->query("INSERT INTO order_items (order_id, product_id, product_price, quantity) 
                         VALUES (:order_id, :product_id, :price, :quantity)");
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':product_id', $product_id);
        $this->db->bind(':price', $price);
        $this->db->bind(':quantity', $quantity);
        
        return $this->db->execute();
    }

    public function getOrderById($order_id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    public function getOrderItems($order_id) {
        $this->db->query("SELECT oi.*, p.product_title, p.product_image 
                         FROM order_items oi 
                         JOIN products p ON oi.product_id = p.product_id 
                         WHERE oi.order_id = :order_id");
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }

    public function getUserOrders($user_id) {
        $this->db->query("SELECT * FROM {$this->table} 
                         WHERE user_id = :user_id 
                         ORDER BY order_date DESC");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
} 