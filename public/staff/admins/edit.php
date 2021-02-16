<?php require_once("../../../private/initialize.php");?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php $page_title= "Admin Edit"; 
include(SHARED_PATH."/staff_header.php");
?>
<?php
    
    if(!(isset($_GET['id']) && strlen(trim($_GET['id']))) > 0)
        redirect_302(url_for("/staff/admins/index.php"));
    $id = $_GET['id'];
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $admin['username'] = $_POST['username'] ?? '' ;
        $admin['password'] = $_POST['password'] ?? '';
        $admin['confirm_password'] = $_POST['confirm_password'] ?? '';
        $admin['email'] = $_POST['email'] ?? '';
        $admin['first_name'] = $_POST['first_name'] ?? '';
        $admin['last_name'] = $_POST['last_name'] ?? '';
        $admin['id']= $id;
        $result = update_admin($admin);
        if($result === true){
            $_SESSION['status'] = "Admininstrator updated successfully";
            redirect_302(url_for("/staff/admins/show.php?id=".urlencode($id)));
        } elseif($result === false){
            $errors = ['Unknown error occured, please try again'];
        } else{
            $errors = $result;
        }
    } else{
    $admin = mysqli_fetch_assoc(find_admin_by_id($id));
    $errors = [];
    }
?>
<div id="content">
    <h1>Edit Administrator</h1>
    <h4><a href="<?php echo url_for("/staff/admins")?>">&larr; Back to listing</a></h4>

    <?php echo display_errors($errors)?>

    <form action="<?php echo WWW_ROOT."/staff/admins/edit.php?id=".urlencode($id)?>" method="post">
        <label for="username">
            Username
            <input type="text"name="username" value="<?php echo $admin['username']?>" id="username"/>
        </label>
        <label for="password">
            Password
            <input type="password"name="password"  id="password"/>
        </label>
        <label for="confirm_password">
            Confirm Password
            <input type="password"name="confirm_password"  id="confirm_password"/>
        </label>
        <label for="email">
            Email
            <input type="text"name="email" value="<?php echo $admin['email']?>" id="email"/>
        </label>
        <label for="first_name">
            First Name
            <input type="text"name="first_name" value="<?php echo $admin['first_name']?>" id="first_name"/>
        </label>
        <label for="last_name">
            Last Name
            <input type="text"name="last_name" value="<?php echo $admin['last_name']?>" id="last_name"/>
        </label>
        <input type="submit" value="Edit Admin"/>
</form>
</div>

<?php
include(SHARED_PATH."/staff_footer.php");
?>