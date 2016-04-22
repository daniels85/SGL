<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar Usuário
			</h4>
			<?php $this->Flash->render('auth'); ?>
			
			<div id="formAddUsuario">
				
				<?php echo $this->Form->create(); ?>

		        <?php echo $this->Form->input('nome'); ?>

		        <?php echo $this->Form->input('matrícula', ['name' => 'matricula']); ?>

		        <?php echo $this->Form->input('username'); ?>

		        <?php echo $this->Form->input('email'); ?>

		        <?php 
		        	$options = [
		        		'' => 'Selecione um tipo',
		        		'Professor' => 'Professor',
		        		'Bolsista' => 'Bolsista',
		        		'Suporte' => 'Suporte'
		        	];

		        	echo $this->Form->input('tipo', ['name' => 'role', 'options' => $options]); 
		       	?>
			        
				<div class="ui error message"></div>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

				<?php echo $this->Form->end(); ?>

			</div>

		</div>
	</div>
</div>