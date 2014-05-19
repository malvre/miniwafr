<?php
include("../includes/common.php");

Security::verify(1);

$output = array();


$itens = array();

$step = 0;


$itens[0]["bloco"] = "Primeiro bloco";
$itens[0]["duracao"] = 3600;
$itens[0]["hora"] = 0 + $step; // 0h

$itens[1]["bloco"] = "Propaganda";
$itens[1]["duracao"] = 600;
$itens[1]["hora"] = 480 + $step; // 8h

$itens[2]["bloco"] = "Homeland";
$itens[2]["duracao"] = 7200;
$itens[2]["hora"] = 840 + $step; // 15h



$itens[3]["bloco"] = "Dexter";
$itens[3]["duracao"] = 3600;
$itens[3]["hora"] = 1020 + $step; // 18h

$itens[4]["bloco"] = "House";
$itens[4]["duracao"] = 3600;
$itens[4]["hora"] = 1080 + $step; // 19h

$itens[5]["bloco"] = "Breaking Bad";
$itens[5]["duracao"] = 3600;
$itens[5]["hora"] = 1200 + $step; // 21h



$output["itens"] = $itens;

echo json_encode($output);
