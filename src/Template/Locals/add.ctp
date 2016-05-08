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
				        <label>Coordenador</label>
				        <?php echo $this->Form->select('coordenadores', $professores, ['name' => 'coordenadores[]', 'multiple' => true]); ?>
					</div>
					<div class="field">
			        	<label>Bolsista</label>
			        	<?php echo $this->Form->select('bolsistas', $bolsistas, ['name' => 'bolsistas[]', 'multiple' => true]); ?>
			        </div>
			        <?php  
			        	$opcoes = [
			        		'' => 'Selecione uma opção',
			        		'Laboratório' => 'Laboratório', 
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