<?php 
use Cake\Mailer\Email;
 ?>
<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="users icon"></i>
		Usuários
	</h4>
	<table class="ui teal stackable table">		
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
					<td >
						<div class="ui floating dropdown icon button">
							<i class="setting icon"></i>
						    Opções
						    <div class="menu" data-id="<?php echo $user->id ?>">
								<a href="/users/view/<?php echo $user->id ?>" class="item"><i class="unhide icon"></i>Ver</a>
								<a href="/users/edit/<?php echo $user->id ?>" class="item"><i class="edit icon"></i>Modificar</a>								
								<a class="item resetarSenha"><i class="setting icon"></i>Resetar Senha</a>
								<a class="item deletarUser"><i class="remove user icon"></i>Excluir</a>
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

<div class="sixten wide column row">
	<a class="ui button teal labeled icon" href="/users/add"><i class="add user icon"></i> Adicionar Usuário</a>
</div>
