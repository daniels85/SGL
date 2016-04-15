<h2 class="ui horizontal divider header">
</h2>
<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Modificar local
			</h4>

			<?php $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('nome', ['required' => true, 'value' => $local->nome]); ?>

			        <?php echo $this->Form->input('Código', ['name' => 'codigo', 'required' => true, 'value' => $local->codigo]); ?>
			        
			        <div class="field">
				        <label>Coordenador: </label> 
				        <input type="hidden" name="coordenadores[]" value=""/>
						<select name="coordenadores[]" class="ui fluid dropdown" multiple>
							<option value=""></option>
							<?php foreach($professores as $key => $professor): ?>
								<option <?= ("value='$professor->matricula'") ?> 
									<?php 
										if(isset($userLocalsCoordenadores)){
											foreach($userLocalsCoordenadores as $keyB => $userLocalsCoordenador){
												if($professor->matricula == $userLocalsCoordenador->matricula){
													echo "selected";					
												}
											}
										}
								 	?> > 

									<?= ($professor->nome." - Matrícula: ".$professor->matricula) ?> 
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="field">
			        	
						<label>Bolsista: </label> 
						<input type="hidden" name="bolsistas[]" value=""/>
						<select name="bolsistas[]" class="ui fluid dropdown" multiple>
							<option value=""></option>
							<?php foreach($bolsistas as $key => $bolsista): ?>
								<option <?= ("value='$bolsista->matricula'") ?> 

									<?php
										if(isset($userLocalsBolsistas)){
											foreach($userLocalsBolsistas as $keyB => $userLocalsBolsista){
												if($bolsista->matricula == $userLocalsBolsista->matricula){
													echo "selected";				
												}						
											}
										}
								 	?> > 

									<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
								</option>
							<?php endforeach; ?>
						</select>

			        </div>
			        <?php
			        	$options = [
			        				'Laboratório' => 'Laboratório', 
									'Sala de Aula' => 'Sala de Aula',
									'Gabinete' => 'Gabinete',
									'Coordenação' => 'Coordenação'
								];
					?>

			        <div class="field">
			        	<select name="tipo">
			        		<?php foreach($options as $option): ?>
			        			<option value="<?php echo $option; ?>" <?php (!strcmp($option, $local->tipo))? print 'selected' : print ''; ?> ><?php echo $option; ?></option>
			        		<?php endforeach; ?>
			        	</select>
			        </div>

			<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
			<?php echo $this->Form->end(); ?>


		</div>
	</div>
</div>