<?php
class Meseta
{
    public int $x;
    public int $y;

    public function __construct(int $x = -1, int $y = -1)
    {
        $this->x = $x;
        $this->y = $y;
    }
}
