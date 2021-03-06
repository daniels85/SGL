<?php 
	use App\Controller\UsersController;
	
?>
<div class="sixteen centered wide column row">
	<h4 class="ui horizontal divider header">
		<i class="desktop icon"></i>
		Tipo de tipoEquipamentos
	</h4>
	<table class="ui teal stackable table center aligned">		
		<thead>
			<tr >
				<th class="three wide"><?php echo $this->Paginator->sort('nome', null, ['direction' => 'desc']); ?></th>
				<th class="nine wide"><?php echo $this->Paginator->sort('descricao', 'Descrição', ['direction' => 'desc']); ?></th>
				<th class="four wide"></th>
			</tr>
		</thead>
			
		<tbody>
			<?php foreach($tipoEquipamentos as $tipo): ?>
				<tr>
					<td><?= ($tipo->nome) ?></td>
					<td><?= ($tipo->descricao) ?></td>
					<td class="left aligned" data-id="<?php echo $tipo->id; ?>">
						<a class="ui button orange mini labeled icon" href="/tipoEquipamentos/edit/<?php echo $tipo->id; ?>"><i class="edit icon"></i>Modificar</a>
						<a class="ui button red mini labeled icon btnApagarTipoEquipamento"><i class="remove icon"></i>Deletar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot class="right aligned">
			<tr>
				<th colspan="3">

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
<div class="sixteen wide column row">
	<a class="ui button teal labeled icon" href="/tipoEquipamentos/add"><i class="add icon"></i>Adicionar Tipo de Equipamento</a>
</div>
<?php 
	endif; 



?>