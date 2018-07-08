<?php
$this->assign('title', 'Inicio');
?>
<div class="container">
  <div class="row">
    			<div class="col-12">
    				&nbsp;
                </div>
                <div class="col-12">
    				<div class="alert alert-warning">
    				<strong><?=h('RECUERDE:');?></strong><?=$this->Text->autoParagraph('Antes de generar el reporte, debe dar de alta a los empleados registrados en el Reloj Biométrico.');?>
    				</div>
                </div>
                <div class="col-12">
    				&nbsp;
                </div>
                <div  class="col align-self-center ">
                    <div class="  justify-content-center">
                    <div class="jumbotron">
                          <h1 class="display-4">Bienvenido</h1>
                          <p class="lead">Por favor, haz click en el botón de abajo para cargar el archivo.</p>
                          <hr class="my-4">
                          <?=$this->Form->create('archivo', ['type' => 'file','action' => 'procesar']);?>
                          		<div class="form-group row">
                              		<div class="col-lg-12">
                              		 <?=$this->Form->file('dat', ['label' => 'Seleccionar...','class' => 'form-control-file']);?>
                              		</div>
                              		<hr class="my-4">	
                              		<div class="col-lg-12">
                              		<?=$this->Form->submit('Procesar', ['name' => 'procesar','class' => 'form-control btn btn-info']);?>
                              		</div>
                              	</div>
                          <?=$this->Form->end();?>
                        </div>
                    </div>
 				</div>
	</div>
</div>