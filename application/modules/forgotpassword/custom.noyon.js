$(document).ready(function(){
	$('.panel a').click(function(){
		var value = $(this).attr('aria-expanded');
		if(value == 'true'){
			$(this).find('h4>i').removeClass('fa-minus-circle').addClass('fa-plus-circle');
		 }else{
			$(this).find('h4>i').removeClass('fa-plus-circle').addClass('fa-minus-circle');
		 }
	})
	
	// onchecked changed the value of nationality field
	$('input').on('ifChecked', function(event){
	  $('#nationality').val("Bangladeshi");
	});
	$('input').on('ifUnchecked', function(event){
	  $('#nationality').val("");
	});
});