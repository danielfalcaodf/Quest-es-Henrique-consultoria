# HCT -Teste Prático - PHP 7.3.9 - Composer MVC

Como eu ja fiz este mesmo teste, eu fiz umas melhorias deixei duas branches para comparar.

## Resolução do problema - LP

#### Caixa.php

- caixaCalc()

Este método e chamado na requisição via ajax e faz validação, transformado de string em float, soma todos os produtos do array, método arredondamento do dinheiro do cliente `PagamentoCliente()`, método de verifica as notas a retornar ao cliente `Troco()` e retorna um JSON

```php
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
        if (!@$log['result']) {
            # code...
            echo $this->ajaxResponse(['message' => ['message' => "Ops erro interno ", 'type' => 'error']], 500);
            return;
        }
        echo $this->ajaxResponse(['message' => ['message' => 'Sucesso ao calcular o troco', 'type' => 'success'], 'result' => $log['result'], 'methodType' => $log['methodType'], 'cod' => $log['cod']]);
    }
```

- PagamentoCliente()

Método arredondamento do dinheiro do cliente e seta os valores total do cliente e da compra

```php
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
```

- Troco()

Um método que inicia array de indice com as notas e valores as quantidade, eu vejo o troco com variável `$this->valorTroco` e coloco em variável auxiliar `$this->auxTroco`, depois uso `while` ele se repete até `$this->valorTroco` ficar a 0, logo verifico se o troco é menor que nota se for o `while` repete até achar a nota que não é menor que troco e com isso pega a nota achada e desconta no troco e somar a quatidade da nota e retorno um array.

```php
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
            if (number_format($this->valorTroco, 2) >= 0.03 && number_format($this->valorTroco, 2) < 0.05) {
                $this->valorTroco = 0.05;
            } else if (number_format($this->valorTroco, 2) >= 0.01 && number_format($this->valorTroco, 2) <= 0.02 && number_format($this->valorTroco, 2) < 0.03 || number_format($this->valorTroco, 2) < 0.01) {
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
```

## Resolução do problema - BD

#### HCT-BD/index.php

Arquivo `config.php` esta a configuraçao do banco e `database.php` e um class com métodos com conexao no banco, este métodos retorna um array com as chaves `'result'` que mostra retorno do banco, `'message'` e `'error' ` uma messagem do banco e o problema e `'cod'` retorna 0 ou 1 (0 para erro e 1 não deu erro).

```php
    include './config.php';
    include './database.php';

    $db = new Banco();
    $log = $db->getLog();
    $log['Insert'] = $db->insertDB('cadastro', ['nome' => 'Teste Teste','email'=>'teste@teste.com','estado' => 'SP', 'comentarios'=> 'Desativado']);
    $log['Questao 2'] = $db->selectDB('cadastro');
    $log['Questao 3'] = $db->selectDB('cadastro', ['estado' => 'SP']);
    $log['Questao 5'] = $db->selectQueryDB("SELECT distinct email FROM cadastro");
    $log['Questao 6'] = $db->updateDB('cadastro', ['nome'=> 'XX'],['estado'=>'SP']);
    $log['Questao 4'] = $db->forceDeleteWhereDB('cadastro', ['estado' => 'SP', 'comentarios'=> 'Desativado']);
    echo json_encode($log);
```

## Requisitos

- [Composer](https://getcomposer.org/ "Composer");
- Extensão `extension=php_intl.dll`;
  > Configurar o apache no arquivo `php.ini` na ultima linha colocar esta configuração `extension=php_intl.dll`

## Instalação

- Clonagem da branche usando `git clone` ou Download zip na pasta do localhost;
  > se for Zip renomear a pasta `TestePratico-Henrique-consultoria-master` para `TestePratico-Henrique-consultoria`;
- Acessar a raiz do projeto com CMD executar o comando `cd .\LP-hct\LP-composer\` ;
- Logo depois executar o comando `composer install` ;
- Esta pronto para rodar no servidor
