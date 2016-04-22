<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar Equipamento
			</h4>
			<?php $this->Flash->render('auth'); ?>
			
			<div id="formEquipamento">
				
				<?php echo $this->Form->create(); ?>

		        <?php echo $this->Form->input('nome'); ?>

		        <?php echo $this->Form->input('tombo'); ?>

		        <?php echo $this->Form->input('fornecedor'); ?>

		        <?php echo $this->Form->input('modelo'); ?>

		        <?php echo $this->Form->input('responsavel'); ?>

		        <?php 

		        	$options = [ '' => 'Selecione um opção' ];

		        	foreach ($locals as $local) {
		        		$options += [$local->codigo => $local->nome];
		        	}

		        	echo $this->Form->input('Local', ['name' => 'codLocal', 'options' => $options]); 

		        ?>		        

		        <?php echo $this->Form->input('dataDeCompra', ['id' => 'dataDeCompra'])?>

		        <?php 

		        	$options = [ '' => 'Selecione um opção' ];

		        	foreach ($tipoEquipamentos as $tipo) {
		        		$options += [$tipo->id => $tipo->nome];
		        	}
		        	
		        	echo $this->Form->input('tipo', ['name' => 'tipo', 'options' => $options]); 
		       	?>
			        
				<div class="ui error message"></div>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

				<?php echo $this->Form->end(); ?>

			</div>

		</div>
	</div>
</div>