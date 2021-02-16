<?php require_once("../../../private/initialize.php");?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php $page_title= "Admin Info"; 
include(SHARED_PATH."/staff_header.php");
?>
<?php
    
    if(!(isset($_GET['id']) && strlen(trim($_GET['id']))) > 0)
        redirect_302(url_for("/staff/admins/index.php"));
    $id = $_GET['id'];
    $admin = mysqli_fetch_assoc(find_admin_by_id($id));
    
?>
<div id="content">
    <h1>Administrator info</h1>
    <h4><a href="<?php echo url_for("/staff/admins")?>">&larr; Back to listing</a></h4>
    <ul>
        <li>Username: <?php echo $admin['username']?></li>
        <li>Email: <?php echo $admin['email']?></li>
        <li>First name: <?php echo $admin['first_name']?></li>
        <li>Last name: <?php echo $admin['last_name']?></li>

    </ul>
           
</div>

<?php
include(SHARED_PATH."/staff_footer.php");
?>