$(document).ready(function(){

	var container = $('.container');
	var listar_equipamentos = container.find('#listar-equipamentos');


	listar_equipamentos.on('click', '.btn_editar_equipamento', function(){
		
		var idEquipamento = $(this).closest('div').attr('data-id');

		console.log(idEquipamento);

		$.ajax({

			url: '/editar-equipamento/'+idEquipamento

		});
	});

	$('#addEquipamento').on('click', function(){
		$('.ui.modal').modal('show');
	});

});