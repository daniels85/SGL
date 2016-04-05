<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Alertas Controller
 *
 * @property \App\Model\Table\AlertasTable $Alertas
 */
class AlertasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $alertas = $this->paginate($this->Alertas);

        $this->set(compact('alertas'));
        $this->set('_serialize', ['alertas']);
    }

    /**
     * View method
     *
     * @param string|null $id Alerta id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alerta = $this->Alertas->get($id, [
            'contain' => []
        ]);

        $this->set('alerta', $alerta);
        $this->set('_serialize', ['alerta']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alerta = $this->Alertas->newEntity();
        if ($this->request->is('post')) {
            $alerta = $this->Alertas->patchEntity($alerta, $this->request->data);
            if ($this->Alertas->save($alerta)) {
                $this->Flash->success(__('The alerta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The alerta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('alerta'));
        $this->set('_serialize', ['alerta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Alerta id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alerta = $this->Alertas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alerta = $this->Alertas->patchEntity($alerta, $this->request->data);
            if ($this->Alertas->save($alerta)) {
                $this->Flash->success(__('The alerta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The alerta could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('alerta'));
        $this->set('_serialize', ['alerta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Alerta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alerta = $this->Alertas->get($id);
        if ($this->Alertas->delete($alerta)) {
            $this->Flash->success(__('The alerta has been deleted.'));
        } else {
            $this->Flash->error(__('The alerta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
