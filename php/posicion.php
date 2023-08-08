<?php
class Posicion
{
    protected $meseta;
    private int $x;
    private int $y;
    private string $direccion;

    public function __construct(Meseta $meseta)
    {
        $this->meseta = $meseta;
    }

    public function setPosicion(int $x, int $y, string $direccion)
    {
        $this->x = $x;
        $this->y = $y;
        $this->direccion = $direccion;
    }

    public function girarIzquierda()
    {
        switch (strtoupper($this->direccion)) {
            case 'N':
                $this->direccion = 'O';
                break;
            case 'O':
                $this->direccion = 'S';
                break;
            case 'S':
                $this->direccion = 'E';
                break;
            case 'E':
                $this->direccion = 'N';
                break;
            default:
                echo ('Movimiento no existe. izq');
                break;
        }
    }

    public function girarDerecha()
    {
        switch (strtoupper($this->direccion)) {
            case 'N':
                $this->direccion = 'E';
                break;
            case 'E':
                $this->direccion = 'S';
                break;
            case 'S':
                $this->direccion = 'O';
                break;
            case 'O':
                $this->direccion = 'N';
                break;
            default:
                echo $this->direccion;
                echo (' Movimiento no existe der.');
                break;
        }
    }

    public function avanzar()
    {
        switch (strtoupper($this->direccion)) {
            case 'N':
                if ($this->posicionValida($this->x, $this->y + 1)) {
                    $this->y++;
                }
                break;
            case 'S':
                if ($this->posicionValida($this->x, $this->y - 1)) {
                    $this->y--;
                }
                break;
            case 'E':
                if ($this->posicionValida($this->x + 1, $this->y)) {
                    $this->x++;
                }
                break;
            case 'O':
                if ($this->posicionValida($this->x - 1, $this->y)) {
                    $this->x--;
                }
                break;
            default:
                echo (' Movimiento no existe avanzar.');
                break;
        }
    }

    public function getPosicion()
    {
        $posicion = $this->x . ' ' . $this->y . ' ' . $this->direccion;
        return $posicion;
    }

    private function posicionValida(int $x, int $y)
    {
        return ($x >= 0 && $x <= $this->meseta->x && $y >= 0 && $y <= $this->meseta->y);
    }
}
