/*This is for CKEDITOR to submit textarea data */
function CKupdate(){
for(instance in CKEDITOR.instances)
CKEDITOR.instances[instance].updateElement();
}

/* delete forum answer */
$(document).ready(function(){
$(document).on("click", ".delete_answer", function(e) {
 var isConfirm = window.confirm('Are You Sure Want To Delete This Answer ?');
 if(isConfirm != true){
	return false;	
}
var answerID = this.rel;
var fqID = $(this).attr("data-fqID");
var uri = encodeURIComponent($(this).attr("data-uri"));
var data_string = 'fqID='+ fqID+ '&answerID='+ answerID ;
console.log(data_string);
$.ajax({
type: "POST",
url: "manipulates/delete.php?xAction=delete_answer",
data:data_string ,
success: function (response) {
setTimeout(function()
{ window.location=("question/"+fqID+"/"+uri); 
}, 3000);
document.getElementById("success").innerHTML=response; 
}
}); });
});

/* for answer update*/
$(document).ready(function(){
$(document).on("click", ".click_update_answer", function(e) {
	e.preventDefault();
	$('.click_update_answer').val('Submiting ...');
	var formData= $(this).closest('form').serialize();
	var fqID = $(".fqID").val();
	var uri = encodeURIComponent($(".uri").val());
	console.log(uri);
	$(".click_update_answer").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.7"});
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
			console.log(formData);
			if(response=="true"){
			setTimeout(function()
			{ window.location=("question/"+fqID+"/"+uri);
			$('.click_update_answer').val('Updating ...'); }, 2000);
			}else{
				$('.click_update_answer').val('Save Edit');
				$(".click_update_answer").css({"pointer-events":"","cursor":"","opacity":""});
				document.getElementById("message").innerHTML=response; 
				}
		}
	}); 
});
});

/* for answer up vote */
$(document).ready(function(){
$(document).on("click", ".click_accept_answer", function(e) {
	var isConfirm = window.confirm('Once you accept this as answer you cannot make any changes later.');
if(isConfirm != true){
	return false;	
}
	var fqID = this.rel;
	var answerID = $(this).attr("data-answerID");
	var data_string = 'fqID='+ fqID+ '&answerID='+ answerID ;
	
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=accept_answer",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="true"){
				$("#show_accepted"+answerID).css({"color":"#08ba08"});
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5> Cannot Vote to your own question</h5></div>');
			}else{
				$('#success').html('<div class="floating_message_red"><h5> Already Accepted</h5></div>');
				$("#show_accepted"+answerID).css({"color":"#8c8c8c"});
			 }
		}
	 }); 
 });
});

/* for answer down vote */
$(document).ready(function(){
$(document).on("click", ".click_ans_down_vote", function(e) {
	var answerID = this.rel;
	var type = $(this).attr("data-type");
	var ownerID = $(this).attr("data-ownerID");
	var data_string = 'answerID='+ answerID+ '&type='+ type+ '&ownerID='+ ownerID;
	
	$("#show_ans_up_vote"+answerID).toggleClass("ok_green ok_grey");
	$("#show_ans_down_vote"+answerID).toggleClass("ok_green ok_grey");
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=down_ans_vote",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="already"){
				$('#success').html('<div class="floating_message_red"><h5> Already Voted</h5></div>');
				$("#show_ans_up_vote"+answerID,"#show_ans_down_vote"+answerID).toggleClass("ok_green ok_grey");
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5> You cannot vote to your own answer</h5></div>');
			}else{
				$("#show_ans_votes"+answerID).hide();
				document.getElementById("ans_add"+answerID).innerHTML=response; 
			}
		 }
	 }); 
  });
});

/* for answer up vote */
$(document).ready(function(){
$(document).on("click", ".click_ans_up_vote", function(e) {
	var answerID = this.rel;
	var type = $(this).attr("data-type");
	var ownerID = $(this).attr("data-ownerID");
	var data_string = 'answerID='+ answerID+ '&type='+ type+ '&ownerID='+ ownerID;
	
	$("#show_ans_up_vote"+answerID).toggleClass("ok_green ok_grey");
	$("#show_ans_down_vote"+answerID).toggleClass("ok_green ok_grey");
	
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=up_ans_vote",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="already"){
				$('#success').html('<div class="floating_message_red"><h5> Already Voted</h5></div>');
				$("#show_ans_up_vote"+answerID,"#show_ans_down_vote"+answerID).toggleClass("ok_green ok_grey");
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5>You cannot vote to your own answer</h5></div>');
			}else{
				$("#show_ans_votes"+answerID).hide();
				document.getElementById("ans_add"+answerID).innerHTML=response; 
			 }
		}
	 }); 
 });
});

