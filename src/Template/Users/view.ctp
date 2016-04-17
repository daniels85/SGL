<div class="sixteen centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="user icon"></i>
		Usuário
	</h3>
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
<div class="sixteen centered wide column row">
	<h3 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Alertas
	</h3>
	<table class="ui table yellow selectable stackable center aligned">
		
		<thead>
			<tr>
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
					<td><?php echo $alerta->geradoPor; ?></td>
					<td><?php echo $alerta->tomboEquipamento; ?></td>
					<td><?php echo $alerta->statusAlerta; ?></td>
					<td><?php echo date('d/m/Y g:i A', strtotime($alerta->dataAlerta)); ?></td>
					<td>
						<button class="ui teal button mini btnVerAlerta"><i class="unhide icon"></i>Ler</button>
						<button class="ui red button mini btnApagarAlerta"><i class="delete icon"></i>Apagar</button>
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

<div class="ui modal">
	<i class="close icon"></i>
	<div class="header">Alerta - Tombo: 367276</div>
	<div class="content">					
		<div class="ui raised segment">
			<h4 class="ui header">Descrição:</h4>
			<div class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
			<h4 class="ui header">Eviado por:</h4>
			<div class="description">
				Alguem
			</div>
			<h4 class="ui header">Criado:</h4>
			<div class="description">
				15/04/2016	
			</div>
		</div>
		
	</div>
	<div class="actions">
		<div class="ui button approve positive small"><i class="checkmark icon"></i>Marcar como resolvido</div>
		<div class="ui button negative cancel small">Criar ocorrência</div>
	</div>
</div>