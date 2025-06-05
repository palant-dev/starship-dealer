<?php

class Category {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        // only unique categories by title, using the lowest ID when there are duplicates
        $this->db->query('SELECT MIN(category_id) as category_id, category_title 
                         FROM categories 
                         GROUP BY category_title 
                         ORDER BY category_title ASC');
        return $this->db->resultSet();
    }

    public function getCategoryById($id) {
        // first try to get the exact category
        $this->db->query('SELECT * FROM categories WHERE category_id = :id');
        $this->db->bind(':id', $id);
        $category = $this->db->single();

        if (!$category) {
            return null;
        }

        // if this is a duplicate category (higher ID), redirect to the main one
        $this->db->query('SELECT MIN(category_id) as main_id 
                         FROM categories 
                         WHERE category_title = :title');
        $this->db->bind(':title', $category->category_title);
        $main = $this->db->single();

        if ($main && $main->main_id != $id) {
            // This is a duplicate, get the main category
            $this->db->query('SELECT * FROM categories WHERE category_id = :id');
            $this->db->bind(':id', $main->main_id);
            return $this->db->single();
        }

        return $category;
    }

    public function addCategory($data) {
        $this->db->query("INSERT INTO categories (category_title) VALUES (:title)");
        $this->db->bind(':title', $data['category_title']);
        return $this->db->execute();
    }

    public function updateCategory($data) {
        $this->db->query("UPDATE categories 
                         SET category_title = :title 
                         WHERE category_id = :id");
        $this->db->bind(':title', $data['category_title']);
        $this->db->bind(':id', $data['category_id']);
        return $this->db->execute();
    }

    public function deleteCategory($id) {
        $this->db->query("DELETE FROM categories WHERE category_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
} 