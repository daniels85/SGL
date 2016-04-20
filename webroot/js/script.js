$(document).ready(function(){

	$('.ui.modal')
		.modal('setting', 'transition', 'fade up');
		
	$('.ui.dropdown')
		.dropdown('setting', 'transition', 'slide down')
		.dropdown();

	$('.launch.icon.item').click(function(event){
		event.preventDefault();
		$('.ui.right.vertical.sidebar.menu')
			.sidebar('setting', 'transition', 'overlay')
			.sidebar('toggle');
	});

	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});

});