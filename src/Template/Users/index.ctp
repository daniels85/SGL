<table>
		
	<thead>
		<tr>
			<th>Nome</th>
			<th>Username</th>
			<th>Matrícula</th>
			<th>Função</th>
			<th>Última vez Ativo</th>
			<th>Cadastrado por</th>
			<th>Data de Cadastro</th>
		</tr>
	</thead>
		
	<tbody>
		<?php foreach($users as $user): ?>
			<tr>
				<td><?= ($user->nome) ?></td>
				<td><?= ($user->username) ?></td>
				<td><?= ($user->matricula) ?></td>
				<td><?= ($user->role) ?></td>
				<td><?= ($user->ultimaVezAtivo) ?></td>
				<td><?= ($user->cadastradoPor) ?></td>
				<td><?= ($user->dataDeCadastro) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>

</table>