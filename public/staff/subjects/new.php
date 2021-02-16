<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php")?>
<?php 
$errors = [];
if(is_post_request()){
  // Handle form values sent by new.php
  $subject = [];
  $subject['menu_name'] = $_POST['menu_name'] ?? '';
  $subject['position'] = $_POST['position'] ?? '';
  $subject['visible'] = $_POST['visible'] ?? '';
  $result = create_new_subject($subject);
  if($result===true){
    $_SESSION['status'] = "Subject successfully added";
    $new_id = mysqli_insert_id($db);
      redirect_302(url_for("/staff/subjects/show.php?id=".urlencode($new_id)));
  } else{
    $errors = $result;
  }
}
?>
<?php $page_title = 'Create Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php $subject_count=get_subject_count()+1;?>
<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject new">
    <h1>Create Subject</h1>
    <?php echo display_errors($errors);?>
    <form action="<?php echo url_for("/staff/subjects/new.php")?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
              <?php for($i=0;$i<$subject_count;$i++){
              echo "<option value=\"{$i}\"";
              if($i==1)
                echo "selected";
              echo "> {$i} </option>";
             } ?>            
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Subject" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
