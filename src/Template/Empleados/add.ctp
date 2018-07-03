<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Empleado $empleado
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Empleados'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="empleados form large-9 medium-8 columns content">
    <?= $this->Form->create($empleado) ?>
    <fieldset>
        <legend><?= __('Add Empleado') ?></legend>
        <?php
            echo $this->Form->control('legajo');
            echo $this->Form->control('nombre');
            echo $this->Form->control('apellido');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
