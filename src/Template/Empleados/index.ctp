<div class='row'>
<nav class="col-3" id="sidebar">
    <ul class="side-nav">
        <li class="list-inline-item"><?=$this->Html->link(__('Nuevo Empleado'), ['action' => 'add'], ['class' => 'btn btn-light'])?> </li>
        <li class="list-inline-item"><?=$this->Html->link(__('Ir a Reporte'), ['action' => 'home'], ['class' => 'btn btn-light'])?> </li>
    </ul>
</nav>
<div class="col-9">
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope="col"><?=$this->Paginator->sort('id')?></th>
                <th scope="col"><?=$this->Paginator->sort('Código')?></th>
                <th scope="col"><?=$this->Paginator->sort('nombre')?></th>
                <th scope="col"><?=$this->Paginator->sort('apellido')?></th>
                <th scope="col" class="actions"><?=__('Acciones')?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ($empleados as $empleado) :
                ?>
            <tr>
                <td><?=$this->Number->format($empleado->id)?></td>
                <td><?=h($empleado->legajo)?></td>
                <td><?=h($empleado->nombre)?></td>
                <td><?=h($empleado->apellido)?></td>
                <td class="actions">
                    <?=$this->Html->link(__('Editar'), ['action' => 'edit',$empleado->id], ['class' => 'btn btn-sm btn-info'])?>
                    <?=$this->Form->postLink(__('Borrar'), ['action' => 'delete',$empleado->id], ['class' => 'btn btn-sm btn-danger','confirm' => __('Confirma la eliminacion del empleado {0}?', $empleado->presentacion)])?>
                </td>
            </tr>
            <?php
            endforeach
            ;
            ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?=$this->Paginator->first('<< ' . __('Primero'))?>
            <?=$this->Paginator->prev('< ' . __('Anterior'))?>
            <?=$this->Paginator->numbers()?>
            <?=$this->Paginator->next(__('Siguiente') . ' >')?>
            <?=$this->Paginator->last(__('Último') . ' >>')?>
            
        </ul>
        <p><?=$this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')])?></p>
    </div>
</div>
</div>