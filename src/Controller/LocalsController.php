<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

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

        if(!(UsersController::isCoordenador($userAuth, $local->codigo) || !strcmp($userAuth['role'], 'Administrador'))){
            
                return $this->redirect($this->Auth->redirectUrl());
            
        }

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
     * @param $codigoLocal Local codigo
     * @return ...
     */
    public function relatorio($codigoLocal = null){

        if($this->request->is('post')){

            $this->viewBuilder()->layout('localPdf');

            //$dataInicio = date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ));
            //$dataFim    = date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ));

            $local = $this->Locals
                                ->find()
                                ->where(['codigo' => $codigoLocal])
                                ->first();

            $equipamentos = $this->Locals->Equipamentos
                                                ->find()
                                                ->where(['codLocal' => $codigoLocal])
                                                ->contain([
                                                    'Alertas' => function($q){
                                                        return $q
                                                                //->where(['statusAlerta' => 'Pendente']);
                                                                ->where(['dataAlerta >' => date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ))])
                                                                ->andWhere(['dataAlerta <' => date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ))]);
                                                    }
                                                ])
                                                ->all()
                                                ->toArray();

            $this->set('local', $local);
            $this->set('equipamentos', $equipamentos);
        }
        
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
            if (isset($user['role']) && $user['role'] === 'Professor' || $user['role'] === 'Administrador') {
                return true;
            }
            return false;
        }

        if($this->request->action === 'relatorio'){
            if (isset($user['role']) && $user['role'] === 'Professor' || $user['role'] === 'Administrador') {
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