<?php require_once("../../../private/initialize.php");?>
<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php require_login(); ?>

<?php $page_title= "Admin Add"; 
include(SHARED_PATH."/staff_header.php");
?>
<?php
    
    
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $admin['username'] = $_POST['username'] ?? '' ;
        $admin['password'] = $_POST['password'] ?? '';
        $admin['confirm_password'] = $_POST['confirm_password'] ?? '';
        $admin['email'] = $_POST['email'] ?? '';
        $admin['first_name'] = $_POST['first_name'] ?? '';
        $admin['last_name'] = $_POST['last_name'] ?? '';
        $result = insert_admin($admin);
        if($result === true){
            $_SESSION['status'] = "Admininstrator added successfully";
            redirect_302(url_for("/staff/admins/show.php?id=".urlencode(mysqli_insert_id($db))));
        } elseif($result === false){
            $errors = ['Unknown error occured, please try again'];
        } else{
            $errors = $result;
        }
    } else{
    $admin= ['username'=>'','first_name'=>'','last_name'=>'','email'=>''];
    $errors = [];
    }
?>
<div id="content">
    <h1>Add Administrator</h1>
    <?php echo display_errors($errors)?>

    <form action="<?php echo WWW_ROOT."/staff/admins/new.php"?>" method="post">
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
        <input type="submit" value="Add Admin"/>
</form>
</div>

<?php
include(SHARED_PATH."/staff_footer.php");
?>