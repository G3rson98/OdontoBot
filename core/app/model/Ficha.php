<?php
class Ficha
{
	public $fecha_fic;
	public $hora;
	public $estado_fic;
	public $ci_pac;
	public $id_agen;

	public function Ficha($fecha_fic, $hora, $estado_fic, $ci_pac, $id_agen)
	{
		$this->fecha_fic = $fecha_fic;
		$this->hora = $hora;
		$this->estado_fic = $estado_fic;
		$this->ci_pac = $ci_pac;
		$this->id_agen = $id_agen;
	}

	public function esFechaValida()
	{
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$fechaco = $fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"];
		$datetime1 = new DateTime($fechaco);
		$datetime2 = new DateTime($this->fecha_fic);
		$interval = $datetime1->diff($datetime2);
		$dias = $interval->format('%R%a');
		if ($dias >= 0) {
			return true;
		} else {
			return false;
		}
	}

	public function esFechaHoy()
	{
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$fechaco = $fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"];
		$datetime1 = new DateTime($fechaco);
		$datetime2 = new DateTime($this->fecha_fic);
		$interval = $datetime1->diff($datetime2);
		$dias = $interval->format('%R%a');
		echo '<pre>';
		print_r($dias);
		echo '</pre>';

		if ($dias == "+0") {
			return "true";
		} else {
			return "false";
		}
	}

	public function esHoraValida()
	{
		date_default_timezone_set('America/La_Paz');
		$fecha = getdate();
		$horaActual = $fecha["hours"] . ":" . $fecha["minutes"];
		$min1 = substr($this->hora, -2);
		$min2 = substr($horaActual, -2);
		$hora1 = substr($this->hora, 0, -3);
		$hora2 = substr($horaActual, 0, -3);

		if ($hora1 > $hora2) {
			return true;
		} else if ($hora1 = $hora2) {
			if ($min1 >= $min2) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public static function getAgendaByCiOdont($ci)
	{
		$sql = "select agenda.id_age from agenda,odontologo where agenda.ci_odont=odontologo.ci_odont and odontologo.ci_odont=:ci";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci, PDO::PARAM_STR);
		$stmt->execute();
		$array = $stmt->fetch();
		return $array["0"];
	}

	public static function getDiaxFecha($fecha)
	{
		$fechaComoEntero = strtotime($fecha);
		// $dia = date("N", $fechaComoEntero);
		switch (date('N', $fechaComoEntero)) {
			case 1:
				$dia = "lunes";
				break;
			case 2:
				$dia = "martes";
				break;
			case 3:
				$dia = "miercoles";
				break;
			case 4:
				$dia = "jueves";
				break;
			case 5:
				$dia = "viernes";
				break;
			case 6:
				$dia = "sabado";
				break;
			case 7:
				$dia = "domingo";
				break;
		}
		return $dia;
	}

	public static function esDiaCorrecto($dia, $ci_odont)
	{
		$arrayHorario = OdontoHorario::getHorioDeOdontologo($ci_odont);
		// echo '<pre>'; print_r($arrayHorario); echo '</pre>';
		foreach ($arrayHorario as $key => $value) {
			$diaH = $value["dia"];
			if ($diaH == $dia) {
				return "true";
				break;
			}
		}
		return "false";
	}

	public static function esHoraCorrecta($hora, $dia, $ci_odont)
	{
		$sql = "SELECT * FROM horario h, odontologo_horario oh where oh.ci_odont = :ci_odont and h.id_hor = oh.id_hor and h.dia=:dia;";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci_odont", $ci_odont, PDO::PARAM_STR);
		$stmt->bindValue(":dia", $dia, PDO::PARAM_STR);
		$stmt->execute();
		$arrayHorDia = $stmt->fetchAll();
		echo '<pre>'; print_r($arrayHorDia); echo '</pre>';
		$horaFicha = $hora;
		$hora1 = strtotime($horaFicha);
		$v1 = 0;
		foreach ($arrayHorDia as $key => $value) {
			$hora2 = strtotime($value["hra_inicio"]);
			$hora3 = strtotime($value["hra_fin"]);
			if ($hora1 >= $hora2 and $hora1 <= $hora3) {
				$v1 = $v1 + 1;
				return "true";
				break;
			}
		}
		if ($v1 == 0) {
			return "false";
		}
	}

	public static function obtenerHoraFin($horaReservaInicial, $id_serv)
	{
		$p1 = explode(":", $horaReservaInicial);

		$minutosTotales = ($p1[0] * 60) + $p1[1];

		$sql = "select servicio.t_duracion from servicio where servicio.id_ser=:id_ser";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_ser", $id_serv, PDO::PARAM_STR);
		$stmt->execute();
		$tds = $stmt->fetch();

		$moremin = $tds["t_duracion"];

		$horafinReserva = $minutosTotales + $moremin;

		$h2 = intdiv($horafinReserva, 60);

		$m2 = $horafinReserva % 60;
		if ($m2 < 10) {
			$m2 = "0" . $m2;
		}

		$horafin = $h2 . ":" . $m2;

		return $horafin;
	}

	public static function mostrarFichaServicio($id_ficha)
	{
		$sql = "SELECT * from ficha,ficha_serv,servicio where ficha.id_fic=ficha_serv.id_ficha and ficha_serv.id_serv=servicio.id_ser and ficha.id_fic=:id_ficha";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_ficha", $id_ficha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
	}

	public static function mostrarFichasDeAgenda($idAgenda, $fecha)
	{
		echo "$fecha";
		$sql = "SELECT * FROM ficha where ficha.id_agen=:id_agenda and ficha.fecha_fic=:fecha";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_agenda", $idAgenda, PDO::PARAM_STR);
		$stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function addFichaServ($id_fic, $id_serv)
	{
		$sql = "insert into ficha_serv values(:id_ficha,:id_serv)";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_ficha", $id_fic, PDO::PARAM_STR);
		$stmt->bindValue(":id_serv", $id_serv, PDO::PARAM_STR);

		$stmt->execute();
		return true;
	}

	public function addFicha($id_serv)
	{
		$sql = "insert into ficha values(null,:fecha,:hora,'a',:cipac,:idagen)";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":fecha", $this->fecha_fic, PDO::PARAM_STR);
		$stmt->bindValue(":hora", $this->hora, PDO::PARAM_STR);
		$stmt->bindValue(":cipac", $this->ci_pac, PDO::PARAM_STR);
		$stmt->bindValue(":idagen", $this->id_agen, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return true;
		} else {
			return false;
		}
	}

	public static function ObtenerUltFicha()
	{
		$sql = "select max(ficha.id_fic) from ficha ";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$ultfich = $stmt->fetch();
		return $ultfich["0"];
	}
	public static function getFichadehoy($ci)
	{
		$sql = "select * from ficha,agenda where ficha.id_agen=agenda.id_age and ficha.fecha_fic=Curdate() and agenda.ci_odont=:ci";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":ci", $ci, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetchAll();
		
	}

	public static function mostrarFichas(){
		$sql = "select * from ficha";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	public static function getfichabyid($id_ficha){
		$sql = "select * from ficha where ficha.id_fic=:id_ficha";
		$con = Database::getConexion();
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":id_ficha", $id_ficha, PDO::PARAM_INT);
		$stmt->execute();
		
		return $stmt->fetch();

	}

}
