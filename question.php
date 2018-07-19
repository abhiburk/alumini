<?php include 'config.php'; 
$fqID = isset($_REQUEST['fqID']) ? htmlentities($_REQUEST['fqID']) : '';
$answerID = isset($_REQUEST['answerID']) ? htmlentities($_REQUEST['answerID']) : '';
$view = isset($_REQUEST['view']) ? htmlentities($_REQUEST['view']) : '';

$sql_questions=mysqli_query($dbconfig,"UPDATE forum_questions SET views=views+1 WHERE fqID='".$fqID."' ") or die(mysqli_error());

$sql_questions=mysqli_query($dbconfig,"SELECT *,$name,fq.createTime,fq.updateTime
FROM forum_questions AS fq 
LEFT JOIN users AS u USING (userID) WHERE fqID='".$fqID."' ") or die(mysqli_error());
$count_questions=mysqli_num_rows($sql_questions);
($questions=mysqli_fetch_assoc($sql_questions));

$sql_answer=mysqli_query($dbconfig,"SELECT * FROM forum_answers AS a LEFT JOIN forum_questions USING (fqID)
WHERE a.answerID='".$answerID."' AND a.userID='".$userid."' "); 
$answers=mysqli_fetch_assoc($sql_answer);
if($questions['fqID']==''){
	include 'includes/error.php';
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Question <?php include 'includes/title.php'; ?></title>
<?php include 'includes/base.php';  ?>
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
    			
                <div id="loading"></div>
                <?php if($view=='edit'){  ?>  
                    <form method="post">
                        <input type="text" name="tittle" value="<?php echo $questions['tittle']; ?>" class="form-control tittle" placeholder="Question Tittle">
                        <input type="hidden" name="xAction" value="update_question">
                        <input type="hidden" name="fqID" class="fqID" value="<?php echo $questions['fqID']; ?>">
                        <input type="hidden" class="uri" name="uri" value="<?php echo ($questions['tittle']); ?>">
                        <textarea name="description" id="editor1" rows="10" cols="80" required ><?php echo htmlentities($questions['description']); ?></textarea>
                        <script> CKEDITOR.replace( 'description' ); </script>
                            
                        <select data-placeholder="Tags" name="ftagID[]"  class="form-control chzn-select" multiple="multiple" tabindex="4" style="height:25px;">
                            <?php 
                            $sql_tags=mysqli_query($dbconfig,"SELECT * FROM forum_tags ORDER BY tagName ASC");
                            while($row_tags=mysqli_fetch_assoc($sql_tags)){
                                $sql_tags_question=mysqli_query($dbconfig,"SELECT * FROM forum_tags LEFT JOIN forum_question_tag AS fqt USING (ftagID)
                                WHERE ftagID='".$row_tags['ftagID']."' AND fqID='".$questions['fqID']."' ") or die (mysqli_error($dbconfig)); 
                                ($row_tag_question=mysqli_fetch_assoc($sql_tags_question));{
                            ?>
                            <option value="<?php echo $row_tags['ftagID']; ?>"<?php if($row_tag_question['ftagID']==$row_tags['ftagID']){echo 'selected';} ?> ><?php echo $row_tags['tagName']; ?></option>
                            <?php }} ?>
                        </select><br><br>
                        <div class="inline-display fright">
                            <div id="message" style="margin-right: 15px;margin-top: 10px;"></div>
                            <input type="submit" onClick="CKupdate()" value="Save Edit" class="btn btn-info btn-xl click_update_question">
                         </div>
                     </form>
                 
    			<?php } ?>
                
                <?php if($view=='answer'){  ?>  

                    <h4><b><a href="question/<?php echo $answers['fqID']; ?>/<?php echo urlencode($answers['tittle']); ?>"><?php echo $answers['tittle']; ?></a></b></h4>
                    <br>
                    <form method="post">
                        <input type="hidden" name="xAction" value="update_answer">
                        <input type="hidden" name="fqID" class="fqID" value="<?php echo $answers['fqID']; ?>">
                        <input type="hidden" class="uri" name="uri" value="<?php echo ($answers['tittle']); ?>">
                        <input type="hidden" name="answerID" class="answerID" value="<?php echo $answers['answerID']; ?>">
                        <textarea name="answerText" id="editor1" rows="10" cols="80" required ><?php echo htmlentities($answers['answerText']); ?></textarea>
                        <script>
                            CKEDITOR.replace( 'answerText' );
                        </script>
                        <div class="inline-display fright">
                            <div id="message" style="margin-right: 15px;margin-top: 10px;"></div>
                            <input type="submit" onClick="CKupdate()" value="Save Edit" class="btn btn-info btn-xl click_update_answer">
                         </div>
                     </form>
                     
                <?php } ?>
                
                <!--Question-->
				 <?php if($view==$questions['tittle']){  ?> 
                    <div class="white-area"><h5>Question</h5></div>
                        <div class="profile_container">
                            <ul class="cute">
                                <?php if($count_questions==''){echo '<li><small>No Questions Available</small></li>';}else{ ?>
                                <li style="display:flex; width:100%">
                                    <span style="margin-left: 10px;">
                                        <?php 
                                        //checking if voted or not
                                        $sql_if_vote=mysqli_query($dbconfig,"SELECT * FROM forum_question_votes WHERE fqID='".$questions['fqID']."'
                                        AND userID='".$userid."' "); 
                                        $check_if_voted=mysqli_num_rows($sql_if_vote); 
										$check_if_voted = isset($check_if_voted) ? htmlentities($check_if_voted) : '';
                                        $voted=mysqli_fetch_assoc($sql_if_vote); ?>
                                        
                                        <a data-type="up" data-ownerID="<?php echo $questions['userID']; ?>" rel="<?php echo $questions['fqID']; ?>" href="javascript:void(0);" class="click_up_vote " title="Up vote if question is clear and userful">
                                            <i class="icon-sort-up    <?php if($check_if_voted==true and $voted['type']=='up'){echo 'ok_green';}else{echo'ok_grey';} ?>" id="show_up_vote"></i> <span id="hide_up_vote"></span>
                                        </a>
                                        <small style="position: absolute;margin-left: -14px;margin-top:25px;font-size: 17px;"><span id="show_votes"><?php echo $questions['votes']; ?></span><span id="add"></span></small>
                                        
                                        <a data-type="down" data-ownerID="<?php echo $questions['userID']; ?>" rel="<?php echo $questions['fqID']; ?>" href="javascript:void(0);" class="click_down_vote" title="Down vote if question is unclear or not useful" >
                                            <i class="icon-sort-down  <?php if($check_if_voted==true and $voted['type']=='down'){echo 'ok_green';}else{echo'ok_grey';} ?>" id="show_down_vote"></i> <span id="hide_down_vote"></span>
                                        </a>
                                    </span>
                                    <span class="inline_grid">
                                        <h4><b><a href="question/<?php echo $questions['fqID']; ?>/<?php echo urlencode($questions['tittle']); ?>"><?php echo $questions['tittle']; ?></a></b></h4>
                                    </span>
                                </li> 
                                <hr>
                                <li>
                                    <?php $sql_tags=mysqli_query($dbconfig,"SELECT tagName FROM forum_tags LEFT JOIN forum_question_tag AS fqt USING (ftagID)
                                    WHERE fqID='".$questions['fqID']."'") or die (mysqli_error($dbconfig)); 
                                    while($row_tag=mysqli_fetch_assoc($sql_tags)){ ?>
                                    <small style="background-color: #b9ebf3;margin: 3px;padding: 3px;color: darkblue;">
                                        <?php echo $row_tag['tagName']; ?>
                                    </small>
                                    <?php } ?> |
                                    <small> Viewed: <?php echo $questions['views']; ?> times </small>
                                </li>
                                <hr>
                                <li><div id="question"><?php echo $questions['description']; ?></div></li>
                                <hr>
                                <script>
								$(document).ready(function(){
									var question=$("div#question pre").text().length
									if(question > 175){
										$('#question pre').css({"overflow-y":"scroll","height":"300px"});
										}
								});
								</script>
                                <li>
                                    <small class="">
                                        <?php if ($questions['userID']==$userid){ ?>
                                        <a rel="<?php echo $questions['fqID']; ?>" href="javascript:void(0);" class="delete_question">Delete</a> | <?php } ?>
                                        <a href="question/<?php echo $questions['fqID']; ?>/edit">Edit</a> |
                                        <!--question/<?php echo $questions['fqID']; ?>/edit-->
                                        Asked by: 
                                        <a href="<?php if($questions['webName']==''){echo 'user/'.$questions["userID"].'';}else{ echo 'user/'.$questions["webName"].'';}  ?>"><?php echo $questions['name']; ?></a>,
                                        <?php echo "".humanTiming($questions['createTime'])." ago"; ?> |
                                        
                                        <?php 
										$sql_edited=mysqli_query($dbconfig,"SELECT *,$name,fq.createTime,fq.updateTime
										FROM forum_questions AS fq 
										LEFT JOIN users AS u ON fq.editedBy=u.userID WHERE fqID='".$fqID."' ") or die(mysqli_error());
										($edited=mysqli_fetch_assoc($sql_edited));
										if($questions['updateTime']!='0' and $edited['editedBy']!=''){echo "Edited";?>
                                        <a href="<?php if($edited['webName']==''){echo 'user/'.$edited["userID"].'';}else{ echo 'user/'.$edited["webName"].'';}  ?>"> 
                                         <?php echo $edited['name']; echo "</a>, ".humanTiming($questions['updateTime'])." ago";}?>
                                    </small>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="div-title"></div>
                 
                 <span class=" inline-display fright">
                     <div id="loading_anwer_box" style="margin-right: 15px;margin-top: 10px;"></div>                            	
                     <a href="javascript:void(0);" class="btn btn-info btn-xl  click_answer_this_question">Answer this Question</a>
                 </span><br><br>
                 
                 <!--Answer Box-->
                 <div class="hide_anwer_box display_none">  
                 	<form method="post">
                     <input type="hidden" name="xAction" value="answer_question">
                     <input type="hidden" name="fqID" class="fqID" value="<?php echo $questions['fqID']; ?>">
                        <input type="hidden" class="uri" name="uri" value="<?php echo ($questions['tittle']); ?>">    
                     <textarea name="answerText" id="editor1" rows="10" cols="80" required /></textarea>
                     <script>
                        CKEDITOR.replace( 'answerText' );
                     </script>
                     <div class=" inline-display fright">
                      <div id="message" style="margin-right: 15px;margin-top: 10px;"></div>
                      <input type="submit" onClick="CKupdate()" value="Post Answer" class="btn btn-info btn-xl click_answer_question">
                     </div> 
                    </form>           
        		 <br><br></div><div class="div-title"></div>
                 
                 <!--Answer-->
                 <?php  
				 $sql_answers=mysqli_query($dbconfig,"SELECT *,$name,a.createTime,a.updateTime
				 FROM forum_answers AS a 
				 LEFT JOIN users AS u USING (userID) WHERE fqID='".$questions['fqID']."' ") or die(mysqli_error());
				 $count_answers=mysqli_num_rows($sql_answers); 
				 $count_answers = isset($count_answers) ? htmlentities($count_answers) : ''; ?>
                 <div class="white-area"><h5><?php echo $count_answers; if($count_answers=='1'){echo ' Answer';}else{echo ' Answers';} ?> </h5></div>
                        
                            	<?php  if($count_answers==''){echo '
								<div class="profile_container"><ul class="cute"><li>No Answer Available Yet</li></ul></div><div class="div-title"></div> ';}else{
								while($answers=mysqli_fetch_assoc($sql_answers)){
								?>
                          <div class="profile_container">
                            <ul class="cute">
                                <li style="display:flex; width:100%">
                                    <span style="margin-left: 10px;margin-top: 18px;">
                                        <?php 
                                        //checking if voted or not
                                        $sql_if_ans_vote=mysqli_query($dbconfig,"SELECT * FROM forum_answer_votes WHERE answerID='".$answers['answerID']."'
                                        AND userID='".$userid."' "); 
                                        $check_if_ans_voted=mysqli_num_rows($sql_if_ans_vote);
										$check_if_ans_voted = isset($check_if_ans_voted) ? htmlentities($check_if_ans_voted) : ''; 
                                        $voted=mysqli_fetch_assoc($sql_if_ans_vote); ?>
                                        <!--Up Vote Btn-->
                                        <a data-type="up" data-ownerID="<?php echo $answers['userID']; ?>" rel="<?php echo $answers['answerID']; ?>" href="javascript:void(0);" class="click_ans_up_vote " title="Up vote if answer is clear and userful">
                                            <i class="icon-sort-up    <?php if($check_if_ans_voted==true and $voted['type']=='up'){echo 'ok_green';}else{echo'ok_grey';} ?>" id="show_ans_up_vote<?php echo $answers['answerID']; ?>"></i> 
                                        </a>
                                        <small style="position: absolute;margin-left: -14px;margin-top:25px;font-size: 17px;"><span id="show_ans_votes<?php echo $answers['answerID']; ?>"><?php echo $answers['votes']; ?></span><span id="ans_add<?php echo $answers['answerID']; ?>"></span></small>
                                        <!--Down Vote Btn-->
                                        <a data-type="down" data-ownerID="<?php echo $answers['userID']; ?>" rel="<?php echo $answers['answerID']; ?>" href="javascript:void(0);" class="click_ans_down_vote" title="Down vote if answer is unclear or not useful" >
                                            <i class="icon-sort-down  <?php if($check_if_ans_voted==true and $voted['type']=='down'){echo 'ok_green';}else{echo'ok_grey';} ?>" id="show_ans_down_vote<?php echo $answers['answerID']; ?>"></i> 
                                        </a>
                                        <!--Accept answer btn-->
                                        <?php if($questions['userID']==$userid and $questions['answerAccepted']=='0'){ ?>
                                        <a data-answerID="<?php echo $answers['answerID']; ?>" class="click_accept_answer" rel="<?php echo $answers['fqID']; ?>" href="javascript:void(0);">
                                        	<i class="icon-ok ok_grey" style="position: absolute;margin-left: -22px;margin-top: 40px;font-size: 30px;" id="show_accepted<?php echo $answers['answerID']; ?>"></i>
                                        </a>
                                        <?php } if($questions['answerAccepted']=='1' and $questions['answerID']==$answers['answerID']){ ?>
                                        <i class="icon-ok ok_green" style="position: absolute;margin-left: -22px;margin-top: 40px;font-size: 30px;" title="Accepted <?php echo "".humanTiming($questions['acceptTime'])." ago";?>"></i>
                                        <?php } ?>
                                    </span>
                                    
                                    <span class="inline_grid" style="padding: 15px;">
                                    <div id="answer<?php echo $answers['answerID']; ?>"><?php echo $answers['answerText']; ?></div>
                                    </span>
                                </li>
                                <!--<hr> 
                                <li style="text-align:center">
                                <a href="" class="btn btn-success btn-sm"><i class="icon-ok"></i> Accept as Answer</a>
                                </li>-->
                                <hr>
                                <li>
                                    <small class="">
                                        <?php if ($answers['userID']==$userid){ ?>
                                        <a href="javascript:void(0);" class="delete_answer" rel="<?php echo $answers['answerID']; ?>" data-uri="<?php echo $questions['tittle']; ?>" data-fqID="<?php echo $answers['fqID']; ?>">Delete</a> | 
                                        <a href="edit/<?php echo $answers['answerID']; ?>/answer" >Edit</a> | <?php } ?>
                                        Answered by: 
                                        <a href="<?php if($answers['webName']==''){echo 'user/'.$answers["userID"].'';}else{ echo 'user/'.$answers["webName"].'';}  ?>"><?php echo $answers['name']; ?></a>,
                                        <?php echo "".humanTiming($answers['createTime'])." ago"; ?> |
                                        
										<?php if($answers['updateTime']!=''){?>
                                         <?php echo "Edited ".humanTiming($answers['updateTime'])." ago";}?>
                                    </small>
                                </li>
                                </ul>
                          </div> <div class="div-title"></div> 
                          <?php }}?>
                                
                          <script>
								$(document).ready(function(){
                                var answer=$("div#answer<?php echo $answers['answerID']; ?> pre").text().length
								if(answer > 175){
									$('#answer<?php echo $answers['answerID']; ?> pre').css({"overflow-y":"scroll","height":"300px"});
									}
								});
							</script>
                              
                 	<?php } // end if condition ?>

    </div>
    
    <div class="col-md-2 grid_2">
    	<!--Popular Question-->
        <div class="white-area"><h5>Similar Questions</h5></div>
        <div class="profile_container">
            <ul class="listing">
            <?php 
					$q=$conn->prepare("SELECT * FROM forum_questions LEFT JOIN forum_answers USING (fqID)
					LEFT JOIN forum_question_tag USING (fqID) LEFT JOIN forum_tags USING (ftagID) 
					WHERE (tittle LIKE :search OR tagName LIKE :search) GROUP BY fqID");
					$q->bindValue(':search','%'.$view.'%'); 
					$q->execute();
					$count=$q->rowCount();
					if($count==''){echo '<li style="padding:5px;">Nothing Available</li>';}{
                                while ($row_question = $q->fetch(PDO::FETCH_ASSOC)) {
				
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
        
    </div><!--end col-md-2 grid_2-->
   
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