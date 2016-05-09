<div class="sixteen centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamentos
	</h4>
	<div id="listar-equipamentos">
		<table class="ui teal stackable definition table">		
			<thead class="center aligned">
				<tr>
					<th class=""></th>
					<th class=""><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>					
					<th class=""><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
					<th class=""><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
					<th class=""><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
					<th class=""><?php echo $this->Paginator->sort('codLocal', 'Local', ['direction' => 'desc']); ?></th>
					<th class=""></th>
				</tr>
			</thead>
			<tbody class="center aligned">
				<?php foreach($equipamentos as $equipamento): 
					if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive" data-tombo="'.$equipamento->tombo.'" ><td><i class="checkmark green icon"></i></td>'; }
					if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning" data-tombo="'.$equipamento->tombo.'" ><td><i class="warning orange sign icon"></i></td>'; }
					if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative" data-tombo="'.$equipamento->tombo.'" ><td><i class="remove red icon"></i></td>'; }
				?>
						<td><?php echo $equipamento->nome; ?></td>
						<td><?php echo $equipamento->status; ?></td>
						<td><?php echo $equipamento->tombo; ?></td>
						<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
						<td><?php echo $equipamento->locals[0]->nome; ?></td>
						<td>
						      <a class="ui button tiny icon green" href="/equipamentos/view/<?php echo $equipamento->tombo ?>"><i class="unhide icon"></i></a>
						      <a class="ui button tiny icon blue" href="/equipamentos/edit/<?php echo $equipamento->tombo ?>"><i class="edit icon"></i></a>
						      <a class="ui button tiny icon red btnApagarEquipamento"><i class="remove icon"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="right aligned full-width">
				<tr>
					<th colspan="7">
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
<div class="sixteen wide column row centered"> 
	<div class="three ui buttons">
		<a href="/equipamentos/add" class="ui button teal labeled icon"><i class="add icon"></i>Cadastrar Equipamento</a>
		<a href="/tipoEquipamentos" class="ui button teal labeled icon"><i class="unhide icon"></i>Ver Tipos</a>
		<a href="/tipoEquipamentos/add" class="ui button teal labeled icon"><i class="add icon"></i>Cadastrar Tipo</a>
	</div>
</div>