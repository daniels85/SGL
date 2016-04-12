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

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
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
        $coordenadores = $this->getCoordenadores($local->codigo);
        
        /** Bolsistas **/
        $bolsistas = $this->getBolistas($local->codigo);
        
        /** Equipamentos **/
        $equipamentos = $this->getEquipamentos($local->codigo);

        $this->set('equipamentos', $equipamentos);
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
        $userLocalsTable = TableRegistry::get('UserLocals');

        if ($this->request->is('post')) {

            $local = $this->Locals->patchEntity($local, $this->request->data);         

            if ($this->Locals->save($local)) {
                
                $matriculasForm = array_unique(array_merge( $this->request->data['bolsistas'], $this->request->data['coordenadores'] ) );
                
                foreach ($matriculasForm as $user) {
                    $this->insereUserLocals( $local->codigo, $user);
                }

                $this->Flash->success(__('Local salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('Erro ao cadastrar local. Tente novamente.'));
            }
        }

        $professores = $this->Locals->Users->find('all', ['conditions' => ['role' => 'Professor']]);
        $bolsistas = $this->Locals->Users->find('all', ['conditions' => ['role' => 'Bolsista']]);
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

        $usersTable = TableRegistry::get('Users');
        $userLocalsTable = TableRegistry::get('UserLocals');
        $codigo = $local->codigo;

        /** Coordenadores e Bolsistas **/
        $usersLocal = $this->getUsersLocals($local->codigo);

        /** Matriculas **/
        $matriculas = $this->getMatriculaUsers($local->codigo);
        
        if(!empty($matriculas)){

            /** Bolsistas **/
            $userLocalsBolsistas = $this->getBolistas($local->codigo);

            /** Coordenadores **/
            $userLocalsCoordenadores = $this->getCoordenadores($local->codigo);
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
                    $this->insereUserLocals( $this->request->data['codigo'], $user);
                }

                /** Deleta do tabela os que foram removidos **/
                foreach($usersLocal as $key => $user){
                    if(!in_array($user->user_matricula, $matriculasForm)){
                        $this->deleteUserLocals($user->id);
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

    /**
     * getUsersLocals method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array composto por user_matricula da tabela UserLocals.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getUsersLocals($codigoLocal){

        $userLocalsTable = TableRegistry::get('UserLocals');
        $usersLocal = $userLocalsTable
                            ->find()
                            ->select(['id', 'user_matricula'])
                            ->where(['local_codigo' => $codigoLocal])
                            ->all()
                            ->toArray();

        return $usersLocal;
    }

    /**
     * getMatriculaUsers method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array com matricula de todos os usuarios relacionados ao local
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getMatriculaUsers($codigoLocal){

        $usersLocal = $this->getUsersLocals($codigoLocal);

        $matriculas = array('');

        foreach($usersLocal as $userLocal){
            $matriculas[] = $userLocal->user_matricula;
        }

        return $matriculas;
    }

    /**
     * getCoordenadores method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array com todos os Coordenadores associados ao local.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getCoordenadores($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = $this->getMatriculaUsers($codigoLocal);

        $coordenadores = $usersTable
                            ->find()
                            ->select(['nome', 'matricula'])
                            ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Professor'])
                            ->all()
                            ->toArray();

        return $coordenadores;
    }

    /**
     * getBolistas method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array com todos os Bolsistas associados ao local.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getBolistas($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = $this->getMatriculaUsers($codigoLocal);

        $bolsistas = $usersTable
                        ->find()
                        ->select(['nome', 'matricula'])
                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                        ->all()
                        ->toArray();

        return $bolsistas;
    }

    /**
     * insereUserLocals method
     *
     * @param string|null $codigo Local codigo e matricula User matricula.
     * @return True ou False.
     */
    public function insereUserLocals($codigo, $matricula){
        $userLocalsTable = TableRegistry::get('UserLocals');
        $entity = $userLocalsTable->newEntity();
        $entity->local_codigo = $codigo;
        $entity->user_matricula = $matricula;

        if($userLocalsTable->save($entity)){
            return true;
        }
        return false;
    }

    /**
     * atualizaUserLocals method
     *
     * @param $id UserLocals id e $codigo Local codigo.
     * @return True ou False.
     */
    public function atualizaUserLocals($id, $codigo){
        $userLocalsTable = TableRegistry::get('UserLocals');
        $entity = $userLocalsTable->get($id);
        $entity->local_codigo = $codigo;

        if($userLocalsTable->save($entity)){
            return true;
        }
        return false;
    }

    /**
     * deleteUserLocals method
     *
     * @param $id UserLocals id.
     * @return True ou False.
     */
    public function deleteUserLocals($id){
        $userLocalsTable = TableRegistry::get('UserLocals');
        $entity = $userLocalsTable->get($id);

        if($userLocalsTable->delete($entity)){
            return true;
        }
        return false;
    }

    public function isAuthorized($user){
        return true;
    } 

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if(in_array($this->request->action, ['edit', 'add', 'delete'])){
            $this->eventManager()->off($this->Csrf);
        }
    }

}    