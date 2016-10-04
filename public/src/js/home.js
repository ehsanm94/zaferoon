$(document).ready(function() {
	$('.ui.sticky').sticky({
		context: '#home_courses-list',
		observeChanges: true,
	});

	$('#calendar-lg').calendar();
	$('#calendar-sm').calendar();

	$('body').persiaNumber();

});