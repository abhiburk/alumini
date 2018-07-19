<!DOCTYPE html>
<html>
<head>
<?php include 'includes/base.php'; ?>
<title>Error <?php include 'includes/title.php'; ?></title>
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
    
                <div class="col-md-7 grid_2">
                    <div class="error-top error">
                        <h3>4<i class="glyphicon glyphicon-ban-circle"></i>4</h3>
                        <span>Whoops! Page not found</span>
                        <p>The page your are looking for has escaped from our servers.</p>
                        <div class="error-btn">
                        <a class="read fourth" href="javascript:void(0);" onclick="goBack()">GO BACK</a>
                        </div>
                    </div>    
                 </div>
<script>
function goBack() {
    window.history.back();
}
</script>

 <?php include 'includes/right_panel.php'; ?>

<!--Container Ends Here-->
<div class="clearfix"></div>
</div>

</div>
</body>
</html>