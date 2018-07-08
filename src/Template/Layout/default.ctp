<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'Reporte de Horarios';
?>
<!DOCTYPE html>
<html>
<head>
    <?=$this->Html->charset()?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=$cakeDescription?>:
        <?=$this->fetch('title')?>
    </title>
    <?=$this->Html->meta('icon')?>

    <?=$this->Html->css(['base.css','bootstrap'])?>
    <?=$this->Html->css(['style.css','bootstrap'])?>

    <?=$this->fetch('meta')?>
    <?=$this->fetch('css')?>
    <?=$this->fetch('script')?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" data-topbar role="navigation">
        <ul class="list-inline title-area col-12">
            <li class="list-inline-item col-3">
                <h1><a href=""><?=$this->fetch('title')?></a></h1>
            </li>
            <li class="list-inline-item">
                <h4><a href=""><?=$this->Html->link(h('Empleados'), ['action' => 'index'], ['class' => 'btn btn-dark']);?></a></h4>
            </li>
            <li class="list-inline-item">
                <h4><a href=""><?=$this->Html->link(h('Reporte'), ['action' => 'home'], ['class' => 'btn btn-dark']);?></a></h4>
            </li>
        </ul>
         
    </nav>
    <?=$this->Flash->render()?>
    <div class="col-12">
        <?=$this->fetch('content')?>
    </div>
    <footer>
    </footer>
</body>
</html>
