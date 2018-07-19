/*Filter Batches*/
$(document).ready(function(){
	$(document).on("click", ".click_filter_batch", function (e) {
		var filter = this.rel;
		var reqid = $(this).attr("data-uid");
		var data_string = 'filter='+ filter+ '&reqid='+ reqid ;
		$("#hide_default_filter").hide();
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/ajax_data.php?xAction=filter_batch",
			data:data_string ,
			success: function (response) {
			console.log(response);
			document.getElementById("show_filter_batch").innerHTML=response; 
			}
		}); 
	});
});


/* for workplace edit form */
$(document).ready(function(){
	$(document).on("click", ".edit_wp", function(e) {
		var workID = this.rel;
		var data_string = 'workID='+ workID;
		$.ajax({
	type: "POST",
	url:"manipulates/ajax_data.php?xAction=edit_wp",
	data:data_string,
	success: function (response) {
			$('#loading').html('Loading...');
			$(".show_workplace_list").css({"display":"none"});
			$(".hideContact_for_wp").toggle(); 
			$(".click_add_wp").toggle();
			setTimeout(function()
			{ $(".show_edit_wp").fadeToggle();
			$('#loading').html(''); }, 1000);
			document.getElementById("show_edit_wp").innerHTML=response; 
		}
		
	  });
   });
});
