<style type="text/css">


</style>
<table>

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

<h4 class="ui horizontal divider header">
	<i class="desktop icon"></i>
	Equipamentos
</h4>

<div id="listar-equipamentos">

<?php foreach($equipamentos as $equipamento): ?>
	
	<div class="ui people shape" >
		<div class="sides">
			<div class="active side">
				<div class="ui card">
					<div class="image">
						<?php 
							if($equipamento->status == "Funcionando"){
								echo '<img src="/img/status/functionando.jpg">';
								echo 'funcionando';
							}
							if($equipamento->status == "Alerta"){
								echo '<img src="/img/status/alerta.jpg">';
								echo 'Alerta';
							}
							if($equipamento->status == "Defeito"){
								echo '<img src="/img/status/defeito.jpg">';
								echo 'Defeito';
							}
						?>					
					</div>
					<div class="content">
						<div class="header"> <?= $equipamento->nome ?> </div>
						<div class="description">
							<p>Tombo: <?= $equipamento->tombo ?></p>
						</div>
					</div>
					<div class="extra content" <?= ('data-id="'.$equipamento->id.'"') ?> >
						<button class="ui green button tiny btn_editar_equipamento">Editar</button>
						<button class="ui primary button tiny">Ver</button>
						<button class="ui orange button tiny">Alertar</button>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endforeach; ?>
</div>

<h4 class="ui horizontal divider header">
</h4>

<button id="addEquipamento" class="ui primary button">Adicionar equipamento</button>

<div class="ui modal">
	 <i class="close icon"></i>
	<div class="header"></div>
	<div class="content"></div>
</div>