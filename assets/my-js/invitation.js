/* for accept group invite */
$(document).ready(function(){
$('.click_accept_invite').click(function(){
var inviteid = this.rel;
var data_string = 'inviteid='+ inviteid;
$("#hide_accept_join"+inviteid).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=accept_group_invitation",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("accept_grp_invitation"+inviteid).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for delete Group Invite */
$(document).ready(function(){
$('.click_delete_invite').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Cancel This Invitation ?');
if(isConfirm != true){
	return false;	
}
var inviteid = this.rel;
var data_string = 'inviteid='+ inviteid;
$("#hide_delete_join"+inviteid).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=delete_group_invitation",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("delete_grp_invitation"+inviteid).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for cancel group invitation */
$(document).ready(function(){
$('.click_cancel_ginvite').click(function(){

var inviteID = this.rel;
var data_string = 'inviteID='+ inviteID ;
$("#hide_cancel"+inviteID).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=cancel_group_invitation",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("cancelled"+inviteID).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for group invitation */
$(document).ready(function(){
$('.click_group_invite').click(function(){

var uid = this.rel;
var gid =$(".click_group_invite").attr('data-gid');
var data_string = 'uid='+ uid+ '&gid='+ gid ;
$("#hide_invite"+uid).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=group_invitation",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("invited"+uid).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for event invitation */
$(document).ready(function(){
$('.click_event_invite').click(function(){

var uid = this.rel;
var eid =$(".click_event_invite").attr('data-eid');
var data_string = 'uid='+ uid+ '&eid='+ eid ;
$("#hide_invite"+uid).hide();
$.ajax({
type: "POST",
url: "manipulates/manipulate.php?xAction=event_invitation",
data:data_string ,
success: function (response) {
console.log(response);
document.getElementById("invited"+uid).innerHTML=response; 
setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });