<?php 
	use App\Controller\UsersController;
	$userAuth = $this->request->session()->read('Auth.User');
?>
<div class="sixteen centered wide column row">
		<h4 class="ui horizontal divider header">
			<i class="building outline icon"></i>
			Informações do Ambiente
		</h4>
		<table class="ui teal stackable table">

			<tr>
				<td>Nome</td>
				<td><?php echo $local->nome; ?></td>
			</tr>
			<tr>
				<td>Código</td>
				<td><?php echo $local->codigo; ?></td>
			</tr>

			<?php foreach($coordenadores as $coordenador): ?>
				<tr>
					<td>Responsável</td>
					<td><?php if($coordenador) echo $coordenador->nome; ?></td>
				</tr>
			<?php endforeach; ?>

			<?php foreach ($bolsistas as $bolsista): ?>
				<tr>
					<td>Bolsista</td>
					<td><?php echo $bolsista->nome; ?></td>
				</tr>
			<?php endforeach; ?>

		</table>
</div>
<div class="sixteen centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamentos
	</h4>

	<div id="listar-equipamentos">

		<table class="ui teal stackable table definition center aligned">
			<thead>
				<tr>
					<th></th>
					<th><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>					
					<th><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
					<th><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
					<th><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($equipamentos as $equipamento): 
					if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive" data-tombo="'.$equipamento->tombo.'" ><td><i class="checkmark green icon"></i></td>'; }
					if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning" data-tombo="'.$equipamento->tombo.'" ><td><i class="warning orange sign icon"></i></td>'; }
					if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative" data-tombo="'.$equipamento->tombo.'" ><td><i class="remove red icon"></i></td>'; }
				?>
						<td><?php echo $equipamento->nome; ?></td>
						<td><?php echo $equipamento->status; ?></td>
						<td><?php echo $equipamento->tombo; ?></td>
						<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
						<td>
							<?php if(!is_null($this->request->session()->read('Auth.User.id'))): ?>
						      <a class="ui button icon green tiny" href="/Equipamentos/view/<?php echo $equipamento->tombo; ?>"><i class="unhide icon"></i></a>						      
						      <button class="ui button icon tiny orange btnAlertarEquipamento <?php if(!strcmp($equipamento->status, 'Alerta') || !strcmp($equipamento->status, 'Defeito')) echo 'disabled'; ?>"><i class="warning sing icon"></i></button>
						      <button class="ui button icon tiny blue btnEditarEquipamento <?php if(!UsersController::isCoordenador($userAuth, $local->codigo) && !UsersController::isBolsista($userAuth, $local->codigo) && strcmp($userAuth['role'], 'Administrador')) echo 'disabled'; ?>"><i class="edit icon"></i></button>
						      <button class="ui button icon tiny red btnApagarEquipamento <?php if(!UsersController::isCoordenador($userAuth, $local->codigo) && !UsersController::isBolsista($userAuth, $local->codigo) && strcmp($userAuth['role'], 'Administrador')) echo 'disabled'; ?>"><i class="delete icon"></i></button>
						    <?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot class="right aligned full-width">
				<tr>
					<th colspan="6">

						<div class="ui pagination menu">
							<?php echo $this->Paginator->prev(); ?>

							<?php echo $this->Paginator->numbers(); ?>
							
							<?php echo $this->Paginator->next(); ?>
						</div>
					</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?php if(UsersController::isCoordenador($userAuth, $local->codigo) || UsersController::isBolsista($userAuth, $local->codigo) || !strcmp($userAuth['role'], 'Administrador')) : ?>

<div class="sixteen wide column row">

	<button class="ui button teal labeled icon" id="addEquipamento" data-id="<?php echo $local->codigo; ?>"><i class="add icon"></i> Adicionar Equipamento</button>
	<?php if($this->request->session()->read('Auth.User.role') === 'Administrador'): ?>
		<a class="ui button teal labeled icon" href="/Locals/moverEquipamentos/<?php echo $local->codigo; ?>"><i class="add icon"></i> Mover Equipamentos</a>
	<?php endif; ?>
</div>

<?php endif; ?>