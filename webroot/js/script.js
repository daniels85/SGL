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
	
	$('.find.equipamento input').api({
		action 		 : 'find equipamento',
		stateContext : '.ui.input.find.equipamento',
		url : 'http://'+$(location).attr('host')+'/Equipamentos/find/{value}',
		method : 'GET',
		beforeXHR: function(xhrObject){
			return xhrObject.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
		},

		onSuccess: function(data){
			var response = {
		        	results : {}
		      	};

			if(!data || !data.equipamentos){
				return;
			}

			$.each(data.equipamentos, function(index, item){
				var maxResults = 4;

				if(index >= maxResults){
					return false;
				}

				if(response.results[index] === undefined) {
					response.results[index] = {
						name    : index,
						results : []
					};
				}

				response.results[index].results.push({
					title       : item.name,
					description : item.tombo
				});

			});
			console.log(response);
			return response;
		}
	});
	

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