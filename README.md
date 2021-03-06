## Sistema de Gerenciamento de Laboratórios (SGL) - [IFCE Campus Maracanaú](https://ifce.edu.br/maracanau)

Aplicação desenvolvida com [CakePHP](http://cakephp.org) 3.x.

---------------------------------------------------------
### Requisitos:

- Servidor HTTP
- PHP 5.5.9 ou superior
- [Composer](https://getcomposer.org/)
- Extensão intl PHP
- Extensão mbstring PHP

### Instalação:
- Clone o repositório 
- Instalando as dependências:
    - Entre na pasta do projeto e execute o comando:
        ```php composer.phar self-update && composer update``` 
        ou se o composer foi instalado globalmente:
        ```composer self-update && composer update```
- Configurar permissões de escrita para as pastas **logs** e **tmp**
- Copiar e renomear o arquivo **config/app.default.php** para **config/app.php**
- Configurar o arquivo **config/app.php**  
  - Configurar uma salt em **Security -> Salt**
    ```php
    'Security' => [
        'salt' => env('SECURITY_SALT', '__SALT__'),
    ],
    ```
    Substitua " **__ SALT __**" pela sua. 
    > A **SALT** deve ser uma string alfanumérica de aproximadamente 40 caracteres. 
      Pode-se utilizar serviços que geram strings randômicas como [**este**](http://www.sethcardoza.com/tools/random-password-generator/).
    
  - Configurar a conexão de banco de dados em Datasources -> default

    > Você pode encontrar mais sobre configuração da Database [aqui](http://book.cakephp.org/3.0/en/orm/database-basics.html#database-configuration).

  - Configurar um novo perfil de transporte de e-mail em EmailTransport

      ``` php
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

- Banco de Dados:
    - Crie um banco de dados chamado **sgl**.
    - Na pasta do projeto execute o comando ```bin/cake migrations migrate ```.

- Usuário administrador:
  
     Coloque o seguinte código em uma view de sua escolha e altere a **Senha** por uma de sua preferência.

  ``` php
  (new \Cake\Auth\DefaultPasswordHasher)->hash("Senha")
  ```
     Copie a senha e cadastre um usuário manualmente no banco de dados, setando **role** como **Administrador**.

----------------------------------------------------------------------------
### Versão 1.11.2

##### <i class="icon-file"></i> Changelog
 Versão   | Descrição
----------:|:--------------------------------------------------------------
  1.12     | [Adicionado] Adicionado Helpers para Formulários e Paginação
  1.11.2.1 | [CakePHP] Atualizado para versão 3.4
  1.11.2   | [Modificação] Adicionado verificação de senha para alteração.
  1.11.1   | [Bugfix] Corrigido alterações da data do equipamento ao modificar status do equipamento.
  1.11.0   | [Modificação] Melhorado o sistema de busca.
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