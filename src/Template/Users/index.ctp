<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="users icon"></i>
		Usuários
	</h4>
	<table class="ui teal stackable table">		
		<thead>
			<tr>
				<th>Nome</th>
				<th>Username</th>
				<th>Matrícula</th>
				<th>Função</th>
				<th>Cadastrado por</th>
				<th>Última vez Ativo</th>
				<th>Data de Cadastro</th>
				<th></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($users as $user): ?>
				<tr>
					<td><?php echo $user->nome; ?></td>
					<td><?php echo $user->username; ?></td>
					<td><?php echo $user->matricula; ?></td>
					<td><?php echo $user->role; ?></td>
					<td><?php echo $user->cadastradoPor; ?></td>
					<td><?php ($user->ultimaVezAtivo) ? print date('d/m/Y H:i', strtotime($user->ultimaVezAtivo)) : print 'Nunca ativo.'; ?></td>
					<td><?php echo date('d/m/Y H:i', strtotime($user->dataDeCadastro)); ?></td>
					<td >
						<div class="ui floating dropdown icon button">
							<i class="setting icon"></i>
						    Opções
						    <div class="menu">
						      <a href="/users/view/<?php echo $user->id ?>" class="item btnVerEquipamento"><i class="unhide icon"></i>Ver</a>
						      <a href="/users/edit/<?php echo $user->id ?>" class="item btnEditarEquipamento"><i class="edit icon"></i>Modificar</a>
						      <a href="/users/delete/<?php echo $user->id ?>" class="item btnAlertarEquipamento"><i class="remove user icon"></i>Excluir</a>
						    </div>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>

<div class="sixten wide column row">
	<a class="ui button teal" href="/users/add"><i class="add user icon"></i> Adicionar Usuário</a>
</div>
