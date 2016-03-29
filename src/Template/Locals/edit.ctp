<form method="POST" accept-charset="utf-8" action="/Locals/add">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" placeholder="Nome" required>
	<label>Codigo: </label> <input type="text" name="codigo" placeholder="Codigo" required>

	<label>Coordenador: </label> 
	<select name="coordenador">
		<?php  foreach($professores as $professores) ?>
		<option <?= ("value='$professores->matricula'") ?> > <?= ($professores->nome." - Matrícula: ".$professores->matricula) ?> </option>
	</select>

	<label>Bolsista: </label> 
	<select name="bolsista">
		<?php  foreach($bolsistas as $bolsista) ?>
		<option <?= ("value='$bolsista->matricula'") ?> > <?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> </option>
	</select>

	<label>Tipo: </label> <input type="text" name="tipo" placeholder="Tipo" required>
	
	<button type="submit">Enviar</button>

</form>