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
        <meta name="_csrfToken" content="<?php echo $this->request->param('_csrfToken'); ?>" >
        <title>
            SGL <?php //echo $this->fetch('title'); ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>

        <?php echo $this->Html->script('jquery-1.12.2.min.js'); ?>
        <?php echo $this->Html->script('jquery.mask.js'); ?>
        <?php echo $this->Html->script('moment.js'); ?>
        
        <?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css'); ?>                 
        <?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js'); ?>         
          
        <?php echo $this->Html->script('locals.js'); ?>
        <?php echo $this->Html->script('equipamentos.js'); ?>
        <?php echo $this->Html->script('formularios.js'); ?>        
        <?php echo $this->Html->script('users.js'); ?>  
        <?php echo $this->Html->script('tipoEquipamentos.js'); ?>
        <?php echo $this->Html->script('script.js'); ?>

        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
        <script type="text/javascript">
            
        </script>
    </head>
    <body>
        <div class="ui grid">           
            <div class="large monitor computer only row">
                <div class="column">
                    <div class="ui fixed menu">
                        <a href="/" class="item">Home</a>
                        <div class="right menu">
                            <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>   
                            <div class="ui category search item">
                                <div class="ui transparent icon input">
                                    <form method="POST" action="/equipamentos/find/" id="formBuscaEquipamento">
                                        <input type="hidden" name='_csrfToken' value="<?php echo $this->request->param('_csrfToken'); ?>"> 
                                        <input class="prompt" type="text" name='tombo' placeholder="Buscar por equipamento">
                                        <i class="search link icon"></i>
                                    </form>
                                </div>
                            </div>

                                <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Professor')): ?>
                                <a href="/users/bolsistas" class="item">Bolsistas</a>
                                <?php endif; ?>

                                <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')): ?>
                                <a href="/users/bolsistas" class="item">Bolsistas</a>
                                <a href="/users" class="item">Usuários</a>
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

        <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>
        <div class="ui right vertical sidebar menu">
            <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Professor')): ?>
            <a href="/users/bolsistas" class="item">Bolsistas</a>
            <?php endif; ?>

            <?php if(!strcmp($this->request->session()->read('Auth.User.role'), 'Administrador')): ?>

            <a href="/users/bolsistas" class="item">Bolsistas</a>
            <a href="/users" class="item">Usuários</a>
            <a href="/equipamentos" class="item">Equipamentos</a>
            <?php endif; ?>
            <div class="item">
                <div class="header">Buscar por Equipamento</div>
                <div class="menu">
                    <div class="ui category search item">
                        <div class="ui transparent icon input">
                            <form method="POST" action="/equipamentos/find/" id="formBuscaEquipamento">
                                <input type="hidden" name='_csrfToken' value="<?php echo $this->request->param('_csrfToken'); ?>"> 
                                <input class="prompt" type="text" name='tombo' placeholder="Buscar por equipamento">
                                <i class="search link icon"></i>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="header"><?php echo $this->request->session()->read('Auth.User.nome'); ?><i class="user icon"></i></div>
                <div class="menu">
                    <a class="item" href="/Users/view/<?php echo $this->request->session()->read('Auth.User.matricula');  ?>"><i class="settings icon"></i>Conta</a>
                    <a class="item" href="/users/logout"><i class="log out icon"></i>Logout</a>
                </div>              
            </div>          
            
        </div>
        <?php endif; ?> 

        <h5 class="ui horizontal divider header"></h5>
        <h5 class="ui horizontal divider header"></h5>

        <div class="ui container">
            
            <div class="ui stackable grid">                   

                <?php echo $this->Flash->render(); ?>

                <?php echo $this->Flash->render('auth'); ?>

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

    </body> 

</html>