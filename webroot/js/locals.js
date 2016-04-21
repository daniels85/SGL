$(document).ready(function(){
	var formAdd = $('#formAddLocal').find('.ui.form');
	var formEdit = $('#formEditLocal').find('.ui.form');

	formAdd.form({
		
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

	formEdit.form({

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

});