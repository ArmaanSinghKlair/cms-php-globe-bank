<?php

  // Performs all actions necessary to log in an admin
  function log_in_admin($admin) {
  // Renerating the ID protects the admin from session fixation.
    session_regenerate_id();
    $_SESSION['status'] = "Login successful";
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];

    return true;
  }
  
  function is_logged_in(){
    return isset($_SESSION['admin_id']);
  }

  function require_login(){
    if(!is_logged_in()){
      $_SESSION['status'] = "You must be logged in to access that page";
      redirect_302(url_for("/staff/login.php"));
    }
  }

  function logout_admin(){
    unset($_SESSION['admin_id']);
    unset($_SESSION['last_login']);
    unset($_SESSION['username']);

  }

?>
