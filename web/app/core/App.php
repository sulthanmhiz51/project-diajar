<?php

class App
{

    /**
     * @var object|string The current controller instance or its name before instantiation.
     * At the point runMiddleware() is called, this should be an object.
     */

    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {

        spl_autoload_register(function ($class) {
            $class = explode('\\', $class);
            $class = end($class);

            if (file_exists('../app/core/' . $class . '.php')) {
                require_once '../app/core/' . $class . '.php';
            } elseif (file_exists('../app/controllers/' . $class . '.php')) {
                require_once '../app/controllers/' . $class . '.php';
            } elseif (file_exists('../app/models/' . $class . '.php')) {
                require_once '../app/models/' . $class . '.php';
            } elseif (file_exists('../app/middlewares/' . $class . '.php')) {
                require_once '../app/middlewares/' . $class . '.php';
            }
        });

        $url = $this->parseURL();

        //controller
        if ($url) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                ($this->controller = ucwords($url[0]));
                unset($url[0]);
            }
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        //method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // params
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        if (is_object($this->controller)) { // Check if it's an object before calling method
            $this->runMiddleware();
        } else {
            // Fallback if controller instantiation failed (e.g., class not found)
            error_log("Fatal Error: Could not instantiate controller '{$this->controller}'. Check class definition and file name casing.");
            // You might want to redirect to a 404 page or display a generic error
            // header('Location: ' . BASEURL . '/error/404'); // Example
            exit; // Stop execution
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    protected function runMiddleware()
    {
        $middlewares = $this->controller->getMiddleware();
        $currentMethod = $this->method; // Get the current method being executed

        foreach ($middlewares as $middlewareConfig) {
            $middlewareClass = '';
            $middlewareParams = [];
            $methodsToApply = []; // To store methods this middleware should apply to

            if (is_array($middlewareConfig)) {
                $middlewareClass = $middlewareConfig[0];
                // Check if a second element exists and is for methods (array or string)
                if (isset($middlewareConfig[1])) {
                    if (is_array($middlewareConfig[1])) {
                        $methodsToApply = $middlewareConfig[1];
                    } else {
                        // If it's a string, treat it as a single method name
                        $methodsToApply = [$middlewareConfig[1]];
                    }
                }
                // Any elements after the methods are considered constructor parameters
                $middlewareParams = array_slice($middlewareConfig, 2);
            } else {
                $middlewareClass = $middlewareConfig;
                // If it's a string, it applies to all methods in the controller by default
            }

            // --- Logic to decide if middleware should run for the current method ---
            $shouldRun = false;
            if (empty($methodsToApply)) {
                // If no specific methods are listed, run for all methods in the controller
                $shouldRun = true;
            } elseif (in_array($currentMethod, $methodsToApply)) {
                // Run only if the current method is in the specified list
                $shouldRun = true;
            }

            if ($shouldRun) {
                // Proceed to instantiate and execute middleware if it should run
                if (class_exists($middlewareClass) && in_array('Middleware', class_implements($middlewareClass))) {
                    $reflector = new ReflectionClass($middlewareClass);
                    $middlewareInstance = $reflector->newInstanceArgs($middlewareParams);

                    if (!$middlewareInstance->handle($this->params)) {
                        exit; // Middleware stopped the request
                    }
                } else {
                    error_log("Error: Middleware class '{$middlewareClass}' not found or does not implement Middleware interface. Please check your controller's \$middleware array.");
                }
            }
        }
    }
}
