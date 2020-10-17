
<?php
class Caixa
{
    private $valorCompraTotal;
    private $valorPagoCliente;
    private $valorTroco ;
    private $valorTrocoCopia;
    public function __construct($valorCompraTotal)
    {
        $this->valorCompraTotal = $valorCompraTotal;
        // $this->valorPagoCliente = $valorPagoCliente;
         


    }

    public function getValor()
    {
    	return $this->valorCompraTotal;
    }
    public function setValor($valor)
    {
        $this->valorCompraTotal = $valor;
    }
    public function Troco()
    { $notas = [100.0,50.0,20.0,10.0,5.0,2.0,1.0,0.5,0.25,0.10,0.05];
      
        $ContNotas = array(0,0,0,0,0,0,0,0,0,0,0,0);
        $dadoValor = number_format($this->valorPagoCliente,2) - number_format($this->valorCompraTotal,2);
		$this->valorTroco=number_format($dadoValor,2);
        $this->valorTrocoCopia = $this->valorTroco;
        
       
        $indice=0;
        while($this->valorTroco!=0)
        {
   
         
            // econtra primeira nota do troco
            while($this->valorTroco<$notas[$indice])
            {    
              
                $indice++;
            }
          
  
             $nota1 =$notas[$indice];
            $nota2 = number_format($nota1,2);
            $this->valorTroco= number_format($this->valorTroco,2)-$nota2;
            $ContNotas[$indice]+=1;
                  
            if($this->valorTroco>=0.03 && $this->valorTroco<0.05 )
            {
                $this->valorTroco = 0.05;
              
            }

           else if($this->valorTroco>=0.01 && $this->valorTroco<=0.02&& $this->valorTroco<0.03 || $this->valorTroco<0.01)
            {
               $this->valorTroco = 0;
            }
          
         
        }
        
      
        echo  '<div class="fundo-pai">
        		<div class="fundo-form">
        		<div class="row">
                <div class="col-xl">
                    <div class="col-12">
                    <label for="valor" class="font-weight-bolder  col-form-label col-form-label-lg">
        		Valor da Compra: R$ '.number_format($this->valorCompraTotal,2,',','.').'</label><br>
        		<label for="valor" class="font-weight-bolder  col-form-label col-form-label-lg">
        		Valor dado pelo Cliente: R$ '.number_format($this->valorPagoCliente,2,',','.').'</label><br>

				<label for="valor" class="font-weight-bolder  col-form-label col-form-label-lg">
        		Valor do troco: R$ '.number_format($this->valorTrocoCopia,2,',','.').'</label>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Moeda/Cédula</th>
                            <th scope="col">Quantidade</th>
                        </tr>
                    
                    </thead>';
                    echo'<tbody>';//inicia tabela
                    $i=0;
            
                    $totcalunas=1;
                    $totlinhas=11 ;
                    
                    for ($l=0;$l<$totlinhas;$l++){//criar linha
                        echo "<tr>";
                        for ($c=0;$c<$totcalunas;$c++){
                        	
                        echo '<td> R$'.number_format($notas[$l],2,',','.').'</td>';
                        	
                             	 echo '<td>'.$ContNotas[$l].'</td>';
                             
                               
                        
                        }
                    echo"</tr>";
                    }
                    echo'</tbody>
                        </table>
                        </div>
                    
	                 
                         </div>';
                        //  if($ContNotas[i]>0)
                        //  {
                        //      echo 
                        //  }
               
      
    }
    public function Pagamento($valorTotal)
    {
        $rest = ceil($valorTotal/100);
        $result = $rest*100;
      
        $this->valorPagoCliente = $result;
        
    }
	public function moeda($get_valor) {
	
		$valor = str_replace(',', '.', $get_valor);
		return $valor; 
}

    


}
?>

