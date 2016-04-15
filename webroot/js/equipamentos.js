var host = $(location).attr('host');	
$(document).ready(function(){
	$('#dataDeCompra').mask("00/00/0000", {placeholder: "__/__/____"});
	var container = $('.container');
	var listar_equipamentos = container.find('#listar-equipamentos');
	var modalHeader = $('.ui.modal').find('.header');
	var modalContent = $('.ui.modal').find('.content');
	var mensagem = $('.ui.modal').find('.mensagem');


	listar_equipamentos.on('click', '.btnEditarEquipamento', function(){
		event.preventDefault();

		var idEquipamento = $(this).closest('tr').attr('data-id');

		$.ajax({

			url: 'http://'+host+'/Equipamentos/edit/'+idEquipamento,
			dataType: 'json',
			type: 'GET',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(data){				

				modalContent.html('');

				conteudoModal  = '<form class="ui form">';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Nome</label>';
				conteudoModal += '<input type="text" id="nome" value="'+data['equipamento'].nome+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Tombo</label>';
				conteudoModal += '<input type="text" id="tombo" value="'+data['equipamento'].tombo+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Status</label>';
				conteudoModal += '<select id="status">';

				conteudoModal += (data['equipamento'].status == 'Funcionando') ? '<option value="Funcionando" selected>Funcionando</option>' : '<option value="Funcionando">Funcionando</option>' ;
				conteudoModal += (data['equipamento'].status == 'Alerta') ? '<option value="Alerta" selected>Alerta</option>' : '<option value="Alerta">Alerta</option>' ;
				conteudoModal += (data['equipamento'].status == 'Defeito') ? '<option value="Defeito" selected>Defeito</option>' : '<option value="Defeito">Defeito</option>' ;

				conteudoModal += '</select>';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Local</label>';
				conteudoModal += '<select id="codLocal">';
				for(i = 0; i < data['locals'].length; i++){
					conteudoModal += (data['locals'][i].codigo == data['equipamento'].codLocal)?'<option value="'+data['locals'][i].codigo+'" selected>'+data['locals'][i].nome+'</option>' : '<option value="'+data['locals'][i].codigo+'">'+data['locals'][i].nome+'</option>';
				}
				conteudoModal += '</select>';				
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Tipo</label>';
				conteudoModal += '<select id="tipo">';
				for(i = 0; i < data['tipoEquipamentos'].length; i++){
					conteudoModal += (data['tipoEquipamentos'][i].id == data['equipamento'].tipo)? '<option value="'+data['tipoEquipamentos'][i].id+'" selected >'+data['tipoEquipamentos'][i].nome+'</option>' : '<option value="'+data['tipoEquipamentos'][i].id+'">'+data['tipoEquipamentos'][i].nome+'</option>';
				}
				conteudoModal += '</select>';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Fornecedor</label>';
				conteudoModal += '<input type="text" id="fornecedor" value="'+data['equipamento'].fornecedor+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Modelo</label>';
				conteudoModal += '<input type="text" id="modelo" value="'+data['equipamento'].modelo+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Responsavel</label>';
				conteudoModal += '<input type="text" id="responsavel" value="'+data['equipamento'].responsavel+'">';
				conteudoModal += '</div>';

				conteudoModal += '<button id="bntEditar" class="ui button green">Salvar</button>';
				conteudoModal += '</form>';

				modalContent.html(conteudoModal);

				modalHeader.html('Editar - Equipamento: '+data['equipamento'].nome+' [ Tombo: '+data['equipamento'].tombo+' ]');

				$('.ui.modal').modal('show');

				$('#bntEditar').on('click', function(event){
					event.preventDefault();

					var nome = $('#nome').val();
					var tombo = $('#tombo').val();
					var status = $('#status').val();
					var codLocal = $('#codLocal').val();
					var fornecedor = $('#fornecedor').val();
					var modelo = $('#modelo').val();
					var responsavel = $('#responsavel').val();
					var tipo = $('#tipo').val();
					var dataDeCompra = $('#dataDeCompra').val();

					$.ajax({

						url: 'http://'+host+'/Equipamentos/edit/'+data['equipamento'].id,
						type: 'PUT',
						data: 	'nome='+nome
								+'&tombo='+tombo
								+'&status='+status
								+'&codLocal='+codLocal
								+'&fornecedor='+fornecedor
								+'&modelo='+modelo
								+'&responsavel='+responsavel
								+'&tipo='+tipo
								+'&dataDeCompra='+dataDeCompra,

						beforeSend: function(request){
							return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
						},

						success: function(data){
							if(data == 'Editado'){
								mensagem_sucesso =  '<div class="ui success message">';
								mensagem_sucesso += '<div class="header">';
								mensagem_sucesso += '<i class="checkmark icon"></i>Equipamento modificado com sucesso.';
								mensagem_sucesso += '</div>';
								mensagem_sucesso += '</div>';

								mensagem.html(mensagem_sucesso);
								setTimeout(function(){
									location.reload();									
								},1000);
							}
							if(data == 'Erro'){
								mensagem_erro =  '<div class="ui negative message">';
								mensagem_erro += '<div class="header">';
								mensagem_erro += '<i class="warning sign icon"></i>Erro ao modificar.';
								mensagem_erro += '</div>';
								mensagem_erro += '</div>';

								mensagem.html(mensagem_erro);
							}
						}

					});

				});

			}

		});

	});


	listar_equipamentos.on('click', '.btnAlertarEquipamento', function(event){
		event.preventDefault();
		now = new Date;
		var data = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();
		var idEquipamento = $(this).closest('tr').attr('data-id');

		$.ajax({

			url: 'http://'+host+'/equipamentos/view/'+idEquipamento,
			dataType: 'json',
			type: 'GET',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(data){
				
				modalContent.html('');

				modalHeader.html("Enviar Alerta - Equipamento: "+data['equipamento'].nome+" [ Tombo: "+data['equipamento'].tombo+" ]");

				conteudoModal  = '<form class="ui form">';
				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Descrição do problema: </label>';
				conteudoModal += '<textarea id="descricao" placeholder="Descreva aqui o problema do equipamento..."></textarea>';
				conteudoModal += '</div>';
				conteudoModal += '<button id="btnEnviarAlerta" class="ui button green">Enviar</button>';
				conteudoModal += '</form>';
				
				modalContent.html(conteudoModal);

				$('.ui.modal').modal('show');

				$('#btnEnviarAlerta').on('click', function(event){
					event.preventDefault();
					var tomboEquipamento = data['equipamento'].tombo;
					var geradoPor = data['session'];
					var descricao = $('#descricao').val();
					var codLocal = data['equipamento'].codLocal;

					$.ajax({
						url: 'http://'+host+'/alertas/add',
						type: 'PUT',
						data: 	'descricao='+descricao
								+'&geradoPor='+geradoPor
								+'&tomboEquipamento='+tomboEquipamento
								+'&codLocal='+codLocal,

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
								alteraStatusEquipamento(data, 'Alerta');
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





	$('#addEquipamento').on('click', function(event){

		event.preventDefault();	
		
		var codLocal = $(this).attr('data-id');

		$.ajax({

			url: 'http://'+host+'/Equipamentos/cadastrar/',
			dataType: 'json',
			type: 'GET',			

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(data){				

				modalContent.html('');

				conteudoModal  = '<form class="ui form">';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Nome: </label>';
				conteudoModal += '<input type="text" name="nome" id="nome" placeholder="Ex.: PC-654">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Tombo: </label>';
				conteudoModal += '<input type="text" name="tombo" id="tombo" placeholder="Ex.: 65464">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Data de Compra: </label>';
				conteudoModal += '<input type="text" name="dataCompra" id="dataDeCompra" placeholder="Ex.: 15/15/15">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Fornecedor: </label>';
				conteudoModal += '<input type="text" name="fornecedor" id="fornecedor" placeholder="Ex.: Empresa X">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Modelo: </label>';
				conteudoModal += '<input type="text" name="modelo" id="modelo" placeholder="Ex.: All in One">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Responsável: </label>';
				conteudoModal += '<input type="text" name="responsavel" id="responsavel" placeholder="Ex.: Fulano">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Tipo</label>';
				conteudoModal += '<select id="tipo">';
				for(i = 0; i < data['tipoEquipamentos'].length; i++){
					conteudoModal += '<option value="'+data['tipoEquipamentos'][i].id+'">'+data['tipoEquipamentos'][i].nome+'</option>';
				}
				conteudoModal += '</select>';
				conteudoModal += '</div>';

				conteudoModal += '<button id="bntSalvarEquipamento" class="ui button green">Salvar</button>';

				conteudoModal += '</form>';

				modalHeader.html('Cadastrar Equipamento');

				modalContent.html(conteudoModal);

				$('.ui.modal').modal('show');

				$('#bntSalvarEquipamento').on('click', function(event){

					event.preventDefault();
					
					var nome = $('#nome').val();
					var tombo = $('#tombo').val();
					var dataDeCompra = $('#dataDeCompra').val();
					var fornecedor = $('#fornecedor').val();
					var modelo = $('#modelo').val();
					var responsavel = $('#responsavel').val();
					var tipo = $('#tipo').val();

					$.ajax({

						url: 'http://'+host+'/equipamentos/cadastrar',
						type: 'PUT',
						data: 	'nome='+nome
								+'&tombo='+tombo
								+'&dataDeCompra='+dataDeCompra
								+'&fornecedor='+fornecedor
								+'&modelo='+modelo
								+'&responsavel='+responsavel
								+'&tipo='+tipo
								+'&codLocal='+codLocal,

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
			}

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