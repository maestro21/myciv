$(function() {
	
	/* tabs */
	$(".tabContent > div").hide();
	$(".tabContent > div:first").show();
	$('.tabs a:first').addClass("selected");	
    $('.tabs a').each(function() {
		$(this).click(function() { console.log('1');
			$('.tabs a').removeClass("selected");
			$( this ).addClass("selected");
			var tab_id = $( this ).attr("href");
			$(".tabContent > div").hide();
			$(tab_id).show();
		});	
	});
	
	
});