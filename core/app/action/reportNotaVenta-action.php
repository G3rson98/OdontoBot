<?php
    
	$id_historial=$_GET["id_historial"];
	$id_consulta=$_GET["id_consulta"];
	$id_ficha=$_GET["id_ficha"];
	$id_paciente=$_GET["id_paciente"];

	$url = "http://localhost:8080/presentacion/core/app/reports/reporte/report_nota_venta.php?id_historial=".$id_historial."&id_consulta=".$id_consulta."&id_paciente=".$id_paciente."&id_ficha=".$id_ficha."";
	Core::redir($url);
?>
