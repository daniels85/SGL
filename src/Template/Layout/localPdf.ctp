<?php 

	$this->response->header([
		'Content-type: application/pdf']);
	header("Content-type:application/pdf");

	$html = '
			<link rel="stylesheet" type="text/css" href="semantic.css" />

			<div class="ui container">

				<h4 class="ui horizontal divider"></h4>

				<div class="ui segment">
					<div class="ui items">
						<div class="item">
							<div class="ui small image right floated">
								
							</div>
							<div class="content">
								<a class="header">Instituto Federal de Educação, Ciência e Tecnologia do Ceará</a>
								<div class="meta">
									<span>Description</span>
								</div>
								<div class="description">
									<p></p>
								</div>
								<div class="extra">
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	';

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('');
	$pdf->SetTitle('Exemplo');
	$pdf->SetSubject('sadsad');

	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/pt.php')) {
	    require_once(dirname(__FILE__).'/lang/pt.php');
	    $pdf->setLanguageArray($l);
	}

	// set font
	$pdf->SetFont('dejavusans', '', 10);

	// add a page
	$pdf->AddPage();

	$html = '
<div style="margin: 20px 0 0 0; border: solid 1px #CCCCCC; padding: 0px;">
	<div style="padding:0; margin: 0 auto;">
		<p style="text-align: center; font-size: 20pt; padding: 0px; font-family: arial;">Relatório de Alertas</p>
		<table style="margin: 0 auto;">
			<tr>
				<td style="text-align: right; padding: 5px; font-family: arial;">Laboratório: </td>
				<td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">'.$local->nome.'</td>
			</tr>
			<tr>
				<td style="text-align: right; padding: 5px; font-family: arial;">Responsável: </td>
				<td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">Fulano</td>
			</tr>
			<tr>
				<td style="text-align: right; padding: 5px; font-family: arial;">Bolsista: </td>
				<td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">Fulano</td>
			</tr>
			<tr>
				<td style="text-align: right; padding: 5px; font-family: arial;">Perido dos alertas: </td>
				<td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">15/15/15 a 15/15/15</td>
			</tr>
		</table>
	</div>

</div>

<div style="margin: 20px 0 0 0; border: solid 1px #CCCCCC; padding: 5px;">
	<div style="margin: 5px 0 0 0; border-bottom: solid 1px #CCCCCC; padding: 5px;">
		<table style="width: 100%;">
			<tr>
				<td style="text-align: center; padding: 5px; font-family: arial; width: 50%;">Equipamento: PC - 01</td>			
				<td style="text-align: center; padding: 5px; font-family: arial; width: 50%;">Tombo: 6516516</td>
			</tr>
		</table>
	</div>

	<div style="margin: 5px 0 0 0; padding: 10px;">
		<table style="padding: 10px;">
	  		<thead>
	  			<tr>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Alerta: 01</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Enviado por: Fulano</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Data: 15/14/6498</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Status: Resolvido</th>
	  			</tr>

	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td colspan="2" style="padding: 10px;">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Descrição:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
		  			<td colspan="2">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Observações:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
	  			</tr>
	  		</tbody>
	  	</table>
	  	<div style="padding: 5px;"><hr></div>
	  	<table style="padding: 10px;">
	  		<thead>
	  			<tr>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Alerta: 01</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Enviado por: Fulano</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Data: 15/14/6498</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Status: Resolvido</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td colspan="2" style="padding: 10px;">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Descrição:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
		  			<td colspan="2">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Observações:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
	  			</tr>
	  		</tbody>
	  	</table>
	  	<div style="padding: 5px;"><hr></div>
	  	<table style="padding: 10px;">
	  		<thead>
	  			<tr>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Alerta: 01</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Enviado por: Fulano</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Data: 15/14/6498</th>
	  				<th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Status: Resolvido</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td colspan="2" style="padding: 10px;">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Descrição:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
		  			<td colspan="2">
			  			<div style="font-size: 12pt; font-family: arial; padding: 2px;">Observações:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			  			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			  			quis nostrud exercitation ullamco.</div>
		  			</td>
	  			</tr>
	  		</tbody>
	  	</table>
	</div>
</div>

	';

	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->Output('example_006.pdf', 'I');

	?>