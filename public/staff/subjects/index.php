<?php require_once("../../../private/initialize.php"); ?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php");?>
<?php
  
  $subject_set = find_all_subjects();
  
?>

<?php $page_title="Subjects"; ?>
<?php require_once(SHARED_PATH."/staff_header.php"); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for("/staff/subjects/new.php")?>">Create New Subject</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
  	    <th>Name</th>
        <th>Pages</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($subject = mysqli_fetch_assoc($subject_set)) { ?>
        <tr>
          <td><?php echo $subject['id']; ?></td>
          <td><?php echo $subject['position']; ?></td>
          <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo $subject['menu_name']; ?></td>
          <td><?php echo find_page_count_by_subject_id($subject['id'])?></td>
          <td><a class="action" href="<?php echo url_for("/staff/subjects/show.php?id=".urlencode(h($subject['id'])))?>">View</a></td>
          <td><a class="action" href="<?php echo url_for("/staff/subjects/edit.php?id=".urlencode(h($subject['id'])))?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for("/staff/subjects/delete.php?id=".urlencode(h($subject['id'])))?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>
    <?php mysqli_free_result($subject_set);?>

  </div>

</div>
<?php require_once(SHARED_PATH."/staff_footer.php"); ?>

