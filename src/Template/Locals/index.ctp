<?php 
	use App\Controller\UsersController;
?>
<div class="sixten centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="building outline icon"></i>
		Laboratórios
	</h4>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr >
				<th class="four wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
				<th class="four wide"><?php echo $this->Paginator->sort('codigo', 'Código', ['direction' => 'desc']); ?></th>
				<th class="four wide"><?php echo $this->Paginator->sort('tipo', null, ['direction' => 'desc']); ?></th>
				<th class="four wide"></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($locals as $local): ?>
				<tr>
					<td><?= ($local->nome) ?></td>
					<td><?= ($local->codigo) ?></td>
					<td><?= ($local->tipo) ?></td>

					<?php if(is_null($this->request->session()->read('Auth.User.role')) || $this->request->session()->read('Auth.User.role') !== 'Administrador'): ?>
						<td class="left aligned">
					<?php else: ?>
						<td class="center aligned">
					<?php endif; ?>

						<!-- OPÇÃO DE VER PARA QUALQUER USUÁRIO QUE NÃO ESTEJA LOGADO -->
						<?php if(is_null($this->request->session()->read('Auth.User.role')) || $this->request->session()->read('Auth.User.role') !== 'Administrador'): ?>
							
							<a class="ui button teal mini labeled icon" href="/Locals/view/<?php echo $local->codigo; ?>"><i class="unhide icon"></i>Ver</a>

						<?php endif; ?>

						<!-- OPÇÃO DE ALTERAR BOLSISTA SE FOR RESPONSÁVEL PELO LOCAL -->
						<?php if(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Professor') && UsersController::isCoordenador($this->request->session()->read('Auth.User'), $local->codigo)): ?>

							<a class="ui button orange mini labeled icon" href="/Locals/bolsista/<?php echo $local->codigo; ?>"><i class="edit icon"></i>Alterar Bolsistas</a>

						<!-- DEMAIS OPÇÃES SE FOR ADMINISTRADOR -->
						<?php elseif(!is_null($this->request->session()->read('Auth.User.id')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>

							<div class="ui floating dropdown icon button">

								<i class="setting icon"></i>
							    Opções
							    <div class="menu" data-codigo="<?php echo $local->codigo ?>">

									<a href="/locals/view/<?php echo $local->codigo ?>" class="item"><i class="unhide icon"></i>Ver</a>
									<a href="/Locals/bolsista/<?php echo $local->codigo; ?>"  class="item"><i class="edit icon"></i>Alterar Bolsistas</a>
									<a href="/locals/edit/<?php echo $local->codigo ?>" class="item"><i class="edit icon"></i>Modificar</a>
									<a class="item apagarLocal"><i class="remove icon"></i>Deletar</a>									

							    </div>

							</div>

						<?php endif; ?>

					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="right aligned">
			<tr>
				<th colspan="4">

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

<?php if(!is_null($this->request->session()->read('Auth.User.username')) && !strcmp($this->request->session()->read('Auth.User.role'), 'Administrador') ): ?>
<div class="sixten wide column row">
	<a class="ui button teal labeled icon" href="/Locals/add"><i class="add icon"></i>Adicionar Local</a>
</div>
<?php endif; ?>