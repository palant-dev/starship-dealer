<?php

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.category_title 
                         FROM products p 
                         LEFT JOIN categories c ON p.product_category_id = c.category_id 
                         ORDER BY p.product_id DESC');
        return $this->db->resultSet();
    }

    public function getFeaturedProducts() {
        $this->db->query('SELECT * FROM products WHERE product_featured = 1 ORDER BY product_id DESC');
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM products WHERE product_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getProductsByCategory($category_id) {
        $this->db->query('SELECT * FROM products WHERE product_category_id = :category_id ORDER BY product_id DESC');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    public function searchProducts($query, $category = 0, $sort = 'name_asc', $tag = null) {
        // making the basic SQL thing with category joined
        $sql = "SELECT p.*, c.category_title 
               FROM products p 
               LEFT JOIN categories c ON p.product_category_id = c.category_id 
               WHERE 1=1";
        $params = [];
        
        // add the search part if user typed something
        if (!empty($query)) {
            $queryTerm = trim($query);
            $sql .= " AND p.product_title LIKE :query";
            $params[':query'] = '%' . $queryTerm . '%';
        }
        
        // filter by category if they picked one
        if ($category > 0) {
            $sql .= " AND p.product_category_id = :category";
            $params[':category'] = $category;
        }
        
        // sort the results based on what they chose
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY p.product_price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY p.product_price DESC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY p.product_title DESC";
                break;
            case 'name_asc':
            default:
                $sql .= " ORDER BY p.product_title ASC";
                break;
        }

        error_log("Final SQL: " . $sql);
        error_log("Parameters: " . print_r($params, true));

        // show the category name for each product
        $sql = "SELECT p.*, c.category_title 
                FROM products p 
                LEFT JOIN categories c ON p.product_category_id = c.category_id 
                WHERE " . substr($sql, strpos($sql, 'WHERE') + 5);
                
        try {
            $this->db->query($sql);
            foreach ($params as $key => $value) {
                $this->db->bind($key, $value);
            }

            $results = $this->db->resultSet();
            
            // checking what we got back from MySQL
            error_log('Database returned ' . count($results) . ' results');
            if (count($results) > 0) {
                error_log('First result format: ' . (is_object($results[0]) ? 'OBJECT' : 'ARRAY'));
                error_log('First result data: ' . print_r($results[0], true));
            } else {
                error_log('NO RESULTS FOUND IN DATABASE - Check if products table has data');
            }
            
            $unique_tags = [];
            
            return [
                'products' => $results,
                'tags' => $unique_tags
            ];
        } catch (Exception $e) {
            error_log("Search error: " . $e->getMessage());
            return [
                'products' => [],
                'tags' => []
            ];
        }
    }

    public function getRelatedProducts($category_id, $current_product_id) {
        $this->db->query("SELECT p.*, c.category_title 
                         FROM products p 
                         JOIN categories c ON p.product_category_id = c.category_id 
                         WHERE p.product_category_id = :category_id 
                         AND p.product_id != :current_id 
                         ORDER BY p.product_id DESC 
                         LIMIT 4");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':current_id', $current_product_id);
        return $this->db->resultSet();
    }

    public function updateStock($product_id, $quantity) {
        $this->db->query("UPDATE products 
                         SET product_quantity = product_quantity - :quantity 
                         WHERE product_id = :id");
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':id', $product_id);
        return $this->db->execute();
    }

    public function toggleFeatured($product_id) {
        $this->db->query("UPDATE products 
                         SET product_featured = NOT product_featured 
                         WHERE product_id = :id");
        $this->db->bind(':id', $product_id);
        return $this->db->execute();
    }
} 