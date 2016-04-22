$(document).ready(function(){
	var formAddLocal = $('#formAddLocal').find('.ui.form');
	var formEditLocal = $('#formEditLocal').find('.ui.form');
	var formAddUsuario = $('#formAddUsuario').find('.ui.form');
	var formEquipamento = $('#formEquipamento').find('.ui.form');
	var formTipoEquipamento = $('#formTipoEquipamento').find('.ui.form');

	formAddLocal.form({	
		
		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo nome é obrigatório.'
				}
			]
		},

		codigo : {
			identifier : 'codigo',
			rules : [
				{
					type : 'minLength[6]',
					prompt : 'O campo código deve ter pelo menos 6 caracteres.'
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
		}

	});

	formEditLocal.form({

		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo nome é obrigatório.'
				}
			]
		},

		codigo : {
			identifier : 'codigo',
			rules : [
				{
					type : 'minLength[6]',
					prompt : 'O campo código deve ter pelo menos 6 caracteres.'
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
		}

	});

	formAddUsuario.form({

		nome: {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo nome é obrigatório.'
				}
			]
		},

		matricula: {
			identifier : 'matricula',
			rules : [
				{
					type : 'minLength[6]',
					prompt : 'Matrícula deve conter no mínimo 6 caracteres.'
				}
			]
		},

		username: {
			identifier : 'username',
			rules : [
				{
					type: 'minLength[6]',
					prompt : 'Username deve conter no mínimo 6 caracteres.'
				}
			]
		},

		email : {
			identifier : 'email',
			rules : [
				{
					type : 'email',
					prompt : 'Insira um email válido.'
				}
			]
		},

		tipo : {
			identifier : 'role',
			rules : [
				{
					type : 'empty',
					prompt : 'Selecione um tipo.'
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
		}

	});

	formTipoEquipamento.form({

		nome : {
			identifier : 'nome',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo nome é obrigatório.'
				}
			]
		},

		descricao : {
			identifier : 'descricao',
			rules : [
				{
					type : 'empty',
					prompt : 'Campo descrição é obrigatório.'
				}
			]
		}

	});


});