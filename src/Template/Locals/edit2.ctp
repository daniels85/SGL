<form method="POST" accept-charset="utf-8" <?= ('action="/Locals/edit/'.$local->id.'"') ?> style="width: 25%;margin: 0 auto;margin-top: 5%;">
	<div style="display:none;">
		<input type="hidden" name="_method" value="POST"/>
	</div>

	<label>Nome: </label> <input type="text" name="nome" <?= ('value="'.$local->nome.'"') ?> required>
	<label>Codigo: </label> <input type="text" name="codigo" <?= ('value="'.$local->codigo.'"') ?> required>


	<label>Coordenador: </label> 
	<select name="coordenadores[]" >
		<option value=""></option>
		<?php if(isset($p)){unset($p);}  foreach($professores as $key => $professor): ?>
			<option <?= ("value='$professor->matricula'") ?> 

				<?php 
					if(isset($userLocalsCoordenadores)){
						foreach($userLocalsCoordenadores as $keyB => $userLocalsCoordenador){
							if($professor->matricula == $userLocalsCoordenador->matricula){
								if(isset($p))
									break 1;
								unset($professores[$key]);
								echo "selected";	
								$p = 1;						
							}
						}
					}
			 	?> > 

				<?= ($professor->nome." - Matrícula: ".$professor->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>

	<select name="coordenadores[]" >
		<option value=""></option>
		<?php if(isset($p)){unset($p);}  foreach($professores as $key => $professor): ?>
			<option <?= ("value='$professor->matricula'") ?> 

				<?php 
					if(isset($userLocalsCoordenadores)){
						foreach($userLocalsCoordenadores as $keyB => $userLocalsCoordenador){
							if($professor->matricula == $userLocalsCoordenador->matricula){
								if(isset($p))
									break 1;
								unset($professores[$key]);
								echo "selected";	
								$p = 1;						
							}							
						}
					}
			 	?> > 

				<?= ($professor->nome." - Matrícula: ".$professor->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>

	<label>Bolsista: </label> 
	<select name="bolsistas[]">
		<option value=""></option>
		<?php if(isset($p)){unset($p);}  foreach($bolsistas as $key => $bolsista): ?>
			<option <?= ("value='$bolsista->matricula'") ?> 

				<?php
					if(isset($userLocalsBolsistas)){
						foreach($userLocalsBolsistas as $keyB => $userLocalsBolsista){
							if($bolsista->matricula == $userLocalsBolsista->matricula){
								if(isset($p))
									break 1;
								unset($bolsistas[$key]);
								echo "selected";	
								$p = 1;						
							}						
						}
					}
			 	?> > 

				<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>
	<select name="bolsistas[]">
		<option value=""></option>
		<?php if(isset($p)){unset($p);}  foreach($bolsistas as $key => $bolsista): ?>
			<option <?= ("value='$bolsista->matricula'") ?> 
				<?php
					if(isset($userLocalsBolsistas)){
						foreach($userLocalsBolsistas as $keyB => $userLocalsBolsista){
							if($bolsista->matricula == $userLocalsBolsista->matricula){
								if(isset($p))
									break 1;
								unset($bolsistas[$key]);
								echo "selected";	
								$p = 1;						
							}						
						}
					}
			 	?> > 

				<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>

	<select name="bolsistas[]">
		<option value=""></option>
		<?php if(isset($p)){unset($p);}  foreach($bolsistas as $key => $bolsista): ?>
			<option <?= ("value='$bolsista->matricula'") ?> 
				<?php
					if(isset($userLocalsBolsistas)){
						foreach($userLocalsBolsistas as $keyB => $userLocalsBolsista){
							if($bolsista->matricula == $userLocalsBolsista->matricula){
								if(isset($p))
									break 1;
								unset($bolsistas[$key]);
								echo "selected";	
								$p = 1;						
							}						
						}
					}
			 	?> > 

				<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
			</option>
		<?php endforeach; ?>
	</select>

	<label>Tipo: </label> <input type="text" name="tipo" <?= ('value="'.$local->tipo.'"') ?> required>
	
	<button type="submit">Enviar</button>

</form>