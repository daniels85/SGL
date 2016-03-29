<?php 
	use Cake\ORM\TableRegistry;
	$userLocalsTable = TableRegistry::get('UserLocals');
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

					$userLocals = $userLocalsTable->find('all', [						
						'conditions' => [
							'local_codigo' => $local->codigo
						]
					])->toArray();

					foreach($userLocals as $user){
						$coordenador[] = $usersTable->find('list', [
							'keyField' => 'role',
							'valueField' => 'nome',
							'conditions' => [
								'matricula' => $user->user_matricula,
								'role' => 'Professor'
							]
						])->toArray();
					}

				?>

				<td><?= var_dump($coordenador) ?></td>
				<td><a <?= ('href="/Locals/view/'.$local->id.'"') ?> >Ver</a></td>

			</tr>
		<?php endforeach; ?>
	</tbody>

</table>