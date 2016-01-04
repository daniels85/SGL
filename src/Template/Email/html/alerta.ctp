<div style="padding: 10px; margin: 0 auto; width: 65%;">
		
	<h3 style="font-family:verdana;">Olá <?php echo $nome; ?>,</h3>

	<h3 style="font-family:verdana;">Há um novo alerta para o <?php echo $equipamento->local->nome; ?>.</h3>
	
	<h4 style="font-family:verdana;">Dados do Equipamento:</h4>
	
	<t style="font-size: 14pt; font-family:courier;">Nome:</t> <t style="font-size: 13pt; font-family:courier;"><?php echo $equipamento->nome; ?></t>
	<br>
	<t style="font-size: 14pt; font-family:courier;">Tombo:</t> <t style="font-size: 13pt; font-family:courier;"><?php echo $equipamento->tombo; ?></t>
	<br>

	<h4 style="font-family:verdana;">Dados do Alerta:</h4>

	<t style="font-size: 14pt; font-family:courier;">Data:</t> <t style="font-size: 13pt; font-family:courier;"><?php echo date('d/m/Y H:i', strtotime($alerta->dataAlerta)); ?></t>
	<br>
	<t style="font-size: 14pt; font-family:courier;">Gerado por:</t> <t style="font-size: 13pt; font-family:courier;"><?php echo $alerta->geradoPor; ?></t>
	<br>
	<t style="font-size: 14pt; font-family:courier;">Descrição:</t> <t style="font-size: 13pt; font-family:courier;"><?php echo $alerta->descricao; ?></t>
	<br>
	<br>
	<hr>
	<br>
	<t style="font-size: 8pt; font-family:courier;">Por favor não responda essa mensagem. Esse é um e-mail automático.</t>
	
</div>