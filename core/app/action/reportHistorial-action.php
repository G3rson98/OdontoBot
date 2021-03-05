<?php
	$PersonaArray=Persona::getpersonabyci($_GET["ci"]);
	$url = "http://localhost:8080/presentacion/core/app/reports/reporte/report_historial.php?ci=".$_GET["ci"]."";

	Core::redir($url);
?>
