<?php

class User extends Model {
    protected $table = 'users';

    public function register($data) {
        $this->db->query("INSERT INTO {$this->table} (username, email, password) 
                         VALUES (:username, :email, :password)");
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        $result = $this->db->execute();
        error_log('Registration result: ' . ($result ? 'success' : 'failed'));
        return $result;
    }

    public function login($email, $password) {
        $this->db->query("SELECT * FROM {$this->table} WHERE email = :email AND password = :password");
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $password);

        $row = $this->db->single();
        return $row ? $row : false;
    }

    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM {$this->table} WHERE email = :email");
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        return $row;
    }

    public function findUserByUsername($username) {
        $this->db->query("SELECT * FROM {$this->table} WHERE username = :username");
        $this->db->bind(':username', $username);

        $row = $this->db->single();
        return $row;
    }

    public function getUserById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :id");
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function updateProfile($data) {
        $this->db->query("UPDATE {$this->table} 
                         SET first_name = :first_name, 
                             last_name = :last_name, 
                             email = :email 
                         WHERE user_id = :id");
        
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':id', $data['id']);

        return $this->db->execute();
    }

    public function updatePassword($user_id, $new_password) {
        $this->db->query("UPDATE {$this->table} 
                         SET password = :password 
                         WHERE user_id = :id");
        
        $this->db->bind(':password', $new_password);
        $this->db->bind(':id', $user_id);

        return $this->db->execute();
    }
} 