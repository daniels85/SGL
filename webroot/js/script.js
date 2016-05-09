$(document).ready(function(){
	
	$('#dataInicio').mask("00-00-0000", {placeholder: "__-__-____"});
	$('#dataFim').mask("00-00-0000", {placeholder: "__-__-____"});
	$('#dataDeCompra').mask("00-00-0000", {placeholder: "__-__-____"});
	
	$('.ui.modal')
		.modal('setting', 'transition', 'fade up');

	$('.coupled.modal')
		.modal({ allowMultiple: true });
		
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

	$('.ui.checkbox').checkbox();

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