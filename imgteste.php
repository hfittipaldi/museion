<script>
function valida()
{
with(document.form1)
{
 if (imagem.value != "") 
 {  
   arquivo = (imagem.value); 
     tipo = arquivo.substring(arquivo.length-4,arquivo.length); 
     tipo = tipo.toLowerCase() 
       if ((tipo == "jpeg") || (tipo == ".jpg") || (tipo == ".gif") || (tipo == ".bmp"))
	    {
		 submit();
	    }
	    else 
	     { 
          alert("Arquivo invalido"); 
          imagem.focus(); 
          return false; 
         } 

 } 
}
}
</script>
<form  name="form1"enctype="multipart/form-data" action="imgteste2.php" method="POST" onSubmit="return valida()">
<input type="hidden" name="MAX_FILE_SIZE" value="30000">
Send this file: <input name="imagem" type="file">
<input type="submit" value="Enviar Arquivo">
</form>

