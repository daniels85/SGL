<table>

	<tr>
		<td>Nome</td>
		<td><?php echo $local->nome; ?></td>
	</tr>
	<tr>
		<td>Código</td>
		<td><?php echo $local->codigo; ?></td>
	</tr>

	<?php foreach ($coordenadores as $coordenador): ?>
		<tr>
			<td>Resposável</td>
			<td><?php echo $coordenador->nome; ?></td>
		</tr>
	<?php endforeach; ?>

	<?php foreach ($bolsistas as $bolsista): ?>
		<tr>
			<td>Bolsista</td>
			<td><?php echo $bolsista->nome; ?></td>
		</tr>
	<?php endforeach; ?>

</table>