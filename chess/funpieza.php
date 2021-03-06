<?php

class Pieza
{

    public function __construct($piezac, $posicionx, $posiciony)
    {
        $this->piezac = $piezac;
        $this->posicionx = $posicionx;
        $this->posiciony = $posiciony;
    }
    public function checkThreats()
    {
        if ($this->piezac == "torre") {
            $bagof = makeTorre($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else if ($this->piezac == "alfil") {
            $bagof = makeAlfil($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else if ($this->piezac == "dama") {
            $bagof = makeDama($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else if ($this->piezac == "rey") {
            $bagof = makeRey($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else if ($this->piezac == "peon") {
            $bagof = makePeon($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else if ($this->piezac == "caballo") {
            $bagof = makeCaballo($this->piezac, $this->posicionx, $this->posiciony);
            return $bagof;
        } else {
            echo "ALGO VA MAL";
        }
    }
    public function tellPlace()
    {
        echo "{$this->piezac}";
        echo "{$this->posicionx}";
        echo "{$this->posiciony}";
    }
    public function asciiPi()
    {
        switch ($this->piezac) {
            case 'dama':
                return "&#9813;";
            case 'torre':
                return "&#9814;";
            case 'alfil':
                return "&#9815;";
            case 'caballo':
                return "&#9816;";
            case 'peon':
                return "&#9817;";
            case 'rey':
                return "&#9812;";
        }
    }
    public $piezaM;

    public function isThreat($piezaM)
    {
        $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
        $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
        $codeP = $letterArray[$piezaM->posicionx] . $numberArray[$piezaM->posiciony];
        $code = $letterArray[$this->posicionx] . $numberArray[$this->posiciony];
        $bagof = $this->checkThreats();

        if (in_array($codeP, $bagof)) {
            echo "$this->piezac en $code AMENAZA  $piezaM->piezac en  $codeP<br>";
            return true;
        } else {
            echo "$this->piezac en $code NO AMENAZA  $piezaM->piezac en  $codeP<br>";
            return false;
        }
    }
}
function transformLetra($x)
{
    switch ($x) {
        case 'A':
            return 0;
        case 'B':
            return 1;
        case "C":
            return 2;
        case 'D':
            return 3;
        case 'E':
            return 4;
        case "F":
            return 5;
        case "G":
            return 6;
        case "H":
            return 7;
    }
}
function tranformNumero($y)
{
    switch ($y) {
        case '1':
            return 0;
        case '2':
            return 1;
        case "3":
            return 2;
        case '4':
            return 3;
        case '5':
            return 4;
        case "6":
            return 5;
        case "7":
            return 6;
        case "8":
            return 7;
    }
}
function makeTorre($pieza, $posicionx, $posiciony)
{
    $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
    $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
    $bagof = array();
    // Tower Logic
    for ($i = 0; $i < 8; $i = $i + 1) {
        $union1 = $letterArray[$i] . $numberArray[$posiciony];
        $union2 = $letterArray[$posicionx] . $numberArray[$i];
        array_push($bagof, $union1);
        array_push($bagof, $union2);
    }

    array_unique($bagof);
    return $bagof;
}

function makeAlfil($pieza, $posicionx, $posiciony)
{
    $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
    $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
    $bagof = array();

    //- Primera Aproximación
    //- 2
    // Obtener fórmula sobre la array
    // Diagonales positivas - 1 de las cordenadas llega a 0(-1,-1), después se elevan(+1,+1) hasta llegar a 7

    // PRIMERA DIAGONAL
    if ($posicionx >= $posiciony) {
        $new1pa = $posicionx - $posiciony;
        $new1pb = 0;
    } else {
        $new1pb = $posiciony - $posicionx;
        $new1pa = 0;
    }

    for ($i = 0; $i < 8; $i++) {
        if ($new1pa + $i < 8 && $new1pb + $i < 8) {
            $union1 = $letterArray[$new1pa + $i] . $numberArray[$new1pb + $i];
            array_push($bagof, $union1);
        }
    }

    // // SEGUNDA DIAGONAL- El algoritmo es mucho más complejo, depende de lo alejados del límite o yo no e sabido plantearlo
    if ($posicionx > 7 - $posiciony) {
        $new2pa = $posicionx - (7 - $posiciony);
        $new2pb = 7;
        for ($i = 0; $i < 8; $i++) {
            if ($new2pa + 7 - $i < 8) {
                $union2 = $letterArray[$i] . $numberArray[$new2pa + 7 - $i];
                array_push($bagof, $union2);
            }
        }
    } else {
        $new2pa = 0;
        $new2pb = $posicionx + $posiciony;
        for ($i = 0; $i < 8; $i++) {
            if ($new2pa + 7 - $i < 8) {
                if ($new2pb - $i > -1) {
                    $union2 = $letterArray[$i] . $numberArray[$new2pb - $i];
                    array_push($bagof, $union2);
                }
            }
        }
    };
    array_unique($bagof);
    return $bagof;
}
function makeDama($pieza, $posicionx, $posiciony)
{
    $bagof = array();
    $bagofTorre = makeAlfil($_GET["pieza"], $posicionx, $posiciony);
    $bagofAlfil = makeTorre($_GET["pieza"],  $posicionx, $posiciony);
    foreach ($bagofTorre as $item) {
        array_push($bagof, $item);
    }
    foreach ($bagofAlfil as $item) {
        array_push($bagof, $item);
    }


    array_unique($bagof);
    return $bagof;
}
function makeCaballo($pieza, $posicionx, $posiciony)
{
    $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
    $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
    $bagof = array();
    // SALTOS DEL CABALLO
    if ((($posicionx - 2 >= 0) && ($posiciony + 1 <= 7))) {
        $newP1 = $letterArray[$posicionx - 2] . $numberArray[$posiciony + 1];
        array_push($bagof, $newP1);
    }
    if ((($posicionx - 2 >= 0) && ($posiciony - 1 >= 0))) {
        $newP2 = $letterArray[$posicionx - 2] . $numberArray[$posiciony - 1];
        array_push($bagof, $newP2);
    }
    if ((($posicionx + 2 <= 7) && ($posiciony + 1 <= 7))) {
        $newP3 = $letterArray[$posicionx + 2] . $numberArray[$posiciony + 1];
        array_push($bagof, $newP3);
    }
    if ((($posicionx + 2 <= 7) && ($posiciony - 1 >= 0))) {
        $newP4 = $letterArray[$posicionx + 2] . $numberArray[$posiciony - 1];
        array_push($bagof, $newP4);
    }
    if ((($posicionx + 1 <= 7) && ($posiciony - 2 >= 0))) {
        $newP5 = $letterArray[$posicionx + 1] . $numberArray[$posiciony - 2];
        array_push($bagof, $newP5);
    }
    if ((($posicionx - 1 >= 0) && ($posiciony - 2 >= 0))) {
        $newP6 = $letterArray[$posicionx - 1] . $numberArray[$posiciony - 2];
        array_push($bagof, $newP6);
    }
    if ((($posicionx + 1 <= 7) && ($posiciony + 2 <= 7))) {
        $newP7 = $letterArray[$posicionx + 1] . $numberArray[$posiciony + 2];
        array_push($bagof, $newP7);
    }
    if ((($posicionx - 1 >= 0) && ($posiciony + 2 <= 7))) {
        $newP8 = $letterArray[$posicionx - 1] . $numberArray[$posiciony + 2];
        array_push($bagof, $newP8);
    }

    array_unique($bagof);
    return $bagof;
}
function makeRey($pieza, $posicionx, $posiciony)
{
    $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
    $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
    $bagof = array();
    // Direcciones
    // Hacia arriba
    // isset soluciona todos los problemas
    for ($i = -1; $i < 2; $i++) {
        for ($j = -1; $j < 2; $j++) {
            if (isset($letterArray[$posicionx + $i]) && isset($numberArray[$posiciony + $j])) {
                $union1 = $letterArray[$posicionx + $i] . $numberArray[$posiciony + $j];
                array_push($bagof, $union1);
            }
        }
    }

    // 


    array_unique($bagof);
    return $bagof;
}
function makePeon($pieza, $posicionx, $posiciony)
{
    $letterArray = array("A", "B", "C", "D", "E", "F", "G", "H");
    $numberArray = array("1", "2", "3", "4", "5", "6", "7", "8");
    $bagof = array();
    for ($i = -1; $i < 2; $i = $i + 2) {
        if (isset($letterArray[$posicionx + $i]) && isset($numberArray[$posiciony + 1])) {
            $union1 = $letterArray[$posicionx + $i] . $numberArray[$posiciony + 1];
            array_push($bagof, $union1);
        }
    }
    array_unique($bagof);

    return $bagof;
}
?>