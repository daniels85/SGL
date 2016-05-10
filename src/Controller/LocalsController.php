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

        
        
        if(!is_null($this->request->session()->read('Auth.User.role')) && $this->request->session()->read('Auth.User.role') === 'Administrador'){
            $locals = $this->paginate($this->Locals);
        }else{
            $locals = $this->Locals
                                ->find()
                                ->where(['tipo !=' => 'Almoxarifado']);

            $locals = $this->paginate($locals);
        }

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


        if(is_null($local)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);            
        }
        

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
     * moverEquipamentos method
     * 
     * @param string|null $codigo Local codigo.
     */
    public function moverEquipamentos($codigo = null){
        
        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        $locals = $this->Locals
                            ->find()
                            ->select(['nome', 'codigo'])
                            ->all()
                            ->toArray();

        /** Equipamentos **/
        $equipamentos = $this->Locals->Equipamentos
                                            ->find()
                                            ->where(['codLocal' => $local->codigo])
                                            ->contain(['TipoEquipamentos']);

        $this->set('local', $local);
        $this->set('locals', $locals);
        $this->set('equipamentos', $equipamentos);

        if($this->request->is('post')){

            if(isset($this->request->data['equipamentos'])){

                $equipamentos   = $this->request->data['equipamentos'];
                $novoLocal      = $this->request->data['local']; 
                
                $query = $this->Locals->Equipamentos
                                                ->find()
                                                ->update()
                                                ->set(['codLocal' => $novoLocal])
                                                ->where(['tombo IN' => $equipamentos]);

                if($query->execute()){
                    $this->Flash->success(__('Equipamentos movidos com sucesso.'));
                }else {
                    $this->Flash->error(__('Ops! Ocorreu um erro ao mover.'));
                }

            }else{
                $this->Flash->error(__('Nenhum equipamento foi selecionado!'));
            }            
            
        }

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

                $this->Flash->success(__('Local cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao cadastrar.'));
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

        if(is_null($local)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1); 
        }

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

                $this->Flash->success(__('Local modificado com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao modifcar o local.'));
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

        $this->request->allowMethod(['ajax']);

        //$local = $this->Locals->get($id);

        $local = $this->Locals
                            ->find()
                            ->where(['codigo' => $codigo])
                            ->all()
                            ->first();

        if(is_null($local)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);
        }

        if ($this->Locals->delete($local)) {
            $this->Flash->success(__('Local deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Ops! Ocorreu um erro ao deletar o local.'));
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

        if(is_null($local)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);
        }

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
                $this->Flash->error(__('Ops! Ocorreu um erro ao salvar.'));
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

        if($this->request->action === 'moverEquipamentos'){
            if(isset($user['role']) && $user['role'] === 'Administrador'){
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