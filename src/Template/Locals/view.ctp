<table>

	<tr>
		<td>Nome</td>
		<td><?php echo $local->nome; ?></td>
	</tr>
	<tr>
		<td>Código</td>
		<td><?php echo $local->codigo; ?></td>
	</tr>

	
	<tr>
		<td>Responsável</td>
		<td><?php if($coordenador) echo $coordenador->nome; ?></td>
	</tr>
	

	<?php foreach ($bolsistas as $bolsista): ?>
		<tr>
			<td>Bolsista</td>
			<td><?php echo $bolsista->nome; ?></td>
		</tr>
	<?php endforeach; ?>

</table>