<div class="sixteen centered wide column row">
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
	<h4 class="ui horizontal divider header">
		<i class="warning sign icon"></i>
		Alertas
	</h4>
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
				<tr class="<?php (!strcmp($alerta->statusAlerta, 'Pendente')) ? print 'negative' : print 'positive'; ?>">
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

<?php if(!empty($user->equipamentos)): ?>
		<div class="sixteen centered wide column row">
			
			<div class="ui fluid accordion">

				<div class="title">
					<h4 class="ui horizontal divider header">
						<i class="desktop icon"></i>
						Equipamentos						
					</h4>
				</div>

				<div class="content">
					<div id="listar-equipamentos">
						<table class="ui teal stackable definition table">		
							<thead class="center aligned">
								<tr>
									<th class=""></th>
									<th class=""><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>					
									<th class=""><?php echo $this->Paginator->sort('status', null, ['direction' => 'desc']); ?></th>
									<th class=""><?php echo $this->Paginator->sort('tombo', null, ['direction' => 'desc']); ?></th>
									<th class=""><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
									<th class=""><?php echo $this->Paginator->sort('codLocal', 'Local', ['direction' => 'desc']); ?></th>
									<th class=""></th>
								</tr>
							</thead>
							<tbody class="center aligned">
								<?php foreach($user->equipamentos as $equipamento): 
									if(!strcmp($equipamento->status, "Funcionando")){ echo '<tr class="positive" data-tombo="'.$equipamento->tombo.'" ><td><i class="checkmark green icon"></i></td>'; }
									if(!strcmp($equipamento->status, "Alerta")){ echo '<tr class="warning" data-tombo="'.$equipamento->tombo.'" ><td><i class="warning orange sign icon"></i></td>'; }
									if(!strcmp($equipamento->status, "Defeito")){ echo '<tr class="negative" data-tombo="'.$equipamento->tombo.'" ><td><i class="remove red icon"></i></td>'; }
								?>
										<td><?php echo $equipamento->nome; ?></td>
										<td><?php echo $equipamento->status; ?></td>
										<td><?php echo $equipamento->tombo; ?></td>
										<td><?php echo $equipamento->tipo_equipamento->nome; ?></td>
										<td><?php echo $equipamento->local->nome; ?></td>
										<td>
										    <a class="ui button tiny icon green" href="/equipamentos/view/<?php echo $equipamento->tombo ?>"><i class="unhide icon"></i></a>
										    <button class="ui button icon tiny blue btnEditarEquipamento"><i class="edit icon"></i></button>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
<?php endif; ?>