<?php
	require_once('../vendor/autoload.php');
	
	define('DB_HOST','localhost');
	define('DB_NAME','consultorio_dr_roblesvd');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_ENCODE','utf8');
	define('PRO_NOMBRE','ODONTOBOT');
	$con = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";", DB_USERNAME, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//Consultas para el reportes
	//CONSULTA PARA EXTRAER notaVenta
	//echo "<pre>";print_r($_GET); echo "</pre>";



	$id_paciente=$_GET["id_paciente"];
	$id_ficha=$_GET["id_ficha"];
	$id_historial=$_GET["id_historial"];
	$id_consulta=$_GET["id_consulta"];
	date_default_timezone_set('America/La_Paz');
	$fecha_actual=date('g:ia  d/m/y ');

	//DATOS DEL ODONTOLOGO
	$sql="SELECT persona.nombre_per, persona.paterno, persona.telefono,persona.celular FROM odontologo,persona, ficha, agenda WHERE ficha.ci_pac=:id_paciente AND ficha.id_fic=:id_ficha AND ficha.id_agen=agenda.id_age AND odontologo.ci_odont=agenda.ci_odont AND persona.ci= odontologo.ci_odont;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_paciente",$id_paciente,PDO::PARAM_INT);
	$stmt->bindValue(":id_ficha",$id_ficha,PDO::PARAM_INT);
	$stmt->execute();
	$odontologo=$stmt->fetch();
	//echo "<pre>";print_r($odontologo); echo "</pre>";

	//DATOS DEL PACIENTE

	$sql="SELECT *FROM persona WHERE persona.ci=:id_paciente";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_paciente",$id_paciente,PDO::PARAM_INT);
	$stmt->execute();
	$paciente=$stmt->fetch();
	//echo "<pre>";print_r($paciente); echo "</pre>";

	//datos de la nota de venta

	$sql="SELECT* from nota_venta WHERE nota_venta.id_historial=:id_historial AND nota_venta.id_consulta=:id_consulta ;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_consulta",$id_consulta,PDO::PARAM_INT);
	$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
	$stmt->execute();
	$notaventa=$stmt->fetch();
	 //echo "<pre>";print_r($notaventa);echo "</pre";
    
	$sql="SELECT cuota.id_cuo,cuota.fecha,cuota.monto from cuota WHERE cuota.id_nota=:id_notaventa AND cuota.ci_paciente=:id_paciente;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_paciente",$id_paciente,PDO::PARAM_INT);
	$stmt->bindValue(":id_notaventa",$notaventa["id_vnot"],PDO::PARAM_INT);
	$stmt->execute();
	$cuotaspagadas=$stmt->fetchAll();
	 //echo "<pre>";print_r($cuotaspagadas);echo "</pre";



	$sql="SELECT* from serv_cons,servicio where serv_cons.id_historial=:id_historial AND serv_cons.id_consulta=:id_consulta AND serv_cons.id_serv=servicio.id_ser";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_consulta",$id_consulta,PDO::PARAM_INT);
	$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
	$stmt->execute();
	$servicios=$stmt->fetchAll();
	// echo "<pre>";print_r($servicios);echo "</pre";

	$sql="SELECT* from producto,prod_con where prod_con.id_historial=:id_historial AND prod_con.id_consulta=:id_consulta AND prod_con.id_prod=producto.id_prod";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":id_consulta",$id_consulta,PDO::PARAM_INT);
	$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
	$stmt->execute();
	$productos=$stmt->fetchAll();
	 //echo "<pre>";print_r($productos);echo "</pre";
	
	$plantilla='<body>
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjQxcHgiIGhlaWdodD0iNDFweCIgdmlld0JveD0iMCAwIDQxIDQxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5MT0dPPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+PC9kZWZzPgogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+CiAgICAgICAgPGcgaWQ9IklOVk9JQ0UtMiIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwLjAwMDAwMCwgLTMwLjAwMDAwMCkiIGZpbGw9IiMyQThFQUMiPgogICAgICAgICAgICA8ZyBpZD0iWkFHTEFWTEpFIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMC4wMDAwMDAsIDE1LjAwMDAwMCkiPgogICAgICAgICAgICAgICAgPGcgaWQ9IkxPR08iIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzkuOTI0NjM2MywxOC40NDg2MjEgTDMzLjc3MDczNTgsMTEuODQyMjkyMyBMMzMuNzcwNzM1OCw0LjIxMDUyNjgxIEMzMy43NzA3MzU4LDIuODMwOTIyMzYgMzIuNzI5MzQxMSwxLjcxMjU0NDE0IDMxLjQ0MTczNzIsMS43MTI1NDQxNCBDMzAuMTU3NDExOSwxLjcxMjU0NDE0IDI5LjExNjAxNzMsMi44MzA5MjIzNiAyOS4xMTYwMTczLDQuMjEwNTI2ODEgTDI5LjExNjAxNzMsNi44NDUxMTcwNCBMMjQuNTMzNzM3NCwxLjkyNjAzNDcxIEMyMi4yNjgwNTg1LC0wLjUwNDQxNDA5NCAxOC4zMjkwMTcxLC0wLjUwMDEyNDQ4NCAxNi4wNjg4NzEsMS45MzAzMjQzMiBMMC42ODExNDgzMjksMTguNDQ4NjIxIEMtMC4yMjY5NDY5ODQsMTkuNDI1NjYyMSAtMC4yMjY5NDY5ODQsMjEuMDA2NzY4MiAwLjY4MTE0ODMyOSwyMS45ODIwNDk0IEMxLjU5MDE2NTc3LDIyLjk1OTA5MDUgMy4wNjU3ODIyMywyMi45NTkwOTA1IDMuOTczODc3NTUsMjEuOTgyMDQ5NCBMMTkuMzU5OTYwOSw1LjQ2Mzc1Mjc1IEMxOS44NjE0OTg0LDQuOTI4NDMxNDcgMjAuNzQ0Nzk4Niw0LjkyODQzMTQ3IDIxLjI0MzQ2NzIsNS40NjIxMDI5IEwzNi42MzE5MDcxLDIxLjk4MjA0OTQgQzM3LjA4ODU2NzUsMjIuNDcwNTE1IDM3LjY4MzM0MjgsMjIuNzEzNzAyOSAzOC4yNzgxMTgsMjIuNzEzNzAyOSBDMzguODc0MDIwNCwyMi43MTM3MDI5IDM5LjQ3MDAyNTIsMjIuNDcwNTE1IDM5LjkyNTA0NjIsMjEuOTgyMDQ5NCBDNDAuODMzNTUxMywyMS4wMDY3NjgyIDQwLjgzMzU1MTMsMTkuNDI1NjYyMSAzOS45MjQ2MzYzLDE4LjQ0ODYyMSBMMzkuOTI0NjM2MywxOC40NDg2MjEgWiIgaWQ9IkZpbGwtMSI+PC9wYXRoPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMS4xMTEzOTc0LDEwLjIwNTg2MTIgQzIwLjY2NDM2ODIsOS43MjYzMDQ4MiAxOS45NDA2OTkzLDkuNzI2MzA0ODIgMTkuNDk0ODk5NiwxMC4yMDU4NjEyIEw1Ljk1OTg0Mjk2LDI0LjczMTM1OTIgQzUuNzQ2MTEzMiwyNC45NjAzNTg0IDUuNjI1MjExNDIsMjUuMjczNjA5OSA1LjYyNTIxMTQyLDI1LjYwMDA2MDIgTDUuNjI1MjExNDIsMzYuMTk0ODQ2IEM1LjYyNTIxMTQyLDM4LjY4MDcyOTcgNy41MDI3NzUwNyw0MC42OTYxODYzIDkuODE4NDUzOTgsNDAuNjk2MTg2MyBMMTYuNTE5NDg2Myw0MC42OTYxODYzIEwxNi41MTk0ODYzLDI5LjU1NTQxMDIgTDI0LjA4NTA2ODgsMjkuNTU1NDEwMiBMMjQuMDg1MDY4OCw0MC42OTYxODYzIEwzMC43ODY2MTM1LDQwLjY5NjE4NjMgQzMzLjEwMjI5MjQsNDAuNjk2MTg2MyAzNC45Nzk3NTM2LDM4LjY4MDcyOTcgMzQuOTc5NzUzNiwzNi4xOTQ4NDYgTDM0Ljk3OTc1MzYsMjUuNjAwMDYwMiBDMzQuOTc5NzUzNiwyNS4yNzM2MDk5IDM0Ljg1OTY3MTUsMjQuOTYwMzU4NCAzNC42NDUyMjQ1LDI0LjczMTM1OTIgTDIxLjExMTM5NzQsMTAuMjA1ODYxMiBaIiBpZD0iRmlsbC0zIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgIDwvZz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPg==" alt="">
			</figure>
			<div class="company-info">
				<h2 class="title">Clinica Dental Dr. Robles</h2>
				<span>Direccion: Av.alemana</span>
				<span class="line"></span>
				<a class="phone" href="tel:602-519-0450">  Telefono:'.$odontologo["telefono"].' </a><a class="phone" href="tel:602-519-0450">  Celular:'.$odontologo["celular"].'</a>
				<span class="line"></span>
				<a class="email" href="mailto:company@example.com">company@example.com</a>
			</div>
		</div>
	</header>

	<section>
		<div class="details clearfix">
			<div class="client left">
				<p>Paciente: </p>
				<p class="name">Nombre : '.$paciente["nombre_per"].' '.$paciente["paterno"].' '.$paciente["materno"].'</p>
				<p class="name">Telefono: '.$paciente["telefono"].'</p>
				<p class="name">Celular: '.$paciente["celular"].'</p>

				<a href="mailto:john@example.com">john@example.com</a>
			</div>
			<div class="data right">
				<div class="title">Nota Venta</div>
				<div class="date">
					Hora y Fecha = '.$fecha_actual.'
				</div>
			</div>
		</div>
		<div class="container">
			<div class="table-wrapper">
				<table>
					<tbody class="head">
						<tr>
							<th class="no"></th>
							<th class="desc"><div>Description</div></th>
							<th class="qty"><div>Quantity</div></th>
							<th class="unit"><div>Unit price</div></th>
							<th class="total"><div>Total</div></th>
						</tr>
					</tbody>
					<tbody class="body">
						';
						foreach ($productos as $key => $p) {
							# code...
						
						$plantilla.='
						<tr>
							<td class="no">Prod # '.($key+1).'</td>
							<td class="desc">Nombre : '.$p["nombre_prod"].'</td>
							<td class="qty">Precio : </td>
							<td class="unit">'.$p["precio_prod"].'</td>

						</tr>
						';
						}
						foreach ($servicios as $key => $ser) {

				$plantilla.='			<tr>
							<td class="no">Serv # '.($key+1).'</td>
							<td class="desc">Nombre : '.$ser["nombre_ser"].'</td>
							<td class="qty">Precio : </td>
							<td class="unit">'.$ser["precio_serv"].'</td>

						</tr>
						';
							# code...
						}
						foreach ($cuotaspagadas as $key => $cu) {

							$plantilla.='			<tr>
										<td class="no">Cuota Pagada # '.($key+1).'</td>
										<td class="desc">Fecha : '.$cu["fecha"].'</td>
										<td class="qty">Monto : </td>
										<td class="unit">'.$cu["monto"].'</td>
			
									</tr>
									';
										# code...
									}
						$plantilla.='

						<tr>
							<td class="no">Nota Venta Total</td>
							<td class="desc">Descuento : '.$notaventa["descuento"].'</td>
							<td class="qty">Saldo : '.$notaventa["saldo"].'</td>
				

						</tr>
					</tbody>
				</table>
			</div>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr>
							<td class="no"></td>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">MONTO TOTAL :'.$notaventa["monto_total"].' </td>

						</tr>
						<tr>
							<td class="no"></td>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit"></td>

						</tr>
						<tr>
							<td class="grand-total" colspan="5"><div><span>MONTO TOTAL:</span></div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="thanks">Thank you!</div>
			<div class="notice">
				<div>NOTICE:</div>
				<div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
			</div>
			<div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
		</div>
	</footer>

</body>';
//echo $plantilla;

	$css=file_get_contents('../css/NotaVenta.css');
	$mpdf = new \Mpdf\Mpdf([]);
	$mpdf->writeHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->writeHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);

//	$NombrePaciente="Historial".$Nombre.".pdf";
	
	$mpdf->Output();
//}


//}
?>