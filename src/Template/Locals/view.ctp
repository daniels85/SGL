<?php 
	use App\Controller\UsersController;
	$userAuth = $this->request->session()->read('Auth.User');
?>
<div class="sixten centered wide column row">
		<h4 class="ui horizontal divider header">
			<i class="building outline icon"></i>
			Laboratório
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
<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamentos
	</h4>

	<div id="listar-equipamentos">

		<table class="ui teal stackable table center aligned">
			<thead>
				<tr>
					<th class="three wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
					<th class="four wide"><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
					<th class="three wide"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($equipamentos as $equipamento): 
					if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive" data-id="'.$equipamento->id.'" >'; }
					if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning" data-id="'.$equipamento->id.'" >'; }
					if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative" data-id="'.$equipamento->id.'" >'; }
				?>
						<td><?php echo $equipamento->nome; ?></td>
						<td><?php echo $equipamento->tombo; ?></td>
						<td><?php echo $equipamento->status; ?></td>
						<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
						<td >
							<div class="ui floating dropdown icon button <?php if(is_null($this->request->session()->read('Auth.User.id'))) echo 'disabled'; ?>">
								<i class="setting icon"></i>
							    Opções
							    <div class="menu">
							      <a class="item" href="/Equipamentos/view/<?php echo $equipamento->id; ?>"><i class="unhide icon"></i>Ver</a>
							      <div class="item btnEditarEquipamento <?php if(!UsersController::isCoordenador($userAuth, $local->codigo) && !UsersController::isBolsista($userAuth, $local->codigo) && strcmp($userAuth['role'], 'Administrador')) echo 'disabled'; ?>"><i class="edit icon"></i>Editar</div>
							      <div class="item btnAlertarEquipamento <?php if(!strcmp($equipamento->status, 'Alerta') || !strcmp($equipamento->status, 'Defeito')) echo 'disabled'; ?>"><i class="warning sing icon"></i>Alertar</div>
							    </div>
							</div>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5">

						<div class="ui right floated pagination menu">
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
<div class="sixten wide column row">
	<button class="ui button teal labeled icon" id="addEquipamento" data-id="<?php echo $local->codigo; ?>"><i class="add icon"></i> Adicionar Equipamento</button>
</div>

<?php endif; ?>