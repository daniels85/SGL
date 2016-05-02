<div class="two column row">
	<div class="column centered">
		<div class="ui teal segment">
			<h4 class="ui horizontal divider header">
				Cadastrar Tipo de Equipamento
			</h4>
			<?php $this->Flash->render('auth'); ?>
			
			<div id="formTipoEquipamento">
				
				<?php echo $this->Form->create(); ?>

		        <?php echo $this->Form->input('nome', ['value' => $tipoEquipamento->nome]); ?>

		        <?php echo $this->Form->input('descrição', ['name' => 'descricao', 'type' => 'textarea', 'value' => $tipoEquipamento->descricao]); ?>

				<div class="ui error message"></div>

				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>

				<?php echo $this->Form->end(); ?>

			</div>

		</div>
	</div>
</div>