<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar local
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('nome', ['required' => true]); ?>

			        <?php echo $this->Form->input('Código', ['name' => 'codigo', 'required' => true]); ?>
			        <div class="field">
				        <label>Coordenador</label>
				        <?php echo $this->Form->select('coordenadores', $professores, ['name' => 'coordenadores[]', 'multiple' => true]); ?>
					</div>
					<div class="field">
			        	<label>Bolsista</label>
			        	<?php echo $this->Form->select('bolsistas', $bolsistas, ['name' => 'bolsistas[]', 'multiple' => true]); ?>
			        </div>

			        <div class="field">
			        	<label>Tipo</label>
			        	<?php echo $this->Form->select(
			        								'tipo', 
			        								[
			        									['empty' => 'Selecione uma opção'], 
			        									[
			        										'Laboratório' => 'Laboratório', 
			        										'Sala de Aula' => 'Sala de Aula',
			        										'Gabinete' => 'Gabinete',
			        										'Coordenação' => 'Coordenação'
			        									]
			        								]); ?>
			        </div>

			<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>