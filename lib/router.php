<?php
require_once('config.php');

class Request {
    public $output = "";
    public $status_code = 200;
    public $reqs = [];
    public $err = "";

    function __construct(){
        /* json input */
        if (isset($_SERVER['CONTENT_TYPE']) && explode(';', $_SERVER['CONTENT_TYPE'])[0] == 'application/json'){
            try{
                $this->reqs = json_decode(file_get_contents('php://input'), true);
            } catch (Exception $e){
                $this->err == "Invalid JSON body";
            }
            return;
        }
    }
    /* set output */
    function out($value){
        $this->output = $value;
    }

    /* append to output for later use */
    function append($value){
        $this->output .= $value;
    }

    /* send custom data ingoring $output */
    function send($out_=""){
        if ($this->status_code != 200) http_response_code($this->status_code);
        die($out_ == "" ? $this->output : $out_);
    }

    /* set/get satuts code */
    function status($code = -1){
        if ($code == -1) return $this->status_code; /* get */
        else $this->status_code = $code;            /* set */
    }

    /* error output */
    function error($msg = "Something went wrong", $code = -1){
        if ($code != -1) $this->status($code);
        header('Content-type: application/json');
        die(json_encode([ "status" => false, "message" => $msg ]));
    }

    /* success output */
    function success($data){
        header('Content-type: application/json');
        $data["status"] = true;
        die(json_encode($data));
    }

    /* getters */
    function req($field, $escape_html = true){
        if (!isset($this->reqs[$field])) $this->error("Missing JSON field '$field'");
        if ($escape_html) return htmlspecialchars($this->reqs[$field]);
        return $this->reqs[$field];
    }

    function get($field, $escape_html = true){
        if (!isset($_GET[$field])) $this->error("Missing GET field '$field'");
        if ($escape_html) return htmlspecialchars($_GET[$field]);
        return $_GET[$field];
    }

    function post($field, $escape_html = true){
        if (!isset($_POST[$field])) $this->error("Missing POST field '$field'");
        if ($escape_html) return htmlspecialchars($_POST[$field]);
        return $_POST[$field];
    }

    function files($name){
        if (!isset($_FILES[$name])) $this->error("Missing file '$name'");
        return $_FILES[$name];
    }

    function cookie($name){
        if (!isset($_COOKIE[$name])) $this->error("Missing cookie '$name'");
        return $_COOKIE[$name];
    }

    /* checkers */
    function has_post($fields){
        foreach($fields as $field)
            if (!isset($this->post[$field])) return false;
        
        return true;
    }

    function has_get($fields){
        foreach($fields as $field)
            if (!isset($this->get[$field])) return false;
        
        return true;
    }

    function has_files($fields){
        foreach($fields as $field)
            if (!isset($this->files[$field])) return false;
    
        return true;
    }

    function has_req($fields){
        foreach($fields as $field)
            if (!isset($this->req[$field])) return false;

        return true;
    }

    function has_cookie($cookies){
        foreach($cookies as $cookie)
            if (!isset($this->cookies[$cookie])) return false;

        return true;
    }
}

function route($routes, $base_prefix = ""){
    $route_points = array_keys($routes);
    /* request uri */
    $req_uri = '/'.trim(preg_replace('/'.preg_quote(BASE_URI.$base_prefix, '/').'/', '', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), 1), '/');
    if (!in_array($req_uri, $route_points)) return false;

    /* route */
    $rout = $routes[$req_uri];
    $rout_parts = explode('/',$rout[0]);
    $func_name = array_pop($rout_parts);
    $func_path = implode('/', $rout_parts);

    if ($func_path != "" && file_exists($func_path.".php")) include_once($func_path.".php");
    if (!function_exists($func_name)) return false;

    $req = new Request();
    if ($req->err != "") $res->error("Invalid JSON", 400);

    $out = call_user_func($func_name, $req);

    /* incase the function did not use res to respond
       the return value is send as output */
    if ($out != null) die($out);
}

?>