/* for answering to question */
$(document).ready(function(){
$(document).on("click", ".click_answer_question", function(e) {
	e.preventDefault();
	$('.click_answer_question').val('Submiting...');
	var formData= $(this).closest('form').serialize();
	var fqID = $(".fqID").val();
	var uri = encodeURIComponent($(".uri").val());
	$(".click_answer_question").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.7"});
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
			console.log(formData);
			if(response=="true"){
			setTimeout(function()
			{ window.location=("question/"+fqID+"/"+uri);
			$('.click_answer_question').val('Posting ...'); }, 2000);
			}else{
				$('.click_answer_question').val('Post Answer');
				$(".click_answer_question").css({"pointer-events":"","cursor":"","opacity":""});
				document.getElementById("loading_anwer_box").innerHTML=response; 
				}
		}
	}); 
});
});

/* for answer box*/
$(document).ready(function(){
$(document).on("click", ".click_answer_this_question", function(e) {
	if($('.click_answer_this_question').text()=='Answer this Question')
	{
	$('.click_answer_this_question').text('Cancel')	
		}
		else{
			$('.click_answer_this_question').text('Answer this Question')
			}
//$('.click_answer_question').text('Cancel');	
$('#loading_anwer_box').html('Loading...');
setTimeout(function()
{ $(".hide_anwer_box").fadeToggle();
$('#loading_anwer_box').html(''); }, 1000);	
});
});

/* for question update*/
$(document).ready(function(){
$(document).on("click", ".click_update_question", function(e) {
	e.preventDefault();
	$('.click_update_question').val('Submiting ...');
	var formData= $(this).closest('form').serialize();
	var fqID = $(".fqID").val();
	var uri = encodeURIComponent($(".uri").val());
	console.log(uri);
	$(".click_update_question").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.7"});
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
			console.log(formData);
			if(response=="true"){
			setTimeout(function()
			{ window.location=("question/"+fqID+"/"+uri);
			$('.click_update_question').val('Updating ...'); }, 2000);
			}else{
				$('.click_update_question').val('Save Edit');
				$(".click_update_question").css({"pointer-events":"","cursor":"","opacity":""});
				document.getElementById("message").innerHTML=response; 
				}
		}
	}); 
});
});

/* for forum down vote */
$(document).ready(function(){
$(document).on("click", ".click_down_vote", function(e) {
	$("#show_up_vote,#show_down_vote").toggleClass("ok_green ok_grey");
	
	var fqID = this.rel;
	var type = $(this).attr("data-type");
	var ownerID = $(this).attr("data-ownerID");
	var data_string = 'fqID='+ fqID+ '&type='+ type+ '&ownerID='+ ownerID;
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=down_vote",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="already"){
				$('#success').html('<div class="floating_message_red"><h5> Already Voted</h5></div>');
				$("#show_up_vote,#show_down_vote").toggleClass("ok_green ok_grey");
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5>You cannot vote to your own question</h5></div>');
			}else{
				$("#show_votes").hide();
				document.getElementById("add").innerHTML=response; 
			}
		 }
	 }); 
  });
});

/* for forum up vote */
$(document).ready(function(){
$(document).on("click", ".click_up_vote", function(e) {
	$("#show_up_vote,#show_down_vote").toggleClass("ok_green ok_grey");
	
	var fqID = this.rel;
	var type = $(this).attr("data-type");
	var ownerID = $(this).attr("data-ownerID");
	var data_string = 'fqID='+ fqID+ '&type='+ type+ '&ownerID='+ ownerID;
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php?xAction=up_vote",
		data:data_string ,
		success: function (response) {
		//console.log(response);
			if(response=="already"){
				$('#success').html('<div class="floating_message_red"><h5> Already Voted</h5></div>');
				$("#show_up_vote,#show_down_vote").toggleClass("ok_green ok_grey");
			}else if(response=="yourself"){	
				$('#success').html('<div class="floating_message_red"><h5>You cannot vote to your own question</h5></div>');
			}else{
				$("#show_votes").hide();
				document.getElementById("add").innerHTML=response; 
			 }
		}
	 }); 
 });
});

/* for asking question */
$(document).ready(function(){
$(document).on("click", ".click_ask_question", function(e) {
	e.preventDefault();
	$('.click_ask_question').val('Submiting...');
	var formData= $(this).closest('form').serialize();
	
	$(".click_ask_question").css({"pointer-events":"none","cursor":"not-allowed","opacity":"0.7"});
	$.ajax({
		type: "POST",
		url: "manipulates/manipulate.php",
		data:formData ,
		success: function (response) {
			console.log(formData);
			if(response=="true"){
			setTimeout(function()
			{ window.location=("forum.php");
			$('.click_ask_question').val('Posting ...'); }, 2000);
			}else{
				$('.click_ask_question').val('Post Question');
				$(".click_ask_question").css({"pointer-events":"","cursor":"","opacity":""});
				document.getElementById("message").innerHTML=response; 
				}
		}
	}); 
});
});