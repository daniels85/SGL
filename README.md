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
  - ###### Installing CakePHP via Composer

    You can install CakePHP into your project using
[Composer](http://getcomposer.org).  If you're starting a new project, we
recommend using the [app skeleton](https://github.com/cakephp/app) as
a starting point. For existing applications you can run the following:

    ``` bash
    $ composer require cakephp/cakephp:"~3.2"
    ```
- Configurar o arquivo config/app.php
  - Configurar a conexão de banco de dados em Datasources -> default
  - Configurar os dados do servidor de e-mail em EmailTransport -> mailSgl
 
----------------------------------------------------------------------------
### Versão 1.10.0

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