<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use tcpdf;
use mypdf;

/**
 * Locals Controller
 *
 * @property \App\Model\Table\LocalsTable $Locals
 */
class LocalsController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Locals.nome' => 'asc',
            'Equipamentos.nome' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {

        $locals = $this->paginate($this->Locals);
        
        //$this->viewBuilder()->template('teste');
        $this->set(compact('locals'));
        $this->set('_serialize', ['locals']);
        
    }

    /**
     * View method
     *
     * @param string|null $codigo Local codigo.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($codigo = null) {

        //$local = $this->Locals->get($id, [
        //    'contain' => []
        //]);

        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        

        /** Coordenador **/
        $coordenadores = UsersController::getCoordenadores($local->codigo);
        
        /** Bolsistas **/
        $bolsistas = UsersController::getBolistas($local->codigo);
        
        /** Equipamentos **/
        $equipamentos = $this->Locals->Equipamentos
                                            ->find()
                                            ->where(['codLocal' => $local->codigo])
                                            ->contain(['TipoEquipamentos']);
                                                
        $this->set('equipamentos', $this->paginate($equipamentos));

        $this->set('local', $local);
        $this->set('coordenadores', $coordenadores);       
        $this->set('bolsistas', $bolsistas);
        $this->set('_serialize', ['local']);

    }

    

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {

        $local = $this->Locals->newEntity();

        if ($this->request->is('post')) {

            $local = $this->Locals->patchEntity($local, $this->request->data);

            if ($this->Locals->save($local)) {               

                $matriculasForm = array_filter(array_unique(array_merge($this->request->data['bolsistas'], $this->request->data['coordenadores'] )));
                
                foreach ($matriculasForm as $user) {
                    UsersController::insereUserLocals( $local->codigo, $user );
                }

                $this->Flash->success(__('Local salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Ocorreu erro ao cadastrar local.'));
            }
        }

        $professores = $this->Locals->Users
                                        ->find('list', [
                                            'keyField' => 'matricula',
                                            'valueField' => 'nome',
                                            'conditions' => ['role' => 'Professor']
                                        ])
                                        ->all()
                                        ->toArray();

        $bolsistas = $this->Locals->Users
                                        ->find('list', [
                                            'keyField' => 'matricula',
                                            'valueField' => 'nome',
                                            'conditions' => ['role' => 'Bolsista']
                                        ])
                                        ->all()
                                        ->toArray();

        $this->set(compact('local', 'professores', 'bolsistas'));
        $this->set('_serialize', ['local']);
    } 

    /**
     * Edit method
     *
     * @param string|null $codigo Local codigo.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($codigo = null) {
        /*
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);
        */

        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        /** Coordenadores e Bolsistas **/
        $usersLocal = UsersController::getUsersLocals($local->codigo);

        /** Matriculas **/
        $matriculas = UsersController::getMatriculaUsers($local->codigo);
        
        if(!empty($matriculas)){

            /** Bolsistas **/
            $userLocalsBolsistas = UsersController::getBolistas($local->codigo);

            /** Coordenadores **/
            $userLocalsCoordenadores = UsersController::getCoordenadores($local->codigo);
        }

        /** Salvar  **/
        if ($this->request->is(['patch', 'post', 'put'])) {

            /** Trata o array de matriculas vindo do formulario **/
            $matriculasForm = array_unique(array_merge( $this->request->data['bolsistas'], $this->request->data['coordenadores'] ) );


            $matriculasForm = array_filter($matriculasForm);
            $matriculaInserir = array_diff($matriculasForm, $matriculas);

            $local = $this->Locals->patchEntity($local, $this->request->data);

            // Salva as outras informalções do local
            if ($this->Locals->save($local)) {    
                
                /** Insere os novos registros **/
                foreach($matriculaInserir as $user){
                    UsersController::insereUserLocals( $this->request->data['codigo'], $user);
                }

                /** Deleta do tabela os que foram removidos **/
                foreach($usersLocal as $key => $user){
                    if(!in_array($user->user_matricula, $matriculasForm)){
                        UsersController::deleteUserLocals($user->id);
                        unset($usersLocal[$key]);
                    }
                }

                /** Atualiza os que se mantem em caso de mudança no codigo do local **/
                //if($this->request->data['codigo'] != $codigo){
                //    foreach ($usersLocal as $user) {
                //        $this->atualizaUserLocals($user->id, $this->request->data['codigo']);
                //    }
                //}

                $this->Flash->success(__('Local salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Ocorreu erro ao modificar o local.'));
            }
        }

        /** VALORES PARA PREENCHER OS INPUTS **/
        $professores = $this->Locals->Users
                                        ->find()
                                        ->select(['nome', 'matricula'])
                                        ->where(['role' => 'Professor'])
                                        ->all()
                                        ->toArray();
        $bolsistas = $this->Locals->Users
                                        ->find()
                                        ->select(['nome', 'matricula'])
                                        ->where(['role' => 'Bolsista'])
                                        ->all()
                                        ->toArray();  

        $this->set(compact('local', 'professores', 'bolsistas', 'userLocalsBolsistas', 'userLocalsCoordenadores'));
        $this->set('_serialize', ['local']);
    }

    /**
     * Delete method
     *
     * @param string|null $codigo Local codigo.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($codigo = null) {

        $this->request->allowMethod(['post', 'delete', 'get']);

        //$local = $this->Locals->get($id);

        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        if ($this->Locals->delete($local)) {
            $this->Flash->success(__('Local deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Ocorreu erro ao deletar local.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * bolsista method
     *
     * @param string|null $codigo Local codigo.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     */
    public function bolsista($codigo = null){
        /**
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);
        **/
        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        $userAuth = $this->request->session()->read('Auth.User');

        /** Bolsistas **/
        $usersLocal = UsersController::getUsersLocalsBolsistas($local->codigo);      

        /** Matriculas **/
        $matriculas = UsersController::getMatriculaUsers($local->codigo);

        if(!empty($matriculas)){

            /** Bolsistas **/
            $userLocalsBolsistas = UsersController::getBolistas($local->codigo);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {

            /** Trata o array de matriculas vindo do formulario **/
            $matriculasForm = array_unique(array_merge($this->request->data['bolsistas']));
            $matriculasForm = array_filter($matriculasForm);

            $matriculaInserir = array_diff($matriculasForm, $matriculas);

            $local = $this->Locals->patchEntity($local, $this->request->data);

            // Salva as outras informalções do local
            if ($this->Locals->save($local)) {    
                
                /** Insere os novos registros **/
                foreach($matriculaInserir as $user){
                    UsersController::insereUserLocals( $local->codigo, $user);
                }

                /** Deleta do tabela os que foram removidos **/
                foreach($usersLocal as $user){
                    if(!in_array($user->user_matricula, $matriculasForm)){
                        UsersController::deleteUserLocals($user->id);
                    }
                }

                $this->Flash->success(__('Bolsistas alterados com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Erro ao alterar bolsista. Tente novamente.'));
            }
        }

        $bolsistas = $this->Locals->Users
                                        ->find()
                                        ->select(['nome', 'matricula'])
                                        ->where(['role' => 'Bolsista'])
                                        ->all()
                                        ->toArray(); 

        $this->set(compact('local', 'bolsistas', 'userLocalsBolsistas', 'usersLocal'));
        $this->set('_serialize', ['local']);
    }

    /**
     * Relatorio method
     *
     * @param string|null $codigoLocal Local codigo
     * @return \Cake\Network\Response -> arquivo pdf | redirect
     */
    public function relatorio($codigoLocal = null){

        if($this->request->is('post')){

            //$this->viewBuilder()->layout('localPdf');

            date_default_timezone_set("America/Fortaleza");

            $dataInicio = date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ));
            $dataFim    = date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ));

            if($dataInicio > $dataFim || $dataInicio > date('Y-m-d H:i:s')){
                $this->Flash->error(__('Período inválido.'));
                return $this->redirect(['action' =>  'relatorio', $codigoLocal]);
            }

            $local = $this->Locals
                                ->find()
                                ->where(['codigo' => $codigoLocal])
                                ->first();

             /** Coordenador **/
            $coordenadores = UsersController::getCoordenadores($local->codigo);
            
            /** Bolsistas **/
            $bolsistas = UsersController::getBolistas($local->codigo);

            $equipamentos = $this->Locals->Equipamentos
                                                ->find()
                                                ->where(['codLocal' => $codigoLocal])
                                                ->order(['nome' => 'ASC'])
                                                ->contain([
                                                    'Locals',
                                                    'TipoEquipamentos',
                                                    'Alertas' => function($q){
                                                        return $q
                                                                //->where(['statusAlerta' => 'Pendente']);
                                                                ->where(['dataAlerta >' => date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ))])
                                                                ->andWhere(['dataAlerta <' => date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ))]);
                                                    }
                                                ])
                                                ->all()
                                                ->toArray();


                                            $this->set('equipamentos', $equipamentos);
            //PdfsController::relatorioLocal($local, $bolsistas, $coordenadores, $equipamentos, $dataInicio, $dataFim);
            $this->gerarRaletorio($local, $bolsistas, $coordenadores, $equipamentos, $dataInicio, $dataFim);
        }
        
    }

    /**
     * gerarRelatorio method
     *
     * @param object $local \Entity\Local
     * @param array $bolsistas \Entity\Users 
     * @param array $coordenadores \Entity\Users 
     * @param array $equipamentos \Entity\Equipamentos
     * @return \Cake\Network\Response -> arquivo pdf 
     */
    public function gerarRaletorio($local, $bolsistas, $coordenadores, $equipamentos, $dataInicio, $dataFim){       

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $dataInicio = date('d-m-Y', strtotime($dataInicio));
        $dataFim    = date('d-m-Y', strtotime($dataFim));
       
        header("Content-type:application/pdf");
        //$this->response->header(['Content-type: application/pdf']);

        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($this->request->session()->read('Auth.User.nome'));
        $pdf->SetTitle('Relatório de Alertas - '.$local->nome);
        $pdf->SetSubject('');
        $imagem = WWW_ROOT.'img/ifce.jpg';
        $header = '
            <table cellspacing="0" cellpadding="0" style="border-bottom: 1px solid black;">
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
                    <td>&nbsp;</td>
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
        <div style="margin: 20px 0 0 0; padding: 0px;">
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
        ';
        
        //Concatenar os equipamentos e alertas

        foreach($equipamentos as $equipamento){

            $html .= '

            <div style="margin: 20px 0 0 0; padding: 5px;">
                <div style="margin: 5px 0 0 0; border-bottom: solid 1px black; padding: 5px;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Equipamento: '.$equipamento->nome.'</td>         
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Tombo: '.$equipamento->tombo.'</td>
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Status: '.$equipamento->status.'</td>
                        </tr>
                        <tr>    
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Tipo: '.$equipamento->tipo_equipamentos[0]->nome.'</td>                                    
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Responsável: '.$equipamento->responsavel.'</td>
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Modelo: '.$equipamento->modelo.'</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; padding: 5px; font-family: arial; width: 33%;">Fornecedor: '.$equipamento->fornecedor.'</td>
                        </tr>
                    </table>
                </div>
                <!--- Alertas -->

                <div style="margin: 5px 0 0 0; padding: 10px;">
               
            ';

            if(empty($equipamento->alertas)){
                $html .= '<div style="font-size: 10pt; text-align: center;"><span>Não há alertas para este equipamento.</span></div>';
            }else{

                foreach($equipamento->alertas as $n => $alerta){
                    $html .= '
                    <table style="padding: 10px;">
                        <thead>
                            <tr>
                                <th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Alerta: '.($n+1).'</th>
                                <th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Enviado por: '.$alerta->geradoPor.'</th>
                                <th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Data: '.date('d/m/Y g:i A', strtotime($alerta->dataAlerta)).'</th>
                                <th style="border-bottom: 1px solid #CCC; border-collapse:initial;">Status: '.$alerta->statusAlerta.'</th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="padding: 10px;">
                                    <div style="font-size: 11pt; font-family: arial; padding: 2px;">Descrição:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;"> '.$alerta->descricao.' </div>
                                </td>
                                <td colspan="2">
                                    <div style="font-size: 11pt; font-family: arial; padding: 2px;">Observações:</div> <div style="font-size: 8pt; font-family: arial; font-style: oblique; padding: 2px;"> '.$alerta->observacoes.' </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>                   
                    
                    <div style="margin-top: 5px; margin-bottom: 5px;"><hr></div>
                    ';

                }

                $html .= '
                         
                    </div>
                    <!-- Fim Alertas -->
                ';

            }

            $html .= '
                </div>
                <!-- Fim Equipamento -->
            ';
        }



        $pdf->writeHTML($html, true, false, true, false, '');


        return $this->response->file(
            $pdf->Output('Relatório de Alertas - '.$local->nome.'.pdf', 'I')
        );

        //$pdf->Output('Relatório de Alertas - '.$local->nome.'.pdf', 'D');
        //return $this->response->download(
        //    $pdf->Output('Relatório de Alertas - '.$local->nome.'.pdf', 'I')
        //);    

    }

    /**
     * getEquipamentos method
     *
     * @param $codigoLocal Local codigo
     * @return array Equipamento $equipamentos
     */
    public function getEquipamentos($codigoLocal){

        $equipamentosTable = TableRegistry::get('Equipamentos');

        $equipamentos = $equipamentosTable
                                    ->find()
                                    ->select(['id', 'nome', 'status', 'tipo', 'tombo'])                                    
                                    ->where(['codLocal' => $codigoLocal])
                                    ->contain(['TipoEquipamentos'])
                                    ->all()
                                    ->toArray();

        return $equipamentos;
    }

    public function isAuthorized($user) {

        if ($this->request->action === 'view') {
            return true;
        }

        if($this->request->action === 'edit'){
            if (isset($user['role']) && $user['role'] === 'Administrador') {
                return true;
            }
            return false;
        }

        if($this->request->action === 'bolsista'){
            $codLocal = $this->request->params['pass']['0'];
            if (isset($user['role']) && UsersController::isCoordenador($user, $codLocal) || $user['role'] === 'Administrador') {
                return true;
            }
            return false;
        }

        if($this->request->action === 'relatorio'){
            $codLocal = $this->request->params['pass']['0'];
            if (isset($user['role']) && UsersController::isCoordenador($user, $codLocal) || $user['role'] === 'Administrador') {
                return true;
            }
            return false;
        }

        return parent::isAuthorized($user);
    } 

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if(in_array($this->request->action, ['edit', 'add', 'delete'])){
            $this->eventManager()->off($this->Csrf);
        }
    }

}    