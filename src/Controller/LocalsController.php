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

        /** Coordenador **/

        $coordenador = $usersTable
                            ->find('all')
                            ->select(['nome', 'matricula', 'role'])
                            ->where(['matricula' => $local->coordenador])
                            ->first();

        
        /** Bolsistas **/

        $usersLocal = $userLocalsTable
                            ->find()
                            ->select(['user_matricula'])
                            ->where(['local_codigo' => $local->codigo])
                            ->all()
                            ->toArray();

        $matBolsistas = array('');

        foreach($usersLocal as $userLocal){
            $matBolsistas[] = $userLocal->user_matricula;
        }

        $bolsistas = $usersTable
                        ->find()
                        ->select(['nome'])
                        ->where(['Users.matricula IN' => $matBolsistas])
                        ->all()
                        ->toArray();

        
        $this->set('local', $local);
        $this->set('coordenador', $coordenador);
       
        $this->set('bolsistas', $bolsistas);
        $this->set('_serialize', ['bolsistas']);

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
        $userLocalsBolsistas = $userLocalsTable->find('all', [
            'conditions' => [
                'local_codigo' => $local->codigo
            ]
        ])->toArray();

        //var_dump($this->request->data);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $local = $this->Locals->patchEntity($local, $this->request->data);
            if ($this->Locals->save($local)) {
                $this->Flash->success(__('The local has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The local could not be saved. Please, try again.'));
            }
        }

        $professores = $this->Locals->Users
                                        ->find()
                                        ->select(['nome', 'matricula', 'role'])
                                        ->where(['role' => 'Professor']);

        $bolsistasQuery = $this->Locals->Users
                                            ->find()
                                            ->select(['nome', 'matricula', 'role'])
                                            ->where(['role' => 'Bolsista']);

    
        $bolsistas = $bolsistasQuery->all()->toArray();

        $this->set(compact('local', 'professores', 'bolsistas', 'userLocalsBolsistas'));
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
        $this->request->allowMethod(['post', 'delete']);
        $local = $this->Locals->get($id);
        if ($this->Locals->delete($local)) {
            $this->Flash->success(__('The local has been deleted.'));
        } else {
            $this->Flash->error(__('The local could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
