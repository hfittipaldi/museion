<?
session_name("Donato");
session_start();
if(!(session_is_registered("susuario")&& session_is_registered("snome"))) {       
 header("Location: index.php"); 
 exit; }
?>