function auto_number(event, value) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;

	// format number
	return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function indo_currency(value) {
	return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
