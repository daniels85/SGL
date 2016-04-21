var host = $(location).attr('host');

$(document).ready(function(){

	container = $('.container');
	modal = container.find('.ui.modal');
	modalMensagem = modal.find('.mensagem');
	modalHeader = modal.find('.header');
	modalContent = modal.find('.content');
	modalActions = modal.find('.actions')

	$('.btnMudarSenha').on('click', function(event){

		event.preventDefault();

		var idUsuario = $(this).closest('th').attr('data-id');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');
		
		modalHeader.html('Alterar Senha');

		conteudo  = '<form class="ui form">';
		conteudo += '<div class="field">';
		conteudo += '<label>Nova senha</label>';
		conteudo += '<input type="password" id="password" name="password">';
		conteudo += '</div>';
		conteudo += '<div class="field">';
		conteudo += '<label>Nova senha</label>';
		conteudo += '<input type="password" id="password2" name="password2">';
		conteudo += '</div>';
		conteudo += '<div class="ui error message"></div>';
		conteudo += '<button class="ui button teal">Salvar</button>';
		conteudo += '</form>';

		modalContent.html(conteudo);

		modal.modal('show');

		$('.ui.form').form({
			password : {
				identifier : 'password',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'A senha deve conter no mínimo 6 caracteres.'
					}
				] 
			},

			password2 : {
				identifier : 'password2',
				rules : [
					{
						type : 'match[password]',
						prompt : 'As senhas não coincidem.'
					}
				]
			}
		}, {

			onSuccess: function(event){
				event.preventDefault();
				
				password = $('#password').val();
				
				$.ajax({

					url: 'http://'+host+'/users/alterarSenha/'+idUsuario,
					type: 'PUT',
					data: 'password='+password,

					beforeSend: function(request){
						return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
					},

					success: function(data){
						if(data == 'sucesso'){
							mensagem_sucesso =  '<div class="ui success message">';
							mensagem_sucesso += '<div class="header">';
							mensagem_sucesso += '<i class="checkmark icon"></i>Senha alterada com sucesso.';
							mensagem_sucesso += '</div>';
							mensagem_sucesso += '</div>';

							modalMensagem.html(mensagem_sucesso);
							setTimeout(function(){
								location.reload();									
							},1000);
						}
						if(data == 'erro'){
							mensagem_erro =  '<div class="ui negative message">';
							mensagem_erro += '<div class="header">';
							mensagem_erro += '<i class="warning sign icon"></i>Erro ao alterar senha.';
							mensagem_erro += '</div>';
							mensagem_erro += '</div>';

							modalMensagem.html(mensagem_erro);
						}
					}

				});

			}

		});

	});

	$('.btnCadastrarBolsista').on('click', function(event){
		event.preventDefault();

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		modalHeader.html('Cadastrar Bolsista');
		
		conteudo  = '<form class="ui form addBolsista">';

		conteudo += '<div class="field">';
		conteudo += '<label>Nome: </label>';
		conteudo += '<input type="text" name="nome" id="nome">';
		conteudo += '</div>';

		conteudo += '<div class="field">';
		conteudo += '<label>Username: </label>';
		conteudo += '<input type="text" name="username" id="username">';
		conteudo += '</div>';

		conteudo += '<div class="field">';
		conteudo += '<label>Matrícula: </label>';
		conteudo += '<input type="text" name="matricula" id="matricula">';
		conteudo += '</div>';

		conteudo += '<div class="field">';
		conteudo += '<label>Email: </label>';
		conteudo += '<input type="email" name="email" id="email">';
		conteudo += '</div>';
		conteudo += '<div class="ui error message"></div>';
		conteudo += '<button class="ui button teal">Enviar</button>';

		conteudo += '</form>';

		
		modalContent.html(conteudo);

		modal.modal('show');

		$('.ui.form.addBolsista').form({
			
			nome : {
				identifier : 'nome',
				rules : [
					{
						type: 'empty',
						prompt: 'Por favor insira um nome.'
					}
				]
			},

			username : {
				identifier : 'username',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'Username deve conter no mínimo 6 caracteres.'
					}
				]
			},

			matricula : {
				identifier : 'matricula',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'Matrícula deve conter no mínimo 6 caracteres.'
					}
				]
			},

			email : {
				identifier : 'email',
				rules : [
					{
						type : 'email',
						prompt : 'Pro favor insira um email válido.'
					}
				]
			}

		}, {

			onSuccess : function(event){
				
				event.preventDefault();
				
				nome = $('#nome').val();
				username = $('#username').val();
				matricula = $('#matricula').val();
				email = $('#email').val();
				
				$('.ui.dimmer.loading').dimmer('show');

				$.ajax({

					url: 	'http://'+host+'/users/cadastrarBolsista',
					type: 	'PUT',
					data:  	'nome='+nome
						   +'&username='+username
						   +'&matricula='+matricula
						   +'&email='+email,

					success: function(data){

						$('.ui.dimmer.loading').dimmer('hide');
				
						if(data == 'cadastrado'){
							mensagem_sucesso =  '<div class="ui success message">';
							mensagem_sucesso += '<div class="header">';
							mensagem_sucesso += '<i class="checkmark icon"></i>Bolsista cadastrado.';
							mensagem_sucesso += '</div>';
							mensagem_sucesso += '</div>';

							modalMensagem.html(mensagem_sucesso);
							setTimeout(function(){
								location.reload();									
							},1600);
						}
						if(data == 'erro'){
							mensagem_erro =  '<div class="ui negative message">';
							mensagem_erro += '<div class="header">';
							mensagem_erro += '<i class="warning sign icon"></i>Erro ao cadastrar.';
							mensagem_erro += '</div>';
							mensagem_erro += '</div>';

							modalMensagem.html(mensagem_erro);
						}
					}


				});

			}

		});

	});


	$('.btnMudarEmail').on('click', function(event){

		event.preventDefault();

		var idUsuario = $(this).closest('th').attr('data-id');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		conteudo  = '<form class="ui form">';
		conteudo += '<div class="field">';
		conteudo += '<label>Email</label>';
		conteudo += '<input type="email" id="email">';
		conteudo += '</div>';
		conteudo += '<div class="ui error message"></div>';
		conteudo += '<button class="ui button teal">Salvar</button>';
		conteudo += '</form>';

		modalHeader.html('Alterar E-mail');

		modalContent.html(conteudo);

		modal.modal('show');


		$('.ui.form').form({
			email : {
				identifier : 'email',
				rules : [
					{
						type : 'email',
						prompt : 'Insira um email válido.'
					}
				]
			}
		}, {

			onSuccess: function(event){

				event.preventDefault();

				email = $('#email').val();

				$.ajax({

					url : 'http://'+host+'/users/alterarEmail/'+idUsuario,
					type : 'PUT',
					data : 'email='+email,

					beforeSend: function(request){
						return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
					},

					success : function(data){
						if(data == 'sucesso'){
							mensagem_sucesso =  '<div class="ui success message">';
							mensagem_sucesso += '<div class="header">';
							mensagem_sucesso += '<i class="checkmark icon"></i>E-mail alterado com sucesso.';
							mensagem_sucesso += '</div>';
							mensagem_sucesso += '</div>';

							modalMensagem.html(mensagem_sucesso);
							setTimeout(function(){
								location.reload();									
							},1000);
						}
						if(data == 'erro'){
							mensagem_erro =  '<div class="ui negative message">';
							mensagem_erro += '<div class="header">';
							mensagem_erro += '<i class="warning sign icon"></i>Erro ao alterar E-mail.';
							mensagem_erro += '</div>';
							mensagem_erro += '</div>';

							modalMensagem.html(mensagem_erro);
						}
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
				
				modalHeader.html('');
				modalContent.html('');
				modalActions.html('');

				conteudo  = '<div class="ui raised segment">';

				conteudo += '<h4 class="ui header">Descrição:</h4>';
				conteudo += '<div class="description">';
				conteudo += data['alerta'].descricao;
				conteudo += '</div>';

				conteudo += '<h4 class="ui header">Enviado por: </h4>';
				conteudo += '<div class="description">';
				conteudo += data['alerta'].geradoPor;
				conteudo += '</div>';

				conteudo += '<h4 class="ui header">Criado: </h4>';
				conteudo += '<div class="description">';
				conteudo += moment(data['alerta'].dataAlerta).format('DD/MM/YYYY');
				conteudo += '</div>';

				conteudo += '</div>';

				conteudo += '<div class="actions">';
				conteudo += '<div class="ui button approve positive small btnResolvido"><i class="checkmark icon"></i>Marcar como resolvido</div>';
				conteudo += '<div class="ui button negative cancel small btnOcorrencia"><i class="warning circle icon"></i>Criar ocorrência</div>';
				conteudo += '</div>';

				modalHeader.html('Alerta - Tombo: '+data['alerta'].tomboEquipamento);
				modalContent.html(conteudo);

				modal.modal('show');

				$('.btnResolvido').on('click', function(event){
					event.preventDefault();

					statusAlerta = 'Resolvido';

					$.ajax({

						url : 'http://'+host+'/alertas/edit/'+idAlerta,
						type : 'PUT',
						data : 'statusAlerta='+statusAlerta,

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

				});

			}

		});

	});

	$('.btnApagarAlerta').on('click', function(event){

		event.preventDefault();

		idAlerta = $(this).closest('td').attr('data-id');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		$.ajax({

			url: 'http://'+host+'/alertas/delete/'+idAlerta,
			type: 'POST',

			beforeSend: function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success: function(data){
				if(data == 'sucesso'){

					conteudoModal  = '<h2 class="ui center aligned icon header green">';
					conteudoModal += '<i class="checkmark icon"></i>';
					conteudoModal += 'Alerta apagado com sucesso';
					conteudoModal += '</h2>';

					modalContent.html(conteudoModal);

					modal.modal('show');

					setTimeout(function(){
						location.reload();									
					},1000);
				}
				if(data == 'erro'){

					conteudoModal  = '<h2 class="ui center aligned icon header green">';
					conteudoModal += '<i class="warning sign icon"></i>';
					conteudoModal += 'Erro ao apagar alerta';
					conteudoModal += '</h2>';

					modalContent.html(conteudoModal);

					modal.modal('show');

				}

			}

		});

	});

	$('.deletarUser').on('click', function(event){

		event.preventDefault();

		idUsuario = $(this).closest('div').attr('data-id');

		modalHeader.html('');
		modalContent.html('');
		modalActions.html('');

		conteudoModal  = '<h2 class="ui center aligned icon header">';
		conteudoModal += '<i class="delete user icon"></i>';
		conteudoModal += 'Realmente deseja apagar este usuário?';
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

							url : 'http://'+host+'/users/delete/'+idUsuario,
							type : 'POST',

							beforeSend : function(request){
								return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
							},

							success : function(data){
								setTimeout(function(){
									location.reload();									
								},500);
							}

						});

					}
				})
		.modal('show');

	});

	$('.resetarSenha').on('click', function(event){

		idUsuario = $(this).closest('div').attr('data-id');

		// Requisição ajax para pegar todos os dados do usuário
		$.ajax({

			url : 'http://'+host+'/users/view/'+idUsuario,
			type : 'GET',
			dataType : 'json',

			beforeSend : function(request){
				return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
			},

			success : function(data){				
				
				modalHeader.html('');
				modalContent.html('');
				modalActions.html('');

				modalHeader.html('Recuperação de senha');

				conteudoModal  = '<h4 class="ui header">';
				conteudoModal += 'Resetar senha de '+data['user'].nome;
				conteudoModal += '<div class="sub header">Um email com a nova senha será enviado para '+data['user'].email+'</div>';
				conteudoModal += '</h4>';

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
								modalActions.html('');
							},
							onApprove : function() {
								
								$.ajax({

									url : 'http://'+host+'/users/resetarSenha/'+idUsuario,
									type : 'POST',

									beforeSend : function(request){
										return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
									},

								});

							}
						}).modal('show');

			}

		});

	});

});