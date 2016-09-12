<?php

class conexao {
   var $id;
	var $res;
   var $row;
   var $nrw;
   var $data;
	
   function conexao($servidor="192.168.0.13", $usuario="root", $senha="visao03", $nomebd="bd_donato")	{
      $this->id = mysql_connect("$servidor", "$usuario", "$senha")  or die ("Problemas ao conectar ao banco de dados!");
      mysql_select_db("$nomebd") or die ("Problemas ao selecionar o banco de dados!");
		
   }

   function executa($sql="")	{
   //Executa uma query no bd e retorna os dados.
      if ($sql=="")	{
         $this->res = 0;
         $this->nrw = 0;
         $this->row = -1;
      } else {
         $this->res = mysql_query($sql, $this->id);
         if ($this->res)
            $this->nrw = mysql_num_rows($this->res);
         $this->row = 0;
      }
   }
	
   function manipula($sql="")	{
   //Executa uma query de DDL ou DML (manipulação de dados)
      return mysql_query($sql, $this->id);
   }

   function primeiro()	{
      $this->row = 0;
      $this->dados();
   }

   function proximo()	{
      $this->row = ($this->row < ($this->nrw - 1)) ? ++$this->row : ($this->nrw - 1);
      $this->dados();
   }

   function anterior()	{
      $this->row = ($this->row > 0) ? --$this->row : 0;
      $this->dados();
   }

   function ultimo()	{
      $this->row = $this->nrw - 1;
      $this->dados();
   }

   function navega($linha=1)	{
      if ($linha >= 0 AND $linha < $this->nrw)
   {
         $this->nrw = $linha;
         $this->dados();
      }
   }

   function dados()	{
      mysql_data_seek($this->res, $this->row);
      $this->data = mysql_fetch_array($this->res);
   }
}
?>
