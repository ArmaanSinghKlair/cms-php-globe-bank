<?php require_once("../../../private/initialize.php")?>
<?php require_login(); ?>

<?php require_once(PRIVATE_PATH."/functions.php"); ?>
<?php 
$id = $_GET['id']?? 1;
$page_title = "Page-{$id}";
$page = [];
$sql = "SELECT * FROM pages where";
$sql .= " id = '".$id."' LIMIT 1";
$result = mysqli_query($db, $sql);
if(!$result){
    echo mysqli_error($db);
    db_disconnect($db);
} else{
    if(!($page = mysqli_fetch_assoc($result))){
        echo "Couldn't find requested record.";
        exit;
    }
    mysqli_free_result($result);
}
?>
<?php require_once(SHARED_PATH."/staff_header.php");?>

<div id="content">
    <a href="<?php echo url_for('/staff/subjects/show.php?id='.urlencode($page['subject_id']))?>" class="back-link">&laquo; Back to Subject</a>
    <div class="preview">
        <a href="<?php echo WWW_ROOT."/index.php?id=".urlencode(h($id))."&preview=true"?>">Preview</a>
    </div>
    <div class="page-show">
    
    <h1>Page: <?php echo h($page['menu_name']); ?></h1>   

    <div class="attributes">
    <dl>
        <dt>Menu Name</dt>
        <dd><?php echo h($page['menu_name']); ?></dd>
    </dl>
    <dl>
        <dt>Subject Name</dt>
        <dd><?php echo find_subject_by_id($page['subject_id'])['menu_name']?></dd>
    </dl>
    <dl>
        <dt>Position</dt>
        <dd><?php echo h($page['position']); ?></dd>
    </dl>
    <dl>
        <dt>Visible</dt>
        <dd><?php echo $page['visible'] == '1' ? 'true' : 'false'; ?></dd>
    </dl>
    <dl>
        <dt>Content</dt>
        <dd><?php echo htmlentities($page['content'])?></dd>
    </dl>
    </div>
    </div>

</div>
<?php require_once(SHARED_PATH."/staff_footer.php");?>

