<?php 
require_once('../config.php');
require_once('../includes/ImageManipulator.php');
$action = isset($_REQUEST['xAction']) ? htmlentities($_REQUEST['xAction']) : '';
//echo '<pre>'; print_r($_REQUEST); print_r($_FILES); die;


if($_REQUEST['xAction']=='update_user_photo'){
    $userImg = $_FILES['userImg']['name'];
	
	$postImg = $_FILES['userImg']['name'];
	$postType=$_REQUEST['postType'];
	$reference=$_REQUEST['reference'];
	$referenceID=$_REQUEST['referenceID'];
	
	if($userImg != ''){
	
	if ($_FILES['userImg']['error'] > 0) {
	echo "Error: " . $_FILES['userImg']['error'] . "<br />";
	} else {
	// array of valid extensions
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['userImg']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
		$newNamePrefix = time() . '_';
		$manipulator = new ImageManipulator($_FILES['userImg']['tmp_name']);
		// resizing to 700x700
		$newImage = $manipulator->resample(700, 700);
		// saving file to uploads folder
		$manipulator->save('../uploads/'. $_FILES['userImg']['name']);
		
		$sql = mysqli_query($dbconfig,"UPDATE users SET userImg = '".($userImg)."' 
		WHERE userID = '".$userid."'") or die(mysqli_error());
		
			
		
			include '../includes/newsfeed.php';
		
	} 
		if($sql==true){
		header('location:../home.php'); exit;
		}else{
		echo "Sorry, Please try again";	
	  	}
	}
  }
}


if($_REQUEST['xAction']=='update_group_photo'){
    $groupImg = ($_FILES['groupImg']['name']);
	$gid = htmlentities($_REQUEST['gid']);
	
	$postImg = $_FILES['groupImg']['name'];
	$postType=$_REQUEST['postType'];
	$reference=$_REQUEST['reference'];
	$referenceID=$_REQUEST['referenceID'];
	if($groupImg != ''){
	
	if ($_FILES['groupImg']['error'] > 0) {
	echo "Error: " . $_FILES['groupImg']['error'] . "<br />";
	} else {
	// array of valid extensions
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['groupImg']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
		$newNamePrefix = time() . '_';
		$manipulator = new ImageManipulator($_FILES['groupImg']['tmp_name']);
		// resizing to 700x700
		$newImage = $manipulator->resample(700, 700);
		// saving file to uploads folder
		$manipulator->save('../uploads/'. $_FILES['groupImg']['name']);
		
		$sql = mysqli_query($dbconfig,"UPDATE user_groups SET groupImg = '".($groupImg)."',updateTime='".$time."' 
		WHERE groupID = '".$gid."'") or die(mysqli_error());
		
		
			include '../includes/newsfeed.php'; 
		
	} 
		if($sql==true){
		header('location:../group/'.$gid.''); exit;
		}else{
		echo "Sorry, Please try again";	
	  	}
	}
  }
}


if($_REQUEST['xAction']=='update_event_photo'){
    $eventImg = ($_FILES['eventImg']['name']);
	$eid = htmlentities($_REQUEST['eid']);
	
	$postImg = $_FILES['eventImg']['name'];
	$postType=$_REQUEST['postType'];
	$reference=$_REQUEST['reference'];
	$referenceID=$_REQUEST['referenceID'];
	if($eventImg != ''){
	
	if ($_FILES['eventImg']['error'] > 0) {
	echo "Error: " . $_FILES['eventImg']['error'] . "<br />";
	} else {
	// array of valid extensions
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['eventImg']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
		$newNamePrefix = time() . '_';
		$manipulator = new ImageManipulator($_FILES['eventImg']['tmp_name']);
		// resizing to 700x700
		$newImage = $manipulator->resample(700, 700);
		// saving file to uploads folder
		$manipulator->save('../uploads/'. $_FILES['eventImg']['name']);
		
		$sql = mysqli_query($dbconfig,"UPDATE user_events SET eventImg = '".($eventImg)."',updateTime='".$time."' 
		WHERE eventID = '".$eid."'") or die(mysqli_error());
		
		
		include '../includes/newsfeed.php';
		
	} 
		if($sql==true){
		header('location:../event/'.$eid.''); exit;
		}else{
		echo "Sorry, Please try again";	
	  	}
	}
  }
}

?>