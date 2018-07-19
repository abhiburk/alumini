<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Ask <?php include 'includes/title.php'; ?></title>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>

<body>
<?php include 'includes/header.php'; ?>
<div class="container">
	<div class="total-info">
	<?php include 'includes/left_panel.php'; ?>
    
    <div class="col-md-5 grid_2">
    	<!--From-->
        <form method="post">
            <input type="text" name="tittle" class="form-control" placeholder="Question Tittle">
            <input type="hidden" name="xAction" value="ask_question">
            <textarea name="description" id="editor1" rows="10" cols="80" required /></textarea>
            <script> CKEDITOR.replace( 'description' );</script>	<br>
            <select data-placeholder="Tags" name="ftagID[]"  class="form-control chzn-select" multiple="multiple" tabindex="4" style="height:25px;">
            <?php 
			$sql_tags=mysqli_query($dbconfig,"SELECT * FROM forum_tags ORDER BY tagName ASC");
			while($row_tags=mysqli_fetch_assoc($sql_tags)){
			?>
            <option value="<?php echo $row_tags['ftagID']; ?>" ><?php echo $row_tags['tagName']; ?></option>
            <?php } ?>
            </select>
            <br><div class="div-title"></div>
            <div class=" inline-display fright">
            <div id="message" style="margin-right: 15px;margin-top: 10px;"></div>
            <input type="submit" onClick="CKupdate()" value="Post Question" class="btn btn-info btn-xl click_ask_question">
            </div>
        </form> 
        <div class="div-title"></div>
    </div><!--end col-md-4-->
    
    <div class="col-md-2 grid_2"></div><!--end col-md-3-->
    
    
    <?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/forum.js"></script>
<!--For Tags-->
<link href="assets/css/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
<link rel="stylesheet" href="assets/plugins/chosen/chosen.min.css" />
<link rel="stylesheet" href="assets/plugins/tagsinput/jquery.tagsinput.css" />
<script src="assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<script src="assets/js/formsInit.js"></script>
<script>
	$(function () { formInit(); });
</script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="assets/plugins/chosen/chosen.jquery.min.js"></script>
<script src="assets/plugins/autosize/jquery.autosize.min.js"></script>

</div>
</body>
</html>