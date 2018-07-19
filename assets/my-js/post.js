/* for deleting post */
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

/* for unliking post */
$(document).ready(function(){
$(document).on("click", ".click_unlike", function(e) {

	var postid = $(this).attr('id');
	var likeType = $(this).attr("data-likeType"); 
	var data_string = 'likeType='+ likeType+ '&postid='+ postid ;
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=unlike_post",
		data:data_string ,
		cache: false,
		success: function (response) {
		//console.log(response);
			$("#"+ postid).css({"color":"","font-weight":"600"}).html('<i class="icon-thumbs-up-alt"></i> Like').addClass('click_like').removeClass('click_unlike');
			$("#default_count"+ postid).hide();
			document.getElementById("like_count"+postid).innerHTML=response;
			if(response=="already"){
				$('#success').html('<div class="floating_message_red"><h5> Already Unliked</h5></div>');
			}
		}
	 }); 
   }); 
});

/* for liking post */
$(document).on("click", ".click_like", function(e) {
	var postid = $(this).attr('id');
	var likeType = $(this).attr("data-likeType"); 
	var data_string = 'likeType='+ likeType+ '&postid='+ postid ;
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=like_post",
		data:data_string ,
		success: function (response) {
				$("#"+postid).css({"color":"#2093F5","font-weight":"600"}).html('<i class="icon-thumbs-up-alt"></i> Liked').addClass('click_unlike').removeClass('click_like');	
			$("#default_count"+ postid).hide();
			document.getElementById("like_count"+postid).innerHTML=response;
			 if(response=="already"){	
				$('#success').html('<div class="floating_message_red"><h5> Already Liked</h5></div>');
			}
		}
	 }); 
 });