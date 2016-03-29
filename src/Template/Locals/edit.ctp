<form method="POST" accept-charset="utf-8" <?= ('action="/Locals/edit/'.$local->id.'"') ?>>
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" <?= ('value="'.$local->nome.'"') ?> required>
	<label>Codigo: </label> <input type="text" name="codigo" <?= ('value="'.$local->codigo.'"') ?> required>

	<label>Coordenador: </label> 
	<select name="coordenador">
		<?php  foreach($professores as $professores): ?>
			<option <?= ("value='$professores->matricula'") ?> > <?= ($professores->nome." - Matrícula: ".$professores->matricula) ?> </option>
		<?php endforeach; ?>
	</select>

	<label>Bolsista: </label> 
	<select name="bolsista">
		<?php  foreach($bolsistas as $bolsista): ?>

			<option <?= ("value='$bolsista->matricula'") ?> 
				<?php 
					foreach($userLocalsBolsistas as $userLocalsBolsista)
						if($bolsista->matricula == $userLocalsBolsista->user_matricula)
							echo "selected";			
			 	?> > 

				<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>

	<label>Tipo: </label> <input type="text" name="tipo" <?= ('value="'.$local->tipo.'"') ?> required>
	
	<button type="submit">Enviar</button>

</form>