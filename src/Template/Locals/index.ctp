<?php 
	use App\Controller\UsersController;
?>
<div class="sixten centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="building outline icon"></i>
		Laboratórios
	</h3>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr >
				<th class="four wide">Nome</th>
				<th class="three wide">Código</th>
				<th class="five wide">Tipo</th>
				<th class="four wide"></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($locals as $local): ?>
				<tr>
					<td><?= ($local->nome) ?></td>
					<td><?= ($local->codigo) ?></td>
					<td><?= ($local->tipo) ?></td>
					<td class="left aligned">

						<a class="ui button teal mini" href="/Locals/view/<?php echo $local->id; ?>"><i class="unhide icon"></i>Ver</a>

						<?php if(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Professor') && UsersController::isCoordenador($this->request->session()->read('Auth.User.matricula'), $local->codigo)): ?>
						<a class="ui button orange mini" href="/Locals/bolsista/<?php echo $local->id; ?>"><i class="edit icon"></i>Alterar Bolsistas</a>
						<?php endif; ?>

						<?php if(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>
						<a class="ui button orange mini" href="/Locals/edit/<?php echo $local->id; ?>"><i class="edit icon"></i>Modificar</a>
						<a class="ui button red mini" href="/Locals/delete/<?php echo $local->id; ?>"><i class="remove icon"></i>Deletar</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>

<?php if(!is_null($this->request->session()->read('Auth.User.username')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>
<div class="sixten wide column row">
	<a class="ui button teal" href="/Locals/add"><i class="add icon"></i>Adicionar Local</a>
</div>
<?php endif; ?>

