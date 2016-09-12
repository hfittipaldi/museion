<?
include_once("seguranca.php");
include("classes/classe_padrao.php");
include("classes/funcoes_extras.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?
$db= new conexao(); 
$db->conecta();
  function troca_de_pg()
  {
    $acao=$_REQUEST[acao];
     if($acao=='I'){
	  echo" cadprev_obra.php";
	 }
	 elseif($acao=='A'){
	 echo "alterar_obra.php";}
}
?>
<title><? echo nome_instituicao(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">

body {
margin:0;
padding:0;
background:#ffffff;
text-align:center; /* hack para o IE */	
	}
</style>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<link href="css/home.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="tudo">
  <table width="750" height="185"  border="0" cellpadding="0" cellspacing="0">
    <tr>
      <th height="89" background="imgs/topo_interno.jpg" scope="col">
        <div id="tit_museu_int"><? echo nome_instituicao() ?></div>
        <div id="sombra_tit_int"><? echo nome_instituicao() ?></div>	
	  <div align="right">
	      <div id="nome_login"><? echo "$_SESSION[snome]"; echo"&nbsp"; echo"<a href=\"logout.php\" onClick='return confirm(".'"Confirma encerramento da sessão ?"'.")'><img src=imgs/icons/btn_sair.gif border='0'></a>"; ?></div>
      </div></th>
    </tr>
    <tr>
      <td height="460" valign="top" background="imgs/fundo_interno.jpg"><table width="100%" height="460"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th height="34" valign="top" scope="col"><iframe src="<? troca_de_pg(); ?>" name="paginas" width="750" height="460" frameborder="0" scrolling="auto" ALLOWTRANSPARENCY="true"></iframe>&nbsp;</th>
          </tr>
      </table></td>
    </tr>
  </table>

</div>
</body>
</html>
