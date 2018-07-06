<?php
$this->assign('title', 'Inicio');
?>
    			<div class="col-12">
    				&nbsp;
                </div>
                <div class="row justify-content-center">
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
