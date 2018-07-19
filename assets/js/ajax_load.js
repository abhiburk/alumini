
$(document).ready(function(){
    $('.menu_head input[type="text"]').on("keyup input", function(){
		$("#result").addClass("search_box");
       $("#result").html('<ul class="cute"><li><center><img src="images/spinner.gif" style="width:30px"></center></li></ul>').show();
		var searchVal = $(this).val();
		var data_string = 'searchVal='+ searchVal ;
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/live_search.php",
			data:data_string ,
			success: function (response) {
			console.log(response);
			setTimeout(function(){ 
			$("#result").html(response).fadeIn();
			}, 2000);
			}
	}); 
    });
			$(document).mouseup(function(e) 
{
    var container = $("#result");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.hide();
    }
});
});	
/*User About Tab*/
$(document).ready(function(){
	$(".tab_about").addClass("active");
	$(document).on("click", ".click_user_tab", function (e) {
		$("#hide_default_tab").hide();
		$("#tab_result").html("Loading ...");
		var tab_filter = this.rel;
		var xAction = 'tab_filter';
		var uid = $(this).attr("data-uid");
		var data_string = 'tab_filter='+ tab_filter+ '&xAction='+ xAction+ '&uid='+ uid ;
		$(".tab_about").removeClass("active");
		$(".remove").removeClass("active");
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/ajax_data.php",
			data:data_string ,
			success: function (response) {
			console.log(response);
			$(".tab_"+tab_filter).addClass("active");
			document.getElementById("tab_result").innerHTML=response; 
    FB.XFBML.parse();
			}
		}); 
	});
});

/*Home Pagination */
$(document).ready(function(){
	//$("#more_result").load('manipulates/ajax_data.php?xAction=home_pagination').show();
	$(document).on("click", ".click_more_records", function (e) {
		
		$("#more_result").html('<span>Loading ...</span>').show();
		var nid = this.rel;
		var data_string = 'nid='+ nid ;
		$("#default_result").hide();
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/ajax_data.php?xAction=home_pagination",
			data:data_string ,
			success: function (response) {
			console.log(response);
			document.getElementById("more_result").innerHTML=response; 
			//$("#more_result").load('manipulates/ajax_data.php?xAction=home_pagination').show();
			}
		}); 
	});
});

/*Search */
$(document).ready(function(){
	$(document).on("click", ".click_searchBy", function (e) {
		$("#show_search").html('<ul class="cute"><li><span>Loading ...</span></li></ul>').show();
		var searchBy = this.rel;
		var datasearch = $(this).attr("data-search");
		var data_string = 'searchBy='+ searchBy+ '&datasearch='+ datasearch ;
		$("#default_search").hide();
		console.log(data_string);
		$.ajax({
			type: "POST",
			url: "manipulates/ajax_data.php",
			data:data_string ,
			success: function (response) {
			console.log(response);
			setTimeout(function(){ 
			$("#show_search").html(response).fadeIn();
			}, 2000);
			
			}
		}); 
	});
});

/* for steps search friends */
$(document).ready(function(){
$(document).on("click", ".click_search_friends", function(e) {
	e.preventDefault();
	var formData= $(this).closest('form').serialize();
	console.log(formData);
	$.ajax({
		type: "POST",
		url: "manipulates/ajax_data.php",
		data:formData ,
		success: function (response) {
			console.log(response);
			$('#loading').html('Loading...');
			setTimeout(function()
			{ 
			$('#loading').html(''); 
			document.getElementById("searchResults").innerHTML=response;
			}, 1000);
			if($('#searchResults:empty').html()!= '')
			{$('#default_new_user').css({"display":"none"});
			}

		}
	}); 
});
});

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
