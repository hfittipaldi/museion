<?
class  conexao {
    var $host = "192.168.0.135";
    var $user = "root";
    var $pass = "visao03";
    var $db = "bd_donato";
    var $socket;
   function conecta() {
      $this->socket = mysql_connect ($this->host,$this->user,$this->pass); // aqui declaramos a var conn como variável da classe
      mysql_select_db ( $this->db, $this->socket); 
      // esse "$this->" ele e utilizado para referenciar uma variável da classe
   }
  }
$con=new conexao();
$con->conecta();
  
?>

