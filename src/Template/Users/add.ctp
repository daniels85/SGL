<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar Usuário
			</h4>
			<?php $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create(); ?>
					<div class="ui error message"></div>
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
			        


			<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	$(function(){
		$('.ui.form').form({
			nome: {
				identifier : 'nome',
				rules : [
					{
						type : 'empty',
						prompt : 'Por favor insira um nome.'
					}
				]
			},

			matricula: {
				identifier : 'matricula',
				rules : [
					{
						type : 'minLength[6]',
						prompt : 'Por favor insira uma matricula de no mínimo 6 caracteres.'
					}
				]
			},

			username: {
				identifier : 'username',
				rules : [
					{
						type: 'minLength[6]',
						prompt : 'Username deve conter no mínimo 6 caracteres.'
					}
				]
			},

			email : {
				identifier : 'email',
				rules : [
					{
						type : 'email',
						prompt : 'Por favor insira um email.'
					}
				]
			},

			tipo : {
				identifier : 'role',
				rules : [
					{
						type : 'empty',
						prompt : 'Selecione um tipo.'
					}
				]
			}

		});
	});

</script>