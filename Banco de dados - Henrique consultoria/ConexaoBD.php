<?php
class ConexaoBD
{
    private $DB;
    private $sql;
    private $result;
public function __construct()
{
    $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
        $this->sql="create table cadastro
            (
             nome varchar (35) not null,
             email varchar (25) not null,
             cidade varchar (35)not null,
             estado varchar (2) not null,
             comentarios text not null
            ); ";
        if(!$this->result=$this->DB->query($this->sql))die("erro de criar");
        else
            echo"Tabela Criada!"."<br>";
    }
    $this->DB->close();
} 
public function SelectTodos()
{   
    $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
        $this->sql="select * from cadastro ";
        if(!$this->result=$this->DB->query($this->sql))die("erro de criar");
        else
        {
            while(true)
            {
                if($this->row=$this->result->fetch_assoc())
                {
                    
                    echo $this->$row["nome"]. "<br>";
                  
                
                }
                else{
					echo "Falta os dados"."<br>";
                    break;
                }
            }    
        }
        $this->DB->close();
        }
}
public function SelectPorEstados()
{
      $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
		$this->sql="select * from cadastro where estado='SP'";

		if(!$this->result=$this->DB->query($this->sql))die("erro de criar");
		else
		{
			while(true)
			{
				if($this->row=$this->result->fetch_assoc())
				{
					
					echo $this->row["*"]. "<br>";
				
				}
				else{
					echo "Falta os dados"."<br>";
					break;
				}
			}
						
		}
		$this->DB->close();
	}
}
public function delete()
{      $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
		$this->sql="delete from cadastro where estado='SP' and comentarios='Desativado';";
				if(!$this->result=$this->DB->query($this->sql)) die("erro..");	
				else
				{					
					echo "Excluido"."<br>";
				}
				$this->DB->close();
	}
}
public function Selectdistinct()
{
        $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
		$this->sql="select distinct email from cadastro";
		if(!$this->result=$this->DB->query($this->sql))die("erro de criar");
		else
		{
			while(true)
			{
				if($this->row=$this->result->fetch_assoc())
				{
					
					echo $this->row["email"]. "<br>";
				
				}
				else{
					echo "Falta os dados"."<br>";
					break;
				}
			}    
		}
		$this->DB->close();
	}
}
public function update()
{
     $this->DB=new mysqli("localhost","root","","teste");

    if($this->DB->connect_error>0)die("erro de conexão");
    else
    {
		$this->sql="update cadastro set nome='XX'";
				if(!$this->result=$this->DB->query($this->sql)) die("erro..");	
				else
				{					
					echo "Alterado"."<br>";
				}
				$this->DB->close();
	}
}



}


?>