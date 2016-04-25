<div class="three column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				<i class="sign in icon"></i>
				Login
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<div id="formLogin">
				<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('username'); ?>
			        <?php echo $this->Form->input('password'); ?>
			        <div class="ui message error"></div>
					<?php echo $this->Html->link('Recuperar Senha', ['controller' => 'Users', 'action' => 'recuperarSenha'], ['class' => 'ui button negative tiny']); ?>
					<?php echo $this->Form->button(__('Login'), ['class' => 'ui button positive tiny right floated']); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
