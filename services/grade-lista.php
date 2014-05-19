<?php
include("../includes/common.php");

function sec2hms ($sec, $padHours = false) {

    $hms = "";
    $hours = intval(intval($sec) / 3600); 
    $hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":" : $hours. ":";
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}

Security::verify(1);

$output = array();

$sql = "SELECT grade_programacao.*, programa.nome_programa, programa.duracao, TIME_FORMAT(SEC_TO_TIME(programa.duracao),'%Hh %im') as duracao_display ".
       "FROM grade_programacao, programa ".
       "WHERE grade_programacao.id_programa=programa.id ".
       "ORDER BY ordem ASC";

$rows = DBH::getRows($sql);
$itens = array();
$duracao_total = 0;
foreach ($rows as $row) {
	$row->duracao_total = $duracao_total;
	$row->duracao_total_display = sec2hms($duracao_total, true);
	$itens[] = $row;

	$duracao_total = $duracao_total + $row->duracao;
}

$output["itens"] = $itens;

echo json_encode($output);
