<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class cubeController extends Controller
{
  
    
    /**
     * 
     * 
     */
    
    function index()
    {
       
       
    }
    
    
    
    /**
     * 
     * 
     */
    
    public function sumar(Request $request)
    {
        $operaciones = $request->input('ope');
        $array_operations=  $this->split_string($operaciones); 
        
       
    }
    
    /**
     * funcion para separar los parametros y operaciones a usar en el ejercicio
     * @param type $string
     */
    public function split_string($string)
    {
        
        
        
    }
    
    
    
    
}
