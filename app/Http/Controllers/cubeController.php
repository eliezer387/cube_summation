<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\View;

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
        $result = $this->process_test_cases($test_cases);
//        View::make('show_results', array('results'=>$result));
        return view('show_results',['results'=>$result]);
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
        for ($x = $i; $x <= $i1; $x++)
        {
            for ($y = $j; $y <= $j1; $y++)
            {
                for ($z = $k; $z <= $k1; $z++)
                {
                    $cube_sum = $cube_sum + $cube[$x][$y][$z];
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

    /**
     * funcion que recibe el arreglo de casos de prueba, ejecuta las pruebas y devuelve el texto con los resultados
     * @param type $test
     * @return string
     */
    public function process_test_cases($test)
    {
        $T = $test[0][0];
        unset($test[0][0]);
        $i = 0;
        $N = 0;
        $cube = array();
        $result = '';
        $x = 0;
        $y = 0;
        $z = 0;
        foreach ($test as $key => $value)
        {
            $cube = array();
            foreach ($value as $k => $v)
            {
                $op[$i] = explode(" ", $v);
                if (count($op[$i]) == 2)
                {
                    $N = $op[$i][1];
                } elseif (strtoupper($op[$i][0]) == "UPDATE")
                {
                    if (empty($cube))
                    {
                        $cube = $this->initialize_cube($N);
                    }
                    $x = $op[$i][1];
                    $y = $op[$i][2];
                    $z = $op[$i][3];
                    $cube = $this->update($x, $y, $z, $cube, $op[$i][4]);

                } elseif (strtoupper($op[$i][0]) == "QUERY")
                {
                    if (empty($cube))
                    {
                        $cube = $this->initialize_cube($N);
                    }
                    $x = $op[$i][1];
                    $y = $op[$i][2];
                    $z = $op[$i][3];
                    $x1 = $op[$i][4];
                    $y1 = $op[$i][5];
                    $z1 = $op[$i][6];
                    $sum = $this->sum($x, $y, $z, $x1, $y1, $z1, $cube);
                    $result.= $sum . "\r\n";
                }

                $i++;
            }
        }

        return $result;
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
                    $cube[$i][$j][$k] = 0;
                }
            }
        }
        return $cube;
    }

}
