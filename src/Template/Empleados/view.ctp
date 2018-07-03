<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Empleado $empleado
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Empleado'), ['action' => 'edit', $empleado->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Empleado'), ['action' => 'delete', $empleado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $empleado->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Empleados'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Empleado'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="empleados view large-9 medium-8 columns content">
    <h3><?= h($empleado->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($empleado->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Apellido') ?></th>
            <td><?= h($empleado->apellido) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($empleado->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Legajo') ?></th>
            <td><?= $this->Number->format($empleado->legajo) ?></td>
        </tr>
    </table>
</div>
