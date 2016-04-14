$(document).ready(function(){
		
		var campos_max_coordenador = 2;
		var x_coordenador = 1;

		var campos_max_bolsista = 3;
		var x_bolsista = 1;

		var selectsCoordenador = $('#coordenadores').html();
		var selectsBolsista = $('#bolsistas').html();

		// Coordenador
		$('#coordenadores').on('click','.addCoordenador',function(e){
			e.preventDefault();
			
			if(x_coordenador < campos_max_coordenador){
				$('#coordenadores')
					.append('<div class="coordenadores">'
								+selectsCoordenador
								+'&nbsp;<a id="delCoordenador"> Remover</a>'
								+'</div>');
				x_coordenador++;
			}

		});

		$('#coordenadores').on('click', '#delCoordenador', function(e){
			e.preventDefault();
			$(this).parent('div').remove();
			x_coordenador--;
		});


		// Bolsistas
		$('#bolsistas').on('click','.addBolsista',function(e){
			e.preventDefault();
			
			if(x_bolsista < campos_max_bolsista){
				$('#bolsistas')
					.append('<div class="bolsistas">'
								+selectsBolsista
								+'&nbsp;<a id="delBolsista"> Remover</a>'
								+'</div>');
				x_bolsista++;
			}

		});

		$('#bolsistas').on('click', '#delBolsista', function(e){
			e.preventDefault();

			$(this).parent('div').remove();
			x_bolsista--;
		});

	});