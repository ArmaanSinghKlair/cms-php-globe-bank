<?php require_once("../private/initialize.php");?>
<?php
$preview = true;
if(isset($_GET['preview']) && $_GET['preview']==true && is_logged_in()){
  $preview = null;
}
if(isset($_GET['id'])){
  $page_id = $_GET['id'];
  $page = find_page_by_id($page_id,['visible'=>$preview]);
  if(!$page)
    redirect_302(url_for("/index.php"));
    $subject_id = $page['subject_id'];
  
} elseif(isset($_GET['subject_id'])){
  $subject_id = $_GET['subject_id'];
  $subject = find_subject_by_id($subject_id,['visible'=>$preview]);
  if(!$subject)
    redirect_302(url_for("/index.php"));

  list($pageset,$stmt) = get_pages_by_subject($subject_id,['visible'=>$preview]);
  $page = mysqli_fetch_assoc($pageset);
  $page_id = $page['id'];
  mysqli_stmt_close($stmt);
  
}
?>
<?php require_once(SHARED_PATH.'./public_header.php')?>

<div id="main">
<?php include(SHARED_PATH.'/public_navigation.php')?>

  <div id="page">
  <?php
  
  if(isset($page_id)){
    // TODO add html escaping
    $allowed_tags = '<div><img><h1><h2><p><br><strong><ul><li><em>';
    echo strip_tags($page['content'],$allowed_tags);
  }
  else
    include(SHARED_PATH.'/static_homepage.php');
  ?>
  </div>
</div>
<?php require_once(SHARED_PATH.'./public_footer.php')?>