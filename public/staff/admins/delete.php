<?php require_once("../../../private/initialize.php");?>
<?php require_login(); ?>
<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php $page_title= "Admin Delete"; 
include(SHARED_PATH."/staff_header.php");
?>
<?php
    
    if(!(isset($_GET['id']) && strlen(trim($_GET['id']))) > 0)
        redirect_302(url_for("/staff/admins/index.php"));
    $id = $_GET['id'];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $result = delete_admin($id);
        if($result){
            $_SESSION['status'] = "Administrator deleted successfully";
            redirect_302(url_for("/staff/admins/index.php"));
        }
    } else{
        $admin = mysqli_fetch_assoc(find_admin_by_id($id));
    }
    
?>
<div id="content">
    <h4><a href="<?php echo url_for("/staff/admins")?>">&larr; Back to listing</a></h4>
    <div class="admins delete">
    <h1>Delete Administrator</h1>
    <p>Are you sure you want to delete this administrator?</p>
    <p class="item"><?php echo h($admin['username']); ?></p>

    <form action="<?php echo url_for('/staff/admins/delete.php?id=' . h(urlencode($admin['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Admin" />
      </div>
    </form>
  </div>
           
</div>

<?php
include(SHARED_PATH."/staff_footer.php");
?>