<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php")?>
<?php if(!isset($_GET['id'])){
    redirect_302(url_for("/staff/subjects/"));
} 

$id = $_GET['id'];
$subject = find_subject_by_id($id);
if(is_post_request()){
    if(delete_subject($id)){
      $_SESSION['status'] = "Subject successfully deleted";
        redirect_302(url_for("/staff/subjects/index.php"));
    }
}else{
    $subject = find_subject_by_id($id);
}
    ?>

<?php $page_title = 'Delete Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject delete">
    <h1>Delete Subject</h1>
    <p>Are you sure you want to delete this subject?</p>
    <p class="item"><?php echo h($subject['menu_name']); ?></p>

    <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(urlencode($subject['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
