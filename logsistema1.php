<?include_once("seguranca.php")?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/home.css" rel="stylesheet" type="text/css">
<link href="css/scroll_interno.css" rel="stylesheet" type="text/css">
</head>

<body >      
<table width="542" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor=#f2f2f2>
  <tr>
    <th width="519" scope="col"><div align="left" class="tit_interno">
	  <? 
require("classes/classe_padrao.php");
include("classes/funcoes_extras.php");

$db=new conexao();
$db->conecta();
echo $_SESSION['lnk'];
?>
</div></th>
  </tr>
  <tr height="20">
    <td valign="top"><form name="form1" method="post" >
<table width="100%"  border="0" cellpadding="0" cellspacing="4">
        <tr>
          <td class="texto_bold">&nbsp;</td>
          <td colspan="2" class="texto_bold">&nbsp;</td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="right">Usu&aacute;rio:</div></td>
          <td colspan="2" class="texto_bold"><input type="text"  readonly="true" class="combo_cadastro" value="<? echo $_REQUEST[user] ?>" size="40"></td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="right">Data:</div></td>
          <td colspan="2" class="texto_bold"><input name="textfield"  readonly="true" type="text" class="combo_cadastro" value="<? echo formata_data($_REQUEST[data]) ?>" size="12"></td>
        </tr>
        <tr>
          <td class="texto_bold"><div align="right">Opera&ccedil;&atilde;o:</div></td>
          <td 
             colspan="2" class="texto_bold">
	     <input name="textfield"  readonly="true" type="text" class="combo_cadastro" size="12" value="<? 
                                                                                                          if($_REQUEST[op]=='A'){echo "Alteração";}  
                                                                                                          if($_REQUEST[op]=='I'){echo "Inclusão";}  
                                                                                                          if($_REQUEST[op]=='E'){echo "Exclusão";} ?>">
		  </td>
        </tr>
        <tr>
          <td class="texto_bold">
             <div align="right">
              <? 
		 if($_REQUEST['autor']<>0)
                 { 
			echo "Autor: ";
		 } 
                 else 
                 { 
                        echo "Obra: "; 
                 }
              ?>
           </div></td>

          <td colspan="2" class="texto_bold"><input name="textfield"  readonly="true" type="text" class="combo_cadastro" value="
          <? 
             if($_REQUEST[autor]<>0)
             {
                $sql="select nomeetiqueta from autor where autor=$_REQUEST[autor]";
                $db->query($sql);
                $autor=$db->dados();
                echo htmlentities($autor[0], ENT_QUOTES);
             } 
             else
             {
                $sql="select titulo,num_registro from obra where obra=".$_REQUEST[obra];
                $db->query($sql);
                $obra=$db->dados();
                echo htmlentities($obra[0], ENT_QUOTES);
             } 
             ?>" size="80" ></td>
        </tr>

        <tr>
          <td class="texto_bold"><div align="right">Observa&ccedil;&atilde;o:</div></td>
          <td colspan="2" class="texto_bold">
          <?
               //
               // PRD10 - Criada textarea para apresentar observação (vindo de logisistema.php)
               //
               list($ob1,$ob2,$ob3,$ob4) = explode("}", $_REQUEST['obs']);
	       if ($ob3 <> "") {$ob3=$ob3.")";}
	       if ($ob4 <> "") {$ob4=$ob4.")";}

               echo "<textarea readonly='true' cols=52 rows=8 class='<combo_cadastro>'>".chr(13.10)."  ".$ob1.")".chr(13.10).$ob2.")".chr(13.10).$ob3.chr(13.10)."  ".$ob4."</textarea>";
          ?>
          </td>
        </tr>

        <tr>
          <td class="texto_bold"><div align="right"></div></td>
          <td colspan="2" class="texto_bold">&nbsp;</td>
        </tr>
        <tr>
          <td width="15%" class="texto_bold">&nbsp;</td>
          <td colspan="2" class="texto_bold">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="3">
          </span></td>
        </tr>
        <tr>
          <td colspan="2">
            <div align="left"><? echo "<a href=\"javascript:history.back();\"><img src='imgs/icons/btn_voltar.gif' width='20' height='20' border='0' alt='Voltar' >"?></div></td>
          <td width="53%">&nbsp;</td>
        </tr>
      </table>
      <br>
    </form>
	</td>
  </tr>
</table>
</body>
</html>
