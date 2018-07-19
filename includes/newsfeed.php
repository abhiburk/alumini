<?php 

$sql=$conn->prepare("INSERT INTO posts (userID,postType,postText,postImg,reference,referenceID,postTime) VALUES (?,?,?,?,?,?,?)");
$sql->execute(array($userid,$postType,$postText,$postImg,$reference,$referenceID,$time));

//fetching post id 
$sql_post=mysqli_query($dbconfig,"SELECT postID FROM posts ORDER BY postID DESC LIMIT 1");
$row_post=mysqli_fetch_assoc($sql_post);

//news feed
$newsBy=$userid;
$type=$postType;
$newsText=$_REQUEST['newsText'];
$reference='post_id';
$referenceID=$row_post['postID']; 
$sql=$conn->prepare("INSERT INTO news_feed (newsBy,type,newsText,reference,referenceID,newsTime) VALUES (?,?,?,?,?,?)");
$sql->execute(array($newsBy,$type,$newsText,$reference,$referenceID,$time)); 	

?>