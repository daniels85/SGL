$(document).ready(function(){
	$('.ui.dropdown')
					.dropdown('setting', 'transition', 'slide down')
					.dropdown();
	$('.launch.icon.item').click(function(event){
		event.preventDefault();
		$('.ui.right.vertical.sidebar.menu')
			.sidebar('setting', 'transition', 'overlay')
			.sidebar('toggle');
	});

	$('.btnVerAlerta').click(function(event){
		$('.ui.modal')
			.modal('setting', 'transition', 'fade up')
			.modal('show');
	});
});