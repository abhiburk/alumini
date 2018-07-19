/* for counting messages */
$(document).ready(function(){
	var loaded = false;
	//initially loading count
	$.ajax({
		type: "POST",
		url: "manipulates/msg_count.php",
		success: function (response) {
			if(response!=0){
			$("#msg_count").addClass('label label-danger');
			document.getElementById("msg_count").innerHTML=response; 
			}
		}
		});
	setInterval(function(){
	//sound_notification.play();
	$.ajax({
		type: "POST",
		url: "manipulates/msg_count.php",
		success: function (response) {
			if(response!=0 & response>0){
			$("#msg_count").addClass('label label-danger');
			document.getElementById("msg_count").innerHTML=response;
			 if(loaded) return; 
			sound_notification.play();
			loaded = true;
			} 
		}
		});
	}, 10000);	
});

<!--Course and Branch-->
function fetch_select(val){
 $.ajax({
 type: 'post',
 url: 'manipulates/manipulate.php',
 data: { get_option:val },
 success: function (response) {
  document.getElementById("new_select").innerHTML=response; 
 } }); }

$('#textfb').keyup(function() {
    $('#targetfb').html($(this).val());
});
$('#textin').keyup(function() {
    $('#targetin').html($(this).val());
});

<!--Click User Profile Menu-->
$(document).ready(function(e) {
    $(document).on("click", ".click_profile_menu", function (e) {
		$(".hide_profile_menu").toggle();
	});
});