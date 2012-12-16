$(function() {
	var cElem = $('#serialize');
	var sChecked = isChecked(cElem);
	var vId = "#varname-wrapper";

	if (sChecked) {
		$(vId).hide();
	}

	// Toggles visibility of the varname text input based on checked state
	// of serialize checkbox
	$("#serialize").change(function() {
		if (isChecked($(this))) {
			$(vId).fadeOut();
		} else {
			$(vId).fadeIn();
		}
	});

	/**
	 * Checks if a checkbox elem is checked
	 * 
	 * @param elem The jQuery object for the selected element
	 * @return bool 
	 */
	function isChecked(elem) {
		return elem.attr('checked') == 'checked';
	}
});