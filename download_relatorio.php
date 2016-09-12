<?php
    include_once("seguranca.php");

   include("classes/classe_padrao.php");
   include("classes/funcoes_extras.php");
    

   $db=new conexao();
   $db->conecta();
   $filex=str_replace(" ", "", $_SESSION[snome]);
   $filey=$filex."01.html";
   $filex=$filex.".html";
   $sqldir="SELECT valor from parametro where parametro='DIR_TEMP'";
   $db->query($sqldir);
   $url=$db->dados();
   $file=$url[0].$filex; 
   //$filex=$filey;
   $num=$_REQUEST[num];
   $txtpesquisa_rel=$_REQUEST[txtpesquisa_rel];
   $modeloR=$_REQUEST[modelo];
   $usuario=$REQUEST[usuario];
   
   $porpagina=$_REQUEST[porpagina];
   $iniciar=$_REQUEST[iniciar];
   $de=$_REQUEST[de];
   $ate=$_REQUEST[ate];
   $rodape=$_REQUEST[rodape];
   $tridimencional=$_REQUEST[tridimencional];
   $traducao=$_REQUEST[traducao];
   $total=$_REQUEST[total];
   $comimagem=$_REQUEST[comimagem];
   $info_filtro=$_REQUEST[info_filtro];
   $modelo2=$_REQUEST[modelo2];
   $tfonta=$_REQUEST[tfa];
   $tfont=$_REQUEST[tf];
 

    
/////////////////////////////////////////////////////////////////////////
////////////////// DOWNLOAD ///////////////////////////////////////////
///////////////////////////////////////////////////////////////////

   if (file_exists($file)) 

   { header("Content-Type: text/html");
     header("Content-Description: File Transfer");
     header("Content-Length:".filesize($file)); 
     header('Content-Disposition: attachment; filename="' . $filex . '"'); 
     header("Content-Transfer-Encoding: binary");
     header('Expires: 0'); 
     header('Pragma: no-cache'); 
     $fp = fopen("$file", "r"); 
     fpassthru($fp); 
     fclose($fp); 
    }else{
       unset($_SESSION['paginas']);
    }



?>