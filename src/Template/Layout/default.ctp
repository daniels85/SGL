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

        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="_csrfToken" <?= ('content='.$this->request->param('_csrfToken')) ?>>
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>

        <?= $this->Html->script('jquery-1.12.2.min.js') ?>
        <?= $this->Html->script('moment.js') ?>
        <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.css') ?>           
        <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/semantic.min.js') ?>
        <?= $this->Html->script('equipamentos.js') ?>
        <?= $this->Html->script('alertas.js') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-3 medium-4 columns">
                <li class="name">
                    <h1><a href=""><?= $this->fetch('title') ?></a></h1>
                </li>
            </ul>
            <div class="top-bar-section">
                <ul class="right">
                    <?php if (!is_null($this->request->session()->read('Auth.User.username'))): ?>   
                        <li><a><?= $this->request->session()->read('Auth.User.nome') ?></a></li>
                        <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>             
                    <?php else: ?>
                        <li><?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?></li>
                    <?php endif; ?>
                    <li><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></li>
                    <li><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></li>
                </ul>
            </div>
        </nav>
        <?= $this->Flash->render() ?>
        <?= $this->Flash->render('auth') ?>
        <div class="container clearfix">
            <?= $this->fetch('content') ?>
        </div>
        <footer>
        </footer>
    </body>
</html>
