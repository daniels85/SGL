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

				<div class="two fields">
			      <div class="field">
			        <label>Início</label>
			        <div class="ui calendar" id="rangestart">
			          <div class="ui input left icon">
			            <i class="calendar icon"></i>
			            <input type="text" name="dataInicio" class="inputData" placeholder="Início">
			          </div>
			        </div>
			      </div>
			      
			      <div class="field">
			        <label>Fim</label>
			        <div class="ui calendar" id="rangeend">
			          <div class="ui input left icon">
			            <i class="calendar icon"></i>
			            <input type="text" name="dataFim" class="inputData" placeholder="Fim">
			          </div>
			        </div>
			      </div>
			    </div>
			    
				<div class="ui message error"></div>
				<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']);; ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

		<div class="five wide column"></div>
</div>