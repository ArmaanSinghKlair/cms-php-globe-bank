<?php
require_once('../../private/initialize.php');

logout_admin();
// or you could use
// $_SESSION['username'] = NULL;

redirect_302(url_for('/staff/login.php'));

?>
