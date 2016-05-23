<?php 

	require_once('tcpdf.php');

	class MYPDF extends TCPDF {

		public function Header(){
			$image_file = '/webroot/img/ifce.jpg';
			$this->Image($image_file, 10, 10, 25, '', 'JPG', '', 'T', false, false, 0, false, false, false);
			$this->setFont('helvetica', 'B', 9);
			$this->Cell(0, 0, 'Instituto Federal de Educação, Ciência e Tecnologia do Ceará', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Ln();
			$this->Cell(0, 0, 'IFCE - Campus Maracanaú', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Ln();
			$this->Cell(0, 0, 'SGL - Sistema de Gerenciamento de Laboratórios', 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Ln();
			$this->Cell(180, 0, '', 'T');
		}

		public function Footer() {
	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont('helvetica', 'I', 8);
	        // Page number
	        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    }

	    public function relatorioLocal($local, $coordenadores, $bolsistas, $equipamentos, $dataInicio, $dataFim){

	    	$this->SetTextColor(0);
	        $this->SetDrawColor(0);
	        $this->SetLineWidth(0.3);
	        $this->SetFont('', 'B', 16);

	    	$this->Cell(180, 20, "Relatório de Alertas", 0, 0, 'C', 0);
	    	$this->Ln();

	    	$this->SetFont('', '', 10);
	    	$this->Cell(90, 5, "Laboratório:", 0, 0, 'R', 0);
	    	$this->Cell(90, 5, $local->nome, 0, 0, 'L', 0);	
			$this->Ln();
			foreach($coordenadores as $coordenador){
				$this->Cell(90, 5, "Responsável:", 0, 0, 'R', 0);
	    		$this->Cell(90, 5, $coordenador->nome, 0, 0, 'L', 0);
	    		$this->Ln();
			}
			foreach($bolsistas as $bolsista){
				$this->Cell(90, 5, "Bolsista:", 0, 0, 'R', 0);
	    		$this->Cell(90, 5, $bolsista->nome, 0, 0, 'L', 0);
	    		$this->Ln();
			}
	    	$this->Cell(90, 5, "Período dos alertas:", 0, 0, 'R', 0);
	    	$this->Cell(90, 5, date('d/m/Y', strtotime($dataInicio))." à ".date('d/m/Y', strtotime($dataFim)), 0, 0, 'L', 0);	    		

	    	$this->Ln();
	    	$this->Ln();
	    	$this->Ln();
	    	foreach($equipamentos as $num => $equipamento){

	    		$header = "Equipamento ".($num+1);

	    		$this->tabelaEquipamentos($header, $equipamento);

	    	}
	    }


	    public function tabelaEquipamentos($header,$data) {
	        // Colors, line width and bold font
	        $this->SetFillColor(190, 190, 190);
	        $this->SetTextColor(0);
	        $this->SetDrawColor(0);
	        $this->SetLineWidth(0.3);
	        $this->SetFont('', 'B', 12);
	        // Header
	        
	        $this->Cell(180, 7, $header, 1, 0, 'L', 1);
	        
	        $this->Ln();
	        // Color and font restoration
	        $this->SetFillColor(224, 235, 255);
	        $this->SetTextColor(0);
	        $this->SetFont('', 'B', 11);
	        // Data
	        $this->Cell(180, 7, "Informações", 1, 0, 'C', 1);
	        $this->Ln();
	        $this->SetFont('', 'B', 9);
	        $this->Cell( 30, 6, "Nome:", 'LTB', 0, 'L', 0);
	        $this->SetFont('', '', 9);
	        $this->Cell( 30, 6, $data->nome, 'RTB', 0, 'L', 0);
	        $this->SetFont('', 'B', 9);
	        $this->Cell( 30, 6, "Tombo:", 'LTB', 0, 'L', 0);
	        $this->SetFont('', '', 9);
	        $this->Cell( 30, 6, $data->tombo, 'RTB', 0, 'L', 0);
	        $this->SetFont('', 'B', 9);
			$this->Cell( 30, 6, "Status:", 'LTB', 0, 'L', 0);
			$this->SetFont('', '', 9);
	        $this->Cell( 30, 6, $data->status, 'RTB', 0, 'L', 0);
	        $this->SetFont('', 'B', 9);
	        $this->Ln();
	        $this->Cell( 45, 6, "Tipo:", 'LTB', 0, 'L', 0);
			$this->SetFont('', '', 9);
	        $this->Cell( 45, 6, $data->tipo_equipamento->nome, 'RTB', 0, 'L', 0);
	        $this->SetFont('', 'B', 9);
	        $this->Cell( 45, 6, "Status:", 'LTB', 0, 'L', 0);
			$this->SetFont('', '', 9);
	        $this->Cell( 45, 6, $data->modelo, 'RTB', 0, 'L', 0);
	        $this->SetFont('', 'B', 9);
	        $this->Ln();

	        if(!empty($data->alertas)){
	        	$this->SetFillColor(190, 190, 190);
		        $this->SetTextColor(0);
		        $this->SetDrawColor(0);
		        $this->SetLineWidth(0.3);
		        $this->SetFont('', 'B', 11);

	        	$this->Cell(180, 7, "Alertas", 1, 0, 'C', 1);
		        $this->Ln();	        

		        $this->SetFillColor(224, 235, 255);
		        $this->SetTextColor(0);

		        foreach($data->alertas as $key => $alerta){

		        	$num = $key+1;
		        	$this->SetFont('', '', 10);

		        	$this->Cell(180, 7, "Alerta #{$num}", 1, 0, 'L', 1);
		        	$this->Ln();

		        	$this->SetFont('', '', 9);
		        	$this->SetFont('', 'B');
		        	$this->Cell( 35, 6, "Gerado por:", 'LT', 0, 'L', 0);
			        $this->SetFont('');
			        $this->Cell( 35, 6, $alerta->geradoPor, 'RT', 0, 'R', 0);
			        $this->SetFont('', 'B');
			        $this->Cell( 20, 6, "Data:", 'LT', 0, 'L', 0);
			        $this->SetFont('');
			        $this->Cell( 20, 6, date('d/m/Y H:i', strtotime($alerta->dataAlerta)), 'RT', 0, 'R', 0);			        
			        $this->SetFont('', 'B');
			        $this->Cell( 35, 6, "Status:", 'LT', 0, 'L', 0);
			        $this->SetFont('');
			        $this->Cell( 35, 6, $alerta->statusAlerta, 'RT', 0, 'R', 0);
			        $this->Ln();			        

			        $this->SetFont('', 'B');
			        $this->Cell( 180, 6, "Descrição:", 'LRT', 0, 'L', 0);
			        $this->Ln();

			        if($this->GetY() > 260 && $this->getNumLines($alerta->descricao, 180) > 1){
			        	$this->addPage();
			        }

			        $this->SetFont('');
			        $this->MultiCell(180, 6, $alerta->descricao, 'LRB', 'L', 0, 0, '', '', true);
			        $this->Ln();

			        if(!empty($alerta->observacoes)){
				        $this->SetFont('', 'B');
				        $this->Cell( 180, 6, "Observações:", 'LRT', 0, 'L', 0);
				        $this->Ln();

				        if($this->GetY() > 260 && $this->getNumLines($alerta->observacoes, 180) > 1){
				        	$this->addPage();
				        }

				        $this->SetFont('');
				        $this->MultiCell(180, 6, $alerta->observacoes, 'LRB', 'L', 0, 0, '', '', true);
				        $this->Ln();
			        }

		        }

		        $this->Cell(180, 0, '', 'T');
		        $this->Ln();
		        $this->Ln();
	        }else{
		       	$this->Ln();
		    }
	        
	    }

	    public function relatorioEquipamento($equipamento, $dataInicio, $dataFim){

	    	$this->SetTextColor(0);
	        $this->SetDrawColor(0);
	        $this->SetLineWidth(0.3);
	        $this->SetFont('', 'B', 16);
	        $this->SetFillColor(190, 190, 190);

	    	$this->Cell(180, 20, "Relatório de Alertas", 0, 0, 'C', 0);
	    	$this->Ln();

	    	$this->SetFont('', 'B', 12);

	    	$this->Cell(180, 5, "Dados do Equipamento", 'LTBR', 0, 'C', 1);
	    	$this->Ln();
	    	$this->SetFont('', 'B', 9);
	    	$this->Cell(30, 5, "Nome:", 'LTB', 0, 'L', 0);
	    	$this->SetFont('', '', 9);
	    	$this->Cell(30, 5, $equipamento->nome, 'TBR', 0, 'R', 0);
	    	$this->SetFont('', 'B', 9);	
	    	$this->Cell(30, 5, "Tombo:", 'LTB', 0, 'L', 0);
	    	$this->SetFont('', '', 9);
	    	$this->Cell(30, 5, $equipamento->tombo, 'TBR', 0, 'R', 0);
	    	$this->SetFont('', 'B', 9);
	    	$this->Cell(30, 5, "Status:", 'LTB', 0, 'L', 0);
	    	$this->SetFont('', '', 9);
	    	$this->Cell(30, 5, $equipamento->status, 'TBR', 0, 'R', 0);	

			$this->Ln();	
			$this->SetFont('', 'B', 9);
	    	$this->Cell(45, 5, "Local:", 'LTB', 0, 'L', 0);	
	    	$this->SetFont('', '', 9);	    	
	    	$this->Cell(45, 5, $equipamento->local->nome, 'TBR', 0, 'R', 0);
	    	$this->SetFont('', 'B', 9);
			$this->Cell(45, 5, "Responsável:", 'LTB', 0, 'L', 0);	
			$this->SetFont('', '', 9);	    	
	    	$this->Cell(45, 5, $equipamento->user->nome, 'TBR', 0, 'R', 0);		
			
			$this->Ln();

			$this->SetFont('', 'B', 9);
			$this->Cell(30, 5, "Tipo:", 'LTB', 0, 'L', 0);	
			$this->SetFont('', '', 9);	    	
	    	$this->Cell(30, 5, $equipamento->tipo_equipamento->nome, 'TBR', 0, 'R', 0);	
	    	$this->SetFont('', 'B', 9);
	    	$this->Cell(30, 5, "Fornecedor:", 'LTB', 0, 'L', 0);
	    	$this->SetFont('', '', 9);		    	
	    	$this->Cell(30, 5, $equipamento->fornecedor, 'TBR', 0, 'R', 0);	
	    	$this->SetFont('', 'B', 9);
	    	$this->Cell(30, 5, "Modelo:", 'LTB', 0, 'L', 0);	
	    	$this->SetFont('', '', 9);	    	
	    	$this->Cell(30, 5, $equipamento->modelo, 'TBR', 0, 'R', 0);	
			
			$this->Ln();

			$this->SetFont('', 'B', 9);
	    	$this->Cell(90, 5, "Período dos alertas:", 'LTB', 0, 'L', 0);
	    	$this->SetFont('', '', 9);
	    	$this->Cell(90, 5, date('d/m/Y', strtotime($dataInicio))." à ".date('d/m/Y', strtotime($dataFim)), 'TBR', 0, 'L', 0);
	    	$this->Ln();

	    	$this->SetFillColor(224, 235, 255);
		    $this->SetTextColor(0);

	    	if(!empty($equipamento->alertas)){

	    		$this->SetFillColor(190, 190, 190);
		        $this->SetTextColor(0);
		        $this->SetDrawColor(0);
		        $this->SetLineWidth(0.3);
		        $this->SetFont('', 'B', 11);

	        	$this->Cell(180, 7, "Alertas", 1, 0, 'C', 1);
		        $this->Ln();	        

		        $this->SetFillColor(224, 235, 255);
		        $this->SetTextColor(0);

	    		foreach($equipamento->alertas as $num => $alerta){
	    			$header = "Alerta #".($num+1);

	    			$this->tabelaAlertas($header, $alerta);
	    		}
	    	}
	    }

	    public function tabelaAlertas($header, $alerta){

	    	$this->SetFont('', '', 10);

        	$this->Cell(180, 7, $header, 1, 0, 'L', 1);
        	$this->Ln();

        	$this->SetFont('', '', 9);
        	$this->SetFont('', 'B');
        	$this->Cell( 35, 6, "Gerado por:", 'LT', 0, 'L', 0);
	        $this->SetFont('');
	        $this->Cell( 35, 6, $alerta->geradoPor, 'RT', 0, 'R', 0);
	        $this->SetFont('', 'B');
	        $this->Cell( 20, 6, "Data:", 'LT', 0, 'L', 0);
	        $this->SetFont('');
	        $this->Cell( 20, 6, date('d/m/Y H:i', strtotime($alerta->dataAlerta)), 'RT', 0, 'R', 0);			        
	        $this->SetFont('', 'B');
	        $this->Cell( 35, 6, "Status:", 'LT', 0, 'L', 0);
	        $this->SetFont('');
	        $this->Cell( 35, 6, $alerta->statusAlerta, 'RT', 0, 'R', 0);
	        $this->Ln();			        

	        $this->SetFont('', 'B');
	        $this->Cell( 180, 6, "Descrição:", 'LRT', 0, 'L', 0);
	        $this->Ln();

	        if($this->GetY() > 260 && $this->getNumLines($alerta->descricao, 180) > 1){
	        	$this->addPage();
	        }

	        $this->SetFont('');
	        $this->MultiCell(180, 6, $alerta->descricao, 'LRB', 'L', 0, 0, '', '', true);
	        $this->Ln();

	        if(!empty($alerta->observacoes)){
		        $this->SetFont('', 'B');
		        $this->Cell( 180, 6, "Observações:", 'LRT', 0, 'L', 0);
		        $this->Ln();

		        if($this->GetY() > 260 && $this->getNumLines($alerta->observacoes, 180) > 1){
		        	$this->addPage();
		        }

		        $this->SetFont('');
		        $this->MultiCell(180, 6, $alerta->observacoes, 'LRB', 'L', 0, 0, '', '', true);
		        $this->Ln();
	        }

	    }

	}

?>