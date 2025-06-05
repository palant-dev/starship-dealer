<?php

class Controller {
    // this function gets models so we can use them
    public function model($model) {
        $modelFile = APP_PATH . "/models/{$model}.php";
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        } else {
            throw new Exception("Model not found: $model");
        }
    }

    // this loads the page template
    public function view($view, $data = []) {
        // this magic function turns array keys into real variables
        extract($data);
        
        // find and load the actual php file
        $viewFile = APP_PATH . "/views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("View not found: $view");
        }
    }

    public function redirect($page) {
        header('location: ' . URLROOT . '/' . $page);
    }

    // saves a message to show on the next page
    public function setMessage($message, $type = 'info') {
        $_SESSION['flash_message'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    // gets the message we saved and deletes it
    public function getMessage() {
        if(isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        }
        return null;
    }
} 