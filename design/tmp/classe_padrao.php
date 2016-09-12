<?
 class conexao
 {
        var $host="192.168.0.135";
        
        var $user="root";

        var $pass = "visao03";

        var $db="donato";

        var $result;

        var $link;

        function conecta()
        {

         $this->link = mysql_connect($this->host,$this->user,$this->pass) or die ("Configuracao de Banco de Dados Errada!");
         mysql_select_db($this->db,$this->link);
        }

        function query($sql){


            $this->result = mysql_query($sql) or die ("Erro ao executar query");

            return $this->result;

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


        function fechar(){


            mysql_close($this->link);

        }

        function liberar(){


            mysql_free_result($this->result);

        }

    }
?>
