<?php

class Model {
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    // functions that all the models can use for database
    public function find($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function findAll() {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    public function create($data) {
        $fields = array_keys($data);
        $values = array_map(function($field) { return ":{$field}"; }, $fields);
        
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                VALUES (" . implode(', ', $values) . ")";
        
        $this->db->query($sql);
        
        foreach($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        return $this->db->execute();
    }

    public function update($id, $data) {
        $fields = array_keys($data);
        $set = array_map(function($field) { return "{$field} = :{$field}"; }, $fields);
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $set) . " WHERE id = :id";
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        
        foreach($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
} 