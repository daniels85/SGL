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
- Configurar permissões de de escrita para as pastas **logs** e **tmp**.
- Copiar e renomear o arquivo **config/app.default.php** para **config/app.php**.  
- Configurar o arquivo **config/app.php**  
  - Configurar a conexão de banco de dados em Datasources -> default
    
    > Você pode encontrar mais sobre configuração da Database [aqui](http://book.cakephp.org/3.0/en/orm/database-basics.html#database-configuration).
  
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
### Versão 1.11.0

##### <i class="icon-file"></i> Changelog
 Versão   | Descrição 
----------:|:--------------------------------------------------------------
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
