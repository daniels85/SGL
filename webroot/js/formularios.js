$(document).ready(function(){
	var formAddLocal = $('#formAddLocal').find('.ui.form');
	var formEditLocal = $('#formEditLocal').find('.ui.form');
	var formAddUsuario = $('#formAddUsuario').find('.ui.form');
	var formEquipamento = $('#formEquipamento').find('.ui.form');
	var formTipoEquipamento = $('#formTipoEquipamento').find('.ui.form');
	var formLogin = $('#formLogin').find('.ui.form');
	var formRecuperarSenha = $('#recuperarSenha').find('.ui.form');
	var formBuscaEquipamento = $('#formBuscaEquipamento');
	var formRelatorioLocal = $('#formRelatorioLocal').find('.ui.form');
	var formMoverEquipamentos = $('#formMoverEquipamentos').find('.ui.form');

	formAddLocal.form({	
		
		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		codigo : {
			identifier : 'codigo',
			rules : [
				{
					type : 'minLength[3]',
					prompt : 'O campo {name} deve ter pelo menos {ruleValue} caracteres.'
				}, {
					type : 'number',
					prompt : 'O campo {name} deve possuir somente números.'
				}
			]
		},

		tipo : {
			identifier : 'tipo',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um {name}.'
				}
			]
		}

	});

	formEditLocal.form({

		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		codigo : {
			identifier : 'codigo',
			rules : [
				{
					type : 'minLength[3]',
					prompt : 'O campo {name} deve conter no mínimo {ruleValue} caracteres.'
				}, {
					type : 'number',
					prompt : 'O campo {name} deve possuir somente números.'
				}
			]
		},

		tipo : {
			identifier : 'tipo',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um {name}.'
				}
			]
		}

	});

	formAddUsuario.form({

		nome: {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		matricula: {
			identifier : 'matricula',
			rules : [
				{
					type : 'minLength[6]',
					prompt : 'O campo {name} deve conter no mínimo {ruleValue} caracteres.'
				}, {
					type : 'number',
					prompt : 'O campo {name} deve possuir somente números.'
				}
			]
		},

		username: {
			identifier : 'username',
			rules : [
				{
					type: 'minLength[5]',
					prompt : 'O campo {name} deve conter no mínimo {ruleValue} caracteres.'
				}
			]
		},

		email : {
			identifier : 'email',
			rules : [
				{
					type : 'email',
					prompt : 'Insira um {name} válido.'
				}
			]
		},

		tipo : {
			identifier : 'role',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um {name}.'
				}
			]
		}

	});

	formEquipamento.form({

		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		tombo : {
			identifier : 'tombo',
			rules : [
				{
					type : 'minLength[6]',
					prompt : 'O campo {name} deve conter no mínimo {ruleValue} caracteres.'
				}, {
					type : 'number',
					prompt : 'O campo {name} deve possuir somente números.'
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
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		modelo : {
			identifier : 'modelo',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		responsavel : {
			identifier : 'responsavel',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		tipo : {
			identifier : 'tipo',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um {name}.'
				}
			]
		}

	});

	formTipoEquipamento.form({

		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		},

		descricao : {
			identifier : 'descricao',
			rules : [
				{
					type : 'empty',
					prompt : 'O campo {name} é obrigatório.'
				}
			]
		}

	});

	formLogin.form({
		username : {
			identifier : 'username',
			rules : [
				{
					type : 'empty',
					prompt : 'Preencha o {name}.'
				}
			]
		},

		password : {
			identifier : 'password',
			rules : [
				{
					type : 'empty',
					prompt : 'Preencha o {name}.'
				}
			]
		}

	});

	formRecuperarSenha.form({

		matricula : {
			identifier : 'matricula',
			rules : [
				{
					type : 'empty',
					prompt : 'Por favor informe sua {name}.'
				},{
					type: 'number',
					prompt : 'O campo {name} deve possuir somente números.'
				}
			]
		}

	});

	formBuscaEquipamento.form({

		tombo : {
			identifier : 'tombo',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo obrigatório.'
				},{
					type : 'number',
					prompt : 'Somente números.'
				}
			]
		}

	});

	formRelatorioLocal.form({

		dataInicio : {
				identifier : 'dataInicio',
				rules : [
					{
						type : 'minLength[8]',
						prompt : 'Insira um {name} válido.'
					}
				]
			},

			dataFim : {
				identifier : 'dataFim',
				rules : [
					{
						type : 'minLength[8]',
						prompt : 'Insira um {name} válido.'
					}
				]
			}

	});

	formMoverEquipamentos.form({

		local : {
			identifier : 'local',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um {name}'
				}
			]
		}

	});

});