<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

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

        $codLocal = $this->request->data['codLocal'];

        $bolsistas = UsersController::getBolistas($codLocal);

        if ($this->request->is('ajax')) {

            $alerta = $this->Alertas->patchEntity($alerta, $this->request->data);

            if ($this->Alertas->save($alerta)) {

                if(!empty($bolsistas)){
                    foreach ($bolsistas as $bolsista) {
                        $bolsistaAlertas = $this->Alertas->BolsistasAlertas->newEntity();
                        $bolsistaAlertas->alerta_id = $alerta->id;
                        $bolsistaAlertas->matricula_bolsista = $bolsista->matricula;
                        $this->Alertas->BolsistasAlertas->save($bolsistaAlertas);
                    }
                    echo 'Cadastrado';
                }
                else{
                    echo 'Erro';
                }                               
                               
            } else {
                echo 'Erro';
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
                echo 'sucesso';
            } else {
                echo 'erro';
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
            echo 'sucesso';
        } else {
            echo 'erro'; 
        }
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if(in_array($this->request->action, ['edit', 'add', 'delete'])){
            $this->eventManager()->off($this->Csrf);
        }
    }

    
    public function isAuthorized($user){
        return true;
    }   
}
