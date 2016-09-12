<?
 class conexao
 {
        var $host="localhost";
        
        var $user="fayga_donato";

        var $pass = "azsxdcfv";

        var $db="fayga_donato";

        var $result;

        var $link;

        var $row;
		
		var $Errno    = 0;
          
	    var $Error    = "";
	    
	    var $Halt_On_Error = "yes";
		
		
        function conecta()
        {
         $this->link = mysql_connect($this->host,$this->user,$this->pass) or die ("Configuracao de Banco de Dados Errada!");
         mysql_select_db($this->db,$this->link);
         mysql_set_charset('utf8');
        }

        function query($sql){


            $this->result = mysql_query($sql);

            
///////////////
           $this->Row   = 0;
           $this->Errno = mysql_errno();
           $this->Error = mysql_error();
           if (!$this->result) {
	           $this->halt();
			}
           return $this->result;
//////////////
        }

function halt() {
    $this->Error = @mysql_error($this->link);
    $this->Errno = @mysql_errno($this->link);
    if ($this->Halt_On_Error == "no")
      return;

    $this->haltmsg();
  }

 function haltmsg() {
//	printf ("ERRO %s - %s",$this->Errno,$this->Error);
	$msgerro= str_replace("'","´",$this->Error);
	echo "<script>alert('ERRO $this->Errno:\\n $msgerro');</script>";
  }
  
     
	 function dados()
		{

            $linha = mysql_fetch_array($this->result);

            return $linha;

        }

        function contalinhas(){
        //Funciona apenas para SELECT's!

            $linhas = mysql_num_rows($this->result);

            return $linhas;

        }
		
		function affected()
		{
		   $rows=mysql_affected_rows($this->link);
		  
		  return $rows;
		}
        
		function lastid()
		{
		 //retorna o id corrente apos um insert
		  $rowid=mysql_insert_id($this->link);
		  return $rowid;
		}
	  
	   function f()
	   {
	     $row=mysql_num_fields($this->result);
		 return $row;
		}
	   
        function fechar(){


            mysql_close($this->link);

        }

        function liberar(){


            mysql_free_result($this->result);

        }

    }
?>
