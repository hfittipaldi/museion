<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<script language="JavaScript1.2" src="js/coolmenus4.js"></script> 
 

</head>
<body>
<style>
/* CoolMenus 4 - default styles - do not edit */
.clCMAbs{position:absolute; visibility:hidden; left:0; top:0}
/* .clCMAbs{position:absolute; visibility:hidden; left:0; top:0}           
/* CoolMenus 4 - default styles - end */
/* Obs: Tudo q estiver com comentÃ¡rio Ã© o original do css. 
/*Style for the background-bar*/
.clBar{position:absolute; width:10; height:10; background-color:#b4c6c8; layer-background-color:#b4c6c8; visibility:hidden;}
/*clBar{position:absolute; width:10; height:10; background-color:Navy; layer-background-color:Navy; visibility:hidden}*/

/*Styles for level 0*/
.clLevel0{text-align:center; position:absolute; padding:2px; font-family:arial,arial narrow, helvetica; font-size:13px; font-weight:normal}
.clLevel0over{text-align:right; position:absolute; padding:2px; font-family:arial,arial narrow, helvetica; font-size:12px; font-weight:bold; font-style:italic}
/*.clLevel0{background-color:Navy; layer-background-color:Navy; color:white;}*/
.clLevel0{color:#596E83;}
/*.clLevel0over{background-color:#336699; layer-background-color:#336699; color:Yellow; cursor:pointer; cursor:hand; }*/
.clLevel0over{background-color:; layer-background-color:; color:black; cursor:pointer; cursor:hand}
/*.clLevel0over{background-color:#336699; layer-background-color:#336699; color:Yellow; cursor:pointer; cursor:hand; }*/
/*.clLevel0border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}*/
.clLevel0border{position:absolute; visibility:hidden; background-color:; layer-background-color:}

/*Styles for level 1*/
.clLevel1{text-align:left; position:absolute; padding:3px; font-family:arial,arial narrow, helvetica; font-size:12px; font-weight:normal}
.clLevel1over{text-align:center; position:absolute; padding:3px; font-family:arial,arial narrow, helvetica; font-size:11px; font-weight:bold; font-style:italic}
/*.clLevel1{background-color:Navy; layer-background-color:Navy; color:white;}*/
.clLevel1{background-color:#ffffff; layer-background-color:#b4c6c8; color:black}
.clLevel1over{background-color:#596E83; layer-background-color:#596E83; color:white; cursor:pointer; cursor:hand; }
/*.clLevel1border{position:absolute; visibility:hidden; background-color:#006699; layer-background-color:#006699}*/
.clLevel1border{position:absolute; visibility:visible; background-color:#ffffff; layer-background-color:#b4c6c8; border-left:1px solid black; border-top:1px solid black}

/*Styles for level 2*/
.clLevel2{text-align:left; position:absolute; padding:3px; font-family:arial,arial narrow, helvetica; font-size:11px; font-weight:normal}
.clLevel2over{text-align:center; position:absolute; padding:3px; font-family:arial,arial narrow, helvetica; font-size:11px; font-weight:normal; font-style:italic}
.clLevel2{background-color:#ffffff; layer-background-color:#b4c6c8; color:black;}
.clLevel2over{background-color:#596E83; layer-background-color:#596E83; color:white; cursor:pointer; cursor:hand; }
.clLevel2border{position:absolute; visibility:visible; background-color:#ffffff; layer-background-color:#b4c6c8;  border:1px solid black}
</style>

<script language="javascript" type="text/javascript">

// Previne erro de alinhamento Ã  direita no FireFox (para resoluÃ§Ã£o 1024x768)
if (navigator.userAgent.toLowerCase().indexOf('firefox')+1) {
	CMfromLeft		= 160
	CMfromTop		= 135
} else {
	CMfromLeft		= 10
	CMfromTop		=-150
}

oCMenu=new makeCM("oCMenu")
oCMenu.pxBetween=5
oCMenu.fromLeft=CMfromLeft
oCMenu.fromTop=CMfromTop 
oCMenu.rows=0 
oCMenu.menuPlacement="0"
                                                             
oCMenu.offlineRoot="file:///C|/Inetpub/wwwroot/dhtmlcentral/projects/coolmenus/examples/" 
oCMenu.onlineRoot="" 
oCMenu.resizeCheck=1
oCMenu.wait=300
oCMenu.fillImg="cm_fill.gif"
oCMenu.zIndex=0

//Background bar properties
oCMenu.useBar=0
oCMenu.barWidth="menu"
oCMenu.barHeight="menu" 
oCMenu.barClass="clBar"
oCMenu.barX="menu"
oCMenu.barY="menu"
oCMenu.barBorderX=0
oCMenu.barBorderY=0
oCMenu.barBorderClass=""

//Level properties - ALL properties have to be spesified in level 0
oCMenu.level[0]=new cm_makeLevel() //Add this for each new level
oCMenu.level[0].width=80

oCMenu.level[0].height=25 
oCMenu.level[0].regClass="clLevel0"
oCMenu.level[0].overClass="clLevel0over"
oCMenu.level[0].borderX=1
oCMenu.level[0].borderY=1
oCMenu.level[0].borderClass="clLevel0border"
oCMenu.level[0].offsetX=0
oCMenu.level[0].offsetY=0
oCMenu.level[0].rows=0
oCMenu.level[0].arrow=0
oCMenu.level[0].arrowWidth=0
oCMenu.level[0].arrowHeight=0
oCMenu.level[0].align="right"

//EXAMPLE SUB LEVEL[1] PROPERTIES - You have to specify the properties you want different from LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[1]=new cm_makeLevel() //Add this for each new level (adding one to the number)
//oCMenu.level[1].width=oCMenu.level[0].width-2
oCMenu.level[1].width=150
oCMenu.level[1].height=22
oCMenu.level[1].regClass="clLevel1"
oCMenu.level[1].overClass="clLevel1over"
oCMenu.level[1].borderX=1
oCMenu.level[1].borderY=1
oCMenu.level[1].align="right" 
oCMenu.level[1].offsetX=-(oCMenu.level[0].width-2)/2+20
oCMenu.level[1].offsetY=0
oCMenu.level[1].borderClass="clLevel1border"
/*
oCMenu.level[1]=new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[1].width=150
oCMenu.level[1].height=20
oCMenu.level[1].offsetX=0
oCMenu.level[1].offsetY=0
oCMenu.level[1].regClass="clLevel2"
oCMenu.level[1].overClass="clLevel2over"
oCMenu.level[1].borderClass="clLevel2border"*/

//EXAMPLE SUB LEVEL[2] PROPERTIES - You have to spesify the properties you want different from LEVEL[1] OR LEVEL[0] - If you want all items to look the same just remove this
oCMenu.level[2]=new cm_makeLevel() //Add this for each new level (adding one to the number)
oCMenu.level[2].width=150
oCMenu.level[2].height=20
oCMenu.level[2].offsetX=0
oCMenu.level[2].offsetY=0
oCMenu.level[2].regClass="clLevel2"
oCMenu.level[2].overClass="clLevel2over"
oCMenu.level[2].borderClass="clLevel2border"
</script>

<?php
 include("menu.php"); 
?>
<script>
oCMenu.construct()		
</script>
</body>
</html>