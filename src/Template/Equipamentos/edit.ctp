<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Modificar Equipamento
			</h4>
			<?php $this->Flash->render('auth'); ?>
			
			<div id="formEquipamento">
				
				<?php echo $this->Form->create(); ?>

		        <?php echo $this->Form->input('nome', ['value' => $equipamento->nome]); ?>

		        <?php echo $this->Form->input('tombo', ['value' => $equipamento->tombo]); ?>

		        <?php 

		        	$options = [
		        		'Funcionando'	=> 'Funcionando',
		        		'Alerta' 		=> 'Alerta',
		        		'Defeito' 		=> 'Defeito'
		        	];

		        	echo $this->Form->input('status', ['options' => $options , 'default' => $equipamento->status]); 

		        ?>

		        <?php echo $this->Form->input('fornecedor', ['value' => $equipamento->fornecedor]); ?>

		        <?php echo $this->Form->input('modelo', ['value' => $equipamento->modelo]); ?>

		        <?php echo $this->Form->input('responsavel', ['value' => $equipamento->responsavel]); ?>

		        <?php 

		        	$options = [];

		        	foreach ($locals as $local) {
		        		$options += [$local->codigo => $local->nome];
		        	}

		        	echo $this->Form->input('Local', ['name' => 'codLocal', 'options' => $options, 'default' => $equipamento->locals[0]->codigo]); 

		        ?>		        

		        <?php echo $this->Form->input('dataDeCompra', ['id' => 'dataDeCompra', 'value' => date('d/m/Y', strtotime($equipamento->dataDeCompra))]) ?>

		        <?php 

		        	$options = [];

		        	foreach ($tipoEquipamentos as $tipo) {
		        		$options += [$tipo->id => $tipo->nome];
		        	}
		        	
		        	echo $this->Form->input('tipo', ['name' => 'tipo', 'options' => $options, 'default' => $equipamento->tipo_equipamentos[0]->id]); 
		       	?>
			        
				<div class="ui error message"></div>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

				<?php echo $this->Form->end(); ?>

			</div>

		</div>
	</div>
</div>