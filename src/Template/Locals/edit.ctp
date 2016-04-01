<form method="POST" accept-charset="utf-8" <?= ('action="/Locals/edit/'.$local->id.'"') ?> style="width: 40%;margin: 0 auto;margin-top: 5%;">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" <?= ('value="'.$local->nome.'"') ?> required>
	<label>Codigo: </label> <input type="text" name="codigo" <?= ('value="'.$local->codigo.'"') ?> required>


	<label>Coordenador: </label> 
	<select name="coordenador">
		<option value=""></option>
		<?php  foreach($professores as $professor): ?>
			<option 
				<?php 
					echo "value='$professor->matricula'"; 
					if($professor->matricula == $local->coordenador)
						echo "selected";
					
				?> 

			> 
				<?= ($professor->nome." - Matrícula: ".$professor->matricula) ?> 
			</option>

		<?php endforeach; ?>
	</select>

	<label>Bolsista: </label> 
	<select name="bolsista[]">
			<option value=""></option>
		<?php  foreach($bolsistas as $key => $bolsista): ?>
			<option <?= ("value='$bolsista->matricula'") ?> 
				<?php foreach($userLocalsBolsistas as $userLocalsBolsista){
						if($bolsista->matricula == $userLocalsBolsista->user_matricula){
							echo "selected";
							unset($bolsistas[$key]);
						}
					}
			 	?> > 

				<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>


	<?php var_dump($bolsistas); ?>

	<label>Tipo: </label> <input type="text" name="tipo" <?= ('value="'.$local->tipo.'"') ?> required>
	
	<button type="submit">Enviar</button>

</form>