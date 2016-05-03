<?php 

	require_once('tcpdf.php');

	class MYPDF extends TCPDF {

		public function Header(){
			//$image_file = __DIR__.'/ifce.jpg';
			//$this->Image($image_file, 10, 10, 30, '', 'JPG', '', 'T', false, false, 0, false, false, false);
			//$this->setFont('helvetica', 'B', 12);
			//$this->Cell(0, 0, 'Instituto Federal de Educação, Ciência e Tecnologia do Ceará', 0, false, 'C', 0, '', 0, false, 'R', 'R');
			$headerData = $this->getHeaderData();
			$this->setFont('helvetica', 'B', 8);
			$this->writeHTML($headerData['string']);
		}

		public function Footer() {
	        // Position at 15 mm from bottom
	        $this->SetY(-15);
	        // Set font
	        $this->SetFont('helvetica', 'I', 8);
	        // Page number
	        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    }

	}

?>