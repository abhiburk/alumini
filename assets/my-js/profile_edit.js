/* click cancel wp */
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

/*Profile Edit*/
$(document).ready(function(e) {
$(document).on("click", ".click_edit", function (e) {
var id=this.rel;	
$(".show"+id).toggle();	
$(".hide"+id).toggleClass("display_none");	
});
});