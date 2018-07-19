<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Forum <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php'; ?>
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
        <!--Questions-->
        <div class="white-area"><h5>Recently Asked Questions <a href="ask.php" class="fright">Ask Question</a></h5></div>
        <?php 
        $sql__questions=mysqli_query($dbconfig,"SELECT *,$name,fq.createTime,fq.updateTime
        FROM forum_questions AS fq 
        LEFT JOIN users AS u USING (userID) ORDER BY fqID DESC  ") or die(mysqli_error());
        $count_questions=mysqli_num_rows($sql__questions); 
        $count_questions = isset($count_questions) ? htmlentities($count_questions) : '';?>
        <div class="profile_container show_workplace_list <?php if($count_questions>=25){echo 'scroll2';} ?>">
            <ul class="cute">
                <?php 
                if($count_questions==''){echo '<li><small>No Questions Available</small></li>';}else{
                while($questions=mysqli_fetch_assoc($sql__questions)){ 
                    $sql_count=mysqli_query($dbconfig,"SELECT answerID FROM forum_answers WHERE fqID='".$questions['fqID']."'");
                    $count_answers=mysqli_num_rows($sql_count);
                    $count_answers = isset($count_answers) ? htmlentities($count_answers) : '';
                ?>
                <li style="display:flex; width:100%">
                    <i class="icon-ok <?php if($questions['answerAccepted']=='1'){echo 'ok_green';}else{echo 'ok_grey';} ?>"></i>
                    <span style="position: absolute;margin-top: 33px;font-size: 11px;"><?php echo $count_answers; ?> Ans</span>
                    <span class="inline_grid">
                        <b><a href="question/<?php echo $questions['fqID']; ?>/<?php echo urlencode($questions['tittle']); ?>"><?php echo ($questions['tittle']); ?></a></b>
                        <small class="grey1">Asked by: 
                        <a href="<?php if($questions['webName']==''){echo 'user/'.$questions["userID"].'';}else{ echo 'user/'.$questions["webName"].'';}  ?>"><?php echo $questions['name']; ?></a>  |
                            <?php echo "" . humanTiming($questions['createTime']). " ago"; ?>
                        </small>
                    </span>
                </li><hr>
                <?php }} ?>
            </ul>
        </div><div class="div-title"></div>
        
    </div>
    
    <div class="col-md-2 grid_2">
    	<!--Popular Question-->
        <div class="white-area"><h5>Popular Questions</h5></div>
        <div class="profile_container">
            <ul class="listing">
            <?php 
			$sql_question=mysqli_query($dbconfig,"SELECT * FROM forum_questions as q LEFT JOIN forum_answers AS a USING (fqID) GROUP BY fqID
			ORDER BY a.fqID DESC");
			$check_question=mysqli_num_rows($sql_question);
			$check_question = isset($check_question) ? htmlentities($check_question) : '';
			if($check_question==0){echo '<h5 class="invite1 grey1">Nothing available</h5>';}else{
			while($row_question=mysqli_fetch_assoc($sql_question)){
				
					$sql_count=mysqli_query($dbconfig,"SELECT answerID FROM forum_answers WHERE fqID='".$row_question['fqID']."'");
                    $count_answers=mysqli_num_rows($sql_count);
                    $count_answers = isset($count_answers) ? htmlentities($count_answers) : '';
			?>
                  <li class="subitem_grey" style="padding:5px; ">
              <a href="question/<?php echo $row_question['fqID']; ?>/<?php echo urlencode($row_question['tittle']); ?>"><small class="grey1 black_bold"><?php echo ($row_question['tittle']); ?></small></a>
                      <small id="break_inline"> 
                        <i class="btn <?php if($row_question['answerAccepted']=='1'){echo 'btn-success';}else{echo 'btn-default';} ?> btn-xs"><?php echo $count_answers; ?> Ans </i>
                      </small>
                  </li>
              </a> 
             <?php }} ?>
             </ul> 
        </div>
        
    </div>
   
    
	<?php include 'includes/right_panel.php'; ?>
<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/forum.js"></script>
</div>
</body>
</html>