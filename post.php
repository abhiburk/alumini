<?php include 'config.php'; 

$pid = isset($_REQUEST['postID']) ? htmlentities($_REQUEST['postID']) : '';

$sql_post=mysqli_query($dbconfig,"SELECT * FROM posts WHERE postID='".$pid."' ") or die(mysqli_error($dbconfig));
$row_post=mysqli_fetch_assoc($sql_post);
$postid = isset($row_post['postID']) ? htmlentities($row_post['postID']) : '';
$postType = isset($row_post['postType']) ? htmlentities($row_post['postType']) : '';

if($postid==''){
	include 'includes/error.php';	
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Post <?php include 'includes/title.php'; ?></title>
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
    
       
<div class="col-md-4 grid_2">

    	  		  <!--Single Post-->                
				  <?php 
				   // for post user
                   $sql_group_post=mysqli_query($dbconfig,"SELECT *,
				   $name FROM news_feed AS f LEFT JOIN users AS u 
				   ON f.newsBy=u.userID LEFT JOIN posts AS p ON p.postID=f.referenceID WHERE postID='".$postid."' ORDER BY feedID DESC");
                   ($row_news_feed=mysqli_fetch_assoc($sql_group_post));
                   ?>   
                   <div class="white-area"><h5>
                   <a href="<?php if($row_news_feed['webName']==''){echo 'user/'.$row_news_feed["userID"].'';}else{ echo 'user/'.$row_news_feed["webName"].'';}  ?>"> 
				   <?php echo $row_news_feed['name']; ?></a>
                   <?php echo $row_news_feed['newsText']; ?>
                   </h5></div>
                   <div class="profile_container">
                     <div class="cover_img_container cute about">
                        <?php if($row_news_feed['postImg']!=''){ ?>
                            <img src="<?php echo 'uploads/'.$row_news_feed['postImg']; ?>"><?php } ?>
                            <small class="post_photo_menu profile_menu"><?php echo $row_news_feed['postText']; ?></small>
                            <ul class="post_photo_menu profile_menu">
                                <li>
                                    <?php 
									//checking if like or not
                                    $sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_news_feed['postID']."'
                                    AND likeType='".$row_news_feed['type']."' AND userID='".$userid."' "); 
                                    $check_if_liked=mysqli_num_rows($sql_if_liked);
									$check_if_liked = isset($check_if_liked) ? htmlentities($check_if_liked) : ''; ?>
                                    <?php 
                                    $sql_last_like=mysqli_query($dbconfig,"SELECT * FROM user_likes LEFT JOIN users USING (userID) 
                                    WHERE likeTo='".$row_news_feed['postID']."' 
                                    AND likeType='".$row_news_feed['type']."' ORDER BY likeID DESC")or die (mysqli_error($dbconfig));
                                    $row_last_like=mysqli_fetch_assoc($sql_last_like);
                                    ?>
                                    <a><small class="grey1">
                                            <span id="default_count<?php echo $row_news_feed['postID']; ?>"><?php  echo $row_news_feed['like_counts']; ?></span>
                                            <span id="like_count<?php echo $row_news_feed['postID']; ?>"></span>
                                        </small></a> 
									<?php if($check_if_liked==true){ ?>	
                                    	<!--if already liked-->
										<a href="javascript:void(0);" id="<?php echo $row_news_feed['postID']; ?>" class="click_unlike"  data-likeType="<?php echo $row_news_feed['postType']; ?>" style="color: #2093F5;font-weight: 600;"> 
										<i class="icon-thumbs-up-alt"></i> Liked </a>
										<?php }else { ?>
										<!--if not liked-->
										<a href="javascript:void(0);" id="<?php echo $row_news_feed['postID']; ?>" class="black_bold click_like"  data-likeType="<?php echo $row_news_feed['postType']; ?>"> 
										<i class="icon-thumbs-up-alt"></i> Like </a>
									<?php } ?>
                                    
                                </li> &nbsp;|
                                <li><a href="javascript:void(0);" class="click_show_comment_box"><i class="icon-comment-alt "></i> Comment </a></li> &nbsp;|&nbsp;
                                <li><small class="grey1"> <?php  echo "" . humanTiming( $row_news_feed['postTime'] ). "";  ?></small></li>&nbsp;|
                                <?php if($userid==$row_news_feed['userID']){ //checking owner of the post ?>
                                <li><a href="javascript:void(0);" class="click_delete_post" rel="<?php echo $row_news_feed['postID']; ?>" data-postType="<?php echo $postType; ?>" data-id="<?php echo $row_news_feed['referenceID']; ?>">
                                <span id="show_delete_post"></span> <span id="hide_delete_post">Delete</span></a> </li>
                                <?php } ?>
                            </ul>
                       </div>
                     </div>
                     <div class="div-title"></div> 
        			
                  <!--Post Comment Box-->  
                  <div class="hire-me hide_comment_box">
                    <ul class="listing">
                      <form method="post" enctype="multipart/form-data">
                          <input type="hidden" name="xAction" value="post_comment">
                          <input type="hidden" name="postType" value="<?php echo $postType; ?>">
                          <input type="hidden" name="postid" value="<?php echo $postid; ?>">
                         <li class="create_group"> 
                            <textarea name="comment" class="form-control" placeholder="Post a comment" style="height: 40px; font-size:12px"></textarea>
                            <span id="show_comment"></span>
                            <span id="hide_comment"><input type="submit" class="btn btn-primary btn-xs click_post_comment" value="Comment" style="font-size:11px"></span>
                         </li> 
                        </form>
                      </ul> 
                  </div><div class="div-title"></div>	
        		  
          		  <!--Displaying Comments--> 
				  <?php 
                    $sql_post_comment=mysqli_query($dbconfig,"SELECT *,$name FROM post_comments LEFT JOIN users USING (userID)
                    WHERE postID='".$postid."' ORDER BY commentID DESC");
                    while($row_post_comment=mysqli_fetch_assoc($sql_post_comment)){
                    ?> 
                    <div class="profile_container" <?php if($row_post_comment['commentID']==$_REQUEST['cmntid']) {echo 'style="background:#FFFFAA;"';} ?> >
                    <small class="post_photo_menu profile_menu" >
                        <a href="<?php if($row_post_comment['webName']==''){echo 'user/'.$row_post_comment["userID"].'';}else{ echo 'user/'.$row_post_comment["webName"].'';}  ?>">
                        <b><?php echo $row_post_comment['name']; ?> </b></a>
                    </small>
                    <small class="post_photo_menu profile_menu" style="margin-left: 7px;"><?php echo $row_post_comment['comment']; ?></small>
                    <ul class="post_photo_menu profile_menu">
                        <li>
                            <?php //checking if like or not
                            $sql_if_liked=mysqli_query($dbconfig,"SELECT * FROM user_likes WHERE likeTo='".$row_post_comment['commentID']."'
                            AND likeType='".$postType.".comment' AND userID='".$userid."' "); 
                            $check_if_liked=mysqli_num_rows($sql_if_liked); 
                            $check_if_liked = isset($check_if_liked) ? htmlentities($check_if_liked) : '';?>
                            <a><small class="grey1"><?php echo $row_post_comment['like_counts']; ?></small></a> 
                            <?php
                            if($check_if_liked==true){
                            ?>	<!--if already liked-->
                                <a href="javascript:void(0);" class="click_comment_unlike" rel="<?php echo $row_post_comment['commentID']; ?>" data-postid="<?php echo $postid; ?>" data-likeType="<?php echo $postType; ?>" style="color: #2093F5;font-weight: 600;"> 
                                <span id="show_comment_unlike<?php echo $row_post_comment['commentID']; ?>"></span> <span id="hide_comment_unlike<?php echo $row_post_comment['commentID']; ?>"><i class="icon-thumbs-up-alt"></i> Liked</span> </a>
                                <?php }else { ?>
                                <!--if not liked-->
                                <a href="javascript:void(0);" class="click_comment_like" rel="<?php echo $row_post_comment['commentID']; ?>" data-postid="<?php echo $postid; ?>" data-likeType="<?php echo $postType; ?>"> 
                                <span id="show_comment_like<?php echo $row_post_comment['commentID']; ?>"></span><span id="hide_comment_like<?php echo $row_post_comment['commentID']; ?>">Like</span> </a>
                            <?php } ?>
                        </li>&nbsp; |&nbsp; 
                        <li><small class="grey1"> <?php  echo "" . humanTiming( $row_post_comment['commentTime'] ). "";  ?> </small></li> &nbsp; | 
                        <?php if($userid==$row_post_comment['userID']){ //checking owner of the comment ?>
                        <li><a href="javascript:void(0);" class="click_delete_comment" rel="<?php echo $row_post_comment['commentID']; ?>" data-postid="<?php echo $postid; ?>" data-postType="<?php echo $postType; ?>">
                        <span id="show_delete<?php echo $row_post_comment['commentID']; ?>"></span> <span id="hide_delete<?php echo $row_post_comment['commentID']; ?>"> Delete</span></a> </li>
                        <?php } ?>
                    </ul>
                  <hr>
               </div>       
               <?php } ?> 
              
             	   
</div><!--end col-md-4 grid_2-->
    
<div class="col-md-3 grid_2">

                  <!--Displaying List of user who liked--> 
                  <?php 
                $sql_who_like=mysqli_query($dbconfig,"SELECT *,$name FROM user_likes LEFT JOIN users USING (userID)
                WHERE likeTo='".$postid."' ORDER BY likeID DESC ");
                $count_who_like=mysqli_num_rows($sql_who_like);
                $count_who_like = isset($count_who_like) ? htmlentities($count_who_like) : '';
                ?>
                <div class="white-area"><h5>People who liked this post (<?php echo $count_who_like; ?>)</h5></div>
                <div class="profile_container <?php if($count_who_like>3){echo 'scroll1';} ?>">
                    <ul class="listing">
                        <?php 
                        if($count_who_like==''){echo '<li class="invite1"><small class="grey">0 people like this post</small></li>';}else{
                        while($row_who_like=mysqli_fetch_assoc($sql_who_like)){
                        ?>
                        <a href="<?php if($row_who_like['webName']==''){echo 'user/'.$row_who_like["userID"].'';}else{ echo 'user/'.$row_who_like["webName"].'';}  ?>">
                          <li class="subitem_grey" style="padding:5px; "> 
                                <img src="<?php if($row_who_like['userImg']==''){echo 'images/default.jpg';}else {
                                echo 'uploads/'.$row_who_like['userImg']; } ?>" alt="User Avatar" class="recent_chat">
                              <small class="" style="margin-left: 5px;"> 
                                <?php echo $row_who_like['name']; ?>
                              </small>
                              <small id="right_btn">
                               <?php 
                              echo "" . humanTiming( $row_who_like['likeTime'] ). ""; ?>
                              </small>
                          </li>
                         </a>  
                         <?php }}?>
                     </ul> 
                </div>  
             
</div><!--end col-md-4 grid_2-->
   
    <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>
<script src="assets/js/myscript.js"></script>
<script src="assets/my-js/post.js"></script>
</div>
</body>
</html>