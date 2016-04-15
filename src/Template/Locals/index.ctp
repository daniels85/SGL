<div class="sixten centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="building outline icon"></i>
		Laboratórios
	</h3>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr >
				<th class="three wide">Nome</th>
				<th class="three wide">Código</th>
				<th class="four wide">Tipo</th>
				<th class="six wide">Actions</th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($locals as $local): ?>
				<tr>
					<td><?= ($local->nome) ?></td>
					<td><?= ($local->codigo) ?></td>
					<td><?= ($local->tipo) ?></td>
					<td>
						<a class="ui inverted button blue mini" href="/Locals/view/<?php echo $local->id; ?>"><i class="unhide icon"></i>Ver</a>
						<a class="ui inverted button orange mini" href="/Locals/edit/<?php echo $local->id; ?>"><i class="edit icon"></i>Editar</a>
						<a class="ui inverted button red mini" href="/Locals/delete/<?php echo $local->id; ?>"><i class="remove icon"></i>Deletar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>
<div class="sixten wide column row">
	<a class="ui button teal" href="/Locals/add"><i class="add icon"></i>Adicionar Local</a>
</div>

