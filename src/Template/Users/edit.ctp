<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Modificar Usuário
			</h4>
			<?php $this->Flash->render('auth'); ?>
				
			<div id="formAddUsuario">
				
				<?php echo $this->Form->create(); ?>
				<div class="ui error message"></div>
		        <?php echo $this->Form->input('nome', ['value' => $user->nome]); ?>

		        <?php echo $this->Form->input('matrícula', ['name' => 'matricula', 'value' => $user->matricula]); ?>

		        <?php echo $this->Form->input('username', ['value' => $user->username]); ?>

		        <?php echo $this->Form->input('email', ['value' => $user->email]); ?>

		        <?php 
		        	$options = [
		        		'' => 'Selecione um tipo',
		        		'Administrador' => 'Administrador',
		        		'Bolsista' 		=> 'Bolsista',
		        		'Professor' 	=> 'Professor',
		        		'Suporte' 		=> 'Suporte'  		
		        	];

		        	echo $this->Form->input('tipo', ['name' => 'role', 'options' => $options, 'default' => $user->role]); 
		       	?>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

				<?php echo $this->Form->end(); ?>

			</div>

		</div>
	</div>
</div>