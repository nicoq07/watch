<div class='row'>

<nav class="col-3" id="sidebar">
    <ul class="side-nav">
        <li class="list-inline-item"><?=$this->Html->link(__('Ver Empleados'), ['action' => 'index'], ['class' => 'btn btn-light'])?> </li>
        <li class="list-inline-item"><?=$this->Html->link(__('Ir a Reporte'), ['action' => 'home'], ['class' => 'btn btn-light'])?> </li>
    </ul>
</nav>
<div class="col align-self-center">
    <?=$this->Form->create($empleado)?>
    <fieldset>
        <legend><?=__('Nuevo Empleado')?></legend>
        <?php
        echo $this->Form->control('legajo');
        echo $this->Form->control('nombre');
        echo $this->Form->control('apellido');
        ?>
    </fieldset>
    <?=$this->Form->button(__('Guardar'), ['class' => 'btn btn-block btn-success'])?>
    <?=$this->Form->end()?>
</div>
</div>