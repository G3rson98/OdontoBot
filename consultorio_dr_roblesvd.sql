-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-02-2020 a las 22:06:03
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consultorio_dr_roblesvd`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarCuota` ()  BEGIN

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarMateriaPrima` ()  BEGIN

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarNotificaciones` ()  BEGIN
	-- parte de insertar not: de q hay productos por vencence
    -- capturando la cantidad de productos por vencerce
    
    DECLARE v_finished INTEGER DEFAULT 0;
    DECLARE FechaVen DATE;
    DECLARE cantidaFicha, cantMat_prima,IDMAT,Cant int default 0;
	DECLARE	c_mat_prima CURSOR FOR
								selecT mp.id_mat,MAX(nmp.fecha_venc) as fechaVenc
								from nota_mat_prima nmp,mat_prima mp 
								where nmp.id_mat = mp.id_mat
								group by mp.id_mat,mp.nombre_mat;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_finished = 1;
    
    OPEN c_mat_prima;
    
    get_matPrima: LOOP
		FETCH c_mat_prima into IDMAT,FechaVen;
        IF v_finished = 1 THEN 
			LEAVE get_matPrima;
		END IF;
        -- pregunto si 
        IF FechaVen < CURDATE() THEN
			SET Cant = Cant +1;
		END IF;
        
    END LOOP get_matPrima;
    CLOSE c_mat_prima;
	-- ---
    SELECT Cant;
    if(Cant > 0)THEN
		insert into notificaciones values(null,'Materia Prima','Se esta por vencer',Cant,CURDATE(),'C');
    END IF;
    
    	-- parte de insertar not: de cuantos consultas debe realizar
    
    Select COUNT(*) into cantidaFicha from ficha where fecha_fic = CURDATE();
    SELECT cantidaFicha;
    if cantidaFicha > 0 then 
		-- insertar un notificacion de cuantas fichas se han atendido
		insert into notificaciones values(null,'Ficha','Se ha Tenido a',cantidaFicha,CURDATE(),'A');
    end if;
    -- parte de insertar not: de materia prima que van a terminar
    Select count(*) into cantMat_prima from mat_prima where stock < 1;
    SELECT cantMat_prima;
    if cantMat_prima > 0 then
		insert into notificaciones values(null,'Materia Prima','Se esta por teminar',cantMat_prima,CURDATE(),'B');
    END IF;
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarOdontologo` (IN `CI` INT, IN `NOMBRE` VARCHAR(50), IN `PATERNO` VARCHAR(50), IN `MATERNO` VARCHAR(50), IN `SEXO` CHAR(1), IN `TELEFONO` INT, IN `CELULAR` INT, IN `DIRECCION` VARCHAR(50), IN `FECHA_NAC` VARCHAR(15), IN `ESTADO` CHAR(1))  BEGIN
   		IF NOT EXISTS(SELECT * FROM Persona p where p.ci = CI) THEN
			INSERT INTO Persona VALUES(CI,NOMBRE,PATERNO,MATERNO,SEXO,TELEFONO,DIRECCION,CELULAR,FECHA_NAC);
			INSERT INTO Odontologo VALUES(CI,ESTADO);
		ELSE -- caso de que se actualize los datos
			UPDATE persona p
			INNER JOIN
				   odontologo  o
			ON p.ci = o.ci_odont
            Set p.nombre_per = NOMBRE,
				p.paterno = PATERNO,
                p.materno = MATERNO,
                P.sexo = SEXO,
                p.telefono = TELEFONO,
                p.direccion = DIRECCION,
                p.celular = CELULAR,
                p.fecha_nac = FECHA_NAC,
                o.estado_odon = ESTADO
            Where p.ci = CI;
		END IF;
   END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarRecepcionista` (IN `CI` INT, IN `NOMBRE` VARCHAR(50), IN `PATERNO` VARCHAR(50), IN `MATERNO` VARCHAR(50), IN `SEXO` CHAR(1), IN `TELEFONO` INT, IN `CELULAR` INT, IN `DIRECCION` VARCHAR(50), IN `FECHA_NAC` VARCHAR(15), IN `ESTADO` CHAR(1))  BEGIN
   		IF NOT EXISTS(SELECT * FROM Persona p where p.ci = CI) THEN
			INSERT INTO Persona VALUES(CI,NOMBRE,PATERNO,MATERNO,SEXO,TELEFONO,DIRECCION,CELULAR,FECHA_NAC);
			INSERT INTO Recepcionista VALUES(CI,ESTADO);
		ELSE -- caso de que se actualize los datos
			UPDATE persona p
			INNER JOIN
				   recepcionista r
			ON p.ci = r.ci_rec
            Set p.nombre_per = NOMBRE,
				p.paterno = PATERNO,
                p.materno = MATERNO,
                P.sexo = SEXO,
                p.telefono = TELEFONO,
                p.direccion = DIRECCION,
                p.celular = CELULAR,
                p.fecha_nac = FECHA_NAC,
                r.estado_rec = ESTADO
            Where p.ci = CI;
		END IF;
   END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarServicio` (IN `ID` INT, IN `NOMBRE` VARCHAR(70), `DESCRIPCION` VARCHAR(200), IN `ESTADO` CHAR(1))  BEGIN
	IF NOT EXISTS(SELECT * FROM servicio WHERE id = ID) THEN
		INSERT INTO servicio VALUES (ID, NOMBRE,DESCRIPCION, ESTADO);
    ELSE
		UPDATE servicio
        SET nombre = NOMBRE,
			descripcion = DESCRIPCION,
			estado = ESTADO
        WHERE id = ID;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertarUsuario` (IN `NOMBRE_USER` VARCHAR(30), IN `CONTRASENA` VARCHAR(20), `ESTADO` CHAR(1), IN `CI_PERS` INT, IN `ID_ROL` INT)  BEGIN
	DECLARE ID INT DEFAULT (SELECT IFNULL(MAX(id),0) FROM Usuario);
    -- SELECT ID; -- ver valor de ID 
	IF NOT EXISTS(SELECT * FROM persona, usuario WHERE ci_persona = CI_PERS) THEN
		SET ID = ID + 1;
		INSERT INTO usuario VALUES (ID, NOMBRE_USER,CONTRASENA, ESTADO,CI_PERS,ID_ROL);
    ELSE
		UPDATE usuario
        SET nombre_usuario = NOMBRE_USER,
			contraseña = CONTRASENA,
			estado = ESTADO,
            id_rol = ID_ROL
        WHERE ci_persona = CI_PERS;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_Paciente` (IN `CI` INT, IN `NOMBRE` VARCHAR(50), IN `PATERNO` VARCHAR(50), IN `MATERNO` VARCHAR(50), IN `SEXO` CHAR(1), IN `TELEFONO` INT, IN `CELULAR` INT, IN `DIRECCION` VARCHAR(50), IN `FECHA_NAC` VARCHAR(15), IN `LUGAR_NAC` VARCHAR(40), IN `ESTADO` CHAR(1))  BEGIN
   		IF NOT EXISTS(SELECT * FROM Persona p where p.ci = CI) THEN
			INSERT INTO Persona VALUES(CI,NOMBRE,PATERNO,MATERNO,SEXO,TELEFONO,DIRECCION,CELULAR,FECHA_NAC);
			INSERT INTO Paciente VALUES(CI,ESTADO,LUGAR_NAC);
		ELSE 
			UPDATE Persona P
			INNER JOIN
				   Paciente PA
			ON P.ci = PA.ci_pac
            Set P.nombre_per = NOMBRE,
				P.paterno = PATERNO,
                P.materno = MATERNO,
                P.sexo = SEXO,
                P.telefono = TELEFONO,
                P.direccion = DIRECCION,
                P.celular = CELULAR,
                P.fecha_nac = FECHA_NAC,
                PA.estado_pac = ESTADO,
                PA.lugar_nac = LUGAR_NAC
            Where P.ci = CI and PA.ci_pac = CI;
		END IF;
   END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `validar_Usuario` (`USERNAME` VARCHAR(30), `CONTRASENA` VARCHAR(30))  BEGIN	
	Select* from usuario u where u.nombre_usuario = USERNAME and u.contrasena = CONTRASENA;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agenda`
--

