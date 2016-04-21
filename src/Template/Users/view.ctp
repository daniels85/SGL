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
			<td>E-mail</td>
			<td><?php echo $user->email; ?></td>
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
		
		<?php if(!strcmp($this->request->session()->read('Auth.User.matricula'), $user->matricula)): ?>
		<tfoot class="full-width">
			<tr>
				<th colspan="2" data-id="<?php echo $user->id; ?>">
					<button class="ui button teal tiny right floated labeled icon btnMudarSenha"><i class="setting icon"></i>Alterar senha</button>
					<button class="ui button teal tiny right floated labeled icon btnMudarEmail"><i class="setting icon"></i>Alterar E-mail</button>
				</th>
			</tr>
		</tfoot>
		<?php endif; ?>
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
				<tr class="<?php (!strcmp($alerta->statusAlerta, 'Resolvido')) ? print 'positive' : print 'negative'; ?>">
					<td><?php echo $alerta->geradoPor; ?></td>
					<td><?php echo $alerta->tomboEquipamento; ?></td>
					<td><?php echo $alerta->statusAlerta; ?></td>
					<td><?php echo date('d/m/Y g:i A', strtotime($alerta->dataAlerta)); ?></td>
					<td data-id="<?php echo $alerta->id; ?>">
						<button class="ui teal button mini labeled icon btnVerAlerta"><i class="unhide icon"></i>Ler</button>
						<button class="ui red button mini labeled icon btnApagarAlerta <?php if($alerta->statusAlerta === 'Pedente') print 'disabled'; ?>"><i class="delete icon"></i>Apagar</button>
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