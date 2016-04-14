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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_csrfToken" content="<?php echo $this->request->param('_csrfToken'); ?>" >
        <title>
            <?php echo $this->fetch('title'); ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>

        <?php echo $this->Html->script('jquery-1.12.2.min.js'); ?>
        <?php echo $this->Html->script('jquery.mask.js'); ?>
        <?php echo $this->Html->script('moment.js'); ?>
        <?php //echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css'); ?>        
        <?php echo $this->Html->css('/semantic-ui/dist/semantic.min.css'); ?>           
        <?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js'); ?>

        <?php echo $this->Html->script('equipamentos.js'); ?>
        <?php echo $this->Html->script('script.js'); ?>

        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
    </head>
    <body>

        <div class="ui pointing menu">
            <a class="item"><?php echo $this->fetch('title'); ?></a>
            <div class="right menu icon">
                <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>   
                    <a class="item" href="/Users/view/<?php echo $this->request->session()->read('Auth.User.id');  ?>"><?php echo $this->request->session()->read('Auth.User.nome'); ?></a>
                    <a href="/users/logout" class="item"><i class="sign out icon"></i>Logout</a>            
                <?php else: ?>
                    <a href="/users/login" class="item"><i class="sign in icon"></i>Login</a>
                <?php endif; ?>
            </div>
        </div>

        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Flash->render('auth'); ?>
        <div class="ui container">
            <div class="ui stackable grid">         
                    <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <footer>
        </footer>
    </body>

</html>
