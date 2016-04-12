<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TipoEquipamentos Controller
 *
 * @property \App\Model\Table\TipoEquipamentosTable $TipoEquipamentos
 */
class TipoEquipamentosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tipoEquipamentos = $this->paginate($this->TipoEquipamentos);

        $this->set(compact('tipoEquipamentos'));
        $this->set('_serialize', ['tipoEquipamentos']);
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Equipamento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoEquipamento = $this->TipoEquipamentos->get($id, [
            'contain' => []
        ]);

        $this->set('tipoEquipamento', $tipoEquipamento);
        $this->set('_serialize', ['tipoEquipamento']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoEquipamento = $this->TipoEquipamentos->newEntity();
        if ($this->request->is('post')) {
            $tipoEquipamento = $this->TipoEquipamentos->patchEntity($tipoEquipamento, $this->request->data);
            if ($this->TipoEquipamentos->save($tipoEquipamento)) {
                $this->Flash->success(__('The tipo equipamento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tipo equipamento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('tipoEquipamento'));
        $this->set('_serialize', ['tipoEquipamento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Equipamento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoEquipamento = $this->TipoEquipamentos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoEquipamento = $this->TipoEquipamentos->patchEntity($tipoEquipamento, $this->request->data);
            if ($this->TipoEquipamentos->save($tipoEquipamento)) {
                $this->Flash->success(__('The tipo equipamento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The tipo equipamento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('tipoEquipamento'));
        $this->set('_serialize', ['tipoEquipamento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Equipamento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tipoEquipamento = $this->TipoEquipamentos->get($id);
        if ($this->TipoEquipamentos->delete($tipoEquipamento)) {
            $this->Flash->success(__('The tipo equipamento has been deleted.'));
        } else {
            $this->Flash->error(__('The tipo equipamento could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user){
        return true;
    }   
}
