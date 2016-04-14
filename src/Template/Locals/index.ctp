<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="building outline icon"></i>
		Laboratórios
	</h4>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr >
				<th >Nome</th>
				<th >Código</th>
				<th >Tipo</th>
				<th >Actions</th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($locals as $local): ?>
				<tr>
					<td><?= ($local->nome) ?></td>
					<td><?= ($local->codigo) ?></td>
					<td><?= ($local->tipo) ?></td>
					<td>
						<a <?= ('href="/Locals/view/'.$local->id.'"') ?> >Ver</a>
						&nbsp;
						<a <?= ('href="/Locals/edit/'.$local->id.'"') ?> >Editar</a>
						&nbsp;
						<a <?= ('href="/Locals/delete/'.$local->id.'" onclick="if (confirm(&quot;Deseja deletar este local?&quot;)) { return true; } return false;"') ?> >Deletar</a>

					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>
<div class="sixten wide column row">
	<a class="ui button teal" href="/Locals/add"><i class="add icon"></i>Adicionar Local</a>
</div>

