<?php
include("../includes/common.php");

$uploaddir = '../uploads/';
$uploadfile = $uploaddir . $_FILES['f_arquivo']['name'];
$uploadimage = $uploaddir . $_FILES['f_imagem']['name'];

print "<pre>";
print "Descrição: " . $_POST["f_descricao"] . "\n\n";

if (move_uploaded_file($_FILES['f_arquivo']['tmp_name'], $uploadfile)) {
    print "O arquivo é válido e foi carregado com sucesso.\n\n";
} else {
    print "Erro durante o upload do arquivo!\n\n";
}

if (move_uploaded_file($_FILES['f_imagem']['tmp_name'], $uploadimage)) {
    print "A imagem é válida e foi carregado com sucesso.\n\n";
} else {
    print "Erro durante o upload da imagem!\n\n";
}

print_r($_FILES);
print "</pre>";