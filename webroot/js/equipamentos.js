var host = $(location).attr('host');	

$(document).ready(function(){
	var container = $('.container');
	var listar_equipamentos = container.find('#listar-equipamentos');
	var modal = $('.ui.modal');
	var modalHeader = $('.ui.modal').find('.header');
	var modalContent = $('.ui.modal').find('.content');
	var mensagem = $('.ui.modal').find('.mensagem');
	var modalActions = $('.ui.modal').find('.actions');

	listar_equipamentos.on('click', '.btnEditarEquipamento', function(){
		event.preventDefault();

		var idEquipamento = $(this).closest('tr').attr('data-id');

		$.ajax({

			url: 'http://'+host+'/Equipamentos/editar/'+idEquipamento,
			dataType: 'json',
			type: 'GET',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(data){				

				modalContent.html('');

				conteudoModal  = '<form class="ui form editEquipamento">';

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
				conteudoModal += '<select id="codLocal" class="ui fluid dropdown">';
				for(i = 0; i < data['locals'].length; i++){
					conteudoModal += (data['locals'][i].codigo == data['equipamento'].codLocal)?'<option value="'+data['locals'][i].codigo+'" selected>'+data['locals'][i].nome+'</option>' : '<option value="'+data['locals'][i].codigo+'">'+data['locals'][i].nome+'</option>';
				}
				conteudoModal += '</select>';				
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Tipo</label>';
				conteudoModal += '<select id="tipo" class="ui fluid dropdown">';
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
				conteudoModal += '<label>dataDeCompra</label>';
				conteudoModal += '<input type="text" id="dataDeCompra" value="'+moment(data['equipamento'].dataDeCompra).format('DD/MM/YYYY')+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Responsavel</label>';
				conteudoModal += '<input type="text" id="responsavel" value="'+data['equipamento'].responsavel+'">';
				conteudoModal += '</div>';

				conteudoModal += '<div class="ui error message"></div>';

				conteudoModal += '<button class="ui button green">Salvar</button>';
				conteudoModal += '</form>';

				modalContent.html(conteudoModal);

				modalHeader.html('Editar - Equipamento: '+data['equipamento'].nome+' [ Tombo: '+data['equipamento'].tombo+' ]');

				$('#dataDeCompra').mask("00/00/0000", {placeholder: "__/__/____"});

				modal.modal('show');

				// Validação do formulário

				$('.ui.form.editEquipamento').form({

					nome : {
						identifier : 'nome',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo nome é obrigatório.'
							}
						]
					},

					tombo : {
						identifier : 'tombo',
						rules : [
							{
								type : 'minLength[6]',
								prompt : 'O tombo deve conter no mínimo 6 caracteres.'
							}
						]
					},

					dataDeCompra : {
						identifier : 'dataDeCompra',
						rules : [
							{
								type : 'minLength[10]',
								prompt : 'Insira uma data válida.'
							}
						]
					},

					fornecedor : {
						identifier : 'fornecedor',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo fornecedor é obrigatório.'
							}
						]
					},

					modelo : {
						identifier : 'modelo',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo modelo é obrigatório.'
							}
						]
					},

					responsavel : {
						identifier : 'responsavel',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo responsável é obrigatório.'
							}
						]
					},

					tipo : {
						identifier : 'tipo',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo tipo é obrigatório.'
							}
						]
					},

				}, {

					onSuccess : function(event){

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

							url: 'http://'+host+'/Equipamentos/editar/'+data['equipamento'].id,
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

					}

				});

			}

		});

	});


	listar_equipamentos.on('click', '.btnAlertarEquipamento', function(event){
		event.preventDefault();
		now = new Date;
		var data = now.getDate()+'/'+(now.getMonth()+1)+'/'+now.getFullYear();
		var idEquipamento = $(this).closest('tr').attr('data-id');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		$.ajax({

			url: 'http://'+host+'/equipamentos/view/'+idEquipamento,
			dataType: 'json',
			type: 'GET',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(equipamento){
				
				modalContent.html('');

				modalHeader.html("Enviar Alerta - Equipamento: "+equipamento['equipamento'].nome+" [ Tombo: "+equipamento['equipamento'].tombo+" ]");

				conteudoModal  = '<form class="ui form enviarAlerta">';
				conteudoModal += '<div class="field">';
				conteudoModal += '<label>Descrição do problema: </label>';
				conteudoModal += '<textarea id="descricao" placeholder="Descreva aqui o problema do equipamento..."></textarea>';
				conteudoModal += '</div>';

				conteudoModal += '<div class="ui error message"></div>';

				conteudoModal += '<button class="ui button green">Enviar</button>';
				conteudoModal += '</form>';
				
				modalContent.html(conteudoModal);

				modal.modal('show');

				// Validação do formulário.
				$('.ui.form.enviarAlerta').form({

					descricao : {
						identifier : 'descricao',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo descrição é obrigatório.'
							}
						]
					}

				}, {

					onSuccess : function(event){

						event.preventDefault();
						var tomboEquipamento = equipamento['equipamento'].tombo;
						var geradoPor = equipamento['session'];
						var descricao = $('#descricao').val();
						var codLocal = equipamento['equipamento'].codLocal;

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

					}

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

				conteudoModal  = '<form class="ui form cadastrarEquipamento">';

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
				conteudoModal += '<select id="tipo" class="ui fluid dropdown">';
				for(i = 0; i < data['tipoEquipamentos'].length; i++){
					conteudoModal += '<option value="'+data['tipoEquipamentos'][i].id+'">'+data['tipoEquipamentos'][i].nome+'</option>';
				}
				conteudoModal += '</select>';
				conteudoModal += '</div>';

				conteudoModal += '<div class="ui error message"></div>';

				conteudoModal += '<button id="bntSalvarEquipamento" class="ui button green">Salvar</button>';

				conteudoModal += '</form>';

				modalHeader.html('Cadastrar Equipamento');

				modalContent.html(conteudoModal);

				$('#dataDeCompra').mask("00/00/0000", {placeholder: "__/__/____"});
				
				modal.modal('show');

				// Validação do furmulário.
				$('.ui.form.cadastrarEquipamento').form({
					nome : {
						identifier : 'nome',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo nome é obrigatório.'
							}
						]
					},

					tombo : {
						identifier : 'tombo',
						rules : [
							{
								type : 'minLength[6]',
								prompt : 'O tombo deve conter no mínimo 6 caracteres.'
							}
						]
					},

					dataDeCompra : {
						identifier : 'dataDeCompra',
						rules : [
							{
								type : 'minLength[10]',
								prompt : 'Insira uma data válida.'
							}
						]
					},

					fornecedor : {
						identifier : 'fornecedor',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo fornecedor é obrigatório.'
							}
						]
					},

					modelo : {
						identifier : 'modelo',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo modelo é obrigatório.'
							}
						]
					},

					responsavel : {
						identifier : 'responsavel',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo responsável é obrigatório.'
							}
						]
					},

					tipo : {
						identifier : 'tipo',
						rules : [
							{
								type : 'empty',
								prompt : 'Campo tipo é obrigatório.'
							}
						]
					},


				}, {

					onSuccess: function(event){

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
					}

				});

			}

		});

	});

	$('.btnVerAlerta').click(function(event){
		
		event.preventDefault();	

		idAlerta = $(this).closest('td').attr('data-id');

		$.ajax({

			url : 'http://'+host+'/alertas/view/'+idAlerta,
			type : 'GET',
			dataType: 'JSON',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},			

			success : function(data){
				// Salva o equipamento
				equipamento = data;

				mensagem.html('');
				modalHeader.html('');
				modalContent.html('');
				modalActions.html('');

				conteudo  = '<div class="ui raised segment">';

				conteudo += '<h4 class="ui header">Descrição:</h4>';
				conteudo += '<div class="description">';
				conteudo += data['alerta'].descricao;
				conteudo += '</div>';

				if(data['alerta'].observacoes != ''){
					conteudo += '<h4 class="ui header">Observação:</h4>';
					conteudo += '<div class="description">';
					conteudo += data['alerta'].observacoes;
					conteudo += '</div>';
				}

				conteudo += '<h4 class="ui header">Enviado por: </h4>';
				conteudo += '<div class="description">';
				conteudo += data['alerta'].geradoPor;
				conteudo += '</div>';

				conteudo += '<h4 class="ui header">Criado: </h4>';
				conteudo += '<div class="description">';
				conteudo += moment(data['alerta'].dataAlerta).format('DD/MM/YYYY');
				conteudo += '</div>';

				conteudo += '</div>';

				for(i = 0; i < data['bolsistas'].length; i++){
					if(data['session'] === data['bolsistas'][i].user_matricula && data['alerta'].statusAlerta === 'Pendente'){

						actionModal  = '<button class="ui button negative labeled icon negative	first btnDefeito">';
						actionModal += '<i class="warning sign icon"></i>';
						actionModal += 'Marcar com defeito';
						actionModal += '</button>';

						actionModal += '<button class="ui button approve labeled icon positive btnResolvido">';
						actionModal += '<i class="checkmark icon"></i>';
						actionModal += 'Marcar como resolvido';
						actionModal += '</button>';
						modalActions.html(actionModal);
					}
				}
								

				modalHeader.html('Alerta - Tombo: '+data['alerta'].tomboEquipamento);
				modalContent.html(conteudo);
				

				modal.modal('show');

				// Marcar como resolvido
				$('.btnResolvido').on('click', function(event){
					event.preventDefault();					

					modal.modal('hide');

					modalHeader.html('');
					modalContent.html('');
					modalActions.html('');

					conteudo  = '<form class="ui form">';

					conteudo += '<div class="field">';
					conteudo += '<label>Descrição</label>';
					conteudo += '<textarea id="descricao" placeholder="Descreva aqui a solução do problema..."></textarea>';
					conteudo += '</div>';

					conteudo += '<div class="ui message error"></div>';

					conteudo += '<button class="ui button green" id="btnEnviar">Enviar</button>';

					conteudo += '</form>';					

					modalHeader.html('Observaçôes');
					modalContent.html(conteudo);

					modal.modal('show');

					// Validação do formulario

					$('.ui.form').form({

						descricao : {
							identifier : 'descricao',
							rules : [
								{
									type : 'empty',
									prompt : 'Campo descrição é obrigatório.'
								}
							]
						}

					}, {

						onSuccess : function(event){
							event.preventDefault();

							var statusAlerta = 'Resolvido';
							var observacoes = $('#descricao').val();

							$.ajax({

								url : 'http://'+host+'/alertas/edit/'+idAlerta,
								type : 'PUT',
								data : 'statusAlerta='+statusAlerta+'&observacoes='+observacoes,

								beforeSend: function(request){
									return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
								},		
								
								success: function(data){

									if(data == 'sucesso'){
										mensagem_sucesso =  '<div class="ui success message">';
										mensagem_sucesso += '<div class="header">';
										mensagem_sucesso += '<i class="checkmark icon"></i>Estado do alerta alterado com sucesso.';
										mensagem_sucesso += '</div>';
										mensagem_sucesso += '</div>';

										modalMensagem.html(mensagem_sucesso);

										alteraStatusEquipamento(equipamento, 'Funcionando');

										setTimeout(function(){
											location.reload();									
										},1000);
									}
									if(data == 'erro'){
										mensagem_erro =  '<div class="ui negative message">';
										mensagem_erro += '<div class="header">';
										mensagem_erro += '<i class="warning sign icon"></i>Erro ao alterar estado do alerta.';
										mensagem_erro += '</div>';
										mensagem_erro += '</div>';

										modalMensagem.html(mensagem_erro);
									}

								}

							});

						}

					});

				});

				// Marcar com defeito				
				$('.btnDefeito').on('click', function(event){
					event.preventDefault();

					

					modal.modal('hide');

					modalHeader.html('');
					modalContent.html('');
					modalActions.html('');

					conteudo  = '<form class="ui form">';

					conteudo += '<div class="field">';
					conteudo += '<label>Descrição</label>';
					conteudo += '<textarea id="descricao" placeholder="Descreva aqui o problema do equipamento..."></textarea>';
					conteudo += '</div>';

					conteudo += '<div class="ui message error"></div>';

					conteudo += '<button class="ui button green" id="btnDefeitoEnviar">Enviar</button>';

					conteudo += '</form>';					

					modalHeader.html('Observaçôes');
					modalContent.html(conteudo);

					modal.modal('show');

					// Validação do formulario
					$('.ui.form').form({

						descricao : {
							identifier : 'descricao',
							rules : [
								{
									type : 'empty',
									prompt : 'Campo descrição é obrigatório.'
								}
							]
						}

					}, {

						onSuccess : function(event){
							event.preventDefault();

							var statusAlerta = 'Encaminhado para o suporte';
							var observacoes = $('#descricao').val();

							$.ajax({

								url : 'http://'+host+'/alertas/edit/'+idAlerta,
								type : 'PUT',
								data : 'statusAlerta='+statusAlerta+'&observacoes='+observacoes,

								beforeSend: function(request){
									return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
								},		
								
								success: function(data){

									if(data == 'sucesso'){
										mensagem_sucesso =  '<div class="ui success message">';
										mensagem_sucesso += '<div class="header">';
										mensagem_sucesso += '<i class="checkmark icon"></i>Estado do alerta alterado com sucesso.';
										mensagem_sucesso += '</div>';
										mensagem_sucesso += '</div>';

										modalMensagem.html(mensagem_sucesso);

										alteraStatusEquipamento(equipamento, 'Defeito');

										setTimeout(function(){
											location.reload();									
										},1000);
									}
									if(data == 'erro'){
										mensagem_erro =  '<div class="ui negative message">';
										mensagem_erro += '<div class="header">';
										mensagem_erro += '<i class="warning sign icon"></i>Erro ao alterar estado do alerta.';
										mensagem_erro += '</div>';
										mensagem_erro += '</div>';

										modalMensagem.html(mensagem_erro);
									}

								}

							});						

						}

					});

				});

			}

		});

	});

});

function alteraStatusEquipamento(equipamento, status){

	$.ajax({

		url: 'http://'+host+'/equipamentos/editar/'+equipamento['equipamento'].id,
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