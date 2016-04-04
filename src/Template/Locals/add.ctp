<script   src="https://code.jquery.com/jquery-1.12.2.min.js"   integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk="   crossorigin="anonymous"></script>

<script type="text/javascript">
	
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

</script>

<form method="POST" accept-charset="utf-8" action="/Locals/add" style="width: 30%;margin: 0 auto;margin-top: 5%;">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" placeholder="Nome" required>
	<label>Codigo: </label> <input type="text" name="codigo" placeholder="Codigo" required>

	<label>Coordenador: </label> 
	<div id="coordenadores">

		<select name="coordenadores[]">
			<option value=""></option>
			<?php  foreach($professores as $professores): ?>
				<option <?= ("value='$professores->matricula'") ?> > <?= ($professores->nome." - Matrícula: ".$professores->matricula) ?> </option>
			<?php endforeach; ?>
		</select>

		<a class="addCoordenador"> Adicionar</a>
	</div>

	<br>
	<label>Bolsista: </label> 
	<div id="bolsistas">
		
		<select name="bolsistas[]">
			<option value=""></option>
			<?php  foreach($bolsistas as $bolsista): ?>
				<option <?= ("value='$bolsista->matricula'") ?> > <?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> </option>
			<?php endforeach; ?>
		</select>

		<a class="addBolsista"> Adicionar</a>
	</div>
	
	<br>
	<label>Tipo: </label> <input type="text" name="tipo" placeholder="Tipo" required>
	
	<button type="submit">Enviar</button>

</form>