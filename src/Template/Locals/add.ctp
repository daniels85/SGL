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
	<select name="bolsista">
		<option value=""></option>
		<?php  foreach($bolsistas as $bolsista): ?>
			<option <?= ("value='$bolsista->matricula'") ?> > <?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> </option>
		<?php endforeach; ?>
	</select>

	<label>Tipo: </label> <input type="text" name="tipo" placeholder="Tipo" required>
	
	<button type="submit">Enviar</button>

</form>