<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php")?>
<?php if(!isset($_GET['id'])){
    redirect_302(url_for("/staff/pages/"));
} 
$page = find_page_by_id($id);

$id = $_GET['id'];
if(is_post_request()){
    if(delete_page($id)){
      $_SESSION['status'] = "Page successfully deleted";
        redirect_302(url_for("/staff/subject/show.php?id=".h(urlencode($page['subject_id']))));
    }
}
    ?>

<?php $page_title = 'Delete Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

<a href="<?php echo url_for('/staff/subjects/show.php?id='.urlencode($page['subject_id']))?>" class="back-link">&laquo; Back to Subject</a>

  <div class="page delete">
    <h1>Delete Page</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo h($page['menu_name']); ?></p>

    <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(urlencode($page['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Subject" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
