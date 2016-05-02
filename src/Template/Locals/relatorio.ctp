<?php 
	use App\Controller\UsersController;
	$userAuth = $this->request->session()->read('Auth.User');

	if(isset($equipamentos)):
		
		foreach ($equipamentos as $equipamento){
	
				echo $equipamento->nome.'<br>';

				foreach ($equipamento->alertas as $alerta) {
					var_dump($alerta);
				}

		}
	?>

<?php else: ?>

<div class="sixteen wide column row">
		<h4 class="ui horizontal divider header">
			<i class="file text outline icon"></i>
			Relatório
		</h4>
		
		<div class="five wide column"></div>

		<div class="six wide column">
			<h1 class="ui horizontal divider header">
			</h1>
			<div id="formRelatorioLocal">
				<?php echo $this->Form->create(null, ['class' => 'ui form equal width']); ?>
				<h4 class="ui dividing header centered">Período do Relatório</h4>
				<div class="fields">
					<?php echo $this->Form->input('nome', ['name' => 'dataInicio', 'id' => 'dataInicio']); ?>
					<?php echo $this->Form->input('nome', ['name' => 'dataFim', 'id' => 'dataFim']); ?>
				</div>
				<div class="ui message error"></div>
				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div class="five wide column"></div>
</div>

<?php 
	endif;
	
?>