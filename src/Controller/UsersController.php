<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Alertas.dataAlerta' => 'desc',
            'Users.nome' => 'asc',
            'Equipamentos.nome' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Csrf');
    }

    public function testeEmail(){

        $data = [
            'nome' => '$user->nome',
            'matricula' => '$user->matricula',
            'email' => 'ivanovdealmeida@gmail.com',
            'username' => '$user->username',
            'newPassword' => '$newPassword',
        ];

        $email = new Email();
        $email->transport('mailSgl');
        $email->emailFormat('html');
        $email->template('recuperarSenha');
        $email->from('sglmailer@gmail.com', 'SGL');
        $email->to($data['email'], $data['nome']);
        $email->viewVars($data);
        $email->subject('sadojaspdjasid');
        
        print '<br>';
        print '<br>';
        print '<br>';
        print '<br>';
        print '<br>';
        print '<br>';

        var_dump($email->send());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * bolsistas method
     *
     * @return \Cake\Network\Response|null
     */
    public function bolsistas(){
        $users = $this->Users
                            ->find()
                            ->where(['role' => 'Bolsista']);

        $users = $this->paginate($users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $matricula User matricula.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($matricula = null) {

        $user = $this->Users 
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->contain(['Equipamentos' => ['TipoEquipamentos', 'Locals']])
                        ->first();

        if(is_null($user)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);
        }

        $alertas = $this->Users->Alertas
                                    ->find()
                                    ->contain(['BolsistasAlertas'])
                                    ->where(['BolsistasAlertas.matricula_bolsista' => $user->matricula]);

        $this->set('user', $user);
        $this->set('alertas', $this->paginate($alertas));
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {   
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            date_default_timezone_set("America/Fortaleza");

            $password = self::gerarSenha(10);

            $this->request->data['password'] = $password;

            $user = $this->Users->patchEntity($user, $this->request->data);
            
            $user->cadastradoPor = $this->request->session()->read('Auth.User.nome');
            $user->dataDeCadastro = date('Y-m-d H:i:s');

            if ($this->Users->save($user)) {
                $this->mailer($this->request->data, 'cadastro', 'Cadastro Efetuado - SGL');
                $this->Flash->success(__('Usuário cadastrado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao cadastrar o usuário.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * recuperarSenha method
     *
     * @return \Cake\Network\Response|void Redirects em caso de sucesso na recuperação.
     */
    public function recuperarSenha(){
        
        if($this->request->is('post')){
            $user = $this->Users
                            ->find()
                            ->select(['id'])
                            ->where(['matricula' => $this->request->data['matricula']])
                            ->first();

            if(!empty($user)){
                $user = $this->Users->get($user->id);

                $newPassword = self::gerarSenha(10);

                $data = [
                    'nome' => $user->nome,
                    'matricula' => $user->matricula,
                    'email' => $user->email,
                    'username' => $user->username,
                    'newPassword' => $newPassword,
                ];

                $user->password = $newPassword;

                if($this->Users->save($user)){
                    $this->mailer($data, 'recuperarSenha', 'Recuperação de Senha - SGL');
                    $this->Flash->success(__('Um e-mail com sua nova senha foi enviado.'));
                    return $this->redirect(['action' => 'login']);
                }else{
                    $this->Flash->error(__('Ops! Ocorreu um erro ao tentar recuperar sua senha.'));
                }

            }else{
                $this->Flash->error(__('Matrícula não encontrada.'));
            }
            
        }

    }

    /**
     * gerarSenhas method
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
     * alterarSenha method
     *
     * @param string|null $matricula User matricula.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function alterarSenha($matricula){
        //$user = $this->Users->get($id);

        $user = $this->Users
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->first();

        $user = $this->Users->patchEntity($user, $this->request->data);

        if($this->Users->save($user)){
            echo 'sucesso';
        }else{
            echo 'erro';
        }
    } 

    /**
     * resetarSenha method
     *
     * @param string|null $matricula User matricula.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function resetarSenha($matricula){
        $user = $this->Users
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->first();

        $newPassword = self::gerarSenha(10);

        $data = [
            'nome' => $user->nome,
            'matricula' => $user->matricula,
            'email' => $user->email,
            'username' => $user->username,
            'newPassword' => $newPassword,
        ];

        $user->password = $newPassword;

        if($this->Users->save($user)){
            $this->mailer($data, 'recuperarSenha', 'Recuperação de Senha - SGL');
            echo 'sucesso';
        }else{
            echo 'erro';
        }
    }

    /**
     * alterarEmail method
     *
     * @param string|null $matricula User matricula.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function alterarEmail($matricula){
        //$user = $this->Users->get($id);

        $user = $this->Users
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->first();

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
            if ($this->Users->save($user)) {
                $this->mailer($this->request->data, 'cadastro', 'Cadastro Efetuado - SGL');
                echo 'cadastrado';
            } else {
                echo 'erro';
            }
        }
    }  

    /**
     * Edit method
     *
     * @param string|null $matricula User matricula.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($matricula = null) {

        $user = $this->Users
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->first();

        if(is_null($user)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);
        }

        if(strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')){
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Usuário modificado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ops! Ocorreu um erro ao modifcar o usuário.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $matricula User matricula.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($matricula = null) {
        $this->request->allowMethod(['ajax']);

        $user = $this->Users
                        ->find()
                        ->where(['matricula' => $matricula])
                        ->first();

        if(is_null($user)){
            throw new \Cake\Datasource\Exception\RecordNotFoundException("Ops! Algo de errado aconteceu.", 1);
        }
        
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('Usuário deletado com sucesso.'));
        } else {
            $this->Flash->error(__('Ops! Ocorreu um erro ao deletar o usuário.'));
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
                $u->ultimaVezAtivo = date('Y-m-d H:i:s');

                $this->Users->save($u);

                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Usuário ou senha ínvalidos, tente novamente.'));
        }
    }

    public function logout(){
        return $this->redirect($this->Auth->logout($this->redirect('/')));
    }


    // Funções ...

    /**
     * getUsersLocals method
     *
     * @param string $codigoLocal Local codigo.
     * @return array $userLocal UserLocals user_matricula.
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
     * @param string $codigoLocal Local codigo.
     * @return array $userLocal UserLocals $user_matricula.
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
     * @param string $codigoLocal Local codigo.
     * @return array $matriculas Users matricula.
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
     * @param string $codigoLocal Local codigo.
     * @return array $coordenadores Users nome e matricula.
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
     * @return array $bolsistas Users nome e matricula.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public static function getBolistas($codigoLocal){

        $usersTable = TableRegistry::get('Users');

        $matriculas = self::getMatriculaUsers($codigoLocal);

        $bolsistas = $usersTable
                        ->find()
                        ->select(['nome', 'matricula', 'email'])
                        ->where(['Users.matricula IN' => $matriculas, 'Users.role' => 'Bolsista'])
                        ->all()
                        ->toArray();

        return $bolsistas;
    }

    /**
     * getMatriculaBolistas method
     *
     * @param string|null $codigoLocal Local codigo.
     * @return array $bolsistas Users matricula.
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
     * @param Object $user Users.
     * @param string $codLocal Locals codigo.
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
     * @param Object $user Users.
     * @param string $codLocal Locals codigo.
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
     * @param string $codigo Local codigo.
     * @param string $matricula User matricula.
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
     * @param string $id UserLocals id.
     * @param string $codifo Local codigo.
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

    /**
     * isAuthorized method
     *
     * @param object $user User.
     * @return true ou false.
     */
    public function isAuthorized($user){

        if($this->request->action === 'view'){
            $userMatricula = $this->request->params['pass'][0];
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['matricula'] === $userMatricula){
                return true;
            }
            return false;
        }

        if($this->request->action === 'edit'){
            $userMatricula = $this->request->params['pass'][0];
             if(isset($user['role']) && $user['role'] === 'Administrador' || $user['matricula'] === $userMatricula){
                return true;
            }
            return false;
        }

        if($this->request->action === 'alterarEmail'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }

        if($this->request->action === 'alterarSenha'){
            if(isset($user['role'])){
                return true;
            }
            return false;
        }

        if($this->request->action === 'resetarSenha'){
            if(isset($user['role']) && $user['role'] === 'Professor' || $user['role'] === 'Administrador'){
                return true;
            }
            return false;
        }

        if($this->request->action === 'bolsistas'){
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Professor'){
                return true;
            }
            return false;
        }

        if($this->request->action === 'cadastrarBolsista'){
            if(isset($user['role']) && $user['role'] === 'Administrador' || $user['role'] === 'Professor' ){
                return true;
            }
            return false;
        }

        if($this->request->action === 'logout'){
            return true;
        }

        return parent::isAuthorized($user);
    }   

}