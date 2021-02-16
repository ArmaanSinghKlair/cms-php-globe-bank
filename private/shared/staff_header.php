<?php if(empty($page_title)) $page_title="Globe Bank Page"; ?>
<!doctype html>

<html lang="en">
  <head>
    <title><?php echo $page_title ?></title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo url_for("/stylesheets/staff.css");?>"/>
  </head>

  <body>
    <div class="main-container">

      <header>
       <h1>GBI Staff Area</h1>
      </header>
        <?php $status = $_SESSION['status'] ?? '';
        if(strlen(trim($status)) > 0){
          echo "<div class='status'>{$status}</div>";
        }
        unset($_SESSION['status']);
        ?>
        <nav>
          <ul class="sidebar-navigation-links-container">
            <li>User: <?php echo $_SESSION['username']??''?></li>
            <li><a href=<?php echo url_for("/staff") ?> class="current-page">Menu</a></li>
            <li><a href="<?php echo WWW_ROOT."/staff/logout.php"?>">Logout</a></li>
          </ul>
        </nav>