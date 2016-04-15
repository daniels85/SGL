<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="user icon"></i>
		Usuário
	</h4>
	<table class="ui teal selectable stackable table">

		<tr>
			<td>Nome</td>
			<td><?php echo $user->nome; ?></td>
		</tr>
		<tr>
			<td>Matricula</td>
			<td><?php echo $user->matricula; ?></td>
		</tr>
		<tr>
			<td>Função</td>
			<td><?php echo $user->role; ?></td>
		</tr>
		<tr>
			<td>Cadastrado por</td>
			<td><?php echo $user->cadastradoPor; ?></td>
		</tr>
		<tr>
			<td>Data de Cadastro</td>
			<td><?php echo date('d/m/Y H:i', strtotime($user->dataDeCadastro)); ?></td>
		</tr>
		<tr>
			<td>Última ativo</td>
			<td><?php echo date('d/m/Y H:i', strtotime($user->ultimaVezAtivo)); ?></td>
		</tr>

	</table>
</div>

<?php 
	if(!empty($alertas)):
		$matricula = $alertas[0]->bolsistas_alerta->matricula_bolsista;
		if($this->request->session()->read('Auth.User.matricula') == $matricula):
?>
<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Alertas
	</h4>
	<table class="ui table yellow selectable stackable center aligned">
		
		<thead>
			<tr>
				<th>Descrição</th>
				<th>Gerado por</th>
				<th>Tombo de Equipamento</th>
				<th>Status do Alerta</th>				
				<th>Data de Envio</th>
				<th></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($alertas as $alerta): ?>
				<tr>
					<td><?php echo $alerta->descricao; ?></td>
					<td><?php echo $alerta->geradoPor; ?></td>
					<td><?php echo $alerta->tomboEquipamento; ?></td>
					<td><?php echo $alerta->statusAlerta; ?></td>
					<td><?php echo date('d/m/Y g:i A', strtotime($alerta->dataAlerta)); ?></td>
					<td>
						<div class="ui floating dropdown icon button">
							<i class="setting icon"></i>
						    Opções
						    <div class="menu">
						      <div class="item"><i class="unhide icon"></i>Ver</div>
						      <div class="item"><i class="delete icon"></i>Excluir</div>
						    </div>
						</div>
					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>
</div>	

<?php 
		endif;
	endif;

?>

