<?php

namespace App\Controllers;

class BaseController {

    protected $viewPath = '';
    protected $method = 'index';
    protected $viewParams = [];
    
    public function __construct(){
        if ( ! $this->viewPath ) { 
            $classname = get_called_class();
            $this->viewPath = str_replace("Controller", '', str_replace("App\\Controllers\\", '', $classname ));
        };
    }

    public static function __callStatic ($method, $arg) {
        $obj = new static;
        $result = call_user_func_array (array ($obj, $method), $arg);
        if (method_exists ($obj, $method))
            return $result;
        return $obj;
    }
    private function loadView($view = '', $params = [], $layout = 'main') {
        // Make variables available in the view
        extract($params);
    
        // Determine if a specific view file is provided or default to `index.php`
        $viewPath = strpos($view, '/') !== false ? $view : "$view/index";
    
        // Load the view content
        ob_start();
        include BASE_DIR . "/views/$viewPath.php";
        $content = ob_get_contents();
        ob_end_clean();
    
        // Load the layout
        $layoutFile = BASE_DIR . "/views/_layout/$layout.php";
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            echo $content;
        }
    }
    

    protected static function redirect($url, $code = 302) {
        // Ensure the URL is absolute
        $fullUrl = strpos($url, '/') === 0 ? $url : '/' . $url;
        header("Location: " . $fullUrl, true, $code);
        exit();
    }
    
    
}