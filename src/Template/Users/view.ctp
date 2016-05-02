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
			<td><?php (!is_null($user->ultimaVezAtivo)) ? print date('d/m/Y H:i', strtotime($user->ultimaVezAtivo)) : print 'Nunca ativo'; ?></td>
		</tr>
	</table>
</div>
<?php if(!strcmp($this->request->session()->read('Auth.User.matricula'), $user->matricula)): ?>
<div class="sixteen centered wide column row" data-matricula="<?php echo $user->matricula; ?>">
	<button class="ui button teal small right floated labeled icon btnMudarSenha"><i class="setting icon"></i>Alterar senha</button>
	<button class="ui button teal small right floated labeled icon btnMudarEmail"><i class="setting icon"></i>Alterar E-mail</button>
</div>
<?php endif; ?>

<?php 
	if(!empty($alertas->toArray())):
		$matricula = $alertas->toArray()[0]->bolsistas_alerta->matricula_bolsista;
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
				<th><?php echo $this->Paginator->sort('geradoPor', 'Gerado Por', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('tomboEquipamento', 'Tombo do Equipamento', ['direction' => 'desc']); ?></th>
				<th><?php echo $this->Paginator->sort('statusAlerta', 'Status do Alerta', ['direction' => 'desc']); ?></th>				
				<th><?php echo $this->Paginator->sort('dataAlerta', 'Data de Envio', ['direction' => 'desc']); ?></th>
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
						<!--<button class="ui red button mini labeled icon btnApagarAlerta <?php if($alerta->statusAlerta === 'Pedente') print 'disabled'; ?>"><i class="delete icon"></i>Apagar</button> -->
					</td>

				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="right aligned">
			<tr>
				<th colspan="5">

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

<?php 
		endif;
	endif;

?>