<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\UsersController;
use App\Controller\PdfsController;
use Cake\Event\Event;

/**
 * Equipamentos Controller
 *
 * @property \App\Model\Table\EquipamentosTable $Equipamentos
 */
class EquipamentosController extends AppController
{

    public $paginate = [
        'limit' => 15,
        'order' => [
            'Equipamentos.nome' => 'asc',            
            'Alertas.dataAlerta' => 'desc',
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
    public function index()
    {

        $equipamentos = $this->Equipamentos
                                        ->find('all')
                                        ->contain(['TipoEquipamentos', 'Locals', 'Users']);

        $this->set('equipamentos', $this->paginate($equipamentos));
        $this->set('_serialize', ['equipamentos']);
    }

    /**
     * View method
     *
     * @param string|null $tombo Equipamento tombo.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($tombo = null)
    {
        
        $equipamento = $this->Equipamentos
                                    ->find()
                                    ->where(['tombo' => $tombo])
                                    ->contain(['TipoEquipamentos', 'Locals', 'Users'])
                                    ->first();

        if(is_null($equipamento)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Usuário não encontrado.", 404);
        }

        $alerta = $this->Equipamentos->Alertas
                                            ->find('all')
                                            ->where(['tomboEquipamento' => $equipamento->tombo])
                                            ->last();

        $alertas = $this->Equipamentos->Alertas
                                            ->find('all')
                                            ->where(['tomboEquipamento' => $equipamento->tombo]);

        $session = $this->request->session()->read('Auth.User.nome');
        //$session = array(
        //        'nome' => $this->request->session()->read('Auth.User.nome'), 
        //        'matricula' => $this->request->session()->read('Auth.User.matricula')
        //    );

        $this->set('alerta', $alerta);
        $this->set('alertas', $this->paginate($alertas));
        $this->set('equipamento', $equipamento);
        $this->set('session', $session);
        $this->set('_serialize', ['equipamento', 'session']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {   

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

        $professores = $this->Equipamentos->Users
                                                ->find('list', ['keyField' => 'matricula', 'valueField' => 'nome'])
                                                ->select(['nome', 'matricula'])
                                                ->where(['role' => 'Professor'])
                                                ->all()
                                                ->toArray();

        
        if ($this->request->is('post')){

            $equipamento = $this->Equipamentos->newEntity();

            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);
            $equipamento->dataDeCompra = date('Y-m-d H:i:s', strtotime($this->request->data['dataDeCompra']));

            if ($this->Equipamentos->save($equipamento)) {
                $this->Flash->success(__('Equipamento cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao cadastrar o equipamento.'));
            }
        }
        
        $this->set(compact('equipamento'));
        $this->set(compact('professores'));
        $this->set(compact('tipoEquipamentos'));
        $this->set(compact('locals'));
        $this->set('_serialize', ['equipamento', 'tipoEquipamentos', 'locals']);
    }

    /**
     * Editar method
     *
     * @param string|null $tombo Equipamento tombo.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editar($tombo = null)
    {   

        $this->request->allowMethod(['ajax']);

        $equipamento = $this->Equipamentos
                                    ->find()
                                    ->where(['tombo' => $tombo])
                                    ->contain(['TipoEquipamentos', 'Locals', 'Users'])
                                    ->first();

        $equipamento->dataDeCompra = date('d-m-Y', strtotime($equipamento->dataDeCompra));

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

        $professores = $this->Equipamentos->Users
                                                ->find()
                                                ->select(['nome', 'matricula'])
                                                ->where(['role' => 'Professor'])
                                                ->all()
                                                ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);

            $equipamento->dataDeCompra = date('Y-m-d H:m:s', strtotime($this->request->data['dataDeCompra']));

            if ($this->Equipamentos->save($equipamento)) {
                echo 'Editado';
            } else {
                echo 'Erro';
            }
        }

        $this->set(compact('equipamento'));
        $this->set(compact('tipoEquipamentos'));
        $this->set(compact('locals'));
        $this->set(compact('professores'));
        $this->set('_serialize', ['equipamento', 'tipoEquipamentos', 'locals', 'professores']);
    }

    /**
     * Edit method
     *
     * @param string|null $tombo Equipamento tombo.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($tombo = null)
    {
        $equipamento = $this->Equipamentos
                                    ->find()
                                    ->where(['tombo' => $tombo])
                                    ->contain(['TipoEquipamentos', 'Locals', 'Users'])
                                    ->first();

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

        $professores = $this->Equipamentos->Users
                                                ->find('list', ['keyField' => 'matricula', 'valueField' => 'nome'])
                                                ->select(['nome', 'matricula'])
                                                ->where(['role' => 'Professor'])
                                                ->all()
                                                ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);
            
            $equipamento->dataDeCompra = date('Y-m-d H:m:s', strtotime($this->request->data['dataDeCompra']));

            if ($this->Equipamentos->save($equipamento)) {
                $this->Flash->success(__('Equipamento modificado com sucesso.'));
            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao modificar o equipamento.'));
            }
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('equipamento'));
        $this->set(compact('professores'));
        $this->set(compact('tipoEquipamentos'));
        $this->set(compact('locals'));
        $this->set('_serialize', ['equipamento', 'tipoEquipamentos', 'locals']);
    }

    /**
     * Delete method
     *
     * @param string|null $tombo Equipamento tombo.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($tombo = null) {

        $this->request->allowMethod(['POST']);
        
        $equipamento = $this->Equipamentos
                                    ->find()
                                    ->where(['tombo' => $tombo])
                                    ->first();

        if ($this->Equipamentos->delete($equipamento)) {
           $this->Flash->success(__('Equipamento deletado com sucesso.'));
        } else {
           $this->Flash->error(__('Ops! Ocorreu um erro ao deletar o equipamento.'));
        }
        return $this->redirect(['controller' => 'Locals', 'action' => 'index']);
    }

    /**
     * Cadastrar method
     *
     */
    public function cadastrar(){

        $tipoEquipamentos = $this->Equipamentos->TipoEquipamentos
                                                            ->find()
                                                            ->select(['id', 'nome'])
                                                            ->all()
                                                            ->toArray();

        $professores = $this->Equipamentos->Users
                                                ->find()
                                                ->select(['nome', 'matricula'])
                                                ->where(['role' => 'Professor'])
                                                ->all()
                                                ->toArray();


        if($this->request->is('put')){

            $equipamento = $this->Equipamentos->newEntity();

            $equipamento = $this->Equipamentos->patchEntity($equipamento, $this->request->data);

            $equipamento->dataDeCompra = date('Y-m-d H:i:s', strtotime($this->request->data['dataDeCompra']));

            if ($this->Equipamentos->save($equipamento)) {
                echo 'Cadastrado';
            } else {
                echo 'Erro ao cadastrar';
            }
        }

        $this->set(compact('tipoEquipamentos'));
        $this->set(compact('professores'));
        $this->set('_serialize', ['tipoEquipamentos', 'professores']);
    }

    /**
     * Find method
     * 
     * @return \Cake\Network\Response|null
     */
    public function find($tombo = null){
        $this->request->allowMethod('ajax');
        $equipamentos = $this->Equipamentos
                                        ->find()
                                        ->contain(['Locals', 'TipoEquipamentos', 'Users'])
                                        ->where(['tombo LIKE' => $tombo."%"])
                                        ->all()
                                        ->toArray();

        $this->set('equipamentos', $equipamentos);        

        $this->set('_serialize', ['equipamentos']);
    }

    public function alterarResponsavel ($codigo = null){
        
        $local = $this->Equipamentos->Locals
                                        ->find()
                                        ->where(['codigo' => $codigo])
                                        ->all()
                                        ->first();

        $professores = $this->Equipamentos->Users
                                                ->find('list', ['keyField' => 'matricula', 'valueField' => 'nome'])
                                                ->select(['nome', 'matricula'])
                                                ->where(['role' => 'Professor'])
                                                ->all()
                                                ->toArray();

        /** Equipamentos **/
        $equipamentos = $this->Equipamentos
                                        ->find()
                                        ->where(['codLocal' => $local->codigo])
                                        ->contain(['TipoEquipamentos', 'Users'])
                                        ->all()
                                        ->toArray();

        $this->set('local', $local);
        $this->set('equipamentos', $equipamentos);
        $this->set('professores', $professores);

        if($this->request->is('post')){

            if(isset($this->request->data['equipamentos'])){

                $equipamentos           = $this->request->data['equipamentos'];
                $novoResponsavel        = $this->request->data['responsavel']; 
                
                $query = $this->Equipamentos
                                                ->find()
                                                ->update()
                                                ->set(['responsavel' => $novoResponsavel])
                                                ->where(['tombo IN' => $equipamentos]);

                if($query->execute()){
                    $this->Flash->success(__('Responsável alterado com sucesso.'));
                    return $this->redirect(['controller' => 'Locals', 'action' => 'view', $codigo]);
                }else {
                    $this->Flash->error(__('Ops! Ocorreu um erro ao alterar.'));
                }

            }else{
                $this->Flash->error(__('Nenhum equipamento foi selecionado!'));
            }            
            
        }

    }

    public function relatorio($tombo = null){
        
        if($this->request->is(['post'])){

            date_default_timezone_set("America/Fortaleza");

            $dataInicio = date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ));
            $dataFim    = date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ));

