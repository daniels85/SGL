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
            <?php $this->fetch('title'); ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->Html->css('base.css'); ?>
        <?php echo $this->Html->css('cake.css'); ?>

        <?php echo $this->Html->script('jquery-1.12.2.min.js'); ?>
        <?php echo $this->Html->script('moment.js'); ?>
        <?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css'); ?>           
        <?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js'); ?>
        <?php echo $this->Html->script('equipamentos.js'); ?>
        <?php echo $this->Html->script('alertas.js'); ?>

        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
    </head>
    <body>
        <nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-3 medium-4 columns">
                <li class="name">
                    <h1><a href=""><?php $this->fetch('title') ?></a></h1>
                </li>
            </ul>
            <div class="top-bar-section">
                <ul class="right">
                    <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>   
                        <li><a href="/Users/view/<?php echo $this->request->session()->read('Auth.User.id');  ?>"><?php echo $this->request->session()->read('Auth.User.nome'); ?></a></li>
                        <li><?php echo $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']); ?></li>             
                    <?php else: ?>
                        <li><?php echo $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']); ?></li>
                    <?php endif; ?>
                    <li><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></li>
                    <li><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></li>
                </ul>
            </div>
        </nav>
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->Flash->render('auth'); ?>
        <div class="container clearfix">
            <?php echo $this->fetch('content'); ?>
        </div>
        <footer>
        </footer>
    </body>
</html>
