<?php
	require_once('../vendor/autoload.php');
	require_once('../plantilla_reporte/plantilla_Receta.php');

	define('DB_HOST','localhost');
	define('DB_NAME','consultorio_dr_roblesvd');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_ENCODE','utf8');
	define('PRO_NOMBRE','ODONTOBOT');
	$con = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";", DB_USERNAME, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

	$id_paciente=$_GET["id_paciente"];
	$id_ficha=$_GET["id_ficha"];
	date_default_timezone_set('America/La_Paz');
	$fecha_actual=date('g:ia  d/m/y ');
	 //DATOS DEL ODONTOLOGO
	$sql="SELECT persona.nombre_per, persona.paterno, persona.telefono,persona.celular FROM odontologo,persona, ficha, agenda WHERE ficha.ci_pac=:id_paciente AND ficha.id_fic=:id_ficha AND ficha.id_agen=agenda.id_age AND odontologo.ci_odont=agenda.ci_odont AND persona.ci= odontologo.ci_odont;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_paciente",$id_paciente,PDO::PARAM_INT);
	$stmt->bindValue(":id_ficha",$id_ficha,PDO::PARAM_INT);
    $stmt->execute();
    $odontologo=$stmt->fetch();


	//DATOS DEL PACIENTE
	$sql="SELECT *FROM persona WHERE persona.ci=:id_paciente";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_paciente",$id_paciente,PDO::PARAM_INT);
    $stmt->execute();
    $paciente=$stmt->fetch();

	$fecha_nacimiento=$paciente["fecha_nac"];
	$fecha1=explode("-",$fecha_nacimiento);
	$fecha2=explode("-",date("Y-m-d"));
	$edad=$fecha2[0]-$fecha1[0];
	if ($fecha2[1]<=$fecha1[1] and $fecha2[2]<=$fecha1[2]) {
		$edad=$edad-1;
	}
	


	// RECETA
	$sql="SELECT* from receta WHERE receta.id_historial=:id_historial and receta.id_consulta=:id_consulta";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_historial",$_GET["id_historial"],PDO::PARAM_INT);
	$stmt->bindValue(":id_consulta",$_GET["id_consulta"],PDO::PARAM_INT);
    $stmt->execute();
    $recetas=$stmt->fetchAll();

	// DATOS DE LA CONSULTA

	$sql="SELECT * FROM consulta  WHERE consulta.id_historial=:id_historial AND consulta.id_con=:id_consulta";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_historial",$_GET["id_historial"],PDO::PARAM_INT);
	$stmt->bindValue(":id_consulta",$_GET["id_consulta"],PDO::PARAM_INT);
    $stmt->execute();
    $consulta=$stmt->fetch();

	$plantilla='<body>
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjQ4cHgiIGhlaWdodD0iNDdweCIgdmlld0JveD0iMCAwIDQ4IDQ3IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5ob21lNDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPgogICAgICAgIDxnIGlkPSJJTlZPSUNFLTMiIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0zOC4wMDAwMDAsIC00MS4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9IlpBR0xBVkxKRSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAyNS4wMDAwMDApIj4KICAgICAgICAgICAgICAgIDxnIGlkPSJob21lNCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOC4wMDAwMDAsIDE2LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik00Ni40MzQ3MTE0LDIxLjI5MTAxNzMgTDM5LjI3NzM2MTQsMTMuNjY2ODQ1MyBMMzkuMjc3MzYxNCw0Ljg1OTI0NjYgQzM5LjI3NzM2MTQsMy4yNjcwODUyMSAzOC4wNjYxNTc5LDEuOTc2Mzk3NDIgMzYuNTY4NTk4NCwxLjk3NjM5NzQyIEMzNS4wNzQ4NTIyLDEuOTc2Mzk3NDIgMzMuODYzNjQ4NywzLjI2NzA4NTIxIDMzLjg2MzY0ODcsNC44NTkyNDY2IEwzMy44NjM2NDg3LDcuODk5NzUwNjEgTDI4LjUzNDE4NjQsMi4yMjI3ODA2OCBDMjUuODk5MDY4LC0wLjU4MjEyOTY0NCAyMS4zMTc3MywtMC41NzcxNzkxMzEgMTguNjg5MDQ2NiwyLjIyNzczMTE5IEwwLjc5MjIxNTc1OSwyMS4yOTEwMTczIEMtMC4yNjM5NTI3NTQsMjIuNDE4NTkyIC0wLjI2Mzk1Mjc1NCwyNC4yNDMzMDA2IDAuNzkyMjE1NzU5LDI1LjM2ODg0NDMgQzEuODQ5NDU2NzcsMjYuNDk2NDE5IDMuNTY1Njg1OTEsMjYuNDk2NDE5IDQuNjIxODU0NDIsMjUuMzY4ODQ0MyBMMjIuNTE2Nzc4Niw2LjMwNTU1ODI0IEMyMy4xMDAwOTYzLDUuNjg3NzU5NTEgMjQuMTI3NDI2Nyw1LjY4Nzc1OTUxIDI0LjcwNzQwNzcsNi4zMDM2NTQyIEw0Mi42MDUwNzI3LDI1LjM2ODg0NDMgQzQzLjEzNjE5NTcsMjUuOTMyNTY4MiA0My44Mjc5NTQ1LDI2LjIxMzIyNDMgNDQuNTE5NzEzMywyNi4yMTMyMjQzIEM0NS4yMTI3ODI5LDI2LjIxMzIyNDMgNDUuOTA1OTcxNywyNS45MzI1NjgyIDQ2LjQzNTE4ODEsMjUuMzY4ODQ0MyBDNDcuNDkxODMzMiwyNC4yNDMzMDA2IDQ3LjQ5MTgzMzIsMjIuNDE4NTkyIDQ2LjQzNDcxMTQsMjEuMjkxMDE3MyBMNDYuNDM0NzExNCwyMS4yOTEwMTczIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjQuNTUzODAyNywxMS43NzgyODc3IEMyNC4wMzM4ODEzLDExLjIyNDg0NTcgMjMuMTkyMjExNywxMS4yMjQ4NDU3IDIyLjY3MzcyMDMsMTEuNzc4Mjg3NyBMNi45MzE2NDk1NiwyOC41NDE3NDI4IEM2LjY4MzA2OTIyLDI4LjgwNjAyNDEgNi41NDI0NTMzMSwyOS4xNjc1Mzg2IDYuNTQyNDUzMzEsMjkuNTQ0Mjg1MyBMNi41NDI0NTMzMSw0MS43NzE0MTk3IEM2LjU0MjQ1MzMxLDQ0LjY0MDMwNTkgOC43MjYxNzA3OCw0Ni45NjYyODU3IDExLjQxOTQ0MjIsNDYuOTY2Mjg1NyBMMTkuMjEzMTM4OCw0Ni45NjYyODU3IEwxOS4yMTMxMzg4LDM0LjEwOTAzOTkgTDI4LjAxMjM1ODQsMzQuMTA5MDM5OSBMMjguMDEyMzU4NCw0Ni45NjYyODU3IEwzNS44MDY2NTA4LDQ2Ljk2NjI4NTcgQzM4LjQ5OTkyMjIsNDYuOTY2Mjg1NyA0MC42ODM1MjA1LDQ0LjY0MDMwNTkgNDAuNjgzNTIwNSw0MS43NzE0MTk3IEw0MC42ODM1MjA1LDI5LjU0NDI4NTMgQzQwLjY4MzUyMDUsMjkuMTY3NTM4NiA0MC41NDM4NTc5LDI4LjgwNjAyNDEgNDAuMjk0NDQzNCwyOC41NDE3NDI4IEwyNC41NTM4MDI3LDExLjc3ODI4NzcgWiIgaWQ9IkZpbGwtMyI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
			</figure>
			<div class="company-info">
				<h2 class="title">Consultorio Dental Dr. Robles</h2>
				<div class="address">
					<span class="icon"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjYuNDIycHgiIGhlaWdodD0iNi43OTJweCINCgkgdmlld0JveD0iMCAwIDYuNDIyIDYuNzkyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2LjQyMiA2Ljc5MiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxICsgRmlsbCAyPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGc+DQoJPGVsbGlwc2UgZmlsbD0ibm9uZSIgY3g9IjMuMjExIiBjeT0iMS45MzciIHJ4PSIxLjAwNiIgcnk9IjAuOTY4Ii8+DQoJPHBhdGggZmlsbD0iI0ZGRkZGRiIgZD0iTTQuNzkyLDQuODMySDQuMTUxQzQuMDg5LDQuOTMxLDQuMDMsNS4wMjMsMy45Nyw1LjExNGgwLjY4M2wxLjE2NCwxLjM5OUgwLjYwNUwxLjc3LDUuMTE0aDAuNjgxDQoJCWMtMC4wNTktMC4wOTEtMC4xMTktMC4xODMtMC4xOC0wLjI4MkgxLjYyOUwwLDYuNzkyaDYuNDIzTDQuNzkyLDQuODMyeiIvPg0KCTxwYXRoIGZpbGw9IiNGRkZGRkYiIGQ9Ik01LjIyMiwxLjkzN0M1LjIyMiwwLjg2OSw0LjMyMywwLDMuMjA5LDBDMi4wOTgsMCwxLjE5OCwwLjg2OSwxLjE5OCwxLjkzNw0KCQljMCwxLjA3MSwyLjAxMiwzLjg3NSwyLjAxMiwzLjg3NVM1LjIyMiwzLjAwOCw1LjIyMiwxLjkzN3ogTTIuMjA1LDEuOTM3YzAtMC41MzUsMC40NTEtMC45NjgsMS4wMDYtMC45NjgNCgkJYzAuNTU2LDAsMS4wMDcsMC40MzUsMS4wMDcsMC45NjhjMCwwLjUzNi0wLjQ1MSwwLjk3LTEuMDA3LDAuOTdTMi4yMDUsMi40NzMsMi4yMDUsMS45Mzd6Ii8+DQo8L2c+DQo8L3N2Zz4NCg==" alt="">
					</span>
					<p>
						Direccion: 2do. Anillo Av.Alemana<br>
						AZ 85004, US
					</p>
				</div>
				<div class="phone">
					<span class="icon">
						<img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUuNXB4IiBoZWlnaHQ9IjUuNDk2cHgiDQoJIHZpZXdCb3g9IjAuMjUgMC4yNSA1LjUgNS40OTYiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMC4yNSAwLjI1IDUuNSA1LjQ5NiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTQyNS4wMDAwMDAsIC03OC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAyNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJQSE9ORSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzkzLjAwMDAwMCwgNTEuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPHBhdGggaWQ9IkZpbGwtMSIgZmlsbD0iI0ZGRkZGRiIgZD0iTTcuNjY2LDYuODJMNi44OTIsNy41OUM2Ljg1Niw3LjYyOCw2LjgxMSw3LjY2MSw2Ljc1NSw3LjY4OA0KCQkJCQlDNi42OTgsNy43MTUsNi42NDMsNy43MzIsNi41ODksNy43NGMtMC4wMDQsMC0wLjAxNiwwLjAwMi0wLjAzNSwwLjAwNFM2LjUxLDcuNzQ2LDYuNDc5LDcuNzQ2DQoJCQkJCWMtMC4wNzQsMC0wLjE5My0wLjAxMi0wLjM1OC0wLjAzN1M1Ljc1Myw3LjYyMSw1LjUxNSw3LjUyMmMtMC4yMzktMC4wOTktMC41MS0wLjI0Ny0wLjgxMi0wLjQ0Ng0KCQkJCQlDNC4zOTksNi44NzksNC4wNzcsNi42MDcsMy43MzYsNi4yNjJDMy40NjQsNS45OTQsMy4yMzksNS43MzgsMy4wNjEsNS40OTNDMi44ODIsNS4yNDksMi43MzgsNS4wMjIsMi42MjksNC44MTUNCgkJCQkJQzIuNTIxLDQuNjA3LDIuNDM5LDQuNDE5LDIuMzg1LDQuMjVjLTAuMDU0LTAuMTY5LTAuMDkxLTAuMzE0LTAuMTEtMC40MzdjLTAuMDItMC4xMjMtMC4wMjctMC4yMTktMC4wMjMtMC4yODkNCgkJCQkJczAuMDA2LTAuMTA4LDAuMDA2LTAuMTE2YzAuMDA4LTAuMDU0LDAuMDI1LTAuMTEsMC4wNTItMC4xNjZjMC4wMjctMC4wNTYsMC4wNi0wLjEwMiwwLjA5OS0wLjEzN2wwLjc3NC0wLjc3NA0KCQkJCQlDMy4yMzcsMi4yNzcsMy4yOTksMi4yNSwzLjM2OSwyLjI1YzAuMDUsMCwwLjA5NSwwLjAxNSwwLjEzNCwwLjA0M2MwLjAzOSwwLjAyOSwwLjA3MiwwLjA2NSwwLjA5OSwwLjEwOGwwLjYyMywxLjE4Mg0KCQkJCQlDNC4yNiwzLjY0Niw0LjI3LDMuNzEzLDQuMjU0LDMuNzg3UzQuMjA2LDMuOTIzLDQuMTU1LDMuOTc0TDMuODcsNC4yNTlDMy44NjIsNC4yNjcsMy44NTUsNC4yNzksMy44NDksNC4yOTYNCgkJCQkJQzMuODQzLDQuMzE0LDMuODQsNC4zMjksMy44NCw0LjM0QzMuODU2LDQuNDIyLDMuODkxLDQuNTE1LDMuOTQ1LDQuNjJDMy45OTIsNC43MTMsNC4wNjMsNC44MjYsNC4xNjEsNC45Ng0KCQkJCQljMC4wOTcsMC4xMzQsMC4yMzUsMC4yODgsMC40MTQsMC40NjNDNC43NDksNS42MDIsNC45MDQsNS43NCw1LjA0LDUuODRjMC4xMzYsMC4wOTksMC4yNSwwLjE3MiwwLjM0LDAuMjE4DQoJCQkJCUM1LjQ3Miw2LjEwNCw1LjU0MSw2LjEzMyw1LjU5LDYuMTQzbDAuMDczLDAuMDE0YzAuMDA4LDAsMC4wMjEtMC4wMDIsMC4wMzgtMC4wMDhTNS43Myw2LjEzNiw1LjczOCw2LjEyOEw2LjA3LDUuNzkNCgkJCQkJYzAuMDctMC4wNjIsMC4xNTEtMC4wOTMsMC4yNDQtMC4wOTNjMC4wNjYsMCwwLjExOSwwLjAxMiwwLjE1OCwwLjAzNWwxLjEyOSwwLjY2M0M3LjY4NCw2LjQ0Niw3LjczMiw2LjUxLDcuNzQ4LDYuNTg4DQoJCQkJCUM3Ljc1OSw2LjY3Nyw3LjczMiw2Ljc1NSw3LjY2Niw2LjgyeiIvPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt="">
					</span>
					Dr.'.$odontologo["nombre_per"].' '.$odontologo["paterno"].'<br>
					<a href="tel:'.$odontologo["telefono"].'">Telf.'.$odontologo["telefono"].' </a>
				</div>
				<div class="email">
					<span class="icon"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjZweCIgaGVpZ2h0PSI0cHgiIHZpZXdCb3g9IjAgMCA2IDQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiPgogICAgPCEtLSBHZW5lcmF0b3I6IFNrZXRjaCAzLjQuMSAoMTU2ODEpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPgogICAgPHRpdGxlPmVtYWlsMTk8L3RpdGxlPgogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+CiAgICA8ZGVmcz48L2RlZnM+CiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBza2V0Y2g6dHlwZT0iTVNQYWdlIj4KICAgICAgICA8ZyBpZD0iSU5WT0lDRS0zIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNDI1LjAwMDAwMCwgLTkzLjAwMDAwMCkiIGZpbGw9IiNGRkZGRkYiPgogICAgICAgICAgICA8ZyBpZD0iTUFJTCIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNDIzLjAwMDAwMCwgOTAuMDAwMDAwKSI+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMiw3IEw4LDcgTDgsMyBMMiwzIEwyLDcgWiBNNC45OTk4MTU2Miw1LjQ3MDEzMjgyIEwyLjUzOTEzNTI0LDMuMjk2NjA4NzkgTDcuNDYwODY0NzYsMy4yOTY2MDg3OSBMNC45OTk4MTU2Miw1LjQ3MDEzMjgyIFogTTQuMDE5NTQ0NTcsNC45OTkzMDQ2MSBMMi4yOTQ5MjAyNSw2LjUyMjU4ODcyIEwyLjI5NDkyMDI1LDMuNDc1OTI3NzcgTDQuMDE5NTQ0NTcsNC45OTkzMDQ2MSBaIE00LjI0MzIwMDg5LDUuMTk2NjExMTEgTDQuOTk5ODE1NjIsNS44NjQ4Mzg1NSBMNS43NTY0MzAzNSw1LjE5NjYxMTExIEw3LjQ2MjMzOTgyLDYuNzAzMjk4NDkgTDIuNTM3NjYwMTgsNi43MDMyOTg0OSBMNC4yNDMyMDA4OSw1LjE5NjYxMTExIFogTTUuOTgwMDg2NjYsNC45OTkzMDQ2MSBMNy43MDQ3MTA5OCwzLjQ3NTkyNzc3IEw3LjcwNDcxMDk4LDYuNTIyNTg4NzIgTDUuOTgwMDg2NjYsNC45OTkzMDQ2MSBaIiBpZD0iZW1haWwxOSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+PC9wYXRoPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
					</span>
					<a href="mailto:'.$odontologo["nombre_per"].'_Odontobor@example.com">'.$odontologo["nombre_per"].'_Odontobot@example.com</a>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="container">
			<div class="details clearfix">
				<div class="client left">
					<p class="name">Paciente: '.$paciente["nombre_per"].' '.$paciente["paterno"].' '.$paciente["materno"].'</p>
					<p>Edad: '.$edad.' años</p>
					<p>Telefono: '.$paciente["telefono"].'</p>
					<p>Celular: '.$paciente["celular"].'
					<p>Direccion: '.$paciente["direccion"].'</p>
					<p>Correo: <a href="mailto:john@example.com">'.$paciente["nombre_per"].'_'.$paciente["paterno"].'@example.com</a></p>
				</div>
				<div class="data right">
					<div class="title">RECETA</div>
					<div class="date">
					Fecha de impresión: '.$fecha_actual.'
					</div>
				</div>
			</div>

			<table border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="total">paciente</th>
						<th class="total">Descripcion</th>
						<th class="total">Diagnostico de Consulta</th>
						<th class="total">Tratamiento</th>
						<th class="total">Fecha retorno</th>
					</tr>
				</thead>
				<tbody>
				<tr>';
				foreach ($recetas as $key => $value) {
				$plantilla.='
				<td class="qty"></td>
				<td class="desc"> '.$value["descripcion_rece"].'</td>
			';
			
				}
$plantilla.='
				<td class="desc">'.$consulta["diagnostico"].'</td>
				<td class="desc">'.$consulta["tratamiento"].'</td>
				<td class="desc">'.$consulta["fecha_retorno"].'
				</tr>
				</tbody>
			</table>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr class="total">
							<td class="qty"></td>
							<td class="desc"></td>
							<td class="unit"></td>
							<td class="total"></td>
						</tr>
						<tr class="total">
							<td class="qty"></td>
							<td class="desc"></td>
							<td class="unit"></td>
							<td class="total"></td>
						</tr>
						<tr class="total">
							<td class="grand-total" colspan="4"><div><span></p></span></div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</body>';



	$css=file_get_contents('../css/receta.css');
	$mpdf = new \Mpdf\Mpdf([]);
	$mpdf->writeHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->writeHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

//	$NombrePaciente=''.$paciente["nombre_per"].$paciente["paterno"].'';// para el autoguardado del pdf postergado :V
	$mpdf->Output();

?>