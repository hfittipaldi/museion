<?php
    include_once("seguranca.php");

   include("classes/classe_padrao.php");
   include("classes/funcoes_extras.php");

   $db=new conexao();
   $db->conecta();
   $mold_registro=$_REQUEST[mold_registro];
   $op=$_REQUEST[op];
   $obra=$_REQUEST[obra];
   $parte=$_REQUEST[parte];

/////////////////////////////////////////////////////////////////////////
////////////////// DOWNLOAD ///////////////////////////////////////////
///////////////////////////////////////////////////////////////////
   $sql="SELECT moldura from moldura where mold_registro='mold_registro'";
   $db->query($sql);
   $row=$db->dados();

   if ($row[moldura]<>'') 
   { 
    echo"<script>alert('Moldura já existe!');location.href= 'parte_obra_dimensoes.php?op=$op&obra=$obra&parte=$parte&moldura=$moldura';      
           </script>";     
  }















?>