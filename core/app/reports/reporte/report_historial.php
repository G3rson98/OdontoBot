<?php
//Añadiendo librerias
	require('../vendor/autoload.php');
	//require('../plantilla_reporte/plantilla_Historial.php');
	//conexion
	define('DB_HOST','localhost');
	define('DB_NAME','consultorio_dr_roblesvd');
	define('DB_USERNAME','root');
	define('DB_PASSWORD','');
	define('DB_ENCODE','utf8');
	define('PRO_NOMBRE','ODONTOBOT');
	$con = new PDO("mysql:=".DB_HOST.";dbname=".DB_NAME.";", DB_USERNAME, DB_PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	//Consultas para el reportes
	//CONSULTA PARA EXTRAER DATOS_PERSONALES
	
	$ci=$_GET["ci"];
	$sql="SELECT *FROM persona WHERE persona.ci=:ci";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":ci",$ci,PDO::PARAM_INT);
    $stmt->execute();
    $Datos_Personales=$stmt->fetch();
    //   echo '<pre>'; print_r($Datos_Personales); echo '</pre>';
	//CONSULTA PARA EXTRAER PACIENTE

	$sql="SELECT *FROM paciente WHERE paciente.ci_pac=:ci";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":ci",$ci,PDO::PARAM_INT);
    $stmt->execute();
    $Datos_paciente=$stmt->fetch();
  //  echo "<pre>";print_r($Datos_paciente);echo "</pre";

    //Consulta para extraer patologia
    $sql="SELECT patologia.nombre_pat,pac_pat.descripcion FROM patologia,pac_pat where patologia.id_pat=pac_pat.id_pat and pac_pat.ci_pac=:ci;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":ci",$ci,PDO::PARAM_INT);
    $stmt->execute();
    $patologia=$stmt->fetchAll();
	//echo '<pre>'; print_r($patologia); echo '</pre>';
	 // consulta para extraer historial
	$sql="SELECT historial.id_his,historial.fecha_reg,historial.ultima_consulta FROM historial WHERE historial.ci_paciente=:ci;";
	$stmt = $con->prepare($sql);
	$stmt->bindValue(":ci",$ci,PDO::PARAM_INT);
    $stmt->execute();
    $historial=$stmt->fetch();
//	  echo '<pre>'; print_r($historial); echo '</pre>';
	  //extraendo las consultas
	  $id_historial=$historial["id_his"];
	  $sql="SELECT consulta.id_con,consulta.motivo,consulta.diagnostico,consulta.tratamiento,consulta.fecha_retorno from consulta where consulta.id_historial=:id_his;";
	  $stmt = $con->prepare($sql);
	  $stmt->bindValue(":id_his",$id_historial,PDO::PARAM_INT);
	  $stmt->execute();
	  $consultas=$stmt->fetchAll();
//	echo '<pre>'; print_r($consultas); echo '</pre>';	
	
	//creando la plantilla

 	 	$nombre=$Datos_Personales["nombre_per"]." ".$Datos_Personales["paterno"]." ".$Datos_Personales["materno"];
		$plantilla='
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjM5cHgiIGhlaWdodD0iMzFweCIgdmlld0JveD0iMCAwIDM5IDMxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5ob21lNDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPgogICAgICAgIDxnIGlkPSJJTlZPSUNFLTEiIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00Mi4wMDAwMDAsIC00NS4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9IlpBR0xBVkxKRSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIj4KICAgICAgICAgICAgICAgIDxnIGlkPSJob21lNCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTIuMDAwMDAwLCAzMC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzguMjc5MzM1LDE0LjAzOTk1MiBMMzIuMzc5MDM3OCw5LjAxMjMzODM1IEwzMi4zNzkwMzc4LDMuMjA0MzM2NzQgQzMyLjM3OTAzNzgsMi4xNTQ0MTY1MyAzMS4zODA1NTkyLDEuMzAzMjk3MjggMzAuMTQ2MDE3NiwxLjMwMzI5NzI4IEMyOC45MTQ2MTk2LDEuMzAzMjk3MjggMjcuOTE2MTQxMSwyLjE1NDQxNjUzIDI3LjkxNjE0MTEsMy4yMDQzMzY3NCBMMjcuOTE2MTQxMSw1LjIwOTMzODY1IEwyMy41MjI2OTc3LDEuNDY1NzY5OTggQzIxLjM1MDM4NzksLTAuMzgzODc0MjAyIDE3LjU3MzY3NTEsLTAuMzgwNjA5NjggMTUuNDA2NjcsMS40NjkwMzQ1IEwwLjY1MzA3ODA4NiwxNC4wMzk5NTIgQy0wLjIxNzU5NDQ1OCwxNC43ODM1MDk1IC0wLjIxNzU5NDQ1OCwxNS45ODY3Nzg1IDAuNjUzMDc4MDg2LDE2LjcyODk5NjYgQzEuNTI0NjM0NzYsMTcuNDcyNTU0MSAyLjkzOTQ0MDgxLDE3LjQ3MjU1NDEgMy44MTAxMTMzNSwxNi43Mjg5OTY2IEwxOC41NjIxMzM1LDQuMTU4MDc5MTUgQzE5LjA0MzAwMjUsMy43NTA2ODM2NSAxOS44ODk5MDE4LDMuNzUwNjgzNjUgMjAuMzY4MDIwMiw0LjE1NjgyMzU2IEwzNS4xMjIyOTk3LDE2LjcyODk5NjYgQzM1LjU2MDE0MTEsMTcuMTAwNzMzNSAzNi4xMzA0MDU1LDE3LjI4NTgwNjcgMzYuNzAwNjcsMTcuMjg1ODA2NyBDMzcuMjcyMDE1MSwxNy4yODU4MDY3IDM3Ljg0MzQ1ODQsMTcuMTAwNzMzNSAzOC4yNzk3MjgsMTYuNzI4OTk2NiBDMzkuMTUwNzkzNSwxNS45ODY3Nzg1IDM5LjE1MDc5MzUsMTQuNzgzNTA5NSAzOC4yNzkzMzUsMTQuMDM5OTUyIEwzOC4yNzkzMzUsMTQuMDM5OTUyIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjAuMjQxMzkyOSw3Ljc2Njk2NTM5IEMxOS44MTI3ODU5LDcuNDAyMDA4NjcgMTkuMTE4OTM5NSw3LjQwMjAwODY3IDE4LjY5MTUxMTMsNy43NjY5NjUzOSBMNS43MTQyMzY3OCwxOC44MjEzMDM2IEM1LjUwOTMxNDg2LDE4Ljk5NTU3ODggNS4zOTMzOTU0NywxOS4yMzM5NzI1IDUuMzkzMzk1NDcsMTkuNDgyNDEwOSBMNS4zOTMzOTU0NywyNy41NDUzNTk2IEM1LjM5MzM5NTQ3LDI5LjQzNzE5MTQgNy4xOTM1ODQzOCwzMC45NzEwMTQxIDkuNDEzODMzNzUsMzAuOTcxMDE0MSBMMTUuODM4NzE1NCwzMC45NzEwMTQxIEwxNS44Mzg3MTU0LDIyLjQ5MjU1MDUgTDIzLjA5MjUxODksMjIuNDkyNTUwNSBMMjMuMDkyNTE4OSwzMC45NzEwMTQxIEwyOS41MTc4OTE3LDMwLjk3MTAxNDEgQzMxLjczODE0MTEsMzAuOTcxMDE0MSAzMy41MzgyMzE3LDI5LjQzNzE5MTQgMzMuNTM4MjMxNywyNy41NDUzNTk2IEwzMy41MzgyMzE3LDE5LjQ4MjQxMDkgQzMzLjUzODIzMTcsMTkuMjMzOTcyNSAzMy40MjMwOTgyLDE4Ljk5NTU3ODggMzMuMjE3NDg4NywxOC44MjEzMDM2IEwyMC4yNDEzOTI5LDcuNzY2OTY1MzkgWiIgaWQ9IkZpbGwtMyI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
			</figure>
			<div class="company-address">
				<h2 class="title">Consultorio Dr Robles</h2>
				<p>
					455 Foggy Heights,<br>
					AZ 85004, US
				</p>
			</div>
		
				<div class="email right">
					<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
					<a href="mailto:company@example.com">company@example.com</a>
					<span class="helper"></span>
				</div>
			</div>
		</div>
	</header>

	<section>
		<div class="container">
			<div class="details clearfix">
				<div class="client left">
					<p>PACIENTE:</p>
					<p class="name">'.$nombre.'</p>
					<p>Ci:'.$Datos_Personales["ci"].'</p>
					<p>telefono:'.$Datos_Personales["telefono"].'"</p>
					<p>celular:'.$Datos_Personales["celular"].'</p>
					<p>Direccion:'.$Datos_Personales["direccion"].'</p>
					<p>Fecha Nacimiento:'.$Datos_Personales["fecha_nac"].'</p>
					<p>Lugar De Nacimiento:'.$Datos_paciente["lugar_nac"].'</p>
					<a href="mailto:john@example.com">john@example.com</a>
				</div>
				<div class="data right">
					<div class="title">HISTORIAL</div>
					<div class="date">
					Fecha de creacion del historial : '.$historial["fecha_reg"].'<br>
					Patologias:<br>';
					foreach ($patologia as $key => $value) {
					$plantilla.='nombre : '.$value["nombre_pat"].'<br>';
					$plantilla.='descripcion : '.$value["descripcion"].'<br>';
					}
					
		$plantilla.='</div>
				</div>
			</div>

			<table border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="desc">Fecha</th>						
						<th class="desc">Formulario de vida</th>
						<th class="desc">Detalle de Consulta</th>
						<th class="desc">Servicios</th>
						<th class="desc">Productos</th>
						<th class="desc">Recetas</th>
						<th class="desc">Odontograma</th>
						
					</tr>
				</thead>';
				foreach ($consultas as $key => $value) {
					$id_con=$value["id_con"];
					//$id_historial;

					$sql="SELECT* FROM ficha,consulta WHERE ficha.id_fic=consulta.id_ficha AND consulta.id_con=:id_con and consulta.id_historial=:id_historial";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$fecha=$stmt->fetch();

					$sql="SELECT * FROM form_de_vida WHERE form_de_vida.id_historial=:id_historial and form_de_vida.id_consulta=:id_con";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$FormVida=$stmt->fetch();

					$sql="SELECT* from serv_cons,servicio where serv_cons.id_historial=:id_historial AND serv_cons.id_consulta=:id_con AND serv_cons.id_serv=servicio.id_ser";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$servicios=$stmt->fetchAll();
					// echo "<pre>";print_r($servicios);echo "</pre";

					$sql="SELECT* from producto,prod_con where prod_con.id_historial=:id_historial AND prod_con.id_consulta=:id_con AND prod_con.id_prod=producto.id_prod";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$productos=$stmt->fetchAll();
					
					//todas las recetas	
					$sql="SELECT* from receta where receta.id_historial=:id_historial AND receta.id_consulta=:id_con";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$recetas=$stmt->fetchAll();

					// odontograma 
					//obteniendo todas las piezas de un paciente
					$sql="SELECT* FROM odontograma,pieza_dental WHERE odontograma.id_historial=:id_historial AND odontograma.id_consulta=:id_con AND pieza_dental.id_odont=odontograma.id_odo;";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_con",$id_con,PDO::PARAM_INT);
					$stmt->bindValue(":id_historial",$id_historial,PDO::PARAM_INT);
					$stmt->execute();
					$piezas=$stmt->fetchAll();
				
$plantilla.='	<tbody  >
				<div class="box">	<tr>
						<td class="desc"><h3>'.$fecha["fecha_fic"].'</h3><br><h3>fecha retorno:</h3>'.$value["fecha_retorno"].'</td>
						<td class="desc"><h3>altura:</h3>'.$FormVida["altura"].'<br>
										<h3>peso:</h3>'.$FormVida["peso"].'<br>
										<h3>temperatura:</h3>'.$FormVida["temperatura"].'<br>
										<h3>frecuencia cardiaca:</h3>'.$FormVida["frecuencia_cardiaca"].'<br>
										<h3>precion arterial:</h3>'.$FormVida["precion_arterial"].'<br></td>
						<td class="desc"><h3>Motivo:</h3>'.$value["motivo"].'<br><h3>diagnostico:</h3>'.$value["diagnostico"].'<br><h3>tratamiento</h3>:'.$value["tratamiento"].'</td>
						<td class="desc">';
						foreach ($servicios as $key => $serv) {
						
						$plantilla.='<HR width="100%"> <h3> Servicio #'.($key+1).' :</h3>
									<h3>nombre :</h3>'.$serv["nombre_ser"].'<br>
									<h3>precio:</h3>'.$serv["precio_serv"].'<br>
									<h3>descripcion:</h3>'.$serv["descripcion_ser"].'<br>';
					}
			$plantilla.='</td>	
						<td class="desc">';
			foreach ($productos as $key => $pro) {
						$plantilla.='<HR width="100%"> <h3> Producto #'.($key+1).' :</h3>
									<h3>nombre :</h3>'.$pro["nombre_prod"].'<br>
									<h3>precio:</h3>'.$pro["precio_prod"].'<br>';
						}
			$plantilla.='</td>
						<td class="desc">';
			foreach ($recetas as $key => $rece) {
						$plantilla.='<HR width="100%"> <h3> Receta #'.($key+1).' :</h3>
									<h3>descripcion:</h3>'.$rece["descripcion_rece"].'<br>';

			}
			$plantilla.='</td>
						<td class="desc">';
			foreach ($piezas as $key => $pieza) {

		$plantilla.='<HR width="100%">
					<h3> Pieza Dental #'.($pieza["nro"]).' :</h3>
					<h3>Nombre:</h3>'.$pieza["nombre_pie"].'<br>
					<h3>Estado actual</h3>'.$pieza["estado_actual"].'';

					//obteniendo cada una de las caras
					$id_pieza=$pieza["nro"];
					$id_odont=$pieza["id_odont"];
					$sql="SELECT* FROM cara_dental,c_p_dental WHERE cara_dental.id_car=c_p_dental.id_cara AND c_p_dental.id_odont=:id_odont AND c_p_dental.id_pieza=:id_pieza;";
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id_odont",$id_odont,PDO::PARAM_INT);
					$stmt->bindValue(":id_pieza",$id_pieza,PDO::PARAM_INT);
					$stmt->execute();
					$caras=$stmt->fetchAll();

					foreach ($caras as $key => $cara) {
					$plantilla.='<br><br><br><h3>Cara Afectada  #'.$cara["id_cara"].':</h3>'.$cara["nombre_car"].'<br>
								<h3>estado diagnostico</h3>'.$cara["estado_diag"].'<br>
								<h3>estado tratamiento</h3>'.$cara["estado_trat"].'';

					}

	}		


		
$plantilla.='</td>
				
				</tr>
			</div>	
				</tbody>
				';
				}
		$plantilla.='	</table>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr>

						</tr>
						<tr>
						
						</tr>
						<tr>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</body>
';
	
   //creando el pdf
	$css=file_get_contents('../css/historial.css');
	$mpdf = new \Mpdf\Mpdf([]);
	$mpdf->writeHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->writeHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
	$mpdf->Output();

?>
