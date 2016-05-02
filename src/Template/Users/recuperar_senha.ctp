<div class="three column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				<i class="repeat icon"></i>
				Recuperar Senha
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<div id="recuperarSenha">
				<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('matricula'); ?>
			        <div class="ui message error"></div>
					<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button positive tiny']); ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>