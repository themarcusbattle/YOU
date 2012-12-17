	$('.checklist li').each(function() {  
		var text = $(this).html();
		$(this).html('<input type="checkbox" />' + text)
	});