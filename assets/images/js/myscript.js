
/* for asking question */
$(document).ready(function(){
 $(document).on("click", ".click_ask", function (e) {
e.preventDefault();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php",
	data:formData ,
	success: function (response) {
	document.getElementById("msg_sent").innerHTML=response;
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

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
}); }); });

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
}); }); });

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



/* for delete group chat*/
$(document).ready(function(){
$('.delete_group_chat').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete This Chat ?');
if(isConfirm != true){
		return false;	
	}
var gid = this.rel;
var data_string = 'gid='+ gid ;
console.log(data_string);
//$("#accept_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/delete.php?xAction=del_group_chat",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for delete group message*/
$(document).ready(function(){
$('.click_del_grp_msg').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete This Message ?');
if(isConfirm != true){
		return false;	
	}
var gdstatusID = this.rel;
var data_string = 'gdstatusID='+ gdstatusID ;
console.log(data_string);
//$("#accept_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/delete.php?xAction=del_group_msg",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for group discussion */
$(document).ready(function(){
$(".msg_loader").hide();
$("#msg_sent").hide();
$(document).on("click", ".click_discussion", function (e) {
e.preventDefault();
$(".msg_loader").show();
$("#btn-chat").hide();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php",
	data:formData ,
	success: function (response) {
	document.getElementById("msg_sent").innerHTML=response;
	$(".msg_loader").hide();
	$("#msg_sent").show();
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for deleting group post */
$(document).ready(function(){
$('.click_delete_post').click(function(){
	var isConfirm = window.confirm('Are You Sure Want To Delete This Post ?');
if(isConfirm != true){
		return false;	
	}
var id =$(".click_delete_post").attr('data-id');	
var postid = this.rel;
var postType =$(".click_delete_post").attr('data-postType');
var data_string ='postid='+ postid+ '&postType='+ postType ;
$("#hide_delete_post").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=delete_post",
	data:data_string ,
	success: function (response) {
	console.log(response);
	if(postType=='group.post')
	{
		setTimeout(function()
		{ window.location=("group/"+id); }, 3000);
		document.getElementById("show_delete_post").innerHTML=response; 
	}else if(postType=='event.post'){
		setTimeout(function()
		{ window.location=("event/"+id); }, 3000);
		document.getElementById("show_delete_post").innerHTML=response; 
	}
	else if(postType=='home.post'){
		setTimeout(function()
		{ window.location=("home.php"); }, 3000);
		document.getElementById("show_delete_post").innerHTML=response; 
	}
	
}
}); }); });

/* for deleting  post comment*/
$(document).ready(function(){
$('.click_delete_comment').click(function(){
	var isConfirm = window.confirm('Are You Sure Want To Delete This Comment ?');
if(isConfirm != true){
		return false;	
	}
var commentid = this.rel;
var postid =$(".click_delete_comment").attr('data-postid');
var postType =$(".click_delete_comment").attr('data-postType');
var data_string = 'commentid='+ commentid+ '&postid='+ postid+ '&postType='+ postType ;
$("#hide_delete"+commentid).hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=delete_comment",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_delete"+commentid).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for unliking post comment*/
$(document).ready(function(){
$('.click_comment_unlike').click(function(){
var commentid = this.rel;
var postid =$(".click_comment_unlike").attr('data-postid');
var likeType =$(".click_comment_unlike").attr('data-likeType');
var data_string = 'commentid='+ commentid+ '&postid='+ postid+ '&likeType='+ likeType ;
$("#hide_comment_unlike"+commentid).hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=unlike_post_comment",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_comment_unlike"+commentid).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for liking post comment */
$(document).ready(function(){
$('.click_comment_like').click(function(){
var commentid = this.rel;
var postid =$(".click_comment_like").attr('data-postid');
var likeType =$(this).attr('data-likeType');
var data_string = 'commentid='+ commentid+ '&postid='+ postid+ '&likeType='+ likeType ;
$("#hide_comment_like"+commentid).hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=like_post_comment",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_comment_like"+commentid).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for hiding comment box */
$(document).ready(function(){
$(document).on("click", ".click_show_comment_box", function () {
$(".hide_comment_box").fadeToggle();
}); 

/* for post comment */
$(document).on("click", ".click_post_comment", function (e) {
e.preventDefault();

$("#hide_comment").hide();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php",
	data:formData ,
	success: function (response) {
	document.getElementById("show_comment").innerHTML=response;

	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for unliking group post */
$(document).ready(function(){
$('.click_unlike').click(function(){
var postid = this.rel;
var likeType = $(this).attr("data-likeType");
var data_string = 'likeType='+ likeType+ '&postid='+ postid ;
$("#hide_unlike"+postid).hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=unlike_group_post",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_unlike"+postid).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for liking post */
$(document).ready(function(){
$('.click_like').click(function(){
var postid = this.rel;
var likeType = $(this).attr("data-likeType"); 
var data_string = 'likeType='+ likeType+ '&postid='+ postid ;
$("#hide_like"+postid).hide();
console.log(data_string);
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=like_post",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("show_like"+postid).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
	}); });
});

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

/* for cancel invitation */
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

/* for cancel */
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



/* for message */
$(document).ready(function(){
$(".msg_loader").hide();
$("#msg_sent").hide();
$(document).on("click", ".click_send_msg", function (e) {
e.preventDefault();
$(".msg_loader").show();
$("#btn-chat").hide();
var formData= $(this).closest('form').serialize();
console.log(formData);
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php",
	data:formData ,
	success: function (response) {
	document.getElementById("msg_sent").innerHTML=response;
	$(".msg_loader").hide();
	$("#msg_sent").show();
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });



/* for delete whole chat*/
$(document).ready(function(){
$('.delete_chat').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete This Chat ?');
if(isConfirm != true){
		return false;	
	}
var uID = this.rel;
var data_string = 'uID='+ uID ;
console.log(data_string);
//$("#accept_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/delete.php?xAction=delete_chat",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); });  });

/* for delete message*/
$(document).ready(function(){
$('.click_del_msg').click(function(){
var isConfirm = window.confirm('Are You Sure Want To Delete This Message ?');
if(isConfirm != true){
		return false;	
	}
var msgID = this.rel;
var data_string = 'msgID='+ msgID ;
console.log(data_string);
//$("#accept_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/delete.php?xAction=del_msg",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for ask contact*/
$(document).ready(function(){
$('.click_share_info').click(function(){
var reqinfoID = this.rel;
var data_string = 'reqinfoID='+ reqinfoID ;
console.log(data_string);
$("#accept_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=share_info",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("req_share").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); })

/* for decline info*/
$(document).ready(function(){
$('.click_decline_info').click(function(){
var reqinfoID = this.rel;
var data_string = 'reqinfoID='+ reqinfoID ;
console.log(data_string);
$("#decline_share").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=decline_info",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("req_decline").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for cancel share info*/
$(document).ready(function(){
$('.click_cancel_share').click(function(){
var sharereqID = this.rel;
var data_string = 'sharereqID='+ sharereqID ;
console.log(data_string);
$("#hide_cancel"+sharereqID).hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=decline_info",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("cancel_share"+sharereqID).innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });



/* for ask contact*/
$(document).ready(function(){
$('.click_ask_contact').click(function(){
var requserID = this.rel;
var reqAbout =$(".click_ask_contact").attr('data-contact');
var data_string = 'requserID='+ requserID+ '&reqAbout='+ reqAbout ;
console.log(data_string);
//$("#cancel_frnd").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=ask_contact",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("contact_ask_success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });

/* for ask email*/
$(document).ready(function(){
$('.click_ask_email').click(function(){
var requserID = this.rel;
var reqAbout =$(".click_ask_email").attr('data-email');
var data_string = 'requserID='+ requserID+ '&reqAbout='+ reqAbout ;
console.log(data_string);
//$("#cancel_frnd").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=ask_email",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("email_ask_success").innerHTML=response; 
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 3000);

}
}); }); });



/* for friend request */
$(document).ready(function(){
$('.click_add_friend').click(function(){
var friendWith = this.rel;
var data_string = 'friendWith='+ friendWith;
$("#add_frnd").hide();
$.ajax({
	type: "POST",
	url: "manipulates/manipulate.php?xAction=friend_request",
	data:data_string ,
	success: function (response) {
	console.log(response);
	document.getElementById("req_sent").innerHTML=response; 
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


/* click cancel */
$(document).ready(function(e) {
	$(document).on("click", ".click_cancel", function (e) {
	setTimeout(function(){// wait for 5 secs(2)
location.reload(); // then reload the page.(3)profile_container
}, 100);
	});
});

/* click more for workplace */
$(document).ready(function(e) {
	$(document).on("click", ".click_more", function (e) {
	var wid=this.rel;
	$(".hide_onclick"+wid).toggle();	
	$(".show_onclick"+wid).toggleClass("display_none");	
	});
});

/* click add workplace */
$(document).ready(function(e) {
	$(document).on("click", ".click_add_wp", function (e) {
			$(".show_workplace_list").toggleClass("display_none");	
			$(".hideContact_for_wp").toggle();	
			$("#show_edit_wp").toggle();
			$(".show_edit_wp").toggle();
			$('#loading').html(''); 
			$(".show_add_wp").toggle();	
			$('#loading').html('');
	
	});
});

/*Profile*/
$(document).ready(function(e) {
	$(document).on("click", ".click_edit", function (e) {
	var id=this.rel;	
	$(".show"+id).toggle();	
	$(".hide"+id).toggleClass("display_none");	
	});
});

