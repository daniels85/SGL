var host = $(location).attr('host');
$(document).ready(function(){
	
	var container = $('.container');
	var listar_equipamentos = container.find('#listar-equipamentos');
	var modalHeader = $('.ui.modal').find('.header');
	var modalContent = $('.ui.modal').find('.content');
	var mensagem = $('.ui.modal').find('.mensagem');


	listar_equipamentos.on('click', '.btnEditarEquipamento', function(){
		event.preventDefault();

		var idEquipamento = $(this).closest('div').attr('data-id');

		console.log(idEquipamento);

	});

	listar_equipamentos.on('click', '.btnAlertarEquipamento', function(event){
		event.preventDefault();
		now = new Date;
		var data = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();
		var idEquipamento = $(this).closest('div').attr('data-id');

		$.ajax({

			url: 'http://'+host+'/equipamentos/view/'+idEquipamento,
			dataType: 'json',
			type: 'GET',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(equipamento){
				$('.ui.modal').modal('show');
				modalHeader.html("Enviar Alerta - Equipamento: "+equipamento['equipamento'].nome+" [ Tombo: "+equipamento['equipamento'].tombo+" ]");

				conteudoModal  = '<form>';
				conteudoModal += '<label>Descrição: </label>';
				conteudoModal += '<textarea id="descricao" placeholder="Descreva aqui o problema do equipamento..."></textarea>';
				conteudoModal += '<button id="btnEnviarAlerta">Enviar</button>';
				conteudoModal += '</form>';

				modalContent.html(conteudoModal);

				$('#btnEnviarAlerta').on('click', function(event){
					event.preventDefault();
					var tomboEquipamento = equipamento['equipamento'].tombo;
					var geradoPor = equipamento['session'];
					var descricao = $('#descricao').val();
					var codLocal = equipamento['equipamento'].codLocal;

					$.ajax({
						url: 'http://'+host+'/alertas/add',
						type: 'PUT',
						data: 'descricao='+descricao+'&geradoPor='+geradoPor+'&tomboEquipamento='+tomboEquipamento+'&codLocal='+codLocal,

						beforeSend: function(request){
							return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
						},

						success: function(data){
							if(data == 'Cadastrado'){
								mensagem_sucesso =  '<div class="ui success message">';
								mensagem_sucesso += '<div class="header">';
								mensagem_sucesso += '<i class="checkmark icon"></i>Alerta cadastrado com sucesso.';
								mensagem_sucesso += '</div>';
								mensagem_sucesso += '</div>';

								mensagem.html(mensagem_sucesso);
								alteraStatusEquipamento(equipamento, 'Alerta');
								setTimeout(function(){
									location.reload();									
								},1000);
							}
							if(data == 'Erro'){
								mensagem_erro =  '<div class="ui negative message">';
								mensagem_erro += '<div class="header">';
								mensagem_erro += '<i class="warning sign icon"></i>Erro ao enviar alerta.';
								mensagem_erro += '</div>';
								mensagem_erro += '</div>';

								mensagem.html(mensagem_erro);
							}
						},

						error: function(XMLHttpRequest, textStatus, errorThrown){
			  			
			  			}

					});

				});

			}

		});



	});

	$('#addEquipamento').on('click', function(){	
		
		var codLocal = $(this).attr('data-id');

		$('.ui.modal').modal('show');

		conteudoForm  = '<form>';
		conteudoForm += '<label>Nome: </label>';
		conteudoForm += '<input type="text" name="nome" id="nome" placeholder="Ex.: PC-654">';
		conteudoForm += '<label>Tombo: </label>';
		conteudoForm += '<input type="text" name="tombo" id="tombo" placeholder="Ex.: 65464">';
		conteudoForm += '<label>Data de Compra: </label>';
		conteudoForm += '<input type="text" name="dataCompra" id="dataCompra" placeholder="Ex.: 15/15/15">';
		conteudoForm += '<label>Fornecedor: </label>';
		conteudoForm += '<input type="text" name="fornecedor" id="fornecedor" placeholder="Ex.: Empresa X">';
		conteudoForm += '<label>Modelo: </label>';
		conteudoForm += '<input type="text" name="modelo" id="modelo" placeholder="Ex.: All in One">';
		conteudoForm += '<label>Responsável: </label>';
		conteudoForm += '<input type="text" name="responsavel" id="responsavel" placeholder="Ex.: Fulano">';
		conteudoForm += '<label>Tipo: </label>';
		conteudoForm += '<select name="tipo" id="tipo">';
		conteudoForm += '<option value="1">Computador</option>';
		conteudoForm += '</select>';
		conteudoForm += '<button id="bntSalvarEquipamento">Salvar</button>';
		conteudoForm += '<br>';
		conteudoForm += '</form>';

		modalHeader.html('Cadastrar Equipamento');
		modalContent.html(conteudoForm);

		$('#bntSalvarEquipamento').on('click', function(event){

			event.preventDefault();
			
			var nome = $('#nome').val();
			var tombo = $('#tombo').val();
			var dataCompra = $('#dataCompra').val();
			var fornecedor = $('#fornecedor').val();
			var modelo = $('#modelo').val();
			var responsavel = $('#responsavel').val();
			var tipo = $('#tipo').val();

			$.ajax({

				url: 'http://'+host+'/equipamentos/cadastrar',
				type: 'PUT',
				data: 'nome='+nome+'&tombo='+tombo+'&dataCompra='+dataCompra+'&fornecedor='+fornecedor+'&modelo='+modelo+'&responsavel='+responsavel+'&tipo='+tipo+'&codLocal='+codLocal,

				beforeSend: function(request){
					return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
				},

				success: function(data){
					if(data == 'Cadastrado'){
						mensagem_sucesso =  '<div class="ui success message">';
						mensagem_sucesso += '<div class="header">';
						mensagem_sucesso += '<i class="checkmark icon"></i>Equipamento cadastrado com sucesso.';
						mensagem_sucesso += '</div>';
						mensagem_sucesso += '</div>';

						mensagem.html(mensagem_sucesso);
						
						setTimeout(function(){
							location.reload();									
						},1000);

					}
					if(data == 'Erro ao cadastrar'){
						mensagem_erro =  '<div class="ui negative message">';
						mensagem_erro += '<div class="header">';
						mensagem_erro += '<i class="warning sign icon"></i>Erro ao cadastrar equipamento.';
						mensagem_erro += '</div>';
						mensagem_erro += '<ul class="list">';
						mensagem_erro += '<li>Verifique se o tombo do equipamento está correto.</li>';
						mensagem_erro += '<li>Verifique se não há outro equipamento com o mesmo tombo.</li>';
						mensagem_erro += '</ul>';
						mensagem_erro += '</div>';

						mensagem.html(mensagem_erro);

					}
				}


			});

		});

	});

});

function alteraStatusEquipamento(equipamento, status){

	$.ajax({

		url: 'http://'+host+'/equipamentos/edit/'+equipamento['equipamento'].id,
		type: 'PUT',
		data: 'status='+status,

		beforeSend: function(request){
			return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
		},

		success: function(data){
			console.log('');
		}


	});
}