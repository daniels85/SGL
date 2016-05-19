<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar Ambiente
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<div id="formAddLocal">

					<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('nome'); ?>

			        <?php echo $this->Form->input('Código', ['name' => 'codigo']); ?>
			        <div class="field">
				        <label>Coordenador: </label> 
				        <input type="hidden" name="coordenadores[]" value=""/>
						<select name="coordenadores[]" class="ui fluid dropdown" multiple>
							<option value=""></option>
							<?php foreach($professores as $professor): ?>
								<option value=" <?php echo $professor->matricula; ?> ">
									<?php echo $professor->nome." - Matrícula: ".$professor->matricula; ?> 
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					
					<div class="field">
		        	
						<label>Bolsista: </label> 
						<input type="hidden" name="bolsistas[]" value=""/>
						<select name="bolsistas[]" class="ui fluid dropdown" multiple>
							<option value=""></option>
							<?php foreach($bolsistas as $bolsista): ?>
								<option value="<?php echo $bolsista->matricula; ?>">

									<?= ($bolsista->nome." - Matrícula: ".$bolsista->matricula) ?> 
								</option>
							<?php endforeach; ?>
						</select>

			        </div>

			        <?php  
			        	$opcoes = [
			        		'' => 'Selecione uma opção',
			        		'Laboratório' => 'Laboratório', 
			        		'Almoxarifado' => 'Almoxarifado',
							'Sala de Aula' => 'Sala de Aula',
							'Gabinete' => 'Gabinete',
							'Coordenação' => 'Coordenação'
			        	]; 
			        ?>
			        <div class="field">
			        	<label>Tipo</label>
			        	
			        	<select class="ui fluid dropdown" id="tipo" name="tipo">
			        		<?php foreach($opcoes as $key => $opcao): ?>
			        			<option value="<?php echo $key; ?>"><?php echo $opcao; ?></option>
			        		<?php endforeach; ?>
			        	</select>

			        </div>

			        <div class="ui error message"></div>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>