<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
    <head>
    
        <?php $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#028482">
        <meta name="_csrfToken" content="<?php echo $this->request->param('_csrfToken'); ?>" >
        <title>
            Sistema de Gerenciamento de Locais
        </title>
        <?php echo $this->Html->meta('icon'); ?>

        <?php echo $this->Html->script('jquery-1.12.2.min.js'); ?>
        <?php echo $this->Html->script('jquery.mask.js'); ?>
        <?php echo $this->Html->script('moment.js'); ?>
        <?php echo $this->Html->script('typed.js'); ?>

        <?php //echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css'); ?>                 
        <?php //echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js'); ?> 

        <?php echo $this->Html->css('sgl'); ?> 

        <?php echo $this->Html->css('/semantic-ui/semantic.min.css'); ?>                 
        <?php echo $this->Html->script('/semantic-ui/semantic.min.js'); ?>          
          
        <?php echo $this->Html->script('locals.js'); ?>
        <?php echo $this->Html->script('equipamentos.js'); ?>
        <?php echo $this->Html->script('formularios.js'); ?>        
        <?php echo $this->Html->script('users.js'); ?>  
        <?php echo $this->Html->script('tipoEquipamentos.js'); ?>
        <?php echo $this->Html->script('script.js'); ?>



        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>

    </head>
    <body>
        <div class="ui stackable one column grid">         

            <div class="large monitor computer only row">

                <div class="column">

                    <div class="ui menu">

                        <a href="/" class="item">Home</a>
                        <div class="right menu">
                            <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>

                            <div class="ui left aligned category search item">
                                <div class="ui search transparent icon input find equipamento">
                                    <i class="search icon"></i>
                                    <input type="text" class="prompt" id="busca" placeholder="Buscar equipamento...">
                                </div>
                                <div class="results"></div>
                            </div>

                                <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Professor')): ?>
                                <a href="/users/bolsistas" class="item">Bolsistas</a>
                                <?php endif; ?>

                                <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')): ?>
                                <a href="/users/bolsistas" class="item">Bolsistas</a>
                                <a href="/users" class="item">Usuários</a>
                                <?php endif; ?>
                                <?php if($this->request->session()->read('Auth.User.role') === 'Administrador' || $this->request->session()->read('Auth.User.role') === 'Suporte'): ?>
                                <a href="/equipamentos" class="item">Equipamentos</a>
                                <?php endif; ?>

                            <div class="ui dropdown item">
                                <?php echo $this->request->session()->read('Auth.User.nome'); ?><i class="user icon"></i>
                                <div class="menu">
                                    <a href="/Users/view/<?php echo $this->request->session()->read('Auth.User.matricula');  ?>" class="item"><i class="settings icon"></i>Conta</a>
                                    <a href="/users/logout" class="item"><i class="sign out icon"></i>Logout</a>
                                </div>
                            </div>
                            <?php else: ?>
                            <a href="/users/login" class="item"><i class="sign in icon"></i>Login</a>
                            <?php endif; ?>  
                        </div>                      
                    </div>                  
                </div>
            </div>
            
            <div class="tablet mobile only row">

                <div class="column">
                    <div class="ui fixed main menu">
                        <a href="/" class="item nav">Home</a>
                        <div class="right menu">
                            <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>
                            <a class="launch icon item">
                                <i class="sidebar icon"></i>
                            </a>
                            <?php else: ?>
                            <a href="/users/login" class="item"><i class="sign in icon"></i>Login</a>
                            <?php endif; ?> 
                        </div>
                    </div>
                </div>

            </div>  

            <!--
            <div class="computer only row">
                <button class="circular ui teal icon button back-computer" onclick="window.history.back();"><i class="arrow left icon"></i></button>
            </div>
            <div class="mobile tablet only row">
                <button class="circular ui teal icon button back-mobile" onclick="window.history.back();"><i class="arrow left icon"></i></button>
            </div>
            -->
        </div>

        

        <div class="full height wrapper">

            <div class="pusher">

                <div class="ui right vertical sidebar menu">
                <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>                
                    <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Professor')): ?>
                    <a href="/users/bolsistas" class="item">Bolsistas</a>
                    <?php endif; ?>

                    <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')): ?>

                    <a href="/users/bolsistas" class="item">Bolsistas</a>
                    <a href="/users" class="item">Usuários</a>            
                    <?php endif; ?>
                    <?php if($this->request->session()->read('Auth.User.role') === 'Administrador' || $this->request->session()->read('Auth.User.role') === 'Suporte'): ?>
                    <a href="/equipamentos" class="item">Equipamentos</a>
                    <?php endif; ?>

                    <div class="item">
                        <div class="header"><?php echo $this->request->session()->read('Auth.User.nome'); ?><i class="user icon"></i></div>
                        <div class="menu">
                            <a class="item" href="/Users/view/<?php echo $this->request->session()->read('Auth.User.matricula');  ?>"><i class="settings icon"></i>Conta</a>
                            <a class="item" href="/users/logout"><i class="log out icon"></i>Logout</a>
                        </div>              
                    </div>  
                    <div class="item">
                        <div class="header">Buscar por Equipamento</div>
                        <div class="menu">

                            <div class="ui fluid category search item">
                                <div class="ui search transparent icon input find equipamento">
                                    <i class="search icon"></i>
                                    <input type="text" class="prompt" id="busca" placeholder="Buscar equipamento...">
                                </div>
                                <div class="results"></div>
                            </div>
                            
                        </div>
                    </div>        
                
                <?php endif; ?>   
                </div>                

                <div class="ui container main">
                    
                    <div class="ui stackable grid">                   

                    <div class="sixten centered wide column row">
                        <?php echo $this->Flash->render(); ?>
                    
                        <?php echo $this->Flash->render('auth'); ?>
                    </div>

                        <?php echo $this->fetch('content'); ?>

                        <div class="ui modal small">
                            <i class="close icon"></i>
                            <div class="ui dimmer loading">                        
                                <div class="ui text loader">Aguarde...</div>                       
                            </div>                     
                            <div class="header"></div> 
                            <div class="mensagem"></div>              
                            <div class="content"></div>
                            <div class="actions"></div> 
                        </div>

                    </div>  

                </div>

            </div>

            <div class="ui vertical inverted footer segment">
                <div class="ui center aligned container">                      
                    <div class="ui horizontal inverted small divided link list">
                        <a class="item" href="/">Sistema de Gerenciamento de Laboratórios</a>
                        <a class="item" href="https://ifce.edu.br/maracanau">Instituto Federal de Educação, Ciência e Tecnologia do Ceará - Campus Maracanaú</a>
                    </div>
                </div>
            </div>

        </div>

    </body> 

</html>
