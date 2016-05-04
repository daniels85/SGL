$(document).ready(function(){
	var host = $(location).attr('host');
	var container = $('.container');
	var modal = container.find('.ui.modal');
	var modalMensagem = modal.find('.mensagem');
	var modalHeader = modal.find('.header');
	var modalContent = modal.find('.content');
	var modalActions = modal.find('.actions');

	$('.btnMudarSenha').on('click', function(event){
		event.preventDefault();

		var matriculaUsuario = $(this).closest('div').attr('data-matricula');

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
						prompt : 'O campo {name} deve ter pelo menos {ruleValue} caracteres.'
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

					url: 'http://'+host+'/users/alterarSenha/'+matriculaUsuario,
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
						prompt: 'O campo {name} é obrigatório.'
					}
				]
			},

			username : {
				identifier : 'username',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'O campo {name} deve ter pelo menos {ruleValue} caracteres.'
					}
				]
			},

			matricula : {
				identifier : 'matricula',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'O campo {name} deve ter pelo menos {ruleValue} caracteres.'
					}, {
						type : 'number',
						prompt : 'O campo {name} deve possuir somente números.'
					}
				]
			},

			email : {
				identifier : 'email',
				rules : [
					{
						type : 'email',
						prompt : 'Por favor insira um email válido.'
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

					beforeSend: function(request){
						return request.setRequestHeader("X-CSRF-TOKEN", $("meta[name='_csrfToken']").attr('content'));
					},
					
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

		var matriculaUsuario = $(this).closest('div').attr('data-matricula');

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

					url : 'http://'+host+'/users/alterarEmail/'+matriculaUsuario,
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

		matriculaUsuario = $(this).closest('div').attr('data-matricula');

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

							url : 'http://'+host+'/users/delete/'+matriculaUsuario,
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

		matriculaUsuario = $(this).closest('div').attr('data-matricula');

		// Requisição ajax para pegar todos os dados do usuário
		$.ajax({

			url : 'http://'+host+'/users/view/'+matriculaUsuario,
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

									url : 'http://'+host+'/users/resetarSenha/'+matriculaUsuario,
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