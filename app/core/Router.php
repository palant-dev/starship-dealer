<?php

class Router {
    private $routes = [];
    private $params = [];

    public function get($route, $controller) {
        $this->routes['GET'][$route] = $controller;
    }

    public function post($route, $controller) {
        $this->routes['POST'][$route] = $controller;
    }

    public function dispatch() {
        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD'];
        
        // cut off the base path stuff so URLs work
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && $basePath !== '\\') {
            $url = substr($url, strlen($basePath));
        }
        
        $url = '/' . ltrim(rtrim($url, '/'), '/');
        
        error_log("Requested URL: " . $url);
        error_log("Available routes: " . print_r($this->routes[$method], true));
        
        // first check if the URL matches exactly
        if (isset($this->routes[$method][$url])) {
            $controller = $this->routes[$method][$url];
            $this->executeController($controller);
            return;
        }
        
        // if that didn't work try the routes with {vars} in them
        foreach ($this->routes[$method] as $route => $controller) {
            $route = '/' . ltrim($route, '/');
            if ($this->matchRoute($route, $url)) {
                $this->executeController($controller);
                return;
            }
        }
        
        // couldn't find any matching route
        header("HTTP/1.0 404 Not Found");
        require_once APPROOT . '/views/error/404.php';
    }

    private function getUrl() {
        $url = $_SERVER['REQUEST_URI'];
        $url = strtok($url, '?');
        return $url;
    }

    private function matchRoute($route, $url) {
        // change {id} to regex
        $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<\1>[0-9]+)', $route);
        $pattern = "#^" . $pattern . "$#";
        
        error_log("Matching route: " . $route . " against URL: " . $url);
        error_log("Pattern: " . $pattern);
        
        if (preg_match($pattern, $url, $matches)) {
            // keep only the named params and throw away the other params
            $this->params = array_filter($matches, function($key) {
                return !is_numeric($key);
            }, ARRAY_FILTER_USE_KEY);
            
            error_log("Route matched. Params: " . print_r($this->params, true));
            return true;
        }
        return false;
    }

    private function executeController($controller) {
        list($controllerName, $method) = explode('@', $controller);
        $controllerFile = APPROOT . "/controllers/{$controllerName}.php";
        
        error_log("Loading controller: " . $controllerFile);
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerInstance = new $controllerName();
            call_user_func_array([$controllerInstance, $method], $this->params);
        } else {
            throw new Exception("Controller not found: $controllerName");
        }
    }
} 