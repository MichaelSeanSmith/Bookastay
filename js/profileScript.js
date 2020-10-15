$('#pic').on('change',function(){
	var fileName = $(this).val();
	$('#picLabel').html(fileName);
});