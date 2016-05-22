$(document).ready(function(){

	var host = $(location).attr('host');
	var container = $('.container');
	var modal = container.find('.ui.modal');
	var modalMensagem = modal.find('.mensagem');
	var modalHeader = modal.find('.header');
	var modalContent = modal.find('.content');
	var modalActions = modal.find('.actions');

	$('.apagarLocal').on('click', function(event){

		event.preventDefault();

		codigoLocal = $(this).closest('div').attr('data-codigo');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		conteudoModal  = '<h2 class="ui center aligned icon header">';
		conteudoModal += '<i class="delete icon"></i>';
		conteudoModal += 'Realmente deseja apagar este Local?';
		conteudoModal += '</h2>';
		conteudoModal += '<h3 class="ui horizontal divider header"></h3>';	

		actionModal = '<button class="ui negative button tiny labeled icon">';
		actionModal += '<i class="remove icon"></i>';
		actionModal += 'Não';
		actionModal += '</button>';

		actionModal += '<button class="ui positive button tiny labeled icon">';
		actionModal += '<i class="checkmark icon"></i>';
		actionModal += 'Sim';
		actionModal += '</button>';

		modalContent.html(conteudoModal);
		modalActions.html(actionModal);

		modal.modal({
					onDeny : function(){
						modal.modal('hide');
					},
					onApprove : function() {
						$.ajax({

							url : 'http://'+host+'/locals/delete/'+codigoLocal,
							type : 'POST',

							beforeSend : function(request){
								return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
							},

							success : function(data, textStatus){
								setTimeout(function(){
									location.reload();									
								},500);
							},

							error: function(XMLHttpRequest, textStatus, errorThrown){
				  				
				  				modalHeader.html('');
								modalContent.html('');
								modalActions.html('');

								conteudoModal  = '<h2 class="ui center aligned header icon">';
								conteudoModal += '<i class="warning sign icon"></i>';
								conteudoModal += '<div class="content">';
								conteudoModal += 'Ops! Ocorreu um erro ao tentar apagar.';
								conteudoModal += '<div class="sub header">';
								conteudoModal += 'Certifique-se que não há nenhum equipamento associado a este Ambiente.';
								conteudoModal += '</div>';
								conteudoModal += '</div>';
								conteudoModal += '</h2>';

								actionModal  = '<button class="ui positive button tiny labeled icon">';
								actionModal += '<i class="checkmark icon"></i>';
								actionModal += 'Ok';
								actionModal += '</button>';

								modalContent.html(conteudoModal);
								modalActions.html(actionModal);
								modal.modal({
											onApprove : function(){
												modal.modal('hide');
											}
										})
										.modal('show');


				  			}

						});

					}
				})
		.modal('show');

	});

});