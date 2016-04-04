<?php 
	use Cake\ORM\TableRegistry;
	
	$usersTable = TableRegistry::get('Users');
?>
<table>
		
	<thead>
		<tr>
			<th>Nome</th>
			<th>Código</th>
			<th>Tipo</th>
			<th>Actions</th>
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