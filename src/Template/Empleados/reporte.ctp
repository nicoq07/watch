<div class='col-12'>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th class="text-center">
				<?=h('Día');?>
				</th>
				<th class="text-center">
				<?=h('Fecha');?>
				</th>
				<th class="text-center">
				<?=h('Hora de Entrada');?>
				</th>
				<th class="text-center">
				<?=h('Hora de Salida');?>
				</th>
				<th class="text-center">
				<?=h('Horas Trabajadas');?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php

foreach ($listado as $empleado => $fechas) :
    ?>
        <tr>
        	<td colspan="5" class="text-center font-weight-bold">
        		<?=h($empleado);?>
        	</td>
        </tr>
        <?php
    
    foreach ($fechas as $fecha => $fichada) :
        $salida = empty($fichada['fichada'][count($fichada['fichada'])]) ? null : $fichada['fichada'][count($fichada['fichada'])];
        $entrada = empty($fichada['fichada'][1]) ? null : h($fichada['fichada'][1]);
        $diff = 'Imposible calcular.';
        if ($salida != null && $entrada != null) {
            $t1 = new DateTime(date('Y-m-d') . ' ' . $entrada);
            $t2 = new DateTime(date('Y-m-d') . ' ' . $salida);
            $intervalo = $t1->diff($t2);
            $diff = $intervalo->format('%H horas %i minutos.');
        }
        
        ?>
        <tr>
        	<td  class="text-center">
        		<?=h($fichada['nom_dia']);?>
        	</td>
              <td class="text-center">
        		<?=h($fecha);?>
        	 </td> 
        	 <td  class="text-center">
        		<?=! empty($fichada['fichada'][1]) ? h($fichada['fichada'][1]) : '-';?>
        	 </td> 
        	  <td  class="text-center">
        		<?=! empty($fichada['fichada'][count($fichada['fichada'])]) ? h($fichada['fichada'][count($fichada['fichada'])]) : '-';?>
        	 </td> 
        	 <td  class="text-center">
        	 	 <?=h($diff);?>
        	 </td>  
                    
        </tr>
        <?php
    endforeach
    ;
    ?>
        


<?php
endforeach
;
?>
		
		</tbody>
	</table>

</div>