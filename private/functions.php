<?php
function url_for($url_path){
    if($url_path[0] != "/")
        $url_path = "/".$url_path;
    return WWW_ROOT.$url_path;
}
function h($string=""){
    return htmlspecialchars($string, ENT_QUOTES|ENT_HTML5,"UTF-8");
}

function error_404(){
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
    exit();
}

function error_500(){
    header($_SERVER["SERVER_PROTOCOL"]." 502 Internal Server Error bitch");
    exit();
}

function redirect_302($location){
    header("Location: {$location}");
    exit();
}

function is_post_request(){
    return $_SERVER['REQUEST_METHOD'] == "POST";
}

function is_get_request(){
    return $_SERVER['REQUEST_METHOD'] == "GET";
}

function display_errors($errors){
    $output = '';
    if(!empty($errors)){
        $output .= "<div class=\"errors\">";
        $output .= "Errors to be fixed";
        $output .= "<ul>";
        foreach($errors as $error){
            $output .= "<li>".h($error)."</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}




?>
