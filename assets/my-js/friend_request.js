/* for friend request */
$(document).ready(function(){

$(document).on("click", ".click_add_friend", function (e) {
var friendWith = this.rel;
var data_string = 'friendWith='+ friendWith;
$("#add_frnd"+friendWith).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=friend_request",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("req_sent"+friendWith).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); });
});

<!--Cancel Sent Request-->
$(document).ready(function(){
$('.click_cancel_friend').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Cancel Friend Request ?');
if(isConfirm != true){
	return false;	
}
var friendreqID = this.rel;
var data_string = 'friendreqID='+ friendreqID;
$("#cancel_frnd"+friendreqID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=friend_request_cancel",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("req_sent_cancel"+friendreqID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for accept friend request */
$(document).ready(function(){
$('.click_accept_friend').click(function(){
var friendreqID = this.rel;
var data_string = 'friendreqID='+ friendreqID;
$("#accept_frnd"+friendreqID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=friend_request_accept",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("req_accept"+friendreqID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

//delete for frnd request
$(document).ready(function(){
$('.click_delete_friend').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete Friend ?');
if(isConfirm != true){
	return false;	
}
var friendreqID = this.rel;
var data_string = 'friendreqID='+ friendreqID;
$("#delete_frnd"+friendreqID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=friend_request_delete",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("req_delete"+friendreqID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

//delete for my friend
$(document).ready(function(){
$('.click_delete_myfriend').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete Friend ?');
if(isConfirm != true){
	return false;	
}
var myfriendID = this.rel;
var data_string = 'myfriendID='+ myfriendID;
$("#delete_frnd").hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=unfrnd",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("req_delete").innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });