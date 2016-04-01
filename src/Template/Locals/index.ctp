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
			<th>Coordenador</th>
			<th>Actions</th>
		</tr>
	</thead>
		
	<tbody>
		<?php foreach($locals as $local): ?>
			<tr>
				<td><?= ($local->nome) ?></td>
				<td><?= ($local->codigo) ?></td>
				<td><?= ($local->tipo) ?></td>

				<?php 

					$coordenador = $usersTable
		                            ->find('all')
		                            ->select(['nome', 'matricula', 'role'])
		                            ->where(['matricula' => $local->coordenador])->first();
				?>

				<td><?php if($coordenador){ echo $coordenador->nome; } ?></td>
				<td>
					<a <?= ('href="/Locals/view/'.$local->id.'"') ?> >Ver</a>
					<a <?= ('href="/Locals/edit/'.$local->id.'"') ?> >&nbsp;Editar</a>
				</td>

			</tr>
		<?php endforeach; ?>
	</tbody>

</table>