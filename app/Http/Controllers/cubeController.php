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
     * funcion principal que se encarga de recibir los datos del input, porcesarlos y
     * enviar la respuesta a la vista  
     * @param Request $request
     */
    public function main(Request $request)
    {
        $operaciones = $request->input('ope');
        $array_operations = $this->split_string($operaciones);

        $test_cases = $this->get_test_case($array_operations);
        $cube = $this->initialize_cube(4);
        dd($test_cases);
    }

    /**
     * funcion para separar los parametros y operaciones 
     * @param type $string
     */
    public function split_string($string)
    {
        $params = explode("\r\n", trim($string));
        //dd($params);
        return $params;
    }

    /**
     * recibe el array de operaciones para armar los casos de prueba 
     * @param array $params
     */
    function get_test_case($params)
    {
        $T = $params[0];
        $elem = explode(" ", $params[1]);
        $N = $elem[0];
        $M = $elem[1];

        $test_cases = array();
        $fin = count($params);

        $o = 0;
        $i = 0;
        while ($i < $fin)
        {
            $test_cases[$o][$i] = $params[$i];
            if ($i == $M + 1)
            {
                $o++;
            }
            $i++;
        }


        return $test_cases;

//        dd($tmp);
    }

    /**
     * Funcion que recibe las posiciones en la matriz para hacer las suma en el cubo
     * 
     * @param int $i
     * @param int $j
     * @param int $k
     * @param int $i1
     * @param int $j1
     * @param int $k1
     * @param array $cube
     * @return int $cube_sum
     */
    public function sum($i, $j, $k, $i1, $j1, $k1, $cube)
    {
        $cube_sum = 0;
        for ($i = 0; $i <= $i1; $i++)
        {
            for ($j = 0; $j <= $j1; $j++)
            {
                for ($k = 0; $k <= $k1; $k++)
                {
                    $cube_sum = $cube_sum + $cube[$i][$j][$k];
                }
            }
        }
        return $cube_sum;
    }

    /**
     * funcon que actualiza el valor de un arreglo en a posicion y el valor recibido 
     * @param int $i
     * @param int $j
     * @param int $k
     * @param array $cube
     * @param int $value
     * @return array
     */
    public function update($i, $j, $k, $cube, $value)
    {

        $cube[$i][$j][$k] = $value;

        return $cube;
    }

    public function process_test_cases($test)
    {
        return;
    }

    
    /**
     * Funcion que inicializa el cubo de longitud definida por el parametro $N 
     * @param int $N
     * @return array
     */
    public function initialize_cube($N)
    {
        $cube = array();
        for ($i = 0; $i < $N; $i++)
        {
            for ($j = 0; $j < $N; $j++)
            {
                for ($k = 0; $k < $N; $k++)
                {
                    $cube[$i][$i][$i] = 0;
                }
            }
        }
        return $cube;
    }

}
