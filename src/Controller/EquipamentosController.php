<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Equipamentos Controller
 *
 * @property \App\Model\Table\EquipamentosTable $Equipamentos
 */
class EquipamentosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $equipamentos = $this->paginate($this->Equipamentos);

        $this->set(compact('equipamentos'));
        $this->set('_serialize', ['equipamentos']);
    }

    /**
     * View method
     *
     * @param string|null $id Equipamento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipamento = $this->Equipamentos->get($id, [
            'contain' => []
        ]);

        $session = $this->request->session()->read('Auth.User.nome');
        //$session = array(
        //        'nome' => $this->request->session()->read('Auth.User.nome'), 
        //        'matricula' => $this->request->session()->read('Auth.User.matricula')
        //    );

        $this->set('equipamento', $equipamento);
        $this->set('session', $session);
        $this->set('_serialize', ['equipamento', 'session']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipamento = $this->Equipamentos->newEntity();
        if ($this->request->is('post')){
            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);
            if ($this->Equipamentos->save($equipamento)) {
                $this->Flash->success(__('The equipamento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The equipamento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('equipamento'));
        $this->set('_serialize', ['equipamento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipamento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipamento = $this->Equipamentos->get($id, [
            'contain' => []
        ]);
        $tipoEquipamentos = $this->Equipamentos->TipoEquipamentos
                                                            ->find()
                                                            ->select(['id', 'nome'])
                                                            ->all()
                                                            ->toArray();

        $locals = $this->Equipamentos->Locals
                                                            ->find()
                                                            ->select(['nome', 'codigo'])
                                                            ->all()
                                                            ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);
            $equipamento->dataDeCompra = date('Y-m-d', strtotime($this->request->data['dataDeCompra']));

            if ($this->Equipamentos->save($equipamento)) {
                echo 'Editado';
            } else {
                echo 'Erro';
            }
        }
        $this->set(compact('equipamento'));
        $this->set(compact('tipoEquipamentos'));
        $this->set(compact('locals'));
        $this->set('_serialize', ['equipamento', 'tipoEquipamentos', 'locals']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipamento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipamento = $this->Equipamentos->get($id);
        if ($this->Equipamentos->delete($equipamento)) {
            $this->Flash->success(__('The equipamento has been deleted.'));
        } else {
            $this->Flash->error(__('The equipamento could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function cadastrar(){

        $equipamento = $this->Equipamentos->newEntity();

        $tipoEquipamentos = $this->Equipamentos->TipoEquipamentos
                                                            ->find()
                                                            ->select(['id', 'nome'])
                                                            ->all()
                                                            ->toArray();


        if($this->request->is('put')){
            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);
            
            if ($this->Equipamentos->save($equipamento)) {
                echo 'Cadastrado';
            } else {
                echo 'Erro ao cadastrar';
            }
        }

        $this->set(compact('tipoEquipamentos'));
        $this->set('_serialize', ['tipoEquipamentos']);
    }

    public function isAuthorized($user){
        return true;
    }   

}
