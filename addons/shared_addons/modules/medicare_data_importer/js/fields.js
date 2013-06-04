(function($)
{
	$(function() {
		$('#name').keyup(function() {
 	 		$('#code').val(slugify($('#name').val()));
		});
	});
})(jQuery);