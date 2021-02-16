<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php")?>
<?php
$errors = [];
$page = [];
$page_count = 1;
if(is_post_request()){
    $page['menu_name'] = $_POST['menu_name'] ?? '';
    $page['position'] = $_POST['position'] ?? '';
    $page['visible'] = $_POST['visible'] ?? 0;
    $page['content'] = $_POST['content'] ?? '';
    $page['subject_id'] = $_POST['subject_id'] ?? 1;
    $result = create_new_page($page);
    if($result === true){
      $_SESSION['status'] = "Page successfully added";
      redirect_302(url_for("/staff/pages/show.php?id=".urlencode(h(mysqli_insert_id($db)))));
    } else{
      $errors = $result;
    }
}else{
  $page['subject_id'] = $_GET['subject_id'] ?? 1;
} 
$page_count = find_page_count_by_subject_id($page['subject_id']);
$subject_set = find_all_subjects();
  
?>


<?php $page_title = 'Create New Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

<a href="<?php echo url_for('/staff/subjects/show.php?id='.urlencode($page['subject_id']))?>" class="back-link">&laquo; Back to Subject</a>

  <div class="page new">
    <h1>Create Page</h1>
    <?php echo display_errors($errors)?>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo $page['menu_name'] ?? ''?>"/></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position" >
            <?php
            for($i=1;$i<=$page_count;$i++){
              echo "<option value={$i}";
              if(isset($page['position']) && $page['position'] == $i)
                echo " selected ";
              echo ">{$i}</option>";
            }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id" >
            <?php
            while($subject = mysqli_fetch_assoc($subject_set)){
              echo "<option value=".$subject['id'];
              if(isset($page['subject_id']) && $page['subject_id'] == $subject['id'])
                echo " selected "; 
              echo ">".$subject['menu_name']."</option>";
            }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php if(isset($page['visible']) && $page['visible'] == 1) echo "checked"?>/>
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content"><?php if(isset($page['content'])) echo $page['content']?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
