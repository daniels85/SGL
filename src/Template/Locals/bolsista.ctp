<h2 class="ui horizontal divider header">
</h2>
<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Alterar bolsista
			</h4>

			<?php $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create(); ?>

					<div class="field">
			        	
						<label>Bolsista: </label> 
						<input type="hidden" name="bolsistas[]" value=""/>
						<select name="bolsistas[]" class="ui fluid dropdown" multiple>
							<option value=""></option>
							<?php foreach($bolsistas as $bolsista): ?>
								<option value="<?php echo $bolsista->matricula; ?>" 

									<?php
										if(isset($userLocalsBolsistas)){
											foreach($userLocalsBolsistas as $userLocalsBolsista){
												if($bolsista->matricula == $userLocalsBolsista->matricula){
													echo "selected";				
												}						
											}
										}
								 	?> > 

									<?php echo $bolsista->nome." - Matrícula: ".$bolsista->matricula; ?> 
								</option>
							<?php endforeach; ?>
						</select>

			        </div>

			<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
			<?php echo $this->Form->end(); ?>


		</div>
	</div>
</div>