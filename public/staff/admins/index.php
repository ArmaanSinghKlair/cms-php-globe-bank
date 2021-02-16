<?php require_once("../../../private/initialize.php");?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php $page_title= "Admin Dashboard"; 
include(SHARED_PATH."/staff_header.php");
?>
<?php 
    $admin_set = find_all_admins();
?>
<div id="content">
    <h1>Administrators</h1>
    <h4><a href="<?php echo url_for("/staff/admins/new.php")?>">Create new admin</a></h4>
    <table class="list">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>View</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
            while($admin = mysqli_fetch_assoc($admin_set)){
                echo "<tr><td>".h($admin['id'])."</td>";
                echo "<td>".h($admin['username'])."</td>";
                echo "<td>".h($admin['email'])."</td>";
                echo "<td>".h($admin['first_name']).h($admin['last_name'])."</td>";
                echo "<td><a href='".WWW_ROOT."/staff/admins/show.php?id=".urlencode($admin['id'])."'>View</a></td>";
                echo "<td><a href='".WWW_ROOT."/staff/admins/edit.php?id=".urlencode($admin['id'])."'>Edit</a></td>";
                echo "<td><a href='".WWW_ROOT."/staff/admins/delete.php?id=".urlencode($admin['id'])."''>Delete</a></td>";

            }        
        ?>
    </table>
</div>

<?php
include(SHARED_PATH."/staff_footer.php");
?>