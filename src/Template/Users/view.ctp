<?php 
	echo date('Y/m/d H:i:s');
	echo $this->request->session()->read('Auth.User.id');
?>

<table>

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
		<td><?php echo date('d/m/Y g:i A', strtotime($user->dataDeCadastro)); ?></td>
	</tr>
	<tr>
		<td>Última ativo</td>
		<td><?php echo date('d/m/Y g:i A', strtotime($user->ultimaVezAtivo)); ?></td>
	</tr>

</table>

<?php 
	if(!empty($alertas)):
		$matricula = $alertas[0]->bolsistas_alerta->matricula_bolsista;
		if($this->request->session()->read('Auth.User.matricula') == $matricula):
?>

	<table>
		
		<thead>
			<tr>
				<th>Descrição</th>
				<th>Gerado por</th>
				<th>Tombo de Equipamento</th>
				<th>Status do Alerta</th>				
				<th>Data de Envio</th>
				<th>Actions</th>
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
						<a <?= ('href="/Alertas/view/'.$alerta->id.'"') ?> >Ver</a>
						&nbsp;
						<a <?= ('href="/Alertas/edit/'.$alerta->id.'"') ?> >Editar</a>
						&nbsp;
						<a <?= ('href="/Alertas/delete/'.$alerta->id.'" onclick="if (confirm(&quot;Deseja deletar este Alerta?&quot;)) { return true; } return false;"') ?> >Deletar</a>

					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

<?php 
		endif;
	endif;

?>

