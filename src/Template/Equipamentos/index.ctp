<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamentos
	</h4>
	<div id="listar-equipamentos">
		<table class="ui teal stackable table">		
			<thead class="center aligned">
				<tr>
					<th class="two wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
					<th class="two wide"><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('codLocal', 'Local', ['direction' => 'desc']); ?></th>
					<th class="three wide"></th>
				</tr>
			</thead>
				
			<tbody class="center aligned">
				<?php foreach($equipamentos as $equipamento): 
					if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive" >'; }
					if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning" >'; }
					if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative" >'; }
				?>
						<td><?php echo $equipamento->nome; ?></td>
						<td><?php echo $equipamento->tombo; ?></td>
						<td><?php echo $equipamento->status; ?></td>
						<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
						<td><?php echo $equipamento->locals[0]->nome; ?></td>
						<td >
							<div class="ui floating dropdown icon button">
								<i class="setting icon"></i>
							    Opções
							    <div class="menu" data-tombo="<?php echo $equipamento->tombo ?>">
							      <a href="/equipamentos/view/<?php echo $equipamento->tombo ?>" class="item"><i class="unhide icon"></i>Ver</a>
							      <a href="/equipamentos/edit/<?php echo $equipamento->tombo ?>" class="item" ><i class="edit icon"></i>Modificar</a>
							      <a class="item apagarEquipamento"><i class="remove icon"></i>Excluir</a>
							    </div>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="full-width">
				<tr>
					<th colspan="6" class="right aligned">
						<div class="ui pagination menu small">
							<?php echo $this->Paginator->prev(); ?>

							<?php echo $this->Paginator->numbers(); ?>
							
							<?php echo $this->Paginator->next(); ?>
						</div>
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="sixten wide column row centered"> 
	<div class="three ui buttons">
		<a href="/equipamentos/add" class="ui button teal labeled icon"><i class="add icon"></i>Cadastrar Equipamento</a>
		<a href="/tipoEquipamentos" class="ui button teal labeled icon"><i class="unhide icon"></i>Ver tipos</a>
		<a href="/tipoEquipamentos/add" class="ui button teal labeled icon"><i class="add icon"></i>Cadastrar tipo</a>
	</div>
</div>