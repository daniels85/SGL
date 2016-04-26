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
				<th class="four wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
				<th class="three wide"><?php echo $this->Paginator->sort('codigo', 'Código', ['direction' => 'desc']); ?></th>
				<th class="four wide"><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
				<th class="five wide"></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($locals as $local): ?>
				<tr>
					<td><?= ($local->nome) ?></td>
					<td><?= ($local->codigo) ?></td>
					<td><?= ($local->tipo) ?></td>
					<td class="left aligned">

						<a class="ui button teal mini labeled icon" href="/Locals/view/<?php echo $local->id; ?>"><i class="unhide icon"></i>Ver</a>

						<?php if(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Professor') && UsersController::isCoordenador($this->request->session()->read('Auth.User'), $local->codigo)): ?>
						<a class="ui button orange mini labeled icon" href="/Locals/bolsista/<?php echo $local->id; ?>"><i class="edit icon"></i>Alterar Bolsistas</a>
						<?php endif; ?>

						<?php if(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>
						<a class="ui button orange mini labeled icon" href="/Locals/edit/<?php echo $local->id; ?>"><i class="edit icon"></i>Modificar</a>
						<a class="ui button red mini labeled icon" href="/Locals/delete/<?php echo $local->id; ?>"><i class="remove icon"></i>Deletar</a>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="right aligned">
			<tr>
				<th colspan="4">

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

<?php if(!is_null($this->request->session()->read('Auth.User.username')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>
<div class="sixten wide column row">
	<a class="ui button teal labeled icon" href="/Locals/add"><i class="add icon"></i>Adicionar Local</a>
</div>
<?php endif; ?>

