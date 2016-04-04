<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Locals Controller
 *
 * @property \App\Model\Table\LocalsTable $Locals
 */
class LocalsController extends AppController
{

    public function initialize(){
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
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

        $local = $this->Locals->get($id, [
            'contain' => []
        ]);

        $userLocalsTable = TableRegistry::get('UserLocals');
        $usersTable = TableRegistry::get('Users');

        /** Matriculas **/
        $matriculas = $this->getMatriculaUsers($local->codigo);

        /** Coordenador **/
        $coordenadores = $usersTable
                            ->find()
                            ->select(['nome'])
                            ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Professor'])
                            ->all()
                            ->toArray();

        
        /** Bolsistas **/
        $bolsistas = $usersTable
                        ->find()
                        ->select(['nome'])
                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                        ->all()
                        ->toArray();

        
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
    public function add()
    {
        $local = $this->Locals->newEntity();
        $userLocalsTable = TableRegistry::get('UserLocals');

        if ($this->request->is('post')) {

            $local = $this->Locals->patchEntity($local, $this->request->data);         

            if ($this->Locals->save($local)) {

                foreach (array_unique($this->request->data['bolsistas']) as $bolsista) {
                    if($bolsista != ''){

                        $userLocalsBolsista = $userLocalsTable->newEntity();
                        $userLocalsBolsista->local_codigo = $this->request->data['codigo'];
                        $userLocalsBolsista->user_matricula = $bolsista;

                        $userLocalsTable->save($userLocalsBolsista);

                    }
                }

                foreach (array_unique($this->request->data['coordenadores']) as $coordenador) {
                    if($coordenador != ''){
                        $userLocalsCoordenador = $userLocalsTable->newEntity();
                        $userLocalsCoordenador->local_codigo = $this->request->data['codigo'];
                        $userLocalsCoordenador->user_matricula = $coordenador;

                        $userLocalsTable->save($userLocalsCoordenador);
                    }
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
    public function edit($id = null)
    {
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);

        $userLocalsTable = TableRegistry::get('UserLocals');
        $usersTable = TableRegistry::get('Users');

        /** Coordenadores e Bolsistas **/
        $usersLocal = $userLocalsTable
                            ->find()
                            ->select(['id', 'user_matricula'])
                            ->where(['local_codigo' => $local->codigo])
                            ->all()
                            ->toArray();

        /** Matriculas **/
        $matriculas = array();

        foreach($usersLocal as $userLocal){
            $matriculas[] = $userLocal->user_matricula;
        }
        
        if(!empty($matriculas)){

            /** Bolsistas **/
            $userLocalsBolsistas = $this->Locals->Users
                                                    ->find()
                                                    ->select(['id', 'nome', 'matricula'])
                                                    ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                                                    ->all()
                                                    ->toArray();

            /** Coordenadores **/
            $userLocalsCoordenadores = $this->Locals->Users
                                                        ->find()
                                                        ->select(['id', 'nome', 'matricula'])
                                                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Professor'])
                                                        ->all()
                                                        ->toArray();

        }


        /** Salvar  **/
        if ($this->request->is(['patch', 'post', 'put'])) {

            //var_dump($this->request->data);
            $matriculasForm = array_unique(array_merge( $this->request->data['bolsistas'], $this->request->data['coordenadores'] ) );
            $matriculasForm = array_filter($matriculasForm);

            $matriculaInserir = array_diff($matriculasForm, $matriculas);

            foreach($matriculaInserir as $user){
                $addUser = $userLocalsTable->newEntity();
                $addUser->local_codigo = $this->request->data['codigo'];
                $addUser->user_matricula = $user;
                $userLocalsTable->save($addUser);
            }
            
            /** Apagar do tabela os que foram removidos **/
            foreach($usersLocal as $user){
                if(!in_array($user->user_matricula, $matriculasForm)){
                    $entity = $userLocalsTable->get($user->id);
                    $userLocalsTable->delete($entity);
                }
            }

            $local = $this->Locals->patchEntity($local, $this->request->data);

            // Salva as outras informalções do local
            if ($this->Locals->save($local)) {

                

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
    public function delete($id = null)
    {
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
     * getMatriculaUsers method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array com matricula de todos os usuarios relacionados ao local
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getMatriculaUsers($codigoLocal){

        $userLocalsTable = TableRegistry::get('UserLocals');

        $usersLocal = $userLocalsTable
                            ->find()
                            ->select(['user_matricula'])
                            ->where(['local_codigo' => $codigoLocal])
                            ->all()
                            ->toArray();

        $matriculas = array('');

        foreach($usersLocal as $userLocal){
            $matriculas[] = $userLocal->user_matricula;
        }

        return $matriculas;
    }

}    