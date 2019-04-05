<?php
require "ConexaoBD.php";
echo "Questao 7 ";
$NovoBanco = new  ConexaoBD();

echo "Questao 2 ";
$NovoBanco->SelectTodos();
echo "Questao 3 ";
$NovoBanco->SelectPorEstados();
echo "Questao 4 ";
$NovoBanco->delete();
echo "Questao 5 ";
$NovoBanco->Selectdistinct();
echo "Questao 6 ";
$NovoBanco->update();










?>