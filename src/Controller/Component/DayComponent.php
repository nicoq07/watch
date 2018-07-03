<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class DayComponent extends Component
{
    public function momentoDelDia()
    {
        
        $saludo = "";
        $time = date("H");
        $timezone = date("e");
        
        if ($time < "12") {
            $saludo = "Buen día ";
        } 
        else  if ($time >= "12" && $time < "18")
        {
            $saludo = "Buenas tardes ";
        }
        else if
        ($time >= "18") {
            $saludo= "Buenas noches ";
        }
        
        return $saludo;
    }
}