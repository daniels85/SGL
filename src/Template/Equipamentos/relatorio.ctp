<div class="sixteen wide column row">
		<h4 class="ui horizontal divider header">
			<i class="file text outline icon"></i>
			Relatório de Equipamento
		</h4>
		
		<div class="five wide column"></div>

		<div class="six wide column">
			<h1 class="ui horizontal divider header">
			</h1>
			<div id="formRelatorioLocal">
				<?php echo $this->Form->create(null, ['class' => 'ui form equal width']); ?>
				<h4 class="ui dividing header centered">Período do Relatório</h4>
				<div class="fields">
					<?php echo $this->Form->input('Início', ['name' => 'dataInicio', 'id' => 'dataInicio']); ?>
					<?php echo $this->Form->input('Fim', ['name' => 'dataFim', 'id' => 'dataFim']); ?>
				</div>
				<div class="ui message error"></div>
				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div class="five wide column"></div>
</div>