CREATE TABLE `agenda` (
  `id_age` int(11) NOT NULL,
  `ci_odont` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `agenda`
--

INSERT INTO `agenda` (`id_age`, `ci_odont`) VALUES
(7, '11386573'),
(9, '11386578'),
(5, '3236957'),
(1, '3246260'),
(2, '3514551'),
(3, '3779456'),
(10, '38849282'),
(8, '7655609'),
(4, '9451784');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cara_dental`
--

CREATE TABLE `cara_dental` (
  `id_car` int(11) NOT NULL,
  `nombre_car` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cara_dental`
--

INSERT INTO `cara_dental` (`id_car`, `nombre_car`) VALUES
(1, 'Oclusal'),
(2, 'Lingual'),
(3, 'Vestibular'),
(4, 'Mesial'),
(5, 'Distal'),
(6, 'Toda'),
(7, 'Encia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_historial` int(11) NOT NULL,
  `id_con` int(11) NOT NULL,
  `motivo` varchar(150) DEFAULT NULL,
  `diagnostico` varchar(150) DEFAULT NULL,
  `tratamiento` varchar(150) DEFAULT NULL,
  `fecha_retorno` date DEFAULT NULL,
  `id_ficha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id_historial`, `id_con`, `motivo`, `diagnostico`, `tratamiento`, `fecha_retorno`, `id_ficha`) VALUES
(1, 1, 'Dolor de una pieza dental', 'Caries dental avanzada', 'Realizar un tratamiento de conducto', '2018-10-23', 1),
(1, 2, 'Continuar con el tratamiento de conducto previo.', NULL, NULL, NULL, 3),
(1, 46, ' Dolor de muela', 'Carie avanzada', ' Tratamiento de conductos', '0000-00-00', 20),
(2, 1, 'Dolor de muela', 'Periodontitis cronica', 'Exodoncia ', '2018-10-27', 2),
(2, 9, 'Dolor de encias', ' Inflamacion bucal', 'Tratamiento de gingivitis', '0000-00-00', 8),
(3, 1, 'Sensibilidad y sangrado en las encías', 'Fibrosis de la encía', 'Gingivectomia ', '2018-10-25', 4),
(3, 47, ' Reconsulta de ortodoncia', ' ', ' ', '0000-00-00', 22),
(4, 49, ' Muela infectada con pus', ' Carie avanzada', 'Extraccion', '0000-00-00', 23),
(6, 48, 'Perdida de pieza dental', ' ', ' Refraccion dental', '0000-00-00', 21),
(6, 50, ' Dolor de muela', ' Carie ', ' Tratamiento de conductos', '0000-00-00', 24),
(6, 51, 'Incomodidad al masticar', ' Debilitamiento dental por falta de calcio', ' Limpieza dental', '2019-07-05', 26),
(11, 52, ' dolor de muela', 'estado grave', ' Tratamiento de conducto', '2019-07-04', 27),
(12, 9, ' Diente roto', ' ', ' Reconstruccion dental', '0000-00-00', 7),
(12, 10, 'Dolor de muela', ' Carie', ' ', '0000-00-00', 9),
(12, 11, ' Ortodoncia', ' ', ' ', '0000-00-00', 10),
(12, 12, ' Consulta general', ' Dientes debiles', ' Limipieza general', '0000-00-00', 10),
(12, 13, 'Toma de medidas de placas', ' ', ' ', '0000-00-00', 10),
(12, 14, 'Reconsulta de ortodoncia', ' ', ' Cambio de ligas', '0000-00-00', 10),
(12, 15, 'dolor de muela', 'Carie', 'Extraccion de dientes', '2019-06-24', 11),
(12, 16, 'Dolor de encias', ' Infeccion de encias', ' Operacion de encias', '0000-00-00', 11),
(12, 17, 'Perdida de esmalte', ' Toma de liquitos que manchan ', 'Bano de esmalte', '0000-00-00', 11),
(12, 18, ' Dientes amarillos', ' Hepatitis', ' Blancamiento', '0000-00-00', 11),
(12, 19, 'Limpieza general ', ' ', ' ', '0000-00-00', 11),
(12, 20, ' ', ' ', ' ', '0000-00-00', 11),
(12, 21, ' ', ' ', ' ', '0000-00-00', 11),
(12, 22, ' ', ' ', ' ', '0000-00-00', 11),
(12, 23, ' ', ' ', ' ', '0000-00-00', 11),
(12, 24, ' ', ' ', ' ', '0000-00-00', 12),
(12, 25, ' ', ' ', ' ', '0000-00-00', 12),
(12, 26, ' ', ' ', ' ', '0000-00-00', 13),
(12, 27, ' ', ' ', ' ', '0000-00-00', 13),
(12, 28, ' ', ' ', ' ', '0000-00-00', 13),
(12, 29, ' ', ' ', ' ', '0000-00-00', 13),
(12, 30, 'resfrio', 'dsasa', 'asd', '2019-06-28', 14),
(12, 31, ' ', ' ', ' ', '0000-00-00', 13),
(12, 32, ' ', ' ', ' ', '0000-00-00', 14),
(12, 33, ' ', ' ', ' ', '0000-00-00', 15),
(12, 34, ' ', ' ', ' ', '0000-00-00', 15),
(12, 35, ' ', ' ', ' ', '0000-00-00', 15),
(12, 36, ' ', ' ', ' ', '0000-00-00', 15),
(12, 37, ' ', ' ', ' ', '0000-00-00', 15),
(12, 38, ' ', ' ', ' ', '0000-00-00', 15),
(12, 39, ' ', ' ', ' ', '0000-00-00', 15),
(12, 40, 'dolor de muelas', 'dsasasssssssssssssssssssssssssssssssssssaaaaaaaaaaaaaaaaaaaa', 'asduuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu', '2019-06-15', 16),
(12, 42, ' ', ' ', ' ', '0000-00-00', 16),
(12, 43, ' ', ' ', ' ', '0000-00-00', 17),
(12, 44, ' ', ' ', ' ', '0000-00-00', 18),
(12, 45, ' ', ' ', ' ', '0000-00-00', 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuota`
--

CREATE TABLE `cuota` (
  `id_nota` int(11) NOT NULL,
  `id_cuo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` float NOT NULL,
  `ci_paciente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuota`
--

INSERT INTO `cuota` (`id_nota`, `id_cuo`, `fecha`, `monto`, `ci_paciente`) VALUES
(1, 1, '2018-10-21', 50, '5401932'),
(1, 2, '2018-10-23', 50, '5401932'),
(1, 3, '2019-06-30', 250, '2578412'),
(2, 1, '2018-10-22', 100, '3236784'),
(3, 1, '2018-10-23', 100, '5478145'),
(3, 2, '2019-06-29', 10, '5401932'),
(3, 3, '2019-06-29', 10, '5401932'),
(3, 4, '2019-06-29', 30, '5401932'),
(3, 5, '2019-06-29', 20, '5401932'),
(3, 6, '2019-06-30', 30, '5401932'),
(5, 1, '2019-06-29', 500, '19087'),
(5, 2, '2019-06-30', 1130, '19087'),
(6, 1, '2019-06-29', 2180, '19087'),
(7, 1, '2019-06-30', 500, '19087'),
(7, 2, '2019-07-02', 100, '19087'),
(7, 3, '2019-07-02', 50, '19087'),
(7, 4, '2019-07-03', 500, '19087'),
(8, 1, '2019-07-03', 800, '19087'),
(8, 2, '2019-07-03', 102, '19087'),
(10, 1, '2019-07-03', 500, '2578412'),
(10, 2, '2019-07-03', 400, '2578412'),
(10, 3, '2019-07-03', 500, '2578412'),
(11, 1, '2019-07-03', 500, '19087'),
(11, 2, '2019-07-03', 300, '19087'),
(17, 1, '2019-07-03', 1000, '19087'),
(17, 2, '2019-07-03', 1200, '19087'),
(18, 1, '2019-07-03', 100, '5478145'),
(18, 2, '2019-07-03', 150, '5478145'),
(19, 1, '2019-07-03', 500, '5401932'),
(19, 2, '2019-07-03', 300, '5401932'),
(20, 1, '2019-07-03', 300, '7841298'),
(20, 2, '2019-07-03', 100, '7841298'),
(21, 1, '2019-07-04', 400, '7841298'),
(22, 1, '2019-07-04', 300, '7841298'),
(23, 1, '2019-07-04', 600, '9812247'),
(23, 2, '2019-07-04', 300, '9812247');

--
-- Disparadores `cuota`
--
DELIMITER $$
CREATE TRIGGER `tr_actualizar_saldo_notaventa` AFTER INSERT ON `cuota` FOR EACH ROW BEGIN
	DECLARE MontoTotal INT;
    DECLARE SaldoAnt INT;
    -- declaro cursor
    DECLARE cur_Datos_NotaVenta CURSOR FOR SELECT saldo
					   FROM nota_venta
					   where id_vnot= NEW.id_nota;
    OPEN cur_Datos_NotaVenta;
		FETCH cur_Datos_NotaVenta into SaldoAnt;
    CLOSE cur_Datos_NotaVenta;
    -- fin de cursor
	update nota_venta nv
    set nv.saldo = SaldoAnt - new.monto
	WHERE nv.id_vnot = NEW.id_nota;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `c_p_dental`
--

CREATE TABLE `c_p_dental` (
  `id_odont` int(11) NOT NULL,
  `id_pieza` smallint(6) NOT NULL,
  `id_cara` int(11) NOT NULL,
  `estado_diag` varchar(20) NOT NULL,
  `estado_trat` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `c_p_dental`
--

INSERT INTO `c_p_dental` (`id_odont`, `id_pieza`, `id_cara`, `estado_diag`, `estado_trat`) VALUES
(1, 13, 1, 'periodontitis', 'f'),
(1, 14, 1, 'ruptura', 't'),
(1, 15, 1, 'ruptura', 'f'),
(1, 15, 2, 'carie', 't'),
(1, 18, 1, 'periodontitis', 'f'),
(1, 41, 1, 'ruptura', 't'),
(1, 45, 1, 'carie', 't'),
(1, 47, 1, 'carie', 't'),
(1, 48, 5, 'ruptura', 't'),
(3, 13, 1, 'carie', 'f'),
(3, 26, 4, 'ninguna', 'f'),
(3, 42, 1, 'gingivitis', 't'),
(3, 46, 1, 'ninguna', 'f'),
(4, 46, 1, 'carie', 't'),
(5, 41, 2, 'ruptura', 't'),
(6, 13, 1, 'carie', 't'),
(6, 42, 4, 'carie', 't'),
(7, 16, 1, 'carie', 't'),
(8, 15, 1, 'ruptura', 't'),
(8, 21, 1, 'carie', 't'),
(8, 41, 1, 'carie', 't'),
(9, 17, 1, 'carie', 't'),
(13, 15, 1, 'ninguna', 'f'),
(14, 16, 1, 'carie', 't');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `id_esp` int(11) NOT NULL,
  `nombre_esp` varchar(30) NOT NULL,
  `estado_espe` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`id_esp`, `nombre_esp`, `estado_espe`) VALUES
(1, 'rehabilitación orales', 'b'),
(2, 'periodoncia ', 'a'),
(3, 'endodoncia', 'a'),
(4, 'odontopediatria', 'a'),
(5, 'ortodoncia', 'a'),
(6, 'odontología forense', 'a'),
(7, 'cariologia', 'a'),
(8, 'gnatologia', 'a'),
(9, 'patologia bucal', 'a'),
(10, 'implantologia oral', 'a'),
(11, 'odontologia preventiva', 'a'),
(12, 'rehabilitación', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha`
--

CREATE TABLE `ficha` (
  `id_fic` int(11) NOT NULL,
  `fecha_fic` date NOT NULL,
  `hora` time NOT NULL,
  `estado_fic` char(1) NOT NULL,
  `ci_pac` varchar(20) NOT NULL,
  `id_agen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ficha`
--

INSERT INTO `ficha` (`id_fic`, `fecha_fic`, `hora`, `estado_fic`, `ci_pac`, `id_agen`) VALUES
(1, '2018-10-21', '15:29:00', 'a', '5401932', 4),
(2, '2018-10-22', '09:00:00', 'a', '3236784', 4),
(3, '2018-10-23', '09:00:00', 'a', '5401932', 4),
(4, '2018-10-23', '09:30:00', 'a', '5478145', 4),
(5, '2019-06-06', '10:50:00', 'a', '19087', 1),
(6, '2019-06-17', '09:30:00', 'a', '19087', 1),
(7, '2019-06-16', '18:00:00', 'a', '19087', 1),
(8, '2019-06-16', '20:00:00', 'a', '3236784', 1),
(9, '2019-06-20', '15:00:00', 'a', '19087', 1),
(10, '2019-06-22', '16:00:00', 'a', '19087', 1),
(11, '2019-06-24', '19:00:00', 'a', '19087', 1),
(12, '2019-06-25', '15:00:00', 'a', '19087', 1),
(13, '2019-06-27', '17:00:00', 'a', '19087', 1),
(14, '2019-06-27', '10:00:00', 'a', '19087', 1),
(15, '2019-06-29', '18:00:00', 'a', '19087', 1),
(16, '2019-06-30', '01:01:00', 'a', '19087', 1),
(17, '2019-07-03', '09:00:00', 'a', '19087', 1),
(18, '2019-07-03', '15:00:00', 'a', '19087', 1),
(19, '2019-07-03', '21:00:00', 'a', '19087', 1),
(20, '2019-07-03', '20:00:00', 'a', '2578412', 1),
(21, '2019-07-03', '20:30:00', 'a', '7841298', 1),
(22, '2019-07-03', '20:45:00', 'a', '5401932', 1),
(23, '2019-07-03', '20:55:00', 'a', '5478145', 1),
(24, '2019-07-04', '00:15:00', 'a', '7841298', 7),
(25, '2019-07-04', '00:50:00', 'a', '7841298', 7),
(26, '2019-07-04', '10:00:00', 'a', '7841298', 1),
(27, '2019-07-04', '11:00:00', 'a', '9812247', 1),
(28, '2019-07-04', '11:30:00', 'a', '9795123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficha_serv`
--

CREATE TABLE `ficha_serv` (
  `id_ficha` int(11) NOT NULL,
  `id_serv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ficha_serv`
--

INSERT INTO `ficha_serv` (`id_ficha`, `id_serv`) VALUES
(1, 20),
(2, 20),
(3, 4),
(4, 20),
(5, 14),
(6, 19),
(7, 7),
(8, 4),
(9, 6),
(10, 9),
(11, 2),
(12, 7),
(13, 4),
(14, 5),
(15, 9),
(16, 14),
(17, 2),
(18, 11),
(19, 13),
(20, 15),
(21, 17),
(22, 12),
(23, 12),
(24, 1),
(25, 2),
(26, 6),
(27, 1),
(28, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_de_vida`
--

CREATE TABLE `form_de_vida` (
  `id_for` int(11) NOT NULL,
  `altura` float DEFAULT NULL,
  `peso` float DEFAULT NULL,
  `temperatura` float DEFAULT NULL,
  `frecuencia_cardiaca` float DEFAULT NULL,
  `precion_arterial` varchar(6) DEFAULT NULL,
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `form_de_vida`
--

INSERT INTO `form_de_vida` (`id_for`, `altura`, `peso`, `temperatura`, `frecuencia_cardiaca`, `precion_arterial`, `id_historial`, `id_consulta`) VALUES
(1, 1.69, 65, 36.5, 75, NULL, 1, 1),
(2, 1.81, 83, 37.8, 85, NULL, 2, 1),
(3, 1.69, 65, 37.2, 85, NULL, 1, 2),
(4, 1.54, 55.5, 36.8, 87, '120 80', 3, 1),
(5, 12, 12, 39.8, 12, '12', 12, 25),
(6, 12, 12, 39.8, 12, '12', 12, 39),
(7, 1.6, 80, 36.5, 85, '', 6, 51),
(8, 1.6, 12, 39.8, 12, '12', 11, 52);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_his` int(11) NOT NULL,
  `fecha_reg` date NOT NULL,
  `ultima_consulta` date DEFAULT NULL,
  `ci_paciente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_his`, `fecha_reg`, `ultima_consulta`, `ci_paciente`) VALUES
(1, '2019-05-11', NULL, '2578412'),
(2, '2019-05-11', NULL, '3236784'),
(3, '2019-05-11', NULL, '5401932'),
(4, '2019-05-11', NULL, '5478145'),
(5, '2019-05-11', NULL, '6869334'),
(6, '2019-05-11', NULL, '7841298'),
(7, '2019-05-11', NULL, '9164512'),
(8, '2019-05-11', NULL, '9215439'),
(9, '2019-05-11', NULL, '9791247'),
(10, '2019-05-11', NULL, '9795123'),
(11, '2019-05-11', NULL, '9812247'),
(12, '0000-00-00', '2019-06-09', '19087');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_hor` int(11) NOT NULL,
  `hra_inicio` time NOT NULL,
  `hra_fin` time NOT NULL,
  `dia` char(12) NOT NULL,
  `estado` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_hor`, `hra_inicio`, `hra_fin`, `dia`, `estado`) VALUES
(1, '09:00:00', '12:00:00', 'lunes', 'a'),
(2, '15:00:00', '20:00:00', 'lunes', 'a'),
(3, '09:00:00', '12:00:00', 'martes', 'a'),
(4, '15:00:00', '21:00:00', 'martes', 'a'),
(5, '09:00:00', '12:00:00', 'miercoles', 'a'),
(6, '15:00:00', '21:00:00', 'miercoles', 'a'),
(7, '09:00:00', '12:00:00', 'jueves', 'a'),
(8, '15:00:00', '21:00:00', 'jueves', 'a'),
(9, '09:00:00', '12:00:00', 'viernes', 'a'),
(10, '15:00:00', '21:00:00', 'viernes', 'a'),
(11, '09:00:00', '12:00:00', 'sabado', 'a'),
(12, '15:00:00', '18:00:00', 'sabado', 'a'),
(13, '00:02:00', '23:01:00', 'domingo', 'a'),
(14, '14:00:00', '21:00:00', 'domingo', 'a'),
(15, '10:00:00', '13:00:00', 'lunes', 'a'),
(16, '00:04:00', '23:00:00', 'jueves', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `idlog` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `accion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `log`
--

INSERT INTO `log` (`idlog`, `id_usuario`, `nombre_usuario`, `id_rol`, `accion`, `descripcion`, `fecha`) VALUES
(1, 1, 'admin', 1, 'ingreso', 'sistema', '2019-05-20 23:28:59'),
(2, 1, 'admin', 1, 'Salio', 'Sistema', '2019-05-21 00:25:02'),
(3, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 00:28:58'),
(4, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-21 00:30:01'),
(5, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-21 00:31:54'),
(6, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-21 00:32:33'),
(7, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 00:34:31'),
(8, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-21 00:35:00'),
(9, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-21 00:35:04'),
(10, 2, 'maria', 3, 'Ingreso', ' al Sistema', '2019-05-21 00:35:27'),
(11, 2, 'maria', 3, 'Salio', 'del Sistema', '2019-05-21 00:35:28'),
(12, 4, 'gabi', 2, 'Ingreso', ' al Sistema', '2019-05-21 00:35:38'),
(13, 4, 'gabi', 2, 'Salio', 'del Sistema', '2019-05-21 00:35:40'),
(14, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 00:35:46'),
(15, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 00:39:44'),
(16, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-21 00:48:59'),
(17, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-21 01:02:46'),
(18, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:13:55'),
(19, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:15:28'),
(20, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:15:44'),
(21, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:47:59'),
(22, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:48:13'),
(23, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:48:16'),
(24, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:49:38'),
(25, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:49:41'),
(26, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:54:08'),
(27, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:54:11'),
(28, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 11:55:33'),
(29, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 11:55:35'),
(30, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 12:07:59'),
(31, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 12:08:15'),
(32, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-21 12:08:22'),
(33, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-21 12:09:17'),
(34, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-21 12:09:31'),
(35, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-21 12:19:19'),
(36, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-21 12:21:07'),
(37, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-21 12:21:23'),
(38, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-22 07:53:07'),
(39, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-22 07:57:14'),
(40, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-22 07:57:22'),
(41, 3, 'camila', 2, 'Inserto', 'un Odontologo', '2019-05-22 10:04:39'),
(42, 3, 'camila', 2, 'Inserto', 'un Odontologo', '2019-05-22 10:14:29'),
(43, 3, 'camila', 2, 'Inserto', 'un Odontologo', '2019-05-22 10:26:01'),
(44, 3, 'camila', 2, 'Inserto', 'un Usuario', '2019-05-22 10:26:02'),
(45, 3, 'camila', 2, 'Inserto', 'un Odontologo', '2019-05-22 10:34:45'),
(46, 3, 'camila', 2, 'Inserto', 'un Usuario', '2019-05-22 10:34:45'),
(47, 3, 'camila', 2, 'Inserto', 'un Odontologo', '2019-05-22 10:36:20'),
(48, 3, 'camila', 2, 'Inserto', 'un Usuario', '2019-05-22 10:36:20'),
(49, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-22 15:27:46'),
(50, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-22 16:06:56'),
(51, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-22 16:07:01'),
(52, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-22 16:51:03'),
(53, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-22 16:51:13'),
(54, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-05-22 16:51:47'),
(55, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-22 16:51:52'),
(56, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-22 16:52:04'),
(57, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-23 05:33:46'),
(58, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-23 05:33:55'),
(59, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-23 05:34:08'),
(60, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-23 07:39:30'),
(61, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-25 08:30:30'),
(62, 1, 'admin', 1, 'Inserto', 'un Paciente', '2019-05-25 09:59:04'),
(63, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-25 11:35:12'),
(64, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-05-25 12:49:14'),
(65, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-05-25 12:55:39'),
(66, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-05-25 12:56:57'),
(67, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-05-25 12:56:57'),
(68, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-05-25 13:02:23'),
(69, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-05-25 13:02:23'),
(70, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-25 13:42:56'),
(71, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-25 13:43:33'),
(72, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-25 13:51:47'),
(73, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-25 13:52:05'),
(74, 1, 'admin', 1, 'Edito', 'un Paciente', '2019-05-25 13:54:06'),
(75, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 14:54:37'),
(76, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 14:55:10'),
(77, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 14:55:54'),
(78, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 14:57:41'),
(79, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 15:02:27'),
(80, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 15:03:08'),
(81, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 15:03:19'),
(82, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 15:03:52'),
(83, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 15:04:07'),
(84, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-05-25 16:16:02'),
(85, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-05-25 16:17:24'),
(86, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-05-25 16:19:22'),
(87, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-05-25 16:20:28'),
(88, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-05-25 16:20:28'),
(89, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-05-25 16:25:39'),
(90, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-05-25 16:25:39'),
(91, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-25 16:36:36'),
(92, 13, 'maria', 3, 'Ingreso', ' al Sistema', '2019-05-25 16:36:43'),
(93, 13, 'maria', 3, 'Salio', 'del Sistema', '2019-05-25 16:36:46'),
(94, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-25 16:44:00'),
(95, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:10:18'),
(96, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:11:10'),
(97, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:12:10'),
(98, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:15:48'),
(99, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:15:58'),
(100, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:16:41'),
(101, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-25 17:17:07'),
(102, 1, 'admin', 1, 'Edito', 'un usuario', '2019-05-25 18:45:22'),
(103, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-26 21:10:46'),
(104, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-05-28 11:17:20'),
(105, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-28 14:05:16'),
(106, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-05-29 20:40:05'),
(107, 1, 'admin', 1, 'Inserto', 'un horario', '2019-05-29 21:38:16'),
(108, 1, 'admin', 1, 'Inserto', 'un horario', '2019-05-29 21:38:41'),
(109, 1, 'admin', 1, 'Edito', 'un horario', '2019-05-29 21:50:21'),
(110, 1, 'admin', 1, 'Edito', 'un horario', '2019-05-29 21:50:41'),
(111, 1, 'admin', 1, 'Edito', 'un horario', '2019-05-29 21:51:19'),
(112, 1, 'admin', 1, 'Edito', 'un horario', '2019-05-29 21:51:54'),
(113, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-05-29 22:10:13'),
(114, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-05-30 01:39:51'),
(115, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 13:45:32'),
(116, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-06 13:46:45'),
(117, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 13:46:51'),
(118, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-06 13:49:07'),
(119, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 14:10:17'),
(120, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-06 14:17:18'),
(121, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 14:17:30'),
(122, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-06 14:28:36'),
(123, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 14:29:32'),
(124, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-06 14:33:15'),
(125, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 14:39:08'),
(126, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-06 15:11:45'),
(127, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-06 15:13:20'),
(128, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-06 15:30:44'),
(129, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 12:58:20'),
(130, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-06-08 14:59:25'),
(131, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-08 14:59:25'),
(132, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:00:12'),
(133, 14, 'prueba', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:00:20'),
(134, 14, 'prueba', 1, 'Salio', 'del Sistema', '2019-06-08 15:00:33'),
(135, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:00:39'),
(136, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:03:33'),
(137, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:03:41'),
(138, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:03:47'),
(139, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:05:42'),
(140, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:05:46'),
(141, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:05:59'),
(142, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:06:03'),
(143, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:06:07'),
(144, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:06:14'),
(145, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:06:23'),
(146, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:07:24'),
(147, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:07:29'),
(148, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:11:10'),
(149, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:11:21'),
(150, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:11:28'),
(151, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:11:54'),
(152, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:11:58'),
(153, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:12:19'),
(154, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:12:54'),
(155, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:13:01'),
(156, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:13:10'),
(157, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:13:17'),
(158, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:13:32'),
(159, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:13:36'),
(160, 13, 'maria', 3, 'Ingreso', ' al Sistema', '2019-06-08 15:13:54'),
(161, 13, 'maria', 3, 'Salio', 'del Sistema', '2019-06-08 15:20:15'),
(162, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:25:19'),
(163, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:30:24'),
(164, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:30:30'),
(165, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:30:54'),
(166, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:30:59'),
(167, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:31:20'),
(168, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:38:31'),
(169, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:38:37'),
(170, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:38:51'),
(171, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:39:55'),
(172, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:40:03'),
(173, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:40:14'),
(174, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:40:21'),
(175, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-08 15:42:27'),
(176, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:42:33'),
(177, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 15:42:40'),
(178, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 15:42:45'),
(179, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:42:52'),
(180, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:58:49'),
(181, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-08 15:58:55'),
(182, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:59:06'),
(183, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:59:36'),
(184, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-08 15:59:50'),
(185, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-08 15:59:50'),
(186, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 15:59:54'),
(187, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 15:59:57'),
(188, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 16:00:02'),
(189, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-08 16:07:16'),
(190, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-06-08 16:07:24'),
(191, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-06-08 16:07:30'),
(192, 13, 'maria', 3, 'Ingreso', ' al Sistema', '2019-06-08 16:07:35'),
(193, 13, 'maria', 3, 'Salio', 'del Sistema', '2019-06-08 16:07:39'),
(194, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-08 16:22:55'),
(195, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-10 20:18:41'),
(196, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-10 20:30:26'),
(197, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-10 20:30:34'),
(198, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-10 20:32:56'),
(199, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-10 20:35:51'),
(200, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-10 20:37:52'),
(201, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-10 20:37:59'),
(202, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-10 20:39:15'),
(203, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-10 20:39:17'),
(204, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-10 20:39:26'),
(205, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-11 16:40:06'),
(206, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-11 16:40:15'),
(207, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-11 16:40:24'),
(208, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-11 17:01:36'),
(209, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-11 17:01:41'),
(210, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-11 17:05:31'),
(211, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-11 17:05:32'),
(212, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-11 17:05:36'),
(213, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-12 15:41:12'),
(214, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-12 16:09:40'),
(215, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-12 16:09:40'),
(216, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-12 16:10:12'),
(217, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-12 16:12:47'),
(218, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-12 16:16:24'),
(219, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-12 16:18:21'),
(220, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-12 16:45:55'),
(221, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-14 08:53:40'),
(222, 1, 'admin', 1, 'Eliminó', 'un producto', '2019-06-14 09:12:59'),
(223, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-16 13:35:54'),
(224, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-16 13:36:07'),
(225, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-16 14:04:55'),
(226, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-16 14:04:57'),
(227, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-16 14:05:39'),
(228, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-16 14:15:20'),
(229, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-16 14:15:31'),
(230, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-16 14:36:50'),
(231, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-16 14:38:34'),
(232, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-16 14:45:16'),
(233, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-16 14:45:33'),
(234, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-16 14:47:18'),
(235, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-17 06:59:01'),
(236, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:37:14'),
(237, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:41:03'),
(238, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:44:22'),
(239, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:46:52'),
(240, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:49:25'),
(241, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:51:29'),
(242, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 09:54:26'),
(243, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-17 10:59:58'),
(244, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-17 11:02:50'),
(245, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-17 11:03:48'),
(246, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-17 11:05:16'),
(247, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-20 08:34:44'),
(248, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-20 08:41:15'),
(249, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-20 10:18:58'),
(250, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 07:43:56'),
(251, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 07:53:57'),
(252, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 07:53:58'),
(253, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 07:54:05'),
(254, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 09:27:37'),
(255, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 09:27:43'),
(256, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 09:32:01'),
(257, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 09:32:10'),
(258, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 09:52:30'),
(259, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:02:30'),
(260, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:13:41'),
(261, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:21:41'),
(262, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:26:00'),
(263, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:31:27'),
(264, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:42:17'),
(265, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:48:12'),
(266, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:57:44'),
(267, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 10:59:11'),
(268, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 11:18:02'),
(269, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-21 11:21:25'),
(270, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 11:58:41'),
(271, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:00:09'),
(272, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 12:02:29'),
(273, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:29'),
(274, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:29'),
(275, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:29'),
(276, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:29'),
(277, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(278, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(279, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(280, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(281, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(282, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(283, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(284, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(285, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(286, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(287, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(288, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(289, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(290, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(291, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(292, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(293, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:30'),
(294, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(295, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(296, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(297, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(298, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(299, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(300, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(301, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(302, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(303, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(304, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(305, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(306, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(307, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(308, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(309, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(310, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(311, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(312, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:31'),
(313, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(314, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(315, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(316, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(317, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(318, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(319, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(320, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(321, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(322, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(323, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(324, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(325, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(326, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(327, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(328, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(329, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(330, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:32'),
(331, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(332, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(333, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(334, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(335, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(336, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(337, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(338, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(339, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(340, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(341, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(342, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(343, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(344, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(345, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:33'),
(346, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(347, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(348, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(349, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(350, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(351, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(352, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(353, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(354, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(355, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(356, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(357, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(358, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(359, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(360, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(361, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(362, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(363, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:34'),
(364, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(365, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(366, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(367, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(368, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(369, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(370, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(371, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(372, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(373, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(374, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(375, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(376, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(377, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(378, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(379, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(380, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:35'),
(381, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(382, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(383, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(384, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(385, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(386, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(387, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(388, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(389, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(390, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(391, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(392, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(393, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(394, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(395, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(396, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(397, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(398, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:36'),
(399, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(400, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(401, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(402, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(403, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(404, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(405, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(406, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(407, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(408, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(409, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(410, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(411, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(412, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(413, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(414, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(415, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(416, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(417, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:37'),
(418, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(419, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(420, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(421, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(422, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(423, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(424, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(425, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(426, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(427, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(428, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(429, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(430, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(431, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(432, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(433, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(434, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:38'),
(435, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(436, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(437, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(438, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(439, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(440, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(441, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(442, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(443, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(444, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(445, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(446, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:39'),
(447, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(448, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(449, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(450, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(451, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(452, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(453, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(454, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(455, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(456, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(457, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(458, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(459, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(460, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(461, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:40'),
(462, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(463, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(464, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(465, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(466, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(467, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(468, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(469, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(470, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(471, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(472, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(473, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(474, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(475, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(476, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(477, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:41'),
(478, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(479, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(480, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(481, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(482, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(483, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(484, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(485, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(486, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(487, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(488, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(489, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(490, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(491, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(492, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(493, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(494, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(495, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(496, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:42'),
(497, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(498, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(499, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(500, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(501, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(502, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(503, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(504, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(505, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(506, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(507, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(508, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(509, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(510, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(511, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(512, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(513, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(514, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(515, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:43'),
(516, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(517, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(518, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(519, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(520, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(521, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(522, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(523, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(524, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(525, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(526, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(527, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(528, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(529, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(530, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(531, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(532, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(533, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:44'),
(534, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(535, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(536, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(537, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(538, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(539, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(540, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(541, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(542, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(543, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(544, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(545, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(546, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(547, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(548, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(549, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(550, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(551, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(552, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:45'),
(553, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(554, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(555, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(556, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(557, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(558, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(559, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(560, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(561, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(562, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(563, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(564, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(565, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(566, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(567, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(568, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(569, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(570, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:46'),
(571, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:47'),
(572, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:47'),
(573, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:47'),
(574, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:02:47'),
(575, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:03:00'),
(576, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 12:03:33'),
(577, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:33'),
(578, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(579, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(580, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(581, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(582, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(583, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(584, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(585, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(586, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(587, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(588, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(589, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(590, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(591, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(592, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(593, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(594, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(595, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(596, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(597, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(598, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(599, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:34'),
(600, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(601, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(602, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(603, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(604, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(605, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(606, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(607, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(608, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(609, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(610, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(611, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(612, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(613, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(614, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(615, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(616, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:35'),
(617, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(618, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(619, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(620, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(621, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(622, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(623, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(624, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(625, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(626, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(627, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(628, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(629, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(630, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(631, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(632, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(633, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(634, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(635, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(636, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(637, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(638, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(639, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:36'),
(640, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(641, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(642, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(643, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(644, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(645, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(646, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(647, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(648, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(649, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(650, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(651, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(652, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(653, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:37'),
(654, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(655, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(656, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(657, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(658, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(659, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(660, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(661, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(662, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(663, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(664, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(665, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(666, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(667, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(668, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(669, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(670, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(671, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:38'),
(672, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(673, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(674, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(675, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(676, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(677, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(678, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(679, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(680, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(681, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(682, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(683, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(684, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(685, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(686, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(687, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(688, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(689, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:39'),
(690, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(691, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(692, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(693, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(694, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(695, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(696, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(697, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(698, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(699, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(700, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(701, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(702, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(703, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(704, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(705, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(706, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(707, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(708, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(709, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:40'),
(710, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(711, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(712, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(713, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(714, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(715, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(716, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(717, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(718, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41');
INSERT INTO `log` (`idlog`, `id_usuario`, `nombre_usuario`, `id_rol`, `accion`, `descripcion`, `fecha`) VALUES
(719, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(720, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(721, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(722, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(723, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(724, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(725, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:41'),
(726, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(727, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(728, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(729, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(730, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(731, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(732, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(733, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(734, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(735, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(736, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(737, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(738, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(739, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(740, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(741, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(742, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:42'),
(743, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(744, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(745, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(746, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(747, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(748, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(749, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(750, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(751, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(752, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(753, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(754, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(755, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(756, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(757, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(758, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:43'),
(759, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(760, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(761, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(762, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(763, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(764, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(765, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(766, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(767, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(768, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(769, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(770, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(771, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(772, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(773, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(774, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(775, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(776, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(777, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(778, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:44'),
(779, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(780, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(781, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(782, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(783, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(784, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(785, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(786, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(787, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(788, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(789, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(790, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(791, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(792, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(793, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(794, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(795, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(796, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(797, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(798, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:45'),
(799, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(800, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(801, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(802, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(803, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(804, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(805, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(806, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(807, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(808, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(809, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(810, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(811, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(812, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(813, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(814, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(815, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(816, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(817, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(818, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:46'),
(819, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(820, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(821, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(822, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(823, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(824, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(825, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(826, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(827, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(828, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(829, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(830, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(831, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(832, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(833, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(834, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(835, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(836, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(837, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:47'),
(838, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(839, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(840, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(841, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(842, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(843, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(844, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(845, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(846, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(847, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(848, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(849, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(850, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(851, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(852, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:48'),
(853, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(854, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(855, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(856, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(857, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(858, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(859, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(860, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(861, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(862, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(863, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(864, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(865, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(866, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(867, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(868, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(869, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:49'),
(870, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(871, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(872, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(873, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(874, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(875, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(876, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(877, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(878, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(879, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(880, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(881, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(882, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(883, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(884, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(885, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(886, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(887, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(888, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(889, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(890, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:50'),
(891, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(892, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(893, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(894, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(895, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(896, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(897, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(898, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(899, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(900, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(901, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(902, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(903, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(904, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(905, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(906, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(907, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:51'),
(908, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(909, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(910, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(911, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(912, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(913, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(914, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(915, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(916, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(917, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(918, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(919, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(920, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(921, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(922, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(923, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(924, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(925, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(926, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:52'),
(927, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(928, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(929, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(930, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(931, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(932, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(933, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(934, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(935, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(936, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(937, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(938, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(939, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(940, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(941, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(942, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(943, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(944, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:53'),
(945, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(946, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(947, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(948, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(949, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(950, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(951, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(952, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(953, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(954, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(955, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(956, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(957, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(958, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(959, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(960, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(961, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(962, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(963, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(964, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:54'),
(965, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(966, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(967, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(968, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(969, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(970, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(971, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(972, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(973, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(974, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(975, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(976, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(977, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(978, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(979, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(980, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(981, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(982, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(983, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:55'),
(984, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(985, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(986, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(987, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(988, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(989, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(990, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(991, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(992, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(993, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(994, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(995, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(996, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(997, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(998, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(999, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(1000, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(1001, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(1002, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:56'),
(1003, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1004, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1005, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1006, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1007, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1008, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1009, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1010, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1011, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1012, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1013, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1014, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1015, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1016, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1017, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:57'),
(1018, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1019, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1020, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1021, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1022, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1023, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1024, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1025, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1026, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1027, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1028, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1029, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1030, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1031, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1032, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1033, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1034, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1035, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1036, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1037, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1038, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1039, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:58'),
(1040, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1041, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1042, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1043, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1044, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1045, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1046, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1047, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1048, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1049, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1050, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1051, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1052, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1053, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1054, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1055, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1056, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1057, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1058, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1059, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1060, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1061, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1062, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:03:59'),
(1063, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1064, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1065, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1066, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1067, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1068, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1069, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1070, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1071, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1072, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1073, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1074, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1075, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1076, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1077, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1078, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1079, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1080, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1081, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1082, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:00'),
(1083, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1084, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1085, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1086, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1087, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1088, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1089, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1090, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1091, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1092, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1093, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1094, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1095, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1096, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1097, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:01'),
(1098, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1099, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1100, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1101, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1102, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1103, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1104, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1105, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1106, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1107, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1108, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1109, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1110, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1111, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1112, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1113, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1114, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1115, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1116, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1117, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1118, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1119, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:02'),
(1120, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1121, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1122, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1123, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1124, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1125, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1126, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1127, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1128, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1129, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1130, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1131, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1132, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1133, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1134, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1135, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1136, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1137, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:03'),
(1138, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:58'),
(1139, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:58'),
(1140, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:58'),
(1141, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1142, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1143, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1144, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1145, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1146, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1147, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1148, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1149, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1150, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1151, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1152, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1153, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1154, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1155, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1156, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1157, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1158, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1159, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1160, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1161, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:04:59'),
(1162, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1163, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1164, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1165, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1166, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1167, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1168, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1169, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1170, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1171, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1172, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1173, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1174, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1175, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1176, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1177, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1178, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1179, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1180, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1181, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1182, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1183, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1184, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:00'),
(1185, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1186, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1187, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1188, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1189, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1190, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1191, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1192, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1193, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1194, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1195, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1196, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1197, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1198, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1199, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1200, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1201, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1202, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1203, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:01'),
(1204, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1205, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1206, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1207, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1208, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1209, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1210, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1211, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1212, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1213, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1214, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1215, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1216, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1217, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1218, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1219, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1220, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1221, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1222, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1223, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1224, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:02'),
(1225, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1226, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1227, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1228, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1229, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1230, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1231, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1232, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1233, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1234, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1235, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1236, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1237, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1238, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1239, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1240, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1241, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:03'),
(1242, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1243, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1244, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1245, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1246, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1247, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1248, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1249, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1250, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1251, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1252, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1253, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1254, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1255, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1256, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1257, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1258, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1259, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1260, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1261, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:04'),
(1262, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1263, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1264, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1265, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1266, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1267, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1268, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1269, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1270, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1271, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1272, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1273, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1274, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1275, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1276, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1277, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1278, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1279, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:05'),
(1280, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1281, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1282, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1283, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1284, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1285, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1286, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1287, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1288, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1289, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1290, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1291, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1292, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1293, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1294, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1295, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1296, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1297, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1298, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1299, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1300, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:06'),
(1301, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1302, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1303, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1304, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1305, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1306, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1307, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1308, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1309, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1310, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1311, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1312, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1313, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1314, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1315, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1316, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1317, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:07'),
(1318, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1319, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1320, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1321, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1322, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1323, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1324, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1325, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1326, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1327, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1328, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1329, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1330, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1331, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1332, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1333, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:08'),
(1334, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:09'),
(1335, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:09'),
(1336, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:05:12'),
(1337, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1338, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1339, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1340, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1341, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1342, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1343, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1344, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1345, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1346, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1347, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1348, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1349, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1350, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1351, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:19'),
(1352, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1353, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1354, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1355, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1356, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1357, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1358, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1359, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1360, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1361, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1362, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1363, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1364, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1365, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1366, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1367, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1368, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1369, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1370, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1371, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:20'),
(1372, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1373, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1374, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1375, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1376, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1377, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1378, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1379, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1380, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1381, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1382, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1383, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1384, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1385, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1386, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1387, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1388, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1389, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1390, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1391, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:21'),
(1392, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1393, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1394, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1395, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1396, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1397, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1398, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1399, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1400, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1401, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1402, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1403, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1404, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1405, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1406, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1407, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1408, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1409, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:22'),
(1410, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1411, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1412, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1413, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1414, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1415, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1416, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1417, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1418, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1419, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1420, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1421, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1422, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1423, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:23'),
(1424, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24');
INSERT INTO `log` (`idlog`, `id_usuario`, `nombre_usuario`, `id_rol`, `accion`, `descripcion`, `fecha`) VALUES
(1425, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1426, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1427, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1428, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1429, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1430, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1431, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1432, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1433, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1434, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1435, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1436, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1437, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1438, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1439, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:24'),
(1440, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1441, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1442, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1443, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1444, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1445, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1446, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1447, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1448, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1449, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1450, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1451, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1452, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1453, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1454, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1455, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1456, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:25'),
(1457, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1458, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1459, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1460, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1461, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1462, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1463, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1464, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1465, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1466, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1467, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1468, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1469, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1470, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1471, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1472, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1473, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1474, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1475, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:26'),
(1476, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1477, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1478, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1479, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1480, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1481, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1482, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1483, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1484, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1485, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1486, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1487, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1488, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1489, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1490, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1491, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1492, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1493, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:27'),
(1494, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1495, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1496, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1497, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1498, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1499, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1500, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1501, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1502, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1503, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1504, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1505, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1506, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1507, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1508, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1509, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1510, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:28'),
(1511, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1512, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1513, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1514, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1515, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1516, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1517, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1518, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1519, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1520, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1521, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1522, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1523, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1524, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1525, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1526, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1527, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1528, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:29'),
(1529, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1530, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1531, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1532, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1533, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1534, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1535, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1536, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1537, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1538, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1539, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1540, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1541, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1542, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1543, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1544, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1545, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1546, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1547, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1548, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:30'),
(1549, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1550, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1551, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1552, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1553, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1554, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1555, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1556, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1557, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1558, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1559, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1560, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1561, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1562, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1563, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1564, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1565, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1566, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1567, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:31'),
(1568, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1569, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1570, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1571, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1572, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1573, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1574, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1575, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1576, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1577, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1578, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1579, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1580, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1581, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1582, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1583, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-21 12:05:32'),
(1584, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:05:41'),
(1585, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 12:07:12'),
(1586, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:07:16'),
(1587, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 12:07:30'),
(1588, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 12:41:08'),
(1589, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 15:32:46'),
(1590, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-21 15:33:03'),
(1591, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-21 15:51:27'),
(1592, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-22 08:51:45'),
(1593, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-22 08:56:01'),
(1594, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-22 09:05:48'),
(1595, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-22 09:12:33'),
(1596, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-22 09:29:00'),
(1597, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-22 14:19:18'),
(1598, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-22 14:54:21'),
(1599, NULL, NULL, NULL, 'Salio', 'del Sistema', '2019-06-22 14:54:22'),
(1600, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-22 14:54:28'),
(1601, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-22 15:09:52'),
(1602, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-22 15:10:37'),
(1603, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-22 17:33:14'),
(1604, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-24 14:45:30'),
(1605, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-24 15:03:26'),
(1606, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-24 15:11:28'),
(1607, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-24 15:33:16'),
(1608, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-24 15:35:49'),
(1609, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-24 15:35:57'),
(1610, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-24 15:38:36'),
(1611, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-24 16:30:55'),
(1612, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-24 16:37:38'),
(1613, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-25 09:18:38'),
(1614, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-25 09:19:13'),
(1615, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-25 09:46:22'),
(1616, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-25 09:46:22'),
(1617, 1, 'admin', 1, 'Insertó', 'formulario de vida a la consul', '2019-06-25 09:48:10'),
(1618, 1, 'admin', 1, 'Inserto', 'una MateriaPrima', '2019-06-25 10:06:40'),
(1619, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-27 07:30:34'),
(1620, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-27 07:30:41'),
(1621, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-27 07:30:48'),
(1622, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-27 07:33:16'),
(1623, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-27 08:16:19'),
(1624, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 08:17:47'),
(1625, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-27 08:19:24'),
(1626, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-27 08:41:31'),
(1627, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 08:44:44'),
(1628, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:22:45'),
(1629, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:26:08'),
(1630, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:27:33'),
(1631, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:30:33'),
(1632, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:31:23'),
(1633, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:34:27'),
(1634, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:36:50'),
(1635, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-27 09:38:15'),
(1636, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-27 11:09:00'),
(1637, 1, 'admin', 1, 'registro', 'un venta', '2019-06-27 13:06:28'),
(1638, 1, 'admin', 1, 'registro', 'un venta', '2019-06-27 13:07:20'),
(1639, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-27 13:10:51'),
(1640, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-29 13:56:50'),
(1641, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-29 13:58:34'),
(1642, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 13:59:35'),
(1643, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 13:59:58'),
(1644, 1, 'admin', 1, 'registro', 'un venta', '2019-06-29 14:15:09'),
(1645, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-06-29 19:40:57'),
(1646, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-29 19:40:57'),
(1647, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-29 20:39:21'),
(1648, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-29 21:11:52'),
(1649, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 21:32:56'),
(1650, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 21:33:18'),
(1651, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 21:42:16'),
(1652, 1, 'admin', 1, 'Insertó', 'un producto', '2019-06-29 21:43:20'),
(1653, 1, 'admin', 1, 'Editó', 'un  producto', '2019-06-29 21:43:31'),
(1654, 1, 'admin', 1, 'Eliminó', 'un  producto', '2019-06-29 21:43:36'),
(1655, 1, 'admin', 1, 'Insertó', 'formulario de vida a la consul', '2019-06-29 21:43:58'),
(1656, 1, 'admin', 1, 'Edito', 'un horario', '2019-06-29 22:17:07'),
(1657, 1, 'admin', 1, 'Edito', 'un horario', '2019-06-29 22:17:56'),
(1658, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-06-29 22:18:28'),
(1659, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 22:23:59'),
(1660, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-06-29 22:26:02'),
(1661, 1, 'admin', 1, 'registro', 'un venta', '2019-06-29 22:26:53'),
(1662, 1, 'admin', 1, 'Editó', 'una especialidad', '2019-06-29 22:48:35'),
(1663, 1, 'admin', 1, 'Eliminó', 'una especialidad', '2019-06-29 22:48:40'),
(1664, 1, 'admin', 1, 'Editó', 'una especialidad', '2019-06-29 22:48:44'),
(1665, 1, 'admin', 1, 'Insertó', 'una especialidad', '2019-06-29 22:49:03'),
(1666, 1, 'admin', 1, 'Insertó', 'especialidad a un odontologo', '2019-06-29 22:49:29'),
(1667, 1, 'admin', 1, 'Insertó', 'especialidad a un odontologo', '2019-06-29 22:49:29'),
(1668, 1, 'admin', 1, 'Insertó', 'especialidad a un odontologo', '2019-06-29 22:49:40'),
(1669, 1, 'admin', 1, 'Inserto', 'una MateriaPrima', '2019-06-29 23:03:26'),
(1670, 1, 'admin', 1, 'Elimino', 'Una Materia Prima', '2019-06-29 23:03:46'),
(1671, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-29 23:11:01'),
(1672, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-06-29 23:12:22'),
(1673, 1, 'admin', 1, 'Inserto', 'un horario', '2019-06-29 23:34:59'),
(1674, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-06-30 03:16:10'),
(1675, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 03:16:10'),
(1676, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:19:38'),
(1677, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:20:06'),
(1678, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:20:35'),
(1679, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:20:59'),
(1680, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:21:09'),
(1681, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-06-30 03:23:28'),
(1682, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 03:23:28'),
(1683, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-06-30 03:23:28'),
(1684, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 03:23:28'),
(1685, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-06-30 03:28:40'),
(1686, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 03:28:41'),
(1687, 1, 'admin', 1, 'Eliminó', 'un Recepcionista', '2019-06-30 03:28:50'),
(1688, 1, 'admin', 1, 'Eliminó', 'un Recepcionista', '2019-06-30 03:28:56'),
(1689, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:29:20'),
(1690, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:29:29'),
(1691, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:31:17'),
(1692, 1, 'admin', 1, 'Edito', 'un recepcionista', '2019-06-30 03:33:54'),
(1693, 1, 'admin', 1, 'Edito', 'un recepcionista', '2019-06-30 03:34:12'),
(1694, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:40:33'),
(1695, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:40:44'),
(1696, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:43:43'),
(1697, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:45:02'),
(1698, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:46:00'),
(1699, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:46:07'),
(1700, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:46:19'),
(1701, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-06-30 03:46:58'),
(1702, 1, 'admin', 1, 'Edito', 'un recepcionista', '2019-06-30 03:47:51'),
(1703, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-06-30 03:51:44'),
(1704, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 03:51:44'),
(1705, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:55:40'),
(1706, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 03:56:16'),
(1707, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-06-30 04:05:47'),
(1708, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-06-30 04:05:47'),
(1709, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 04:11:14'),
(1710, 1, 'admin', 1, 'Edito', 'un usuario', '2019-06-30 04:11:52'),
(1711, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-06-30 04:14:15'),
(1712, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-06-30 04:21:26'),
(1713, 1, 'admin', 1, 'Inserto', 'una MateriaPrima', '2019-06-30 04:32:39'),
(1714, 1, 'admin', 1, 'Inserto', 'una MateriaPrima', '2019-06-30 04:48:47'),
(1715, 1, 'admin', 1, 'Elimino', 'Una Materia Prima', '2019-06-30 04:56:00'),
(1716, 1, 'admin', 1, 'Elimino', 'Una Materia Prima', '2019-06-30 04:56:05'),
(1717, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-02 16:55:50'),
(1718, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 07:39:46'),
(1719, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 07:41:09'),
(1720, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 07:41:28'),
(1721, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 08:26:55'),
(1722, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 08:27:12'),
(1723, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 08:56:31'),
(1724, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 09:04:52'),
(1725, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 09:22:17'),
(1726, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 16:41:00'),
(1727, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 16:41:24'),
(1728, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 17:03:47'),
(1729, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 17:09:21'),
(1730, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:10:40'),
(1731, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:11:04'),
(1732, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:11:38'),
(1733, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 17:13:35'),
(1734, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:18:04'),
(1735, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:18:36'),
(1736, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:18:36'),
(1737, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 17:22:52'),
(1738, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 18:01:10'),
(1739, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 18:06:19'),
(1740, NULL, NULL, NULL, 'Insertó', 'una Ficha', '2019-07-03 18:07:41'),
(1741, NULL, NULL, NULL, 'Insertó', 'una Ficha', '2019-07-03 18:08:17'),
(1742, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 18:08:54'),
(1743, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 18:09:24'),
(1744, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 18:49:14'),
(1745, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 19:15:33'),
(1746, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 19:15:38'),
(1747, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:20:12'),
(1748, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:23:42'),
(1749, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:25:47'),
(1750, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:32:16'),
(1751, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:34:20'),
(1752, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:35:59'),
(1753, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 19:40:29'),
(1754, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-03 19:40:48'),
(1755, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-03 19:41:02'),
(1756, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 19:41:06'),
(1757, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-03 19:43:44'),
(1758, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-03 19:43:55'),
(1759, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 19:44:01'),
(1760, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-03 19:44:08'),
(1761, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-03 19:44:27'),
(1762, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-03 19:44:32'),
(1763, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-03 19:45:45'),
(1764, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 19:45:50'),
(1765, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-03 19:46:10'),
(1766, 1, 'admin', 1, 'Inserto', 'un Odontologo', '2019-07-03 19:49:06'),
(1767, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-07-03 19:49:07'),
(1768, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-07-03 19:50:01'),
(1769, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-03 19:50:44'),
(1770, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-03 19:52:45'),
(1771, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:53:27'),
(1772, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:54:42'),
(1773, 1, 'admin', 1, 'registro', 'un venta', '2019-07-03 19:54:53'),
(1774, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 20:50:40'),
(1775, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 20:55:45'),
(1776, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 21:03:07'),
(1777, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 21:06:14'),
(1778, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-03 22:35:30'),
(1779, 1, 'admin', 1, 'Inserto', 'un horario', '2019-07-03 22:38:09'),
(1780, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 22:39:43'),
(1781, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-03 22:43:18'),
(1782, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-03 22:46:32'),
(1783, 7, 'user2', 2, 'Ingreso', ' al Sistema', '2019-07-03 22:46:39'),
(1784, 7, 'user2', 2, 'Insertó', 'un producto a una consulta', '2019-07-03 22:46:58'),
(1785, 7, 'user2', 2, 'registro', 'un venta', '2019-07-03 22:47:20'),
(1786, 7, 'user2', 2, 'Salio', 'del Sistema', '2019-07-04 00:06:26'),
(1787, 15, 'joaquin', 2, 'Ingreso', ' al Sistema', '2019-07-04 00:08:11'),
(1788, 15, 'joaquin', 2, 'Salio', 'del Sistema', '2019-07-04 00:08:44'),
(1789, 15, NULL, 2, 'Ingreso', ' al Sistema', '2019-07-04 00:20:36'),
(1790, 15, NULL, 2, 'Salio', 'del Sistema', '2019-07-04 00:21:06'),
(1791, 15, NULL, 2, 'Salio', 'del Sistema', '2019-07-04 00:21:06'),
(1792, 15, NULL, 2, 'Ingreso', ' al Sistema', '2019-07-04 00:21:17'),
(1793, 15, NULL, 2, 'Salio', 'del Sistema', '2019-07-04 00:21:31'),
(1794, 1, NULL, 1, 'Ingreso', ' al Sistema', '2019-07-04 00:22:22'),
(1795, 1, NULL, 1, 'Salio', 'del Sistema', '2019-07-04 00:22:54'),
(1796, 15, 'joaquin', 2, 'Ingreso', ' al Sistema', '2019-07-04 00:32:49'),
(1797, 15, 'joaquin', 2, 'Salio', 'del Sistema', '2019-07-04 00:33:07'),
(1798, 20, 'carmen', 3, 'Ingreso', ' al Sistema', '2019-07-04 00:33:15'),
(1799, 20, 'carmen', 3, 'Salio', 'del Sistema', '2019-07-04 00:33:20'),
(1800, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 00:36:47'),
(1801, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-04 00:37:02'),
(1802, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 00:39:10'),
(1803, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 01:04:28'),
(1804, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 01:05:07'),
(1805, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 01:06:14'),
(1806, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 01:07:57'),
(1807, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 01:08:02'),
(1808, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 01:08:05'),
(1809, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-04 01:08:13'),
(1810, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-04 01:08:14'),
(1811, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 01:08:56'),
(1812, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 01:09:04'),
(1813, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 01:09:13'),
(1814, 1, 'admin', 1, 'Inserto', 'un Recepcionista', '2019-07-04 01:14:27'),
(1815, 1, 'admin', 1, 'Inserto', 'un Usuario', '2019-07-04 01:14:27'),
(1816, 1, 'admin', 1, 'Edito', 'un recepcionista', '2019-07-04 01:14:46'),
(1817, 1, 'admin', 1, 'Edito', 'un Odontologo', '2019-07-04 01:15:14'),
(1818, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 07:10:27'),
(1819, 1, 'admin', 1, 'Eliminó', 'un Odontólogo', '2019-07-04 07:13:11'),
(1820, 1, 'admin', 1, 'Eliminó', 'un Recepcionista', '2019-07-04 07:13:35'),
(1821, 1, 'admin', 1, 'Insertó', 'una Ficha', '2019-07-04 07:29:08'),
(1822, 1, 'admin', 1, 'Insertó', 'formulario de vida a la consul', '2019-07-04 07:30:25'),
(1823, 1, 'admin', 1, 'registro', 'un venta', '2019-07-04 07:32:07'),
(1824, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-07-04 07:41:35'),
(1825, 1, 'admin', 1, 'Inserto', 'una nota compra', '2019-07-04 07:43:39'),
(1826, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 07:51:50'),
(1827, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 07:55:07'),
(1828, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 07:56:55'),
(1829, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-04 07:57:11'),
(1830, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-04 07:57:18'),
(1831, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 07:57:23'),
(1832, 1, 'admin', 1, 'Edito', 'un usuario', '2019-07-04 07:58:56'),
(1833, 1, 'admin', 1, 'Salio', 'del Sistema', '2019-07-04 07:59:09'),
(1834, 3, 'camila', 2, 'Ingreso', ' al Sistema', '2019-07-04 07:59:14'),
(1835, 3, 'camila', 2, 'Insertó', 'una Ficha', '2019-07-04 08:00:49'),
(1836, 3, 'camila', 2, 'Insertó', 'una Ficha', '2019-07-04 08:01:44'),
(1837, 3, 'camila', 2, 'Salio', 'del Sistema', '2019-07-04 08:01:56'),
(1838, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-07-04 08:02:01'),
(1839, 1, 'admin', 1, 'Insertó', 'un producto a una consulta', '2019-07-04 08:05:40'),
(1840, 1, 'admin', 1, 'Insertó', 'formulario de vida a la consul', '2019-07-04 08:06:13'),
(1841, 1, 'admin', 1, 'registro', 'un venta', '2019-07-04 08:08:07'),
(1842, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2019-08-15 14:41:32'),
(1843, 1, 'admin', 1, 'Ingreso', ' al Sistema', '2020-02-01 21:04:29'),
(1844, 1, 'admin', 1, 'Salio', 'del Sistema', '2020-02-01 21:04:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mat_prima`
--

CREATE TABLE `mat_prima` (
  `id_mat` int(11) NOT NULL,
  `nombre_mat` varchar(50) NOT NULL,
  `descripcion_mat` varchar(100) DEFAULT NULL,
  `estado_mat` char(1) NOT NULL,
  `cant_usos` int(11) DEFAULT NULL,
  `tot_usos` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mat_prima`
--

INSERT INTO `mat_prima` (`id_mat`, `nombre_mat`, `descripcion_mat`, `estado_mat`, `cant_usos`, `tot_usos`, `stock`) VALUES
(1, 'Pasta de pulir', 'para pulir dientes', 'a', 16, 23, 13),
(2, 'Fluor tópico', 'para los dientes', 'b', 40, 45, 8),
(3, 'Eugenol', 'recina para tapadura de dientes', 'b', 11, 23, 4),
(4, 'Formocrisol', 'descripcion', 'a', 0, 100, 0),
(6, 'Coagulante tópico', 'para la boca', 'a', 0, 30, 0),
(7, 'Recina acrilica', 'erwer', 'a', 0, 34, 0),
(8, 'Guantes', 'para las manos', 'a', 0, 2, 5),
(9, 'Barbijos', 'para cubrirse la boca', 'a', 0, 5, 0),
(10, 'Brackets', 'para los dientes', 'a', 0, 10, 2),
(11, 'Resortes', 'para los dientes', 'a', 0, 10, 0),
(12, 'Godive', 'para los dientes', 'a', 0, 10, 0),
(13, 'Geringas', 'para inyectar', 'a', 0, 1, 0),
(14, 'Recina', 'para tapadura de dientes', 'a', 0, 12, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_compra`
--

CREATE TABLE `nota_compra` (
  `id_cnot` int(11) NOT NULL,
  `nit` int(11) DEFAULT NULL,
  `fecha_cnot` date NOT NULL,
  `monto_cnot` float NOT NULL,
  `nombre_emp` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nota_compra`
--

INSERT INTO `nota_compra` (`id_cnot`, `nit`, `fecha_cnot`, `monto_cnot`, `nombre_emp`, `id_usuario`) VALUES
(1, 5467876, '2019-07-06', 450, 'OdontoHouse', 1),
(2, 221342, '2019-07-06', 200, 'OH', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_mat_prima`
--

CREATE TABLE `nota_mat_prima` (
  `id_nota_c` int(11) NOT NULL,
  `id_mat` int(11) NOT NULL,
  `cantidad` smallint(6) NOT NULL,
  `precio` float NOT NULL,
  `fecha_venc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nota_mat_prima`
--

INSERT INTO `nota_mat_prima` (`id_nota_c`, `id_mat`, `cantidad`, `precio`, `fecha_venc`) VALUES
(1, 2, 2, 100, '2021-11-20'),
(1, 8, 5, 50, '2020-10-10'),
(2, 2, 2, 100, '2023-06-20');

--
-- Disparadores `nota_mat_prima`
--
DELIMITER $$
CREATE TRIGGER `tr_actualizar_stock_santTotal` AFTER INSERT ON `nota_mat_prima` FOR EACH ROW BEGIN
	DECLARE STOCK_Ant INT;
    -- declaro cursor
    DECLARE cur_Datos_Mat_Prima CURSOR FOR SELECT stock
											FROM mat_prima
											where id_mat= NEW.id_mat;
    OPEN cur_Datos_Mat_Prima;
		FETCH cur_Datos_Mat_Prima into STOCK_Ant;
    CLOSE cur_Datos_Mat_Prima;
    -- fin de cursor
    
	update mat_prima m
    set m.stock = STOCK_Ant+ new.cantidad
	WHERE m.id_mat = NEW.id_mat;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_venta`
--

CREATE TABLE `nota_venta` (
  `id_vnot` int(11) NOT NULL,
  `fecha_vnot` date NOT NULL,
  `descuento` float NOT NULL,
  `monto_total` float NOT NULL,
  `saldo` float NOT NULL,
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nota_venta`
--

INSERT INTO `nota_venta` (`id_vnot`, `fecha_vnot`, `descuento`, `monto_total`, `saldo`, `id_historial`, `id_consulta`) VALUES
(1, '2018-10-21', 0, 350, 0, 1, 1),
(2, '2018-10-22', 0, 100, 0, 2, 1),
(3, '2018-10-23', 0, 200, 0, 3, 1),
(5, '2019-06-27', 0, 1630, 0, 12, 30),
(6, '2019-06-29', 0, 2180, 0, 12, 33),
(7, '2019-06-30', 0, 1150, 0, 12, 40),
(8, '2019-07-03', 0, 902, 0, 12, 43),
(10, '2019-07-03', 0, 1400, 0, 1, 46),
(11, '2019-07-03', 0, 800, 0, 12, 45),
(17, '2019-07-03', 0, 2200, 0, 12, 44),
(18, '2019-07-03', 0, 250, 0, 4, 49),
(19, '2019-07-03', 0, 800, 0, 3, 47),
(20, '2019-07-03', 0, 400, 0, 6, 48),
(21, '2019-07-04', 0, 400, 0, 6, 50),
(22, '2019-07-04', 0, 300, 0, 6, 51),
(23, '2019-07-04', 0, 900, 0, 11, 52);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_not` int(11) NOT NULL,
  `nombre_tab` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `tipo_not` char(1) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_not`, `nombre_tab`, `descripcion`, `cantidad`, `fecha`, `tipo_not`) VALUES
(5, 'Materia Prima', 'Se esta por vencer', 1, '2019-06-21', 'C'),
(6, 'Materia Prima', 'Se esta por teminar', 1, '2019-06-21', 'B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontograma`
--

CREATE TABLE `odontograma` (
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `id_odo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `odontograma`
--

INSERT INTO `odontograma` (`id_historial`, `id_consulta`, `id_odo`) VALUES
(1, 1, 10),
(6, 51, 13),
(11, 52, 14),
(12, 9, 1),
(12, 10, 2),
(12, 11, 3),
(12, 15, 4),
(12, 22, 5),
(12, 24, 6),
(12, 26, 7),
(12, 27, 8),
(12, 42, 9),
(12, 43, 12),
(12, 45, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontologo`
--

CREATE TABLE `odontologo` (
  `ci_odont` varchar(20) NOT NULL,
  `estado_odon` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `odontologo`
--

INSERT INTO `odontologo` (`ci_odont`, `estado_odon`) VALUES
('11386573', 'a'),
('11386578', 'a'),
('3236957', 'a'),
('3246260', 'a'),
('3514551', 'a'),
('3779456', 'a'),
('38849282', 'b'),
('7655609', 'a'),
('9451784', 'a'),
('9795465', 'a');

--
-- Disparadores `odontologo`
--
DELIMITER $$
CREATE TRIGGER `crear_agenda` AFTER INSERT ON `odontologo` FOR EACH ROW begin
	DECLARE  pac varchar(20);
    set pac= NEW.ci_odont;
    insert into agenda values (null,pac);
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odontologo_horario`
--

CREATE TABLE `odontologo_horario` (
  `ci_odont` varchar(20) NOT NULL,
  `id_hor` int(11) NOT NULL,
  `nro_consultorio` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `odontologo_horario`
--

INSERT INTO `odontologo_horario` (`ci_odont`, `id_hor`, `nro_consultorio`) VALUES
('11386573', 1, NULL),
('11386573', 2, NULL),
('11386573', 3, NULL),
('11386573', 4, NULL),
('11386573', 5, NULL),
('11386573', 6, NULL),
('11386573', 9, NULL),
('11386573', 13, NULL),
('11386573', 14, NULL),
('11386573', 16, NULL),
('3246260', 1, NULL),
('3246260', 2, NULL),
('3246260', 3, NULL),
('3246260', 4, NULL),
('3246260', 5, NULL),
('3246260', 6, NULL),
('3246260', 7, NULL),
('3246260', 8, NULL),
('3246260', 9, NULL),
('3246260', 10, NULL),
('3246260', 11, NULL),
('3246260', 12, NULL),
('3246260', 13, NULL),
('3246260', 14, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odont_espe`
--

CREATE TABLE `odont_espe` (
  `ci_odont` varchar(20) NOT NULL,
  `id_espe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `odont_espe`
--

INSERT INTO `odont_espe` (`ci_odont`, `id_espe`) VALUES
('11386573', 1),
('11386573', 2),
('11386573', 3),
('11386573', 4),
('11386573', 7),
('11386573', 12),
('3246260', 3),
('3246260', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `odont_servicio`
--

CREATE TABLE `odont_servicio` (
  `ci_odont` varchar(20) NOT NULL,
  `id_serv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `odont_servicio`
--

INSERT INTO `odont_servicio` (`ci_odont`, `id_serv`) VALUES
('11386573', 1),
('11386573', 2),
('11386573', 3),
('11386573', 4),
('11386573', 5),
('11386573', 6),
('11386573', 7),
('11386573', 8),
('11386573', 9),
('11386573', 18),
('11386573', 19),
('11386573', 20),
('11386573', 21),
('3246260', 1),
('3246260', 2),
('3246260', 3),
('3246260', 4),
('3246260', 5),
('3246260', 6),
('3246260', 7),
('3246260', 8),
('3246260', 9),
('3246260', 10),
('3246260', 11),
('3246260', 12),
('3246260', 13),
('3246260', 14),
('3246260', 15),
('3246260', 16),
('3246260', 17),
('3246260', 18),
('3246260', 19),
('3246260', 20),
('7655609', 1),
('7655609', 2),
('7655609', 3),
('7655609', 4),
('7655609', 17),
('7655609', 18),
('7655609', 19),
('7655609', 20),
('7655609', 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `ci_pac` varchar(20) NOT NULL,
  `estado_pac` char(1) NOT NULL,
  `lugar_nac` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`ci_pac`, `estado_pac`, `lugar_nac`) VALUES
('19087', 'a', 'Potosi-Bolivia'),
('2578412', 'a', 'Santa Cruz de la Sierra-Bolivia'),
('3236784', 'a', 'Sucre -Bolivia'),
('5401932', 'a', 'La Paz-Bolivia'),
('5478145', 'a', 'Cochabamba-Bolivia'),
('6869334', 'a', 'Santa Cruz de la Sierra-Bolivia'),
('7841298', 'a', 'Camiri-Bolivia'),
('9164512', 'a', 'Puerto Suarez-Bolivia'),
('9215439', 'a', 'Santa Cruz de la Sierra-Bolivia'),
('9791247', 'a', 'Santiago-Chile'),
('9795123', 'a', 'Santa Cruz de la Sierra-Bolivia'),
('9812247', 'a', 'Warnes-Bolivia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pac_pat`
--

CREATE TABLE `pac_pat` (
  `id_pat` int(11) NOT NULL,
  `ci_pac` varchar(20) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pac_pat`
--

INSERT INTO `pac_pat` (`id_pat`, `ci_pac`, `descripcion`) VALUES
(1, '19087', 'alergia al latex'),
(1, '2578412', 'por cuasa de otras'),
(1, '5401932', 'Alergia al polen y al polvo'),
(2, '19087', 'por cuasa de otras'),
(2, '2578412', 'asdf'),
(2, '3236784', 'Asma'),
(2, '5478145', 'Desviacion de tabique'),
(3, '19087', 'por cuasa de otras'),
(4, '19087', 'por cuasa de otras'),
(9, '19087', 'por cuasa de otras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patologia`
--

CREATE TABLE `patologia` (
  `id_pat` int(11) NOT NULL,
  `nombre_pat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `patologia`
--

INSERT INTO `patologia` (`id_pat`, `nombre_pat`) VALUES
(1, 'Alergias'),
(2, 'Enfermedades respiratorias'),
(3, 'Enfermedades cardiológicas'),
(4, 'Enfermedades endócrinas'),
(5, 'Enfermedades osteoarticulares'),
(6, 'Enfermedades neurológicas'),
(7, 'Enfermedades infectocontagiosos'),
(8, 'Enfermedades metabólicas'),
(9, 'Fiebre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_rol` int(11) NOT NULL,
  `id_per` int(11) NOT NULL,
  `nombre_per` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_rol`, `id_per`, `nombre_per`) VALUES
(1, 1, 'ADM Personal'),
(1, 2, 'ADM Reservas'),
(1, 3, 'ADM Consultas'),
(1, 4, 'ADM INVENTARIO'),
(1, 5, 'SEGURIDAD'),
(1, 6, 'FLUJO DE CAJA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ci` varchar(20) NOT NULL,
  `nombre_per` char(30) NOT NULL,
  `paterno` char(20) NOT NULL,
  `materno` char(20) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `fecha_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ci`, `nombre_per`, `paterno`, `materno`, `sexo`, `telefono`, `direccion`, `celular`, `fecha_nac`) VALUES
('11386531', 'Maria Dolores', 'Rodrigez', 'Manzano', 'F', 0, 'B. Suarez C. 12 5', 0, '1983-03-09'),
('11386573', 'Dario Darwin', 'Rodrigez', 'Manzano', 'M', 0, 'B/Suarez C/12 #5', 78908654, '2018-08-02'),
('11386578', 'Joaquin', 'Chumacero', 'Jupanqui', 'M', 32433211, 'Barrio Suares', 76372198, '1986-03-08'),
('1201', 'Juanito', 'Suares', 'asd', 'M', 0, 'ccc', 1234, '2017-11-30'),
('19087', 'Leonardo', 'Marzella', 'Mamani', 'M', 980, 'B/Suarez C/12 #5', 68, '2017-02-03'),
('2578412', 'Dante', 'Velarde', 'Yacob', 'M', NULL, '4to Anillo Condominio Curupau #12', 74512392, '1989-07-20'),
('3236784', 'Roberto', 'Vaca', 'Pedraza', 'M', 3641189, '6to anillo Av. Cumavi Calle 16 de Julio #78', 70901477, '1991-10-25'),
('3236957', 'David', 'Torrez', 'Rojas', 'M', 365784, 'Av. Roca y Coronado 778', 70901455, '1985-10-20'),
('3246260', 'Marcos', 'Robles', 'Soria', 'M', 3481746, '7mo Anillo Calle Manantial #17', 73136298, '1975-10-24'),
('3514551', 'Samantha Kiara', 'Mendoza', 'Justiniano', 'F', 3487812, 'Av. Los Cusis Calle Manantial #96', 70901477, '1972-01-19'),
('3779456', 'Selena', 'Terrazas', 'Quispe', 'F', NULL, 'Av. Virgen de Cotoca Calle Tulipanes #456', 70915436, '1985-04-08'),
('38849282', 'Felipe', 'Mendez', 'Taborga', 'M', 345298, 'Barrio Suares', 71829354, '1987-07-09'),
('5401932', 'Camila Stefanie', 'Yacob', 'Cwirko', 'F', 3532789, 'Av. Roca y Coronado Calle Fátima #218', 72684169, '1997-05-19'),
('5478145', 'María Luisa', 'Roca', 'Valverde', 'F', NULL, '4to Anillo Calle Nazaret #157', 67732598, '1987-08-30'),
('5678214', 'Maria Doris', 'Lopez', 'Arancibia', 'M', 3671178, '2do anillo Av. Alemania Calle Bosque #154', 76915431, '1977-10-05'),
('685439', 'Julia', 'Arjona', 'Mendieta', 'F', 32433211, 'Barrio Suares', 76372198, '1987-07-09'),
('6869334', 'Gerson', 'Oliva', 'Rojas', 'M', 3537842, 'Av. Trompillo Calle 2 #45', 72785569, '1960-02-18'),
('7655609', 'Juanito', 'Suares', 'Manzano', 'M', 0, '4to Anillo Cod. Curupau 12', 76372198, '2019-06-05'),
('7841298', 'Reinaldo', 'Roca', 'Soria', 'M', 36412859, '3er anillo interno Calle 8 #218', 70954137, '1988-05-19'),
('78530966', 'Marcia', 'Lopez', 'Ribera', 'F', 0, 'B Suarez C12 ', 76372198, '0000-00-00'),
('8793261', 'Carmen', 'Ribera', 'Montaño', 'F', 0, 'Barrio Suares', 76372198, '1980-03-09'),
('9164512', 'Luis Pablo', 'Torrico', 'Darin', 'M', 3549815, '1er Anillo Calle Cochabamba #721', 60897577, '1990-08-05'),
('9215439', 'Rocio Daniela', 'Fernandez', 'Molina', 'F', 3657891, '1er anillo Calle Ballivian #657', 79825478, '1999-03-25'),
('9451784', 'Luis Samuel', 'Torrez', 'Fernandez', 'M', NULL, 'Plan 3000 Calle Juanes #784', 78942157, '1970-04-12'),
('9791247', 'Fatima', 'Campos', 'Osinaga', 'F', 3574197, 'Av. Cristo Redentor Calle 3 #441', 60700411, '1989-12-20'),
('9795123', 'Marcos Daniel', 'Robles', 'Alpire', 'M', 3481875, 'Urb. Las Palmeras Calle 3 #13', 60800754, '1997-11-20'),
('9795465', 'Rosa', 'Lopez', 'Costa', 'F', 70863685, 'Av. Roca y Coronado #778', 3481697, '1985-10-20'),
('9812247', 'Ivana Ana', 'Vargas', 'Zurita', 'F', 3876911, 'Plan 3000 Av. Cirio Calle Oliva #12', 60865784, '1980-04-12'),
('98374223', 'Lucia', 'Pardo', 'Peralta', 'F', 32433211, 'Barrio Suares', 76372198, '1988-03-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pieza_dental`
--

CREATE TABLE `pieza_dental` (
  `id_odont` int(11) NOT NULL,
  `nro` smallint(6) NOT NULL,
  `nombre_pie` varchar(25) NOT NULL,
  `estado_actual` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pieza_dental`
--

INSERT INTO `pieza_dental` (`id_odont`, `nro`, `nombre_pie`, `estado_actual`) VALUES
(1, 13, 'Canino', 'e'),
(1, 14, 'Premolar', 'r'),
(1, 15, 'Premolar', 'r'),
(1, 18, 'Tercer Molar', 'e'),
(1, 41, 'Incisivo central', 'p'),
(1, 45, 'Premolar', 'r'),
(1, 47, 'Segundo Molar', 'r'),
(1, 48, 'Tercer Molar', 'e'),
(3, 13, 'Canino', 'r'),
(3, 26, 'Primer Molar', 'p'),
(3, 42, 'Incisivo lateral', 'r'),
(3, 46, 'Primer Molar', 'p'),
(4, 46, 'Primer Molar', 'r'),
(5, 41, 'Incisivo central', 'p'),
(6, 13, 'Canino', 'r'),
(6, 42, 'Incisivo lateral', 'r'),
(7, 16, 'Primer Molar', 'r'),
(8, 15, 'Premolar', 'r'),
(8, 21, 'Incisivo central', 'r'),
(8, 41, 'Incisivo central', 'r'),
(9, 17, 'Segundo Molar', 'r'),
(13, 15, 'Premolar', 'r'),
(14, 16, 'Primer Molar', 'r');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_prod` int(11) NOT NULL,
  `nombre_prod` varchar(80) NOT NULL,
  `estado_prod` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_prod`, `nombre_prod`, `estado_prod`) VALUES
(2, 'Metal Cromo', 'a'),
(3, 'Metal Oro', 'a'),
(4, 'Placa removible', 'a'),
(5, 'Placas metalicas', 'a'),
(6, 'Protesis de porcelana', 'a'),
(7, 'Protesis de recina', 'a'),
(8, 'Protesis de oro', 'a'),
(9, 'Protesis de parcial', 'a'),
(10, 'Protesis de total', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_con`
--

CREATE TABLE `prod_con` (
  `id_prod` int(11) NOT NULL,
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `precio_prod` float NOT NULL,
  `cantidad_prod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prod_con`
--

INSERT INTO `prod_con` (`id_prod`, `id_historial`, `id_consulta`, `precio_prod`, `cantidad_prod`) VALUES
(2, 1, 46, 300, 1),
(2, 4, 49, 100, 1),
(2, 6, 48, 100, 1),
(3, 6, 50, 300, 1),
(2, 11, 52, 300, 1),
(2, 12, 30, 300, 1),
(2, 12, 33, 800, 1),
(3, 12, 33, 150, 1),
(4, 12, 33, 1000, 1),
(2, 12, 37, 300, 1),
(4, 12, 37, 800, 1),
(2, 12, 40, 300, 1),
(2, 12, 42, 300, 1),
(4, 12, 42, 300, 1),
(2, 12, 43, 300, 2),
(2, 12, 44, 500, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionista`
--

CREATE TABLE `recepcionista` (
  `ci_rec` varchar(20) NOT NULL,
  `estado_rec` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recepcionista`
--

INSERT INTO `recepcionista` (`ci_rec`, `estado_rec`) VALUES
('11386531', 'a'),
('5678214', 'b'),
('685439', 'a'),
('78530966', 'a'),
('8793261', 'a'),
('98374223', 'b');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `id_rece` int(11) NOT NULL,
  `descripcion_rece` varchar(500) NOT NULL,
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receta`
--

INSERT INTO `receta` (`id_rece`, `descripcion_rece`, `id_historial`, `id_consulta`) VALUES
(1, 'Ibuprofeno 500 mg en caso de dolor. \r\nAmoxixilina 200 mg cada 8 horas por 4 dias. ', 1, 1),
(2, 'Ciprofloxacina 500 mg 1/12 hrs, quetoralac 20 mg 1/12 hrs', 2, 1),
(3, 'Ibuprofeno 500mg c/8 hrs. Utilizar enjuague bucal 3 veces al dia.', 3, 1),
(4, '0', 12, 33),
(5, 'ppppppppppppppppppppppppppp', 3, 1),
(9, '4444444444444gggggggggggggggggggggggggg', 12, 42),
(11, 'recina para tapadura de dientes', 12, 44),
(12, 'recina para tapadura de dientes', 6, 50),
(13, 'Enjuague bucal Colgate Pro White', 6, 51);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Odontologo'),
(3, 'Recepcionista');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_ser` int(11) NOT NULL,
  `nombre_ser` varchar(70) NOT NULL,
  `descripcion_ser` varchar(200) DEFAULT NULL,
  `estado_ser` char(1) NOT NULL,
  `t_duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_ser`, `nombre_ser`, `descripcion_ser`, `estado_ser`, `t_duracion`) VALUES
(1, 'Obturaciones dentarias de recina', 'Tapadura con recina de una pieza dental', 'b', 20),
(2, 'Incrustacion de Cromo', 'Tapadura con metal cromo de una pieza dental', 'b', 20),
(3, 'Incrustacion de Oro', 'Tapadura con metal oro de una pieza dental', 'a', 0),
(4, 'Tratamiento de conductos', 'Retiro del nervio', 'a', 30),
(5, 'Sellante', 'Proteccion de diente para prevencion de caries', 'a', 30),
(6, 'Limpieza Dental', 'Elimiinacion de las irritantes locales', 'a', 30),
(7, 'Gingivectomia', 'Recorte de encias', 'a', 40),
(8, 'Exodoncia', 'Extraccion dentaria', 'a', 60),
(9, 'Apicectomia', 'Eliminar la punta de la raiz dentaria', 'a', 40),
(10, 'Ortodoncia Preventiva', 'Correccion de mal formaciones dentarias con placas removibles', 'a', 30),
(11, 'Ortodoncia Correctiva Metalico', 'Correccion de mal formaciones dentarias con placas metalicas', 'a', 30),
(12, 'Ortodoncia Correctiva Porcelana', 'Correccion de mal formaciones dentarias con placas blancas', 'a', 50),
(13, 'Blanqueamiento dental', 'Clareamiento de los dientes', 'a', 20),
(14, 'Ortodoncia Correctiva', 'Correccion de mal formaciones dentarias con placas metalicas', 'a', 45),
(15, 'Protesis fija de recina', 'Forro dentario', 'a', 30),
(16, 'Protesis fija de porcelana', 'Forro dentario', 'a', 35),
(17, 'Protesis fija de oro', 'Forro dentario', 'a', 35),
(18, 'Protesis Removible Parcial', 'Reemplazo de dientes faltantes', 'a', 30),
(19, 'Protesis Removible Total', 'Reemplazo de dientes totales', 'a', 40),
(20, 'Consulta general', 'Consulta General de un paciente', 'a', 20),
(21, 'sellante', 'para los dientes', 'a', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serv_cons`
--

CREATE TABLE `serv_cons` (
  `id_serv` int(11) NOT NULL,
  `id_historial` int(11) NOT NULL,
  `id_consulta` int(11) NOT NULL,
  `precio_serv` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `serv_cons`
--

INSERT INTO `serv_cons` (`id_serv`, `id_historial`, `id_consulta`, `precio_serv`) VALUES
(1, 1, 46, 300),
(1, 3, 47, 300),
(1, 6, 48, 300),
(1, 11, 52, 300),
(1, 12, 15, 2),
(1, 12, 24, 4),
(1, 12, 30, 80),
(1, 12, 40, 300),
(1, 12, 43, 300),
(1, 12, 44, 300),
(1, 12, 45, 300),
(2, 1, 46, 800),
(2, 3, 47, 500),
(2, 6, 50, 100),
(2, 11, 52, 300),
(2, 12, 15, 2),
(2, 12, 33, 300),
(2, 12, 40, 400),
(2, 12, 43, 2),
(2, 12, 44, 300),
(2, 12, 45, 500),
(3, 4, 49, 150),
(3, 12, 24, 2),
(3, 12, 30, 900),
(3, 12, 40, 150),
(3, 12, 44, 600),
(4, 1, 1, 350),
(4, 1, 2, 350),
(4, 12, 33, 80),
(5, 12, 26, 300),
(5, 12, 30, 350),
(5, 12, 33, 50),
(6, 6, 51, 300),
(7, 3, 1, 200),
(8, 2, 1, 100),
(8, 12, 40, 800),
(13, 12, 40, 600);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serv_mat`
--

CREATE TABLE `serv_mat` (
  `id_serv` int(11) NOT NULL,
  `id_mat_pri` int(11) NOT NULL,
  `cant_usos_serv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `serv_mat`
--

INSERT INTO `serv_mat` (`id_serv`, `id_mat_pri`, `cant_usos_serv`) VALUES
(1, 1, 1),
(1, 3, 1),
(11, 1, 22),
(11, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usu` int(11) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `estado_usu` char(1) NOT NULL,
  `ci_persona` varchar(20) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usu`, `nombre_usuario`, `contrasena`, `estado_usu`, `ci_persona`, `id_rol`) VALUES
(1, 'admin', 'admin', 'a', '3246260', 1),
(3, 'camila', 'cami', 'a', '5401932', 2),
(7, 'user2', '12345', 'a', '11386573', 2),
(13, 'maria', 'maria', 'a', '5678214', 3),
(14, 'juan', '1234', 'a', '7655609', 2),
(15, 'joaquin', '$2a$07$usesomesillystringforeh6t', 'a', '11386578', 2),
(16, 'marcia', '1234', 'a', '78530966', 3),
(17, 'marcia', '1234', 'a', '78530966', 3),
(18, 'julia', '1234', 'a', '685439', 3),
(19, 'mariadolores', '1234', 'a', '11386531', 3),
(20, 'carmen', '1234', 'a', '8793261', 3),
(21, 'felipe', '1234', 'a', '38849282', 2),
(22, 'lucia', '1234', 'a', '98374223', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usu_perm`
--

CREATE TABLE `usu_perm` (
  `id_usu_perm` int(11) NOT NULL,
  `id_usu` int(11) NOT NULL,
  `id_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usu_perm`
--

INSERT INTO `usu_perm` (`id_usu_perm`, `id_usu`, `id_permiso`) VALUES
(22, 7, 2),
(23, 7, 3),
(24, 7, 5),
(25, 13, 2),
(30, 14, 2),
(31, 14, 3),
(32, 14, 4),
(70, 1, 1),
(71, 1, 2),
(72, 1, 3),
(73, 1, 4),
(74, 1, 5),
(75, 1, 6),
(76, 18, 2),
(77, 18, 5),
(78, 19, 2),
(79, 19, 3),
(80, 19, 5),
(88, 20, 2),
(89, 20, 3),
(90, 20, 5),
(106, 21, 2),
(107, 21, 3),
(108, 21, 4),
(109, 15, 2),
(110, 15, 3),
(111, 15, 4),
(112, 15, 6),
(113, 22, 2),
(114, 22, 3),
(115, 22, 6),
(116, 3, 1),
(117, 3, 2),
(118, 3, 4),
(119, 3, 5),
(120, 3, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_age`),
  ADD KEY `ci_odont` (`ci_odont`);

--
-- Indices de la tabla `cara_dental`
--
ALTER TABLE `cara_dental`
  ADD PRIMARY KEY (`id_car`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_historial`,`id_con`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD PRIMARY KEY (`id_nota`,`id_cuo`),
  ADD KEY `ci_paciente` (`ci_paciente`);

--
-- Indices de la tabla `c_p_dental`
--
ALTER TABLE `c_p_dental`
  ADD PRIMARY KEY (`id_odont`,`id_pieza`,`id_cara`),
  ADD KEY `id_cara` (`id_cara`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_esp`);

--
-- Indices de la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD PRIMARY KEY (`id_fic`),
  ADD KEY `ci_pac` (`ci_pac`),
  ADD KEY `id_agen` (`id_agen`);

--
-- Indices de la tabla `ficha_serv`
--
ALTER TABLE `ficha_serv`
  ADD PRIMARY KEY (`id_ficha`,`id_serv`),
  ADD KEY `id_serv` (`id_serv`);

--
-- Indices de la tabla `form_de_vida`
--
ALTER TABLE `form_de_vida`
  ADD PRIMARY KEY (`id_for`),
  ADD KEY `id_historial` (`id_historial`,`id_consulta`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_his`),
  ADD KEY `ci_paciente` (`ci_paciente`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_hor`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`idlog`);

--
-- Indices de la tabla `mat_prima`
--
ALTER TABLE `mat_prima`
  ADD PRIMARY KEY (`id_mat`);

--
-- Indices de la tabla `nota_compra`
--
ALTER TABLE `nota_compra`
  ADD PRIMARY KEY (`id_cnot`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `nota_mat_prima`
--
ALTER TABLE `nota_mat_prima`
  ADD PRIMARY KEY (`id_nota_c`,`id_mat`),
  ADD KEY `id_mat` (`id_mat`);

--
-- Indices de la tabla `nota_venta`
--
ALTER TABLE `nota_venta`
  ADD PRIMARY KEY (`id_vnot`),
  ADD KEY `id_historial` (`id_historial`,`id_consulta`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_not`);

--
-- Indices de la tabla `odontograma`
--
ALTER TABLE `odontograma`
  ADD PRIMARY KEY (`id_odo`),
  ADD KEY `id_historial` (`id_historial`,`id_consulta`);

--
-- Indices de la tabla `odontologo`
--
ALTER TABLE `odontologo`
  ADD PRIMARY KEY (`ci_odont`);

--
-- Indices de la tabla `odontologo_horario`
--
ALTER TABLE `odontologo_horario`
  ADD PRIMARY KEY (`ci_odont`,`id_hor`),
  ADD KEY `id_hor` (`id_hor`);

--
-- Indices de la tabla `odont_espe`
--
ALTER TABLE `odont_espe`
  ADD PRIMARY KEY (`ci_odont`,`id_espe`),
  ADD KEY `id_espe` (`id_espe`);

--
-- Indices de la tabla `odont_servicio`
--
ALTER TABLE `odont_servicio`
  ADD PRIMARY KEY (`ci_odont`,`id_serv`),
  ADD KEY `id_serv` (`id_serv`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`ci_pac`);

--
-- Indices de la tabla `pac_pat`
--
ALTER TABLE `pac_pat`
  ADD PRIMARY KEY (`id_pat`,`ci_pac`),
  ADD KEY `ci_pac` (`ci_pac`);

--
-- Indices de la tabla `patologia`
--
ALTER TABLE `patologia`
  ADD PRIMARY KEY (`id_pat`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_rol`,`id_per`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ci`);

--
-- Indices de la tabla `pieza_dental`
--
ALTER TABLE `pieza_dental`
  ADD PRIMARY KEY (`id_odont`,`nro`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_prod`);

--
-- Indices de la tabla `prod_con`
--
ALTER TABLE `prod_con`
  ADD PRIMARY KEY (`id_historial`,`id_consulta`,`id_prod`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Indices de la tabla `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD PRIMARY KEY (`ci_rec`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`id_rece`),
  ADD KEY `id_historial` (`id_historial`,`id_consulta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_ser`);

--
-- Indices de la tabla `serv_cons`
--
ALTER TABLE `serv_cons`
  ADD PRIMARY KEY (`id_serv`,`id_historial`,`id_consulta`),
  ADD KEY `id_historial` (`id_historial`,`id_consulta`);

--
-- Indices de la tabla `serv_mat`
--
ALTER TABLE `serv_mat`
  ADD PRIMARY KEY (`id_serv`,`id_mat_pri`),
  ADD KEY `id_mat_pri` (`id_mat_pri`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usu`),
  ADD KEY `ci_persona` (`ci_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `usu_perm`
--
ALTER TABLE `usu_perm`
  ADD PRIMARY KEY (`id_usu_perm`),
  ADD KEY `id_usu` (`id_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_age` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cara_dental`
--
ALTER TABLE `cara_dental`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_esp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ficha`
--
ALTER TABLE `ficha`
  MODIFY `id_fic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `form_de_vida`
--
ALTER TABLE `form_de_vida`
  MODIFY `id_for` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_his` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_hor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `idlog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1845;

--
-- AUTO_INCREMENT de la tabla `mat_prima`
--
ALTER TABLE `mat_prima`
  MODIFY `id_mat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `nota_compra`
--
ALTER TABLE `nota_compra`
  MODIFY `id_cnot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nota_venta`
--
ALTER TABLE `nota_venta`
  MODIFY `id_vnot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_not` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `odontograma`
--
ALTER TABLE `odontograma`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `patologia`
--
ALTER TABLE `patologia`
  MODIFY `id_pat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `receta`
--
ALTER TABLE `receta`
  MODIFY `id_rece` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_ser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usu_perm`
--
ALTER TABLE `usu_perm`
  MODIFY `id_usu_perm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`ci_odont`) REFERENCES `odontologo` (`ci_odont`);

--
-- Filtros para la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `ficha` (`id_fic`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`id_historial`) REFERENCES `historial` (`id_his`);

--
-- Filtros para la tabla `cuota`
--
ALTER TABLE `cuota`
  ADD CONSTRAINT `cuota_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `nota_venta` (`id_vnot`),
  ADD CONSTRAINT `cuota_ibfk_2` FOREIGN KEY (`ci_paciente`) REFERENCES `paciente` (`ci_pac`);

--
-- Filtros para la tabla `c_p_dental`
--
ALTER TABLE `c_p_dental`
  ADD CONSTRAINT `c_p_dental_ibfk_1` FOREIGN KEY (`id_odont`,`id_pieza`) REFERENCES `pieza_dental` (`id_odont`, `nro`),
  ADD CONSTRAINT `c_p_dental_ibfk_2` FOREIGN KEY (`id_cara`) REFERENCES `cara_dental` (`id_car`);

--
-- Filtros para la tabla `ficha`
--
ALTER TABLE `ficha`
  ADD CONSTRAINT `ficha_ibfk_1` FOREIGN KEY (`ci_pac`) REFERENCES `paciente` (`ci_pac`),
  ADD CONSTRAINT `ficha_ibfk_2` FOREIGN KEY (`id_agen`) REFERENCES `agenda` (`id_age`);

--
-- Filtros para la tabla `ficha_serv`
--
ALTER TABLE `ficha_serv`
  ADD CONSTRAINT `ficha_serv_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `ficha` (`id_fic`),
  ADD CONSTRAINT `ficha_serv_ibfk_2` FOREIGN KEY (`id_serv`) REFERENCES `servicio` (`id_ser`);

--
-- Filtros para la tabla `form_de_vida`
--
ALTER TABLE `form_de_vida`
  ADD CONSTRAINT `form_de_vida_ibfk_1` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`ci_paciente`) REFERENCES `paciente` (`ci_pac`);

--
-- Filtros para la tabla `nota_compra`
--
ALTER TABLE `nota_compra`
  ADD CONSTRAINT `nota_compra_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usu`);

--
-- Filtros para la tabla `nota_mat_prima`
--
ALTER TABLE `nota_mat_prima`
  ADD CONSTRAINT `nota_mat_prima_ibfk_1` FOREIGN KEY (`id_nota_c`) REFERENCES `nota_compra` (`id_cnot`),
  ADD CONSTRAINT `nota_mat_prima_ibfk_2` FOREIGN KEY (`id_mat`) REFERENCES `mat_prima` (`id_mat`);

--
-- Filtros para la tabla `nota_venta`
--
ALTER TABLE `nota_venta`
  ADD CONSTRAINT `nota_venta_ibfk_1` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `odontograma`
--
ALTER TABLE `odontograma`
  ADD CONSTRAINT `odontograma_ibfk_1` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `odontologo`
--
ALTER TABLE `odontologo`
  ADD CONSTRAINT `odontologo_ibfk_1` FOREIGN KEY (`ci_odont`) REFERENCES `persona` (`ci`);

--
-- Filtros para la tabla `odontologo_horario`
--
ALTER TABLE `odontologo_horario`
  ADD CONSTRAINT `odontologo_horario_ibfk_1` FOREIGN KEY (`ci_odont`) REFERENCES `odontologo` (`ci_odont`),
  ADD CONSTRAINT `odontologo_horario_ibfk_2` FOREIGN KEY (`id_hor`) REFERENCES `horario` (`id_hor`);

--
-- Filtros para la tabla `odont_espe`
--
ALTER TABLE `odont_espe`
  ADD CONSTRAINT `odont_espe_ibfk_1` FOREIGN KEY (`ci_odont`) REFERENCES `odontologo` (`ci_odont`),
  ADD CONSTRAINT `odont_espe_ibfk_2` FOREIGN KEY (`id_espe`) REFERENCES `especialidad` (`id_esp`);

--
-- Filtros para la tabla `odont_servicio`
--
ALTER TABLE `odont_servicio`
  ADD CONSTRAINT `odont_servicio_ibfk_1` FOREIGN KEY (`ci_odont`) REFERENCES `odontologo` (`ci_odont`),
  ADD CONSTRAINT `odont_servicio_ibfk_2` FOREIGN KEY (`id_serv`) REFERENCES `servicio` (`id_ser`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`ci_pac`) REFERENCES `persona` (`ci`);

--
-- Filtros para la tabla `pac_pat`
--
ALTER TABLE `pac_pat`
  ADD CONSTRAINT `pac_pat_ibfk_1` FOREIGN KEY (`id_pat`) REFERENCES `patologia` (`id_pat`),
  ADD CONSTRAINT `pac_pat_ibfk_2` FOREIGN KEY (`ci_pac`) REFERENCES `paciente` (`ci_pac`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `pieza_dental`
--
ALTER TABLE `pieza_dental`
  ADD CONSTRAINT `pieza_dental_ibfk_1` FOREIGN KEY (`id_odont`) REFERENCES `odontograma` (`id_odo`);

--
-- Filtros para la tabla `prod_con`
--
ALTER TABLE `prod_con`
  ADD CONSTRAINT `prod_con_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `producto` (`id_prod`),
  ADD CONSTRAINT `prod_con_ibfk_2` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `recepcionista`
--
ALTER TABLE `recepcionista`
  ADD CONSTRAINT `recepcionista_ibfk_1` FOREIGN KEY (`ci_rec`) REFERENCES `persona` (`ci`);

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `receta_ibfk_1` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `serv_cons`
--
ALTER TABLE `serv_cons`
  ADD CONSTRAINT `serv_cons_ibfk_1` FOREIGN KEY (`id_serv`) REFERENCES `servicio` (`id_ser`),
  ADD CONSTRAINT `serv_cons_ibfk_2` FOREIGN KEY (`id_historial`,`id_consulta`) REFERENCES `consulta` (`id_historial`, `id_con`);

--
-- Filtros para la tabla `serv_mat`
--
ALTER TABLE `serv_mat`
  ADD CONSTRAINT `serv_mat_ibfk_1` FOREIGN KEY (`id_serv`) REFERENCES `servicio` (`id_ser`),
  ADD CONSTRAINT `serv_mat_ibfk_2` FOREIGN KEY (`id_mat_pri`) REFERENCES `mat_prima` (`id_mat`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`ci_persona`) REFERENCES `persona` (`ci`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);

--
-- Filtros para la tabla `usu_perm`
--
ALTER TABLE `usu_perm`
  ADD CONSTRAINT `usu_perm_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `evento_notificaciones` ON SCHEDULE EVERY 1 DAY STARTS '2019-06-21 18:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	CALL insertarNotificaciones();
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
