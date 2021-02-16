<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php")?>
<?php
if(!isset($_GET['id']))
    redirect_302(WWW_ROOT."/staff/subjects");
$id = $_GET['id'];
$subject_count = get_subject_count()+1;
$errors = [];

if(is_post_request()){
    // Handle form values sent by new.php
    $subject = array();
    $subject['menu_name'] = $_POST['menu_name'] ?? '';
    $subject['position'] = $_POST['position'] ?? '';
    $subject['visible'] = $_POST['visible'] ?? '';

    $result = update_subject($subject, $id);

    if($result===true){
      $_SESSION['status'] = "Subject successfully edited";
      redirect_302(url_for("/staff/subjects/show.php?id=".urlencode($id)));
    }
    else{
      $errors = $result;
      //var_dump($errors);
    }
}  else{
  $subject = find_subject_by_id($id);

  }

?>
<?php $page_title = 'Edit Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject new">
    <h1>Edit Subject</h1>
    <?php echo display_errors($errors);?>
    <form action="<?php echo $_SERVER['PHP_SELF']."?id=".urlencode(h($id))?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo $subject['menu_name'] ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position" value="<?php echo $subject['position']?>">
            <?php for($i=0;$i<$subject_count;$i++){
              echo "<option value=\"{$i}\"";
              if($subject['position']==$i)
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
          <input type="checkbox" name="visible" value="1" <?php if($subject['visible']=="1") echo "checked";?>/>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Subject" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
