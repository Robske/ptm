// Alerts
$(".alert").delay(5000).hide(0);


// Add slide down & up animation to Bootstrap dropdown when expanding.
$('.dropdown').on('show.bs.dropdown', function() {
	$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});

$('.dropdown').on('hide.bs.dropdown', function() {
	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(0);
});