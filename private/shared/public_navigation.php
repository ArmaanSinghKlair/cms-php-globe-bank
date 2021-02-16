<navigation>
  <?php $nav_subjects = find_all_subjects(['visible'=>$preview]);

  
  ?>
  <ul class="subjects">
    <?php while($nav_subject = mysqli_fetch_assoc($nav_subjects)) { ?>
      <li <?php if(isset($subject_id)&&$subject_id==$nav_subject['id']) echo "class='selected'"?>>
        <a href="<?php echo url_for('index.php?subject_id='.urlencode($nav_subject['id'])); ?>">
          <?php echo h($nav_subject['menu_name']); ?>
        </a>
        <?php list($page_set,$stmt) = get_pages_by_subject($nav_subject['id'],['visible'=>$preview]);
        ?>
        <ul class="pages">
        <?php while(isset($subject_id) && $nav_subject['id']==$subject_id && $nav_page = mysqli_fetch_assoc($page_set)) { ?>
            <li <?php if(isset($page_id)&&$page_id==$nav_page['id']) echo "class='selected'"?>>
              <a href="<?php echo url_for('index.php?id='.urlencode(h($nav_page['id']))); ?>" >
                <?php echo h($nav_page['menu_name']); ?>
              </a>
            </li>
          <?php } // while mysqli_fetch ?>
        </ul>
        <?php mysqli_stmt_close($stmt); ?>

      </li>
    <?php } // while $nav_subjects ?>
  </ul>
  <?php mysqli_free_result($nav_subjects); ?>
</navigation>
