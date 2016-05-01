$(document).ready(function(){

	host = $(location).attr('host');
	container = $('.container');
	modal = container.find('.ui.modal');
	modalMensagem = modal.find('.mensagem');
	modalHeader = modal.find('.header');
	modalContent = modal.find('.content');
	modalActions = modal.find('.actions');

	$('.gerarRelatorioLocal').on('click', function(event){

		event.preventDefault();

		var codLocal = $(this).closest('button').attr('data-id');

		modal.modal('show');

		conteudo = '<form class="ui form" method="POST" action="">';

		conteudo += '<h4 class="ui dividing header">Período do Relatório</h4>';

		conteudo += '<div class="equal width fields required">';

		conteudo += '<div class="field">';
		conteudo += '<label>Início: </label>';
		conteudo += '<input type="text" id="dataInicio">';
		conteudo += '</div>';

		conteudo += '<div class=" field">';
		conteudo += '<label>Fim: </label>';
		conteudo += '<input type="text" id="dataFim">';
		conteudo += '</div>';

		conteudo += '</div>';

		conteudo += '<div class="ui message error"></div>';

		conteudo += '<button class="ui button positive">Enviar</button>';

		conteudo += '</form>';

		modalHeader.html('Gerar Relatório');

		modalContent.html(conteudo);

		modal.modal('show');

		$('#dataInicio').mask("00/00/0000", {placeholder: "__/__/____"});
		$('#dataFim').mask("00/00/0000", {placeholder: "__/__/____"});

		$('.ui.form').form({
			
			dataInicio : {
				identifier : 'dataInicio',
				rules : [
					{
						type : 'minLength[10]',
						prompt : 'Insira uma data de início válida.'
					}
				]
			},

			dataFim : {
				identifier : 'dataFim',
				rules : [
					{
						type : 'minLength[10]',
						prompt : 'Insira uma data de fim válida.'
					}
				]
			}

		}, {
			
			onSuccess : function(event){
				event.preventDefault();

				var dataInicio = $('#dataInicio').val();
				var dataFim = $('#dataFim').val();

				/*
				$.ajax({

					url : 'http://'+host+'/locals/relatorio/'+codLocal,
					dataType: 'json',
					type : 'POST',
					data : 'dataInicio='+dataInicio+'&dataFim='+dataFim,

					beforeSend: function(request){
						return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
					}

				});
				*/
			}

		});

	});

});