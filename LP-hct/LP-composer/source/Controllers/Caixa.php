<?php

namespace Source\Controllers;

use Source\Controllers\Controller;

class Caixa extends Controller
{
    private $valorTotal;
    private $pgTotalCliente;
    private $valorTroco;
    private $auxTroco;
    public function __construct($router)
    {
        parent::__construct($router);
    }
    /**
     * @param mixed $data
     * 
     * @return void
     */
    public function caixaCalc($data): void
    {
        $produtos = filter_var_array($data['valorProduto'], FILTER_SANITIZE_STRIPPED);
        // validação 
        if (in_array('', $produtos)) {
            echo $this->ajaxResponse(["message" => ["type" => "error", "message" => "Preeancha todos os campos para fazer calculo dos produtos"]]);
            return;
        }

        // fomato dinheiro (string) para decimal com array
        $produtos = $this->formtNormal($produtos);
        // somar os valores do array
        $valorTotal = array_sum($produtos);
        //  fazer o arredondamento do pagamento do cliente
        $this->PagamentoCliente((float) $valorTotal);
        // retorna as notas para troco
        $log = $this->Troco();
        // retorna para ajax via json
        echo $this->ajaxResponse(['message' => ['message' => 'Sucesso ao calcular o troco', 'type' => 'success'], 'result' => $log['result'], 'methodType' => $log['methodType'], 'cod' => $log['cod']]);
    }
    /**
     * @return array
     */
    public function Troco(): array
    {

        $log['cod'] = 1;
        $log['methodType'] = 'troco';
        // $notas = [100.0, 50.0, 20.0, 10.0, 5.0, 2.0, 1.0, 0.5, 0.25, 0.10, 0.05];

        // $ContNotas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $ContNotas = ["100.0" => 0, "50.0" => 0, "20.0" => 0, "10.0" => 0, "5.0" => 0, "2.0" => 0, "1.0" => 0, "0.50" => 0, "0.25" => 0, "0.10" => 0, "0.05" => 0];
        $notas = array_keys($ContNotas);
        $troco = (float) $this->pgTotalCliente - (float) $this->valorTotal;

        $this->valorTroco = number_format($troco, 2);
        $this->auxTroco = $this->valorTroco;

        $indice = 0;

        while ($indice < count($notas) and $this->valorTroco != 0) {


            // encontrar primeira nota do troco



            while ($indice < count($notas) and $this->valorTroco < (float) $notas[$indice]) {


                $indice++;
            }


            if ($indice < count($notas)) {
                $nota = number_format($notas[$indice], 2);
                // descontar o valor do troco com a nota achada
                $this->valorTroco = number_format($this->valorTroco, 2) - $nota;
                // somar quantas notas precisa 
                $ContNotas[$notas[$indice]] += 1;
            }



            // fazer o arredondar do centavos restantes 
            if ($this->valorTroco >= 0.03 && $this->valorTroco < 0.05) {
                $this->valorTroco = 0.05;
            } else if ($this->valorTroco >= 0.01 && $this->valorTroco <= 0.02 && $this->valorTroco < 0.03 || $this->valorTroco < 0.01) {
                $this->valorTroco = 0;
            }
        }
        // retornar um array com formatação de dinheiro e retonar as notas e contas notas de troco
        $log['result']['valorCompra'] = $this->formtMoney($this->valorTotal);
        $log['result']['dinheiroCliente'] = $this->formtMoney($this->pgTotalCliente);
        $log['result']['troco'] = $this->formtMoney($this->auxTroco);
        $log['result']['contNotas'] = $ContNotas;
        $log['result']['notas'] =  $this->formtMoneyArr($notas);

        return $log;
    }
    /**
     * @param mixed $valorTotal
     * 
     * @return void
     */
    public function PagamentoCliente($valorTotal): void
    {
        $this->valorTotal = $valorTotal;
        $rest = ceil($valorTotal / 100);
        $result = $rest * 100;

        $this->pgTotalCliente = $result;
    }
}