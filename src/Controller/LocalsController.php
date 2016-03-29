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
    public function view($id = null)
    {
        $local = $this->Locals->get($id, [
            'contain' => []
        ]);

        $userLocalsTable = TableRegistry::get('UserLocals');
        $usersTable = TableRegistry::get('Users');

        $usersLocal = $userLocalsTable->find('all', 
            [
                'conditions' => 
                [
                    'local_codigo' => $local->codigo 
                ] 
            ]
        );

        $coordenadoresQuery = [];

        foreach ($usersLocal as $user) {
            $coordenadoresQuery[] = $usersTable->find('all', ['conditions' => ['role' => 'Professor', 'matricula' => $user->user_matricula]]);
        }

        foreach ($coordenadoresQuery as $query) {
            foreach ($query as $q) {
                $coordenadores[] = $q;
            }
        }

        $bolsistasQuery = [];

        foreach ($usersLocal as $user) {
            $bolsistasQuery[] = $usersTable->find('all', ['conditions' => ['role' => 'Bolsista', 'matricula' => $user->user_matricula]]);
        }

        foreach ($bolsistasQuery as $query) {
            foreach ($query as $q) {
                $bolsistas[] = $q;
            }
        }

        $this->set('local', $local);
        $this->set('coordenadores', $coordenadores);
        $this->set('bolsistas', $bolsistas);
        $this->set('_serialize', ['local', 'coordenadores']);
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
        $userLocalsCoordenador = $userLocalsTable->newEntity();
        $userLocalsBolsista = $userLocalsTable->newEntity();

        if ($this->request->is('post')) {
            $local = $this->Locals->patchEntity($local, $this->request->data);

            $userLocalsCoordenador->local_codigo = $this->request->data['codigo'];
            $userLocalsCoordenador->user_matricula = $this->request->data['coordenador'];

            $userLocalsBolsista->local_codigo = $this->request->data['codigo'];
            $userLocalsBolsista->user_matricula = $this->request->data['bolsista'];

            if ($this->Locals->save($local) && $this->Locals->UserLocals->save($userLocalsBolsista) && $this->Locals->UserLocals->save($userLocalsCoordenador)) {
                $this->Flash->success(__('The local has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The local could not be saved. Please, try again.'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $local = $this->Locals->patchEntity($local, $this->request->data);
            if ($this->Locals->save($local)) {
                $this->Flash->success(__('The local has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The local could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('local'));
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