            if($dataInicio > $dataFim || $dataInicio > date('Y-m-d H:i:s')){
                $this->Flash->error(__('Período inválido.'));
                return $this->redirect(['action' =>  'relatorio', $codigoLocal]);
            }
            
            $equipamento = $this->Equipamentos
                                        ->find()
                                        ->where(['tombo' => $tombo])
                                        ->contain([
                                                'TipoEquipamentos', 
                                                'Users', 
                                                'Locals',
                                                'Alertas' => function($q){
                                                        return $q
                                                        //->where(['statusAlerta' => 'Pendente']);
                                                            ->where(['dataAlerta >' => date('Y-m-d H:i:s', strtotime($this->request->data['dataInicio'] . '00:00:00' ))])
                                                            ->andWhere(['dataAlerta <' => date('Y-m-d H:i:s', strtotime($this->request->data['dataFim'] . '23:59:59' ))]);
                                                    }
                                                ])
                                                ->all()
                                                ->first();

            if(is_null($equipamento)){
                throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Equipamento não encontrado.", 404);
            }

            $this->response->header(['Content-type: application/pdf']);

            return PdfsController::relatorioEquipamento($equipamento, $dataInicio, $dataFim);

        }

    }

    public function isAuthorized($user){
        
        if($this->request->action === 'index'){
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Suporte'){
                return true;
            }
            return false;
        }

        if($this->request->action === 'cadastrar'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }

        if($this->request->action === 'add'){
            if(isset($user['role']) && $user['role'] === 'Administrador' ){
                return true;
            }
            return false;
        }

        if($this->request->action === 'view'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }

        if($this->request->action === 'editar'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }

        if($this->request->action === 'edit'){
            if(isset($user['role']) && $user['role'] === 'Administrador' ){
                return true;
            }
            return false;
        }

        if($this->request->action === 'delete'){
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Professor' || $user['role'] === 'Bolsista'){
                return true;
            }
            return false;            
        }

        if($this->request->action === 'find'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }
        
        if($this->request->action === 'alterarResponsavel'){
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Professor' || $user['role'] === 'Bolsista'){
                return true;
            }
            return false;            
        }

        if($this->request->action === 'relatorio'){
            $tomboEquipamento = $this->request->params['pass']['0'];
            $equipamento = $this->Equipamentos->find()->where(['tombo' => $tomboEquipamento])->contain(['Locals', 'Users'])->first();
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Suporte' || UsersController::isCoordenador($user, $equipamento->codLocal) || $equipamento->responsavel === $user['matricula']){
                return true;
            }
            return false;            
        }

    }   

}
