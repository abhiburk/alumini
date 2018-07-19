/* delete event */
$(document).ready(function(){
$('.delete_event').click(function(){
 var isConfirm = window.confirm('Are You Sure Want To Delete This Event ?');
 if(isConfirm != true){
	return false;	
}
var eid = this.rel;
var data_string = 'eid='+ eid ;
$.ajax({
type: "POST",
url: "manipulates/delete.php?xAction=delete_event",
data:data_string ,
success: function (response) {
setTimeout(function()
{ window.location=("createevent.php"); }, 3000);
document.getElementById("success").innerHTML=response; 
}
}); });
});

/* for event decline */
$(document).ready(function(){
$('.click_decline_event').click(function(){
var eid = this.rel;
var status = 'Declined';
var data_string = 'eid='+ eid+ '&status='+ status ;
$("#hide_decline").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=event_action",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("show_decline").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for event cancel intrested */
$(document).ready(function(){
$('.click_cancel_intrested').click(function(){
	var esid = this.rel;
	var status = 'event.interest';
	var data_string = 'esid='+ esid+ '&status='+ status ;
	$("#hide_cancel_intrested").hide();
	$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=event_cancel_action",
	data:data_string ,
	success: function (response) {
		console.log(response);
		document.getElementById("show_cancel_intrested").innerHTML=response; 
		setTimeout(function(){// wait for 5 secs(2)
		location.reload(); // then reload the page.(3)profile_container
		}, 3000);
		
	}
	}); 
}); 
});

/* for event intrested */
$(document).ready(function(){
$('.click_intrested_event').click(function(){
	var eid = this.rel;
	var status = 'Interested';
	var data_string = 'eid='+ eid+ '&status='+ status ;
	$("#hide_intrested").hide();
	$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=event_action",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_intrested").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
	location.reload(); // then reload the page.(3)profile_container
	}, 3000);
	
	}
	}); 
}); 
});

/* for event canceling */
$(document).ready(function(){
$('.click_cancel_attending').click(function(){
var esid = this.rel;
var status = 'event.attend';
var data_string = 'esid='+ esid+ '&status='+ status ;
$("#cancel_attend").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=event_cancel_action",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("show_cancel").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for event attending */
$(document).ready(function(){
$('.click_attend_event').click(function(){

var eid = this.rel;
var status = 'Attending';
var data_string = 'eid='+ eid+ '&status='+ status ;
$("#attend_event").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=event_action",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("show_attend").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for update event */
$(document).ready(function(){
$(document).on("click", ".click_update_event", function (e) {
e.preventDefault();
var eid = $(".eid").val();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
type: "POST",
url: "manipulates/manipulate.php",
data:formData ,
success: function (response) {
setTimeout(function()
{ window.location=("createevent.php?view=editevent&eid="+eid); }, 3000);
document.getElementById("success").innerHTML=response; 


}
}); }); });

/* for create event */
$(document).ready(function(){
$(document).on("click", ".click_create_event", function (e) {
e.preventDefault();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
type: "POST",
url: "manipulates/manipulate.php",
data:formData ,
success: function (response) {
setTimeout(function()
{ window.location=("invite.php?view=event"); }, 3000);
document.getElementById("success").innerHTML=response; 

}
}); }); });