<div class="sixteen centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Alertas
	</h4>
	<table class="ui yellow stackable table">		
		<thead class="center aligned">
			<tr>
				<th class="three wide"><?php  echo $this->Paginator->sort('tomboEquipamento', 'Tombo', ['direction' => 'desc']); ?></th>
				<th class="three wide"><?php echo $this->Paginator->sort('statusAlerta', 'Status do Alerta', ['direction' => 'desc']); ?></th>
				<th class="three wide"><?php echo $this->Paginator->sort('geradoPor', 'Gerado Por', ['direction' => 'desc']); ?></th>
				<th class="four wide"><?php echo $this->Paginator->sort('dataAlerta', 'Data do Alerta', ['direction' => 'desc']); ?></th>
				<th class="three wide"></th>
			</tr>
		</thead>
			
		<tbody class="center aligned">
			<?php foreach($alertas as $alerta): ?>
				<tr class=" <?php (strcmp($alerta->statusAlerta, 'Pendente')) ? print 'positive' : print 'negative'; ?> ">
			
					<td><?php echo $alerta->tomboEquipamento; ?></td>
					<td><?php echo $alerta->statusAlerta; ?></td>
					<td><?php echo $alerta->geradoPor; ?></td>
					<td><?php echo $alerta->dataAlerta; ?></td>
					<td>
						<a href="/alertas/view/<?php echo $alerta->id; ?>" class="ui mini button teal labeled icon"><i class="unhide icon"></i>Ver</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="full-width">
			<tr>
				<th colspan="6" class="right aligned">
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