<?php
    ob_start(); // start output buffering
    session_start();    //turn on sessions

    define("PRIVATE_PATH",__DIR__);
    define("PROJECT_PATH",dirname(PRIVATE_PATH,1));
    define("SHARED_PATH",PRIVATE_PATH."/shared");
    define("PUBLIC_PATH",PROJECT_PATH."/public");

    $public = substr($_SERVER["PHP_SELF"],0,strpos($_SERVER["PHP_SELF"],"/public")+7);
    define("WWW_ROOT",$public);
    
    require_once("functions.php");
    require_once("database.php");
    require_once("query_functions.php");
    require_once("validation_functions.php");
    require_once("auth_functions.php");
    $db = db_connect();
?>
