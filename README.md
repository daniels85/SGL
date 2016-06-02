## Sistema de Gerenciamento de Laboratórios (SGL) - [IFCE Campus Maracanaú](https://ifce.edu.br/maracanau)

Aplicação desenvolvida com [CakePHP](http://cakephp.org) 3.x.

---------------------------------------------------------
### Requisitos:

- Servidor HTTP
- PHP 5.5.9 ou superior
- Extensão mbstring PHP 
- Extensão intl PHP
- Extenção mbstring PHP

### Instalação:
- Fazer a instalação base do [CakePHP](http://cakephp.org) 3.x.
  - ###### Instalando o CakePHP via Composer
    O CakePHP utiliza o [Composer](https://getcomposer.org/), uma ferramenta de gerenciamento de dependências para PHP 5.3+, como o método suportado oficial para instalação.
    
    Primeiramente, você precisará baixar e instalar o Composer se não o fez anteriormente. Se você tem cURL instalada, é tão fácil quanto executar o seguinte:

    ``` bash
    $ curl -s https://getcomposer.org/installer | php
    ```
    Ou, você pode baixar **composer.phar** do [Site oficial do Composer](https://getcomposer.org/download/).
   
    Para sistemas Windows, você pode baixar o instalador [aqui](https://github.com/composer/windows-setup/releases/). Mais instruções para o instalador Windows do Composer podem ser encontradas dentro do LEIA-ME [aqui](https://github.com/composer/windows-setup).
   
    Agora que você baixou e instalou o Composer, você pode receber uma nova aplicação CakePHP executando:

    ``` bash
    $ php composer.phar create-project --prefer-dist cakephp/app my\_app\_name
    ```
    ###### Ou se o Composer estiver instalado globalmente:
    
    ``` bash
    $ composer self-update && composer create-project --prefer-dist cakephp/app my_app_name
    ```
    > Você pode encontrar mais sobre a instalação do CakePHP 3.x [aqui](http://book.cakephp.org/3.0/pt/installation.html).

- Configurar o arquivo config/app.php
  - Configurar a conexão de banco de dados em Datasources -> default
    >> Você pode encontrar mais sobre configuração da Database [aqui](http://book.cakephp.org/3.0/en/orm/database-basics.html#database-configuration).
  - Configurar um novo perfil de transporte de e-mail em EmailTransport
     
      ``` bash
        'mailSgl' => [
            'host' => 'ssl://smtp.gmail.com',
            'port' => 465,
            'timeout' => 60,
            'username' => 'username/email',
            'password' => 'password',
            'className' => 'Smtp',
            'context' => [
                 'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ]
        ]
      ```
      > Para mais explicações sobre como configurar o Mail Transport visitar o [Cookbook [Email]](http://book.cakephp.org/3.0/en/core-libraries/email.html).
 
----------------------------------------------------------------------------
### Versão 1.10.0.1

##### <i class="icon-file"></i> Changelog
 Versão   | Descrição 
----------:|:--------------------------------------------------------------
  1.10.0.1 | [CakePHP] Atualizado para versão 3.2.10
  1.10.0   | [Adicionado] Professores podem ver a lista de alertas de seus bolsistas
  1.9.1    | [Bugfix] Corrigido bug na data de compra ao salvar os equipamentos.
  1.9.0    | [Removido] Opção de apagar equipamento pelo perfil do usuário.
  1.8.0    | [Adicionado] Gerar relatórios dos Equipamentos.
  1.7.0    | [Adicionado] Gerar relatórios dos Ambientes.
  1.6.0.1  | [CakePHP] Atualizado para versão 3.2.9.
  1.6.0    | [Adicionado] Alterar responsável.
  1.5.0    | [Adicionado] Enviar email aos bolsistas ao ser gerado alertas.
  1.4.0    | [Adicionado] Perfil Suporte.
  1.3.0    | [ALteração]Modificado relação dos responsáveis por um equipamento. Agora são associados aos Usuários.
  1.2.2    | [Bugfix] Corrigido erros ao cadastrar ambiente.
  1.2.1    | [Bugfix] Corrigido erros de permissão ao excluir equipamento.
  1.2.0    | [Adicionado] Função de mover vários equipamentos.
  1.1.0    | [Adicionado] Opção de excluir equipamento.
