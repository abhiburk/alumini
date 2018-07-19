<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Home <?php include 'includes/title.php'; ?></title>
<link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- Custom Theme files -->
<?php include 'includes/stylesheets.php'; ?>
</head>

<body>
<div class="excontainer">
    <form method="post">
    <input type="hidden" name="xAction" value="demo_insert">
    <textarea name="text"></textarea>
    <input type="submit" class="click_demo" value="Submit">
    </form>
    <div id="result"></div>
 					<div class="panel panel-default" id="hide">
                        <?php $sql=mysqli_query($dbconfig,"SELECT * FROM demo");
								while($row=mysqli_fetch_assoc($sql)){ 
                                echo $row['text']; echo '<br>'; }								?>
                    </div>
</div>

<script>
$(function worker(){
    // don't cache ajax or content won't be fresh
    $.ajaxSetup ({
        cache: false
    });	
$(document).on("click", ".click_demo", function (e) {
e.preventDefault();

var formData= $(this).closest('form').serialize();
var loadUrl = "http://localhost/alumini/manipulates/ajax_data.php";
var ajax_load = "loading...";
console.log(formData);
$.ajax({
	type: "POST",
	url: "manipulates/ajax_data.php",
	data:formData ,
	success: function (response) {
	document.getElementById("result").innerHTML=response;
		$("#hide").css("display","none");
        $("#result").html(ajax_load);
setTimeout(function(){
$("#result").html(ajax_load).load(loadUrl); 
}, 3000);

}
}); }); });
   

</script>
</body>
</html>