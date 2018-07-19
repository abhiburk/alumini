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