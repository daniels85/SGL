<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use MYPDF;
use App\Model\Entity\Local;
use App\Model\Entity\Equipamento;
use App\Model\Entity\TipoEquipamento;
use App\Model\Entity\Alerta;
use App\Model\Entity\User;

/**
 * Pdfs Controller
 *
 */
class PdfsController extends AppController {

	public function initialize() {
        parent::initialize();
    }

    public function relatorioLocal($local, $bolsistas, $coordenadores, $equipamentos, $dataInicio, $dataFim){		

    	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		//$this->response->header(['Content-type: application/pdf']);

		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		        
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("SGL");
		$pdf->SetTitle('Relatório de Alertas - '.$local->nome.' - '.date('dmY', strtotime($dataInicio)).' - '.date('dmY', strtotime($dataFim)));
		$pdf->SetSubject('');

		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

		$pdf->relatorioLocal($local, $coordenadores, $bolsistas, $equipamentos, $dataInicio, $dataFim);

		

		return $this->response->file(
            $pdf->Output('Relatório de Alertas - '.$local->nome.' - '.date('dmY', strtotime($dataInicio)).' - '.date('dmY', strtotime($dataFim)).'.pdf', 'I')
        );

    }

    public function relatorioEquipamento(){

    }

    public function gerar(){
    	
    }

}