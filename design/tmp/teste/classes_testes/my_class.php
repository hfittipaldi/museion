<?

# para esse arquivo daremos o nome de mysql_class.php

class TMySQL { 

 var $host='192.168.0.135';    // qual o servidor

 var $db='bd_donato';      // qual a base

 var $user='root';    // qual o username

 var $pass='visao03';    // qual a senha

 var $socket;  //socket da conexao com o banco

 function connect($host, $db, $user, $pass) {

  $this->host = $host;

  $this->db = $db;

  $this->user = $user;

  $this->pass = $pass;

  $this->socket=mysql_connect($this->host,$this->db,$this->user,$this->pass);

  if (!$this->socket) {

    echo "Não foi possível conectar-se ao Bando de Dados MySQL";

  }

  else

  {

  if (!mysql_select_db($this->db,$this->socket)){

    echo "Banco de dados não encontrado";

  }

  else

  {

    echo "Banco de dados conectado!";

  }

  }

 }

}

?>

