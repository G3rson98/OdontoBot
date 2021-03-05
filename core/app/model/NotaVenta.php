<?php 

Class NotaVenta {

	public static function mostrarNotaVentas(){
		$sql = 'SELECT 
					nv.id_vnot as id_notaventa,
					h.id_his as ID_historial,
					c.id_con as ID_consulta,
    				c.id_ficha as ID_ficha,
    				pa.ci_pac as ci,
    				CONCAT(pe.nombre_per, " " , pe.paterno) as nombre_paciente,
    				nv.monto_total as monto,
    				nv.saldo as saldo,
    				nv.fecha_vnot as fecha
				FROM historial h, consulta c, nota_venta nv, paciente pa, persona pe
				where h.id_his = c.id_historial and
						nv.id_historial=h.id_his and nv.id_consulta=c.id_con and 
    					h.ci_paciente = pa.ci_pac and pe.ci = pa.ci_pac;';
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
	}

    public static function mostrarNotaVenta($idHist,$idCons){
        $sql = 'SELECT 
                    nv.id_vnot as id_notaventa,
                    h.id_his as ID_historial,
                    c.id_con as ID_consulta,
                    nv.monto_total as monto,
                    nv.saldo as saldo,
                    nv.fecha_vnot as fecha
                FROM historial h, consulta c, nota_venta nv, paciente pa, persona pe
                where h.id_his = c.id_historial and
                        nv.id_historial=h.id_his and nv.id_consulta=c.id_con and 
                        h.ci_paciente = pa.ci_pac and pe.ci = pa.ci_pac and
                        h.id_his = :idHist and c.id_con = :idCons;';
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function mostrarNotaVentaById($idNota){
        $sql = 'SELECT 
                    nv.id_vnot as id_notaventa,
                    h.id_his as ID_historial,
                    c.id_con as ID_consulta,
                    pa.ci_pac as ci_paciente,
                    nv.monto_total as monto,
                    nv.saldo as saldo,
                    nv.fecha_vnot as fecha
                FROM historial h, consulta c, nota_venta nv, paciente pa, persona pe
                where h.id_his = c.id_historial and
                        nv.id_historial=h.id_his and nv.id_consulta=c.id_con and 
                        h.ci_paciente = pa.ci_pac and pe.ci = pa.ci_pac and
                        nv.id_vnot=:idNota;';
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idNota",$idNota,PDO::PARAM_INT);
        if($stmt->execute()){
            // echo '<pre>'; print_r("exito"); echo '</pre>';
            return $stmt->fetch();
        }
        echo '<pre>'; print_r("fallo"); echo '</pre>';
        return false;
    }

	public static function registar($montoTotal,$saldo,$idHist,$idCons){
        echo '<pre>'; print_r(" aqui en el model ".$saldo); echo '</pre>';
		$sql="INSERT INTO `nota_venta`(`id_vnot`, `fecha_vnot`, `descuento`, `monto_total`, `saldo`, `id_historial`, `id_consulta`) VALUES (null, CURDATE(),0,:montoTotal,:saldo,:idHist,:idCons);";
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
		$stmt->bindValue(":montoTotal", $montoTotal,PDO::PARAM_STR);
		$stmt->bindValue(":saldo", $saldo,PDO::PARAM_STR);
		$stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);

        if($stmt->execute())
        	return true;
        return false;
	}

	public static function mostrarDatosDePaciente($idHist,$idCons){
		$sql= 'SELECT 
				h.id_his as ID_historial,
				c.id_con as ID_consulta,
    			c.id_ficha as ID_ficha,
    			pa.ci_pac as ci,
    			CONCAT(pe.nombre_per, " " , pe.paterno) as nombre_paciente,
    			pa.lugar_nac as lugar_nacimiento
			FROM historial h, consulta c, paciente pa, persona pe
			where h.id_his = c.id_historial and 
    			h.ci_paciente = pa.ci_pac and 
    			pe.ci = pa.ci_pac  and
    			h.id_his=:idHist and c.id_con=:idCons;';
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();

	}

	public static function mostrarServiciosRealizados($idHist,$idCons){
		$sql= 'SELECT 
				h.id_his as ID_historial,
				c.id_con as ID_consulta,
    			c.id_ficha as ID_ficha,
    			sc.id_serv as ID_servicio,
    			s.nombre_ser as nombre_servicio,
    			sc.precio_serv as precio
			FROM historial h, consulta c, serv_cons sc, servicio s
			where h.id_his = c.id_historial and
				sc.id_historial=h.id_his and sc.id_consulta=c.id_con and
    			sc.id_serv = s.id_ser and
    			c.id_historial = :idHist and c.id_con = :idCons;';
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public static function mostrarProductosOcupados($idHist,$idCons){
		$sql= 'SELECT 
				h.id_his as ID_historial,
				c.id_con as ID_consulta,
    			c.id_ficha as ID_ficha,
    			pc.id_prod as ID_producto,
    			p.nombre_prod as nombre_producto,
    			pc.precio_prod as precio,
    			pc.cantidad_prod as cantidad
			FROM historial h, consulta c, prod_con pc, producto p
			where h.id_his = c.id_historial and
				pc.id_historial=h.id_his and pc.id_consulta=c.id_con and
    			pc.id_prod = p.id_prod and
    			c.id_historial = :idHist and c.id_con = :idCons;';
		$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
	}

	public static function existeNotaVenta($idHist,$idCons){

		$sql="SELECT nv.id_vnot
			FROM historial h, consulta c, nota_venta nv
			where h.id_his = c.id_historial and 
				nv.id_historial = h.id_his and nv.id_consulta = c.id_con and
    			h.id_his=:idHist and c.id_con =:idCons;";
    	$con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":idHist", $idHist,PDO::PARAM_INT);
        $stmt->bindValue(":idCons", $idCons,PDO::PARAM_INT);
        $stmt->execute();
        $resp = $stmt->fetch();
        return $resp[0];
    }
}