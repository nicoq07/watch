<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class ReportComponent extends Component
{

    private $dat = $_FILES['dat'];

    private $procesar = $_POST['procesar'];

    private $days = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes'
    ];

    // if (! empty($procesar)) {
    
    // if (! empty($dat) && $dat['error'] == 0) {
    // $checkCopy = copy($dat['tmp_name'], PATH_ARCHIVOS);
    
    // if (! $checkCopy) {
    // echo "Error copiando el archivo, reintente por favor";
    // error_log(date('d-m-Y , h:i:s') . ": No se copió el archivo. \n ", 3, LOGEO);
    // die();
    // }
    
    // $reporte = crearReporte(PATH_ARCHIVOS, $days);
    
    // if (! $reporte) {
    // echo "Error generando el reporte, reintente por favor";
    // error_log(date('d-m-Y , h:i:s') . ": Error generando el reporte, reintente por favor. \n", 3, LOGEO);
    // die();
    // }
    
    // mostrarReporte($reporte);
    // }
    // }
    public function leerDat($ruta)
    {
        $lineas = null;
        $fh = fopen($ruta, 'r');
        $i = 0;
        while ($line = fgets($fh)) {
            $line = str_replace("\t", '.', $line);
            $line = ltrim($line);
            
            $lineas[$i] = $line;
            $i ++;
        }
        fclose($fh);
        
        if (! empty($lineas)) {
            return $lineas;
        }
        
        return false;
    }

    public function procesarDat($ruta, $days)
    {
        $array_lineas = leerDat($ruta);
        if (! $array_lineas) {
            return false;
        }
        $legajos = traerLegajos($array_lineas);
        if (! $legajos) {
            return false;
        }
        $legajoDias = agruparDiasLegajos($legajos, $array_lineas);
        if (! $legajoDias) {
            return false;
        }
        $listaOrdenada = ordenarPorDia($legajoDias);
        if (! $listaOrdenada) {
            return false;
        }
        $diasTrabajados = traerDias($listaOrdenada);
        
        $diasCompletos = agruparDiasHoras($legajos, $diasTrabajados, $listaOrdenada, $days);
        echo '<pre>';
        print_r($diasCompletos);
        die();
        
        return $legajoDias;
    }

    public function agruparDiasLegajos($legajos, $array_lineas)
    {
        $arrayAux = null;
        foreach ($legajos as $legajo => $val) {
            
            for ($i = 0; $i < count($array_lineas); $i ++) {
                $auxExplode = explode('.', $array_lineas[$i]);
                $_legajo = $auxExplode[0];
                if (is_numeric($legajo)) {
                    if ($_legajo == $legajo) {
                        
                        $arrayAux[$legajo][$i] = $auxExplode[1];
                    }
                }
            }
        }
        if (! $arrayAux) {
            return false;
        }
        
        return $arrayAux;
    }

    public function traerLegajos($array)
    {
        $legajosDeArchivo = leerArchivoEmpleados();
        $legajos = null;
        // array de legajos
        for ($i = 0; $i < count($array); $i ++) {
            
            $auxExplode = explode('.', $array[$i]);
            $legajo = $auxExplode[0];
            if (is_numeric($legajo)) {
                $legajos[$legajo] = '';
            }
        }
        
        if (! $legajos) {
            return false;
        }
        return $legajos;
    }

    public function traerDias($array)
    {
        $diasTrabajados = null;
        // array de legajos
        foreach ($array as $legajos => $val) {
            for ($i = 0; $i < count($val); $i ++) {
                
                $auxExplode = explode(' ', $val[$i]);
                $diasTrabajados[$legajos][$auxExplode[0]] = '';
            }
        }
        if (! $diasTrabajados) {
            return false;
        }
        return $diasTrabajados;
    }

    public function agruparDiasHoras($legajos, $diasTrabajados, $arrayOrdenado, $days)
    {
        $arrayAux = null;
        
        foreach ($legajos as $legajo1 => $v) {
            // dia de este legajo
            foreach ($diasTrabajados[$legajo1] as $diaTrabajado => $b) {
                $i = 1;
                foreach ($arrayOrdenado[$legajo1] as $diaOrdenado) {
                    $aux = explode(" ", $diaOrdenado);
                    if ($diaTrabajado == $aux[0]) {
                        $arrayAux[$legajo1][$diaTrabajado]['fichada'][$i] = $aux[1];
                        $nom_dia = date('l', strtotime($diaTrabajado));
                        $arrayAux[$legajo1][$diaTrabajado]['nom_dia'] = $days["$nom_dia"];
                        $i ++;
                    }
                }
            }
        }
        
        if (! $arrayAux) {
            return false;
        }
        
        return $arrayAux;
    }

    public function crearReporte($ruta, $days)
    {
        $array = procesarDat($ruta, $days);
    }

    public function mostrarReporte($reporte)
    {}

    public function ordenarPorDia(array $array)
    {
        $arrayOrdenado = null;
        foreach ($array as $legajo => $val) {
            $arrayOrdenado[$legajo] = orderListByValue($val);
        }
        return $arrayOrdenado;
    }

    public function orderListByValue(array $list)
    {
        $list = array_values($list);
        
        for ($i = 1; $i < count($list); $i ++) {
            
            for ($j = 0; $j < count($list) - $i; $j ++) {
                
                if (strtotime($list[$j]) > strtotime($list[$j + 1])) {
                    
                    $k = $list[$j + 1];
                    
                    $list[$j + 1] = $list[$j];
                    
                    $list[$j] = $k;
                }
            }
        }
        
        return $list;
    }

    public function groupListByDate(array $list)
    {
        $arrayAgrupado = null;
        for ($i = 1; $i < count($list); $i ++) {
            
            for ($j = 0; $j < count($list) - $i; $j ++) {
                
                if (date('d-m-Y', strtotime($list[$j])) == date('d-m-Y', strtotime($list[$j + 1]))) {}
            }
        }
        return $list;
    }

    public function leerArchivoEmpleados()
    {
        $ruta = PATH_EMPLEADOS;
        
        $lineas = null;
        $fh = fopen($ruta, 'r');
        $i = 0;
        while ($line = fgets($fh)) {
            $line = str_replace("\t", '.', $line);
            $line = ltrim($line);
            
            $lineas[$i] = $line;
            $i ++;
        }
        fclose($fh);
        
        if (! empty($lineas)) {
            return $lineas;
        }
        
        foreach ($lineas as $linea) {
            
            $aux = explode(",", $linea);
        }
        
        return false;
    }
}