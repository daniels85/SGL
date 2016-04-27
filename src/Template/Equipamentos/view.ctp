<div class="sixteen centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Equipamento
	</h3>
	<table class="ui teal selectable stackable table">

		<tr>
			<td>Nome</td>
			<td><?php echo $equipamento->nome; ?></td>
		</tr>
		<tr>
			<td>Tombo</td>
			<td><?php echo $equipamento->tombo; ?></td>
		</tr>		
		<tr>
			<td>Status</td>
			<td><?php echo $equipamento->status; ?></td>
		</tr>
		<tr>
			<td>Local</td>
			<td><?php echo $equipamento->locals[0]->nome; ?></td>
		</tr>
		<tr>
			<td>Tipo</td>
			<td><?php echo $equipamento->tipo_equipamentos[0]->nome; ?></td>
		</tr>
		<tr>
			<td>Modelo</td>
			<td><?php echo $equipamento->modelo; ?></td>
		</tr>
		<tr>
			<td>Fornecedor</td>
			<td><?php echo $equipamento->fornecedor; ?></td>
		</tr>
		<tr>
			<td>Responsável</td>
			<td><?php echo $equipamento->responsavel; ?></td>
		</tr>
	
	</table>
</div>

<?php if(!is_null($alerta)): ?>
<div class="sixteen centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Último Alerta
	</h3>
	<table class="ui table yellow selectable stackable center aligned">
		
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('geradoPor', 'Gerado Por', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('tomboEquipamento', 'Tombo do Equipamento', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('statusAlerta', 'Status do Alerta', ['direction' => 'desc']); ?></th>				
				<th><?php echo $this->Paginator->sort('dataAlerta', 'Data de Envio', ['direction' => 'desc']); ?></th>
				<th></th>
			</tr>
		</thead>
			
		<tbody>
			
			<tr class="<?php (!strcmp($alerta->statusAlerta, 'Resolvido')) ? print 'positive' : print 'negative'; ?>">
				<td><?php echo $alerta->geradoPor; ?></td>
				<td><?php echo $alerta->tomboEquipamento; ?></td>
				<td><?php echo $alerta->statusAlerta; ?></td>
				<td><?php echo date('d/m/Y g:i A', strtotime($alerta->dataAlerta)); ?></td>
				<td data-id="<?php echo $alerta->id; ?>">
					<button class="ui teal button mini labeled icon btnVerAlerta"><i class="unhide icon"></i>Ler</button>
				</td>
			</tr>
			
		</tbody>
	</table>
</div>
<?php endif; ?>