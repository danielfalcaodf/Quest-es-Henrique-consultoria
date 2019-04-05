<?php
require "Caixa.php";

$produtos=$_GET["produto"];
if (empty($produtos)) echo "Desculpa... faltou usar botão mais";

else{
 $calc=array_sum($produtos);

 $Caixa01 = new Caixa(number_format($calc,2));


$Caixa01->Pagamento($Caixa01->getValor());

$Caixa01->Troco();
  }

?>

