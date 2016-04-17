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

        

        $this->set(compact('locals'));
        $this->set('_serialize', ['locals']);
    }

    /**
     * View method
     *
     * @param string|null $id Local id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $equipamentosTable = TableRegistry::get('Equipamentos');
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);


        /** Coordenador **/
        $coordenadores = UsersController::getCoordenadores($local->codigo);
        
        /** Bolsistas **/
        $bolsistas = UsersController::getBolistas($local->codigo);
        
        /** Equipamentos **/
        $equipamentos = $this->getEquipamentos($local->codigo);

        $this->set('equipamentos', $this->paginate($equipamentos2 = $this->Locals->Equipamentos
                                                                                            ->find()
                                                                                            ->where(['codLocal' => $local->codigo])
                                                                                            ->contain(['TipoEquipamentos'])
                                                                                            ));

        $this->set('local', $local);
        $this->set('coordenadores', $coordenadores);       
        $this->set('bolsistas', $bolsistas);
        $this->set('_serialize', ['local']);
    }

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
                $this->Flash->error(__('Erro ao cadastrar local. Tente novamente.'));
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
     * @param string|null $id Local id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {

        $local = $this->Locals->get($id, [
            'contain' => []
        ]);

        $codigo = $local->codigo;

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

                $this->Flash->success(__('The local has been saved.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('The local could not be saved. Please, try again.'));
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
     * @param string|null $id Local id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete', 'get']);

        $local = $this->Locals->get($id);

        if ($this->Locals->delete($local)) {
            $this->Flash->success(__('The local has been deleted.'));
        } else {
            $this->Flash->error(__('The local could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function bolsista($id = null){
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);
        
        if(!UsersController::isCoordenador($this->request->session()->read('Auth.User.matricula'), $local->codigo)){
            if(strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')){
                return $this->redirect($this->Auth->redirectUrl());
            }
        }

        $codigo = $local->codigo;

        /** Bolsistas **/
        $usersLocal = UsersController::getUsersLocalsBolsistas($local->codigo);
        
        

        /** Matriculas **/
        $matriculas = UsersController::getUsersLocals($local->codigo);

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

                $this->Flash->success(__('The local has been saved.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('The local could not be saved. Please, try again.'));
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
     * isCoordenador method
     *
     * @param string|null $matricula Users matricula e $codLocal Locals codigo.
     * @return True ou False.
     */
    public static function isCoordenador($matricula, $codigoLocal){
        $matriculas = UsersController::getMatriculaUsers($codigoLocal);
        if(in_array($matricula, $matriculas)){
            return true;
        }
        return false;
    }

    /**
     * isBolsista method
     *
     * @param string|null $matricula Users matricula e $codLocal Locals codigo.
     * @return True ou False.
     */
    public static function isBolsista($matricula, $codigoLocal){
        $matriculas = self::getMatriculaUsers($codigoLocal);
        if(in_array($matricula, $matriculas)){
            return true;
        }
        return false;
    }

    public function isAuthorized($user){       
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

        return parent::isAuthorized($user);
    } 

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if(in_array($this->request->action, ['edit', 'add', 'delete'])){
            $this->eventManager()->off($this->Csrf);
        }
    }

}    