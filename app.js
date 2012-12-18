$('form').submit(function(e) { 
		e.preventDefault();
		
		var method = $(this).attr('method');
		var action = $(this).attr('action');
		
		if(method == 'PUT') { action = $(this).attr('action') + '?' + $(this).serialize(); }
		
		$.ajax({
			type: method,
			url: action,
			data: $(this).serialize(),
			dataType: 'JSON'
		}).done(function(data) {  
			if(data.message) alert(data.message)
			if(data.success) $('.modal').modal('hide');
		});
		
	});