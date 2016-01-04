<div class="ten wide column centered">
	<div class="ui teal segment">
		<h4 class="ui horizontal divider header">
			Mover equipamentos
		</h4>
		<?php $this->Flash->render('auth'); ?>

		<div id="formMoverEquipamentos">
		
			<?php echo $this->Form->create(); ?>
		    
			<?php 
	        	$options = [
	        		'' => 'Selecione um local',
	        	];

	        	foreach($locals as $local){
	        		$options[$local->codigo] = $local->nome;
	        	}

	        	echo $this->Form->input('Local', ['class' => 'ui dropdown selection six wide field', 'name' => 'local', 'options' => $options]); 
	       	?>

	       	<div class="field">
	       		<label>Equipamentos</label>
	       	</div>
		    <table class="ui teal stackable table center aligned">
				<thead>
					<tr>
						<th></th>
						<th>Nome</th>					
						<th>Status</th>
						<th>Tombo</th>
						<th>Tipo</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($equipamentos as $equipamento): 
						if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive">'; }
						if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning">'; }
						if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative">'; }
					?>		
							<td>
								<div class="ui checkbox">
									<input type="checkbox" name="equipamentos[]" class="hidden checkbox" value="<?php echo $equipamento->tombo; ?>">
								</div>
							</td>
							<td><?php echo $equipamento->nome; ?></td>
							<td><?php echo $equipamento->status; ?></td>
							<td><?php echo $equipamento->tombo; ?></td>
							<td><?php echo $equipamento->tipo_equipamento->nome; ?></td>								
						</tr>
					<?php endforeach; ?>
				</tbody> 
				<tfoot class="full-width">
					<tr class="left aligned">
						<th colspan="4">
							<div class="ui small blue button" onclick="marcarTodos();">
								Marcar Todos
							</div>
							<div class="ui small blue button" onclick="desmarcarTodos();">
								Desmarcar Todos
							</div>
						</th>
						<th class="right aligned">
							<?php echo $this->Form->button(__('Enviar'), ['class' => 'ui button green']); ?>
						</th>
					</tr>
				</tfoot>

			</table>
			
			
			<div class="ui error message"></div>
			

			<?php echo $this->Form->end(); ?>
				
		</div>
	</div>
</div>