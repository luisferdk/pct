/* Simple script to highlight fields that are left empty that have the attribute data-required = true */
/* Use only for jquery chosen dropdown fields. HTML5 "required" attribute is sufficient for other inputs */

$('form').each(function() {

	$(this).submit(function() {
		
		var faults = $(this).find('select').filter(function() {
			return $(this).data('required') && $(this).val() === "";
		}).css("background-color", "#FFB0B0");
		
		// Apply to special chosen fields
		faults.each(function() {
			var id = "#" + $(this).attr("id") + "_chosen a";
			$(id).css("background-color", "#FFB0B0");
			$(id).css("background-image", "none");
			$(id).css("color", "#333");
			$(this).change(function() {
				$(id).css("background-image", "linear-gradient(#eeeeee 20%, #ffffff 80%)");
			});
		});
		
		if(faults.length) {
			return false;
		}
	});
	
});