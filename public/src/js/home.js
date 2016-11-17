$(document).ready(function() {
	$('.zaferoon').html('');
	var intervalId = setInterval(function() {
		$('.zaferoon').html($('.zaferoon').html() + '. ');
	}, 125);

	setTimeout(function() {
		clearInterval(intervalId);
		$('.zaferoon').html('زعفرون');
	}, 500);
});