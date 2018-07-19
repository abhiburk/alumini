/* for cancel leave group */
$(document).ready(function(){
$('.click_cancel_leave').click(function(){
$("#hide_for_cancel").addClass("hide_confirm");
});   });

/* for confirm and delete Group */
$(document).ready(function(){
$('.click_confirm_leave').click(function(){
var gid = this.rel;
var data_string = 'gid='+ gid;
$("#leave_hide").hide();
$.ajax({
type: "POST",
url: "manipulates/delete.php?xAction=confirm_leave",
data:data_string ,
success: function (response) {
console.log(response);
setTimeout(function()
{ window.location="creategroup.php"; }, 3000);
document.getElementById("leave_group").innerHTML=response;

}
}); }); });

/* for Leave Group */
$(document).ready(function(){
$('.click_leave_group').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Leave This Group ?');
if(isConfirm != true){
	return false;	
}
var gid = this.rel;
var data_string = 'gid='+ gid;
$.ajax({
type: "POST",
url: "manipulates/delete.php?xAction=leave_group",
data:data_string ,
success: function (response) {
console.log(response);
	if(response==''){
	$(".hide_confirm").removeClass("hide_confirm");
	}else {
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}
}); }); });

/* for Approve Group */
$(document).ready(function(){
$('.approve_request').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Approve This Request ?');
if(isConfirm != true){
	return false;	
}
var greqID = this.rel;
var data_string = 'greqID='+ greqID;
$("#approve_mem"+greqID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=approve_request",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("approve"+greqID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for Decline Group */
$(document).ready(function(){
$('.decline_request').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Decline This Request ?');
if(isConfirm != true){
	return false;	
}
var greqID = this.rel;
var gid =$(".decline_request").attr('data-gid');
var data_string = 'greqID='+ greqID+ '&gid='+ gid ;
$("#decline_mem"+greqID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=decline_request",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("decline"+greqID).innerHTML=response; 
}
}); }); });

/* for Join Group */
$(document).ready(function(){
$('.click_join_group').click(function(){
var gid = this.rel;
var data_string = 'gid='+ gid;
$("#join_group").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=join_group_request",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("greq_sent").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); });});

/* for Cancel Group */
$(document).ready(function(){
$('.click_cancel_group').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Cancel This Request ?');
if(isConfirm != true){
	return false;	
}
var gid = this.rel;
var data_string = 'gid='+ gid;
$("#cancel_group").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=cancel_group_request",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("greq_sent").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for remove group members */
$(document).ready(function(){
$('.remove_guser').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Remove This Person ?');
if(isConfirm != true){
	return false;	
}
var mID = this.rel;
var gid =$(".remove_guser").attr('data-gid');
var data_string = 'mID='+ mID+ '&gid='+ gid ;
console.log(data_string);
$("#remove_mem"+mID).hide();
$.ajax({
type: "POST",
url: "manipulates/delete.php?xAction=remove_guser",
data:data_string ,
success: function (response) {
//console.log(response);
document.getElementById("remove_success"+mID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });