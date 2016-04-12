<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UserLocals Controller
 *
 * @property \App\Model\Table\UserLocalsTable $UserLocals
 */
class UserLocalsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $userLocals = $this->paginate($this->UserLocals);

        $this->set(compact('userLocals'));
        $this->set('_serialize', ['userLocals']);
    }

    /**
     * View method
     *
     * @param string|null $id User Local id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userLocal = $this->UserLocals->get($id, [
            'contain' => []
        ]);

        $this->set('userLocal', $userLocal);
        $this->set('_serialize', ['userLocal']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userLocal = $this->UserLocals->newEntity();
        if ($this->request->is('post')) {
            $userLocal = $this->UserLocals->patchEntity($userLocal, $this->request->data);
            if ($this->UserLocals->save($userLocal)) {
                $this->Flash->success(__('The user local has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user local could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('userLocal'));
        $this->set('_serialize', ['userLocal']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User Local id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userLocal = $this->UserLocals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userLocal = $this->UserLocals->patchEntity($userLocal, $this->request->data);
            if ($this->UserLocals->save($userLocal)) {
                $this->Flash->success(__('The user local has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user local could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('userLocal'));
        $this->set('_serialize', ['userLocal']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User Local id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userLocal = $this->UserLocals->get($id);
        if ($this->UserLocals->delete($userLocal)) {
            $this->Flash->success(__('The user local has been deleted.'));
        } else {
            $this->Flash->error(__('The user local could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user){
        return false;
    }   
}
