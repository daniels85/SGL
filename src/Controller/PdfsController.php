<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Request;
use mypdf;

/**
 * Pdfs Controller
 *
 */
class PdfsController extends AppController {
	
    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

	/**
     * relatorioLocal method
     *
     * @param object $local \Entity\Local
     * @param array $bolsistas \Entity\Users 
     * @param array $coordenadores \Entity\Users 
     * @param array $equipamentos \Entity\Equipamentos
     * @return \Cake\Network\Response -> arquivo pdf 
     */
	public static function relatorioLocal($local, $bolsistas, $coordenadores, $equipamentos, $dataInicio, $dataFim){

        define('WP_MEMORY_LIMIT', '64M');
        $r = new Request();

		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$dataInicio = date('d-m-Y', strtotime($dataInicio));
        $dataFim    = date('d-m-Y', strtotime($dataFim));
       
        header("Content-type:application/pdf");           

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('teste');
        $pdf->SetTitle('Relatório de Alertas - '.$local->nome);
        $pdf->SetSubject('sadsad');

        $imagem = WWW_ROOT.'img/ifce.jpg';
        $header = '
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td rowspan="5"><img src="'.$imagem.'" width="125"></td>
					<td></td>
				</tr>
				<tr style="text-align: right;">		
					<td>Instituto Federal de Educação, Ciência e Tecnologia do Ceará</td>
				</tr>
				<tr style="text-align: right;">		
					<td>IFCE - Campus Maracanaú</td>
				</tr>
				<tr style="text-align: right;">		
					<td>SGL - Sistema de Gerenciamento de Laboratórios</td>
				</tr>
				<tr style="text-align: right;">		
					<td>555td>
				</tr>
			</table>
		';

        $pdf->setHeaderData($ln='', $lw=0, $ht='', $header, $tc=array(0,0,0), $lc=array(0,0,0));

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
        ';

        foreach($coordenadores as $coordenador){
            $html .= '
                    <tr>
                        <td style="text-align: right; padding: 5px; font-family: arial;">Responsável: </td>
                        <td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">'.$coordenador->nome.'</td>
                    </tr>
                ';
        }

        foreach($bolsistas as $bolsista){
            $html .= '
                    <tr>
                        <td style="text-align: right; padding: 5px; font-family: arial;">Bolsista: </td>
                        <td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">'.$bolsista->nome.'</td>
                    </tr>
                ';
        }
        
        $html .= '
                    <tr>
                        <td style="text-align: right; padding: 5px; font-family: arial;">Período dos alertas: </td>
                        <td style="text-align: left; padding: 5px; font-style: oblique; font-family: arial;">'.$dataInicio.' à '.$dataFim.'</td>
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


        //$pdf->Output('Relatório de Alertas - '.$local->nome.'.pdf', 'D');
        return $r->response->file(
            $pdf->Output('Relatório de Alertas - '.$local->nome.'.pdf', 'I')
        );


	}

}