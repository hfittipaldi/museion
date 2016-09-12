<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>


<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="AC_RunActiveContent.js" language="javascript"></script>



</head>

<body>

<?

echo '

<script language="javascript">
				if (AC_FL_RunContent == 0) {
					alert("This page requires AC_RunActiveContent.js.");
				} else {
					AC_FL_RunContent(
						"codebase", "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0",
						"width", "500",
						"height", "375",
						"src", "sources/rotateTool_blackDiamond_zoom",
						"quality", "high",
						"pluginspage", "http://www.macromedia.com/go/getflashplayer",
						"align", "middle",
						"play", "true",
						"loop", "true",
						"scale", "noScale",
						"wmode", "window",
						"flashVars", "dataFile=sources/'.$_REQUEST[id].'.zip",
						"devicefont", "false",
						"id", "rotateTool",
						"bgcolor", "#FFFFFF",
						"name", "rotateTool",
						"menu", "true",
						"allowFullScreen", "false",
						"allowScriptAccess","sameDomain",
						"movie", "sources/rotateTool_blackDiamond_zoom",
						"salign", "lt"
						); //end AC code
				}

				
			</script>';
?>

</body>
</html>