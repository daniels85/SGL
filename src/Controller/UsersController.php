<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }


    public function bolsistas(){
        $users = $this->paginate($this->Users->find()->where(['role' => 'Bolsista']));
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $alertas2 = $this->Users->BolsistasAlertas
                                    ->find()                                
                                    ->contain(['Alertas'])
                                    ->where(['matricula_bolsista' => $user->matricula])
                                    ->all()
                                    ->toArray();

        $alertas = $this->Users->Alertas
                                    ->find()
                                    ->contain(['BolsistasAlertas'])
                                    ->where(['BolsistasAlertas.matricula_bolsista' => $user->matricula])
                                    ->all()
                                    ->toArray();

        $this->set('user', $user);
        $this->set('alertas', $alertas);
        $this->set('_serialize', ['user', 'alertas']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            date_default_timezone_set("America/Fortaleza");

            $password = self::gerarSenha(10);

            $this->request->data['password'] = $password;

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->cadastradoPor = $this->request->session()->read('Auth.User.nome');
            $user->dataDeCadastro = date('Y-m-d H:i:s');

            if ($this->Users->save($user) && self::mailer($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
    * Gerar senhas method
    * 
    * @author Thiago Belem <contato@thiagobelem.net>
    *
    * @param integer $tamanho Tamanho da senha a ser gerada
    * @param boolean $maiusculas Se terá letras maiúscualas
    * @param boolean $numeros Se terá números
    * @param boolean $simboloas Se terá simbolos
    *
    * @return string A senha gerada
    */
    public function gerarSenha($tamanho = 8, $maiusculas = true, $numero = true, $simbolos = false){
        
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num  = '123456789';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if($maiusculas) $caracteres .= $lmai;
        if($numero) $caracteres .= $num;
        if($simbolos) $caracteres .= $simb;

        $len = strlen($caracteres);

        for($n = 1; $n < $tamanho; $n++){
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }

        return $retorno;

    }

    /**
     * Edit method
     *
     * @param $data Dados para formar o email.
     * @return boolean True ou False.
     */
    public function mailer($data){
        $email = new Email();
        $email->transport('mailSgl');
        $email->emailFormat('html');
        $email->template('cadastro');
        $email->from('sglmailer@gmail.com', 'SGL');
        $email->to($data['email'], $data['nome']);
        $email->viewVars($data);
        $email->subject('Cadastro Efetuado - SGL');
        
        try{
            $email->send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    /**
     * alterarSenha method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function alterarSenha($id){
        $user = $this->Users->get($id);

        $user = $this->Users->patchEntity($user, $this->request->data);

        if($this->Users->save($user)){
            echo 'sucesso';
        }else{
            echo 'erro';
        }
    } 

    /**
     * alterarEmail method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function alterarEmail($id){
        $user = $this->Users->get($id);

        $user = $this->Users->patchEntity($user, $this->request->data);

        if($this->Users->save($user)){
            echo 'sucesso';
        }else{
            echo 'erro';
        }
    } 

    /**
     * cadastrarBolsista method
     *
     * @return String cadastrado ou erro
     */
    public function cadastrarBolsista(){
        $user = $this->Users->newEntity();
        if ($this->request->is('put')) {

            date_default_timezone_set("America/Fortaleza");

            $password = self::gerarSenha(10);

            $this->request->data['password'] = $password;
            $this->request->data['role'] = 'Bolsista';

            $user = $this->Users->patchEntity($user, $this->request->data);
            $user->cadastradoPor = $this->request->session()->read('Auth.User.nome');
            $user->dataDeCadastro = date('Y-m-d H:i:s');
            if ($this->Users->save($user) && self::mailer($this->request->data)) {
                echo 'cadastrado';
            } else {
                echo 'erro';
            }
        }
    }  

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login(){

        if(!is_null($this->request->session()->read('Auth.User.username'))){
            $this->redirect('/');
        }

        if($this->request->is('post')){
            $user = $this->Auth->identify();
            if($user){

                date_default_timezone_set("America/Fortaleza");
                $u = $this->Users->get($user['id']);
                $u->ultimaVezAtivo = date('Y/m/d H:i:s');

                $this->Users->save($u);

                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Usuário ou senha ínvalido, tente novamente.'));
        }
    }

    public function logout(){
        return $this->redirect($this->Auth->logout($this->redirect('/')));
    }

    /**
     * getUsersLocals method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array composto por user_matricula da tabela UserLocals.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public static function getUsersLocals($codigoLocal){

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
     * getUsersLocals method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array composto por user_matricula da tabela UserLocals.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public static function getUsersLocalsBolsistas($codigoLocal){


        $matriculaBolsistas = self::getMatriculaBolistas($codigoLocal);

        $matriculas = array('');

        foreach($matriculaBolsistas as $matricula){
            $matriculas[] = $matricula->matricula;
        }

        $userLocalsTable = TableRegistry::get('UserLocals');

        $usersLocal = $userLocalsTable
                            ->find()
                            ->select(['id', 'user_matricula'])
                            ->where(['user_matricula IN' => $matriculas, 'local_codigo' => $codigoLocal])
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
    public static function getMatriculaUsers($codigoLocal){

        $usersLocal = self::getUsersLocals($codigoLocal);

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
    public static function getCoordenadores($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = self::getMatriculaUsers($codigoLocal);

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
    public static function getBolistas($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = self::getMatriculaUsers($codigoLocal);

        $bolsistas = $usersTable
                        ->find()
                        ->select(['nome', 'matricula'])
                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                        ->all()
                        ->toArray();

        return $bolsistas;
    }

    /**
     * getMatriculaBolistas method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return Array com as matriculas de todos os Bolsistas associados ao local.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public static function getMatriculaBolistas($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = self::getMatriculaUsers($codigoLocal);

        $bolsistas = $usersTable
                        ->find()
                        ->select(['matricula'])
                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                        ->all()
                        ->toArray();

        return $bolsistas;
    }

    /**
     * isCoordenador method
     *
     * @param string|null $matricula Users matricula e $codLocal Locals codigo.
     * @return True ou False.
     */
    public static function isCoordenador($user, $codigoLocal){
        $matriculas = self::getMatriculaUsers($codigoLocal);
        if(in_array($user['matricula'], $matriculas) && !strcmp($user['role'], 'Professor')){
            return true;
        }else{
            return false;
        }
    }

    /**
     * isBolsista method
     *
     * @param string|null $matricula Users matricula e $codLocal Locals codigo.
     * @return True ou False.
     */
    public static function isBolsista($user, $codigoLocal){
        $matriculas = self::getMatriculaUsers($codigoLocal);
        if(in_array($user['matricula'], $matriculas) && !strcmp($user['role'], 'Bolsista')){
            return true;
        }
        return false;
    }

    /**
     * insereUserLocals method
     *
     * @param string|null $codigo Local codigo e $matricula User matricula.
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

    public function beforeFilter(Event $event) {
        $this->eventManager()->off($this->Csrf);
    }

    public function isAuthorized($user){
        return true;
    }   

}
