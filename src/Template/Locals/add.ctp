<script   src="https://code.jquery.com/jquery-1.12.2.min.js"   integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk="   crossorigin="anonymous"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
		var campos_max = 3;
		var x = 1;

		var selects = $('#bolsistas').html();

		$('#bolsistas').on('click','.addBolsista',function(e){
			e.preventDefault();
			
			if(x < campos_max){
				$('#bolsistas').append('<div class="bolsistas">'
											+selects
											+'&nbsp;<a id="delBolsista"> Remover</a>'
											+'</div>');
				x++;
			}

		});

		$('#bolsistas').on('click', '#delBolsista', function(e){
			e.preventDefault();

			$(this).parent('div').remove();
			x--;
		});

	});

</script>

<form method="POST" accept-charset="utf-8" action="/Locals/add" style="width: 40%;margin: 0 auto;margin-top: 5%;">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" placeholder="Nome" required>
	<label>Codigo: </label> <input type="text" name="codigo" placeholder="Codigo" required>

	<label>Coordenador: </label> 
	<select name="coordenador">
		<option value=""></option>
		<?php  foreach($professores as $professores): ?>
			<option <?= ("value='$professores->matricula'") ?> > <?= ($professores->nome." - Matrícula: ".$professores->matricula) ?> </option>
		<?php endforeach; ?>
	</select>

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