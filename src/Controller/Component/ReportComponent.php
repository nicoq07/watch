<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class ReportComponent extends Component
{

    private $days = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes'
    ];

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

    public function procesarDat($ruta)
    {
        $array_lineas = $this->leerDat($ruta);
        if (empty($array_lineas)) {
            error_log(date('d-m-Y , h:i:s') . ": Error al leer el dat. \n ", 3, LOGEO);
            
            return false;
        }
        
        $legajos = $this->traerLegajos($array_lineas);
        if (empty($legajos)) {
            error_log(date('d-m-Y , h:i:s') . ": Error al traer legajos. \n ", 3, LOGEO);
            
            return false;
        }
        
        $legajoDias = $this->agruparDiasLegajos($legajos, $array_lineas);
        if (empty($legajoDias)) {
            error_log(date('d-m-Y , h:i:s') . ": Error en AgruparDiasLegajo. \n ", 3, LOGEO);
            
            return false;
        }
        
        $listaOrdenada = $this->ordenarPorDia($legajoDias);
        if (empty($listaOrdenada)) {
            error_log(date('d-m-Y , h:i:s') . ": Error en OrdenarPorDia. \n ", 3, LOGEO);
            
            return false;
        }
        
        $diasTrabajados = $this->traerDias($listaOrdenada);
        if (empty($diasTrabajados)) {
            error_log(date('d-m-Y , h:i:s') . ": Error en traerDias. \n ", 3, LOGEO);
            
            return false;
        }
        
        $diasCompletos = $this->agruparDiasHoras($legajos, $diasTrabajados, $listaOrdenada, $this->days);
        
        if (empty($diasCompletos)) {
            error_log(date('d-m-Y , h:i:s') . ": Error en agruparDiasHoras. \n ", 3, LOGEO);
            
            return false;
        }
        
        // $salida = $this->calcularDiferencia($diasCompletos);
        // if (empty($salida)) {
        // error_log(date('d-m-Y , h:i:s') . ": Error en calcularDiferencia. \n ", 3, LOGEO);
        
        // return false;
        // }
        // echo '<pre>';
        // print_r($diasCompletos);
        // die();
        
        return $diasCompletos;
    }

    public function calcularDiferencia(array $fecha)
    {
        // $diff = null;
        // foreach ($fecha as $key => $value) {
        // foreach ($value as $reKey => $reValue) {
        // if ($reKey == 'fichada') {
        
        // }
        // }
        // }
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
                        $arrayAux[$legajo1][$diaTrabajado]['diff'] = '-1';
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
            $arrayOrdenado[$legajo] = $this->orderListByValue($val);
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