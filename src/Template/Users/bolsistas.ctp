<div class="sixteen centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="users icon"></i>
		Bolsistas
	</h4>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('username', null, ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('matricula', 'Matrícula', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('role', 'Função', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('email', 'E-mail', ['direction' => 'desc']); ?></th>
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
					<td><?php echo $user->email; ?></td>
					<td>
						<a href="/users/view/<?php echo $user->matricula ?>" class="ui button teal labeled icon mini"><i class="unhide icon"></i>Ver</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="right aligned">
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

<div class="sixteen wide column row">
	<button class="ui button teal labeled icon btnCadastrarBolsista"><i class="add user icon"></i>Cadastrar Bolsista</button>
</div>