<?php

require_once 'php/posicion.php';
require_once 'php/meseta.php';

class Rover
{
    protected $posicion;
    protected $meseta;

    public function __construct(Meseta $meseta)
    {
        $this->meseta = $meseta;
        $this->posicion = new Posicion($meseta);
    }

    public function moverse(int $x, int $y, string $dir, string $comandos)
    {
        $this->posicion->setPosicion($x, $y, $dir);

        $arr1 = str_split($comandos);
        for ($j = 0; $j < count($arr1); $j++) {

            switch (strtoupper($arr1[$j])) {
                case  'R':
                    $this->posicion->girarDerecha();
                    break;
                case  'L':
                    $this->posicion->girarIzquierda();
                    break;
                case 'M':
                    $this->posicion->avanzar();
                    break;
                default:
                    break;
            }
        }

        return  $this->posicion->getPosicion();
    }
}
