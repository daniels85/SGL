<div class="three column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				<i class="sign in icon"></i>
				Login
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create(); ?>
			        <?php echo $this->Form->input('username', ['required' => true]); ?>
			        <?php echo $this->Form->input('password', ['required' => true]); ?>
			<?php echo $this->Form->button(__('Login'), ['class' => 'ui button green']);; ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
