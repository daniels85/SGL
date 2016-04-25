<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamentos
	</h4>
	<div id="listar-equipamentos">
		<table class="ui teal stackable center aligned table">		
			<thead>
				<tr>
					<th class="two wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
					<th class="two wide"><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('codLocal', 'Local', ['direction' => 'desc']); ?></th>
					<th class="three wide"></th>
				</tr>
			</thead>
				
			<tbody>
				<?php foreach($equipamentos as $equipamento): ?>
					<tr>
						<td><?php echo $equipamento->nome; ?></td>
						<td><?php echo $equipamento->tombo; ?></td>
						<td><?php echo $equipamento->status; ?></td>
						<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
						<td><?php echo $equipamento->locals[0]->nome; ?></td>
						<td >
							<div class="ui floating dropdown icon button">
								<i class="setting icon"></i>
							    Opções
							    <div class="menu" data-id="<?php echo $equipamento->id ?>">
							      <a href="/equipamentos/view/<?php echo $equipamento->id ?>" class="item"><i class="unhide icon"></i>Ver</a>
							      <a href="/equipamentos/edit/<?php echo $equipamento->id ?>" class="item" ><i class="edit icon"></i>Modificar</a>
							      <a href="/equipamentos/delete/<?php echo $equipamento->id ?>" class="item delete"><i class="remove icon"></i>Excluir</a>
							    </div>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="6">

						<div class="ui right floated pagination menu small">
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

<div class="sixten wide column row">
	<a class="ui button teal labeled icon small" href="/equipamentos/add"><i class="add icon"></i>Cadastrar Equipamento</a>
	<a class="ui button teal labeled icon small" href="/tipoEquipamentos"><i class="unhide icon"></i>Ver Tipos de Equipamento</a>
	<a class="ui button teal labeled icon small" href="/tipoEquipamentos/add"><i class="add icon"></i>Cadastrar Tipo de Equipamento</a>
</div>