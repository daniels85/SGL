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

<table>
	<thead>
		<tr>
			<th>Tombo</th>
			<th>Nome</th>
			<th>Status</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($equipamentos as $equipamento): ?> 
			<tr>
				<td><?= ($equipamento->tombo) ?></td>
				<td><?= ($equipamento->nome) ?></td>
				<td><?= ($equipamento->status) ?></td>
				<td><?= ($equipamento->tipo_equipamentos[0]->nome) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<button id="addEquipamento" class="ui primary button">Adicionar equipamento</button>

<div class="ui modal">
	 <i class="close icon"></i>
	<div class="header"></div>
	<div class="content"></div>
</div>