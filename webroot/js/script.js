$(document).ready(function(){
	
	$('.inputData').mask("00-00-0000");
	$('#dataDeCompra').mask("00-00-0000", {placeholder: "__-__-____"});
	
	$('.ui.accordion').accordion();

	$('.ui.modal')
		.modal('setting', 'transition', 'fade up');

	$('.coupled.modal')
		.modal({ allowMultiple: true });
		
	$('.ui.dropdown')
		.dropdown('setting', 'transition', 'slide down')
		.dropdown();

	$('.button')
		.popup({
    		on: 'hover'
 		 });

	$('.launch.icon.item').click(function(event){
		event.preventDefault();
		$('.ui.right.vertical.sidebar.menu')
			.sidebar('setting', 'transition', 'overlay')
			.sidebar('setting', 'mobileTransition', 'overlay')
			.sidebar('toggle');
	});

	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});

	$('.ui.checkbox').checkbox();


	$('#rangestart').calendar({
		type: 'date',
		endCalendar: $('#rangeend'),
		formatter: {
			date: function (date, settings) {
				if (!date) return '';
				var day = date.getDate();
				var month = date.getMonth() + 1;
				var year = date.getFullYear();
				return day + '-' + month + '-' + year;
			}
		}
	});
	$('#rangeend').calendar({
		type: 'date',
		startCalendar: $('#rangestart'),
		formatter: {
			date: function (date, settings) {
				if (!date) return '';
				var day = date.getDate();
				var month = date.getMonth() + 1;
				var year = date.getFullYear();
				return day + '-' + month + '-' + year;
			}
		}
	});

});

function marcarTodos(){
  $('.checkbox').each(
         function(){
           $(this).prop("checked", true);              
         }

    );
}
function desmarcarTodos(){
  $('.checkbox').each(
         function(){
           $(this).prop("checked", false);               
         }
    );
}