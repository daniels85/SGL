<div class="sixteen centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Equipamento
	</h3>
	<table class="ui selectable stackable table <?php (strcmp($alerta->statusAlerta, 'Pendente')) ? print 'green' : print 'red'; ?>">

		<tr>
			<td>Tombo do Equipamento</td>
			<td><?php echo $alerta->tomboEquipamento; ?></td>
		</tr>
		<tr>
			<td>Status do Alerta</td>
			<td><?php echo $alerta->statusAlerta; ?></td>
		</tr>		
		<tr>
			<td>Gerado por</td>
			<td><?php echo $alerta->geradoPor; ?></td>
		</tr>
		<tr>
			<td>Data do Alerta</td>
			<td><?php echo date('d/m/Y g:i A', strtotime($alerta->dataAlerta)); ?></td>
		</tr>
		<tr>
			<td>Descrição</td>
			<td><?php echo $alerta->descricao; ?></td>
		</tr>
		<?php if(!empty($alerta->observacoes)): ?>
		<tr>
			<td>Observações</td>
			<td><?php echo $alerta->observacoes; ?></td>
		</tr>
		<?php endif; ?>
	
	</table>
</div>