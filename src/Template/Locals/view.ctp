<?php 
	use App\Controller\UsersController;
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
					<th class="three wide">Nome</th>
					<th class="four wide">Tombo</th>
					<th class="three wide">Status</th>
					<th class="three wide">Tipo</th>
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
							<div class="ui floating dropdown icon button">
								<i class="setting icon"></i>
							    Opções
							    <div class="menu">
							      <div class="item btnVerEquipamento"><i class="unhide icon"></i>Ver</div>
							      <div class="item btnEditarEquipamento"><i class="edit icon"></i>Editar</div>
							      <div class="item btnAlertarEquipamento"><i class="warning sing icon"></i>Alertar</div>
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
<div class="sixten wide column row">
	<button class="ui button teal" id="addEquipamento" data-id="<?php echo $local->id; ?>"><i class="add icon"></i> Adicionar Equipamento</button>
</div>

<div class="ui modal">
	<i class="close icon"></i>
	<div class="mensagem"></div>
	<div class="header"></div>
	<div class="content"></div>
</div>