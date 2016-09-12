<?php
require("class.grid.phtml");
$grid = new grid();
$grid->titles = Array("Menu_item", "Menu_nome", "Chamada", "Posicao","Ordenacao");
$grid->colsOrder =Array("Menu_item", "Menu_nome", "Chamada", "Posicao","Ordenacao");
$grid->colsSize = Array(180, 220, 100, 80);
$grid->titlesBgColor = "649db4";
$grid->titlesOffColor = "accad7";
$grid->titlesOnColor = "ffc0000";
$grid->listColor = "EFEFEF";
$grid->selectedRow = "99cea7";
$grid->overRow = "CECECE";
$grid->eraseCol = 1;
$grid->show("Select menu_item, menu_nome, chamada, posicao, ordenacao from menu_item");
?>

