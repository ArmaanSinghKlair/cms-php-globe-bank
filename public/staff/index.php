<?php require_once("../../private/initialize.php"); ?>
<?php require_login(); ?>
<?php require_once(PRIVATE_PATH."/functions.php"); ?>
<?php $page_title="Staff Menu"; ?>
<?php require_once(SHARED_PATH."/staff_header.php"); ?>
<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li><a href="<?php echo url_for("/staff/subjects/index.php")?>">Subjects</a></li>
      <li><a href="<?php echo url_for("/staff/admins/index.php")?>">Admins</a></li>

    </ul>
  </div>
</div>
<?php require_once(SHARED_PATH."/staff_footer.php"); ?>
