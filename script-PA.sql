-- --------------------------------------------------------
-- Insertar a la tabla Paciente -- Funnciona en la NUEVA BASE DE DATOS 
Select* from paciente p ,persona per where per.ci = p.ci_pac;
DROP PROCEDURE insert_Paciente;
DELIMITER //
   CREATE PROCEDURE insert_Paciente(
   	IN CI INT,
    IN NOMBRE varchar(50),
    IN PATERNO varchar(50),
    IN MATERNO varchar(50),
   	IN SEXO char(1),
    IN TELEFONO INT,
    IN CELULAR INT,
    IN DIRECCION VARCHAR(50),
    IN FECHA_NAC VARCHAR(15),
    IN LUGAR_NAC varchar(40),
    IN ESTADO CHAR(1)
   	)BEGIN
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
   END//
   
   
   use consultorio_dr_robles;
-- prueba Insertando Paciente
CALL insert_Paciente(19087,'vvvv','yy','zfg','F',3324712,77824543,'B/Suarez','1990-02-13','tarija','a');
Select * from paciente p ,persona per where per.ci = p.ci_pac and per.ci = 111;

-- --------------------------------------------------------
-- Insertar a la tabla Usuario --
DROP PROCEDURE insertarUsuario;
DELIMITER //
CREATE PROCEDURE insertarUsuario(
IN NOMBRE_USER VARCHAR(30), IN CONTRASENA varchar(20), ESTADO CHAR(1), IN CI_PERS INT, IN ID_ROL INT
)BEGIN
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
END//
-- PRUEBA --
-- CALL insertarUsuario(NOMBRE_USER VARCHAR,CONTRASENA varchar, ESTADO CHAR,CI_PERS INT,ID_ROL INT);
CALL insertarUsuario('Mary',1234,'A',43123854,3);
CALL insertarUsuario('juanito',1234,'A',78936741,2);
-- --------------------------------------------------------
-- Insertar a la tabla Servicio --
DROP PROCEDURE insertarServicio;
DELIMITER //
CREATE PROCEDURE insertarServicio(
IN ID INT, IN NOMBRE varchar(70), DESCRIPCION VARCHAR(200), IN ESTADO CHAR(1)
)BEGIN
	IF NOT EXISTS(SELECT * FROM servicio WHERE id = ID) THEN
		INSERT INTO servicio VALUES (ID, NOMBRE,DESCRIPCION, ESTADO);
    ELSE
		UPDATE servicio
        SET nombre = NOMBRE,
			descripcion = DESCRIPCION,
			estado = ESTADO
        WHERE id = ID;
    END IF;
END//
-- PRUEBA --
CALL insertarServicio(1,'General','Consulta generales','A');

-- --------------------------------------------------------
-- Insertar a la tabla MATERIA PRIMA --
DROP PROCEDURE insertarMateriaPrima;
DELIMITER //
CREATE PROCEDURE insertarMateriaPrima(
)BEGIN

END//;

-- --------------------------------------------------------
-- Insertar a la tabla CUOTA --
DROP PROCEDURE insertarCuota;
DELIMITER //
CREATE PROCEDURE insertarCuota(
)BEGIN

END//;
-- --------------------------------------------------------
-- PROCEDIMIENTOS ALMACENADOS PARA MOSTRAR LOS DATOS
-- --------------------------------------------------------
-- Mostrar PACIENTE

-- --------------------------------------------------------
-- MOSTRAR PERSONAL

-- --------------------------------------------------------
-- MOSTRAR MATERIA PRIMA


-- --------------------------------------------------------
    

/*DELIMITER $$
CREATE TRIGGER before_employee_update 
    BEFORE UPDATE ON employees
    FOR EACH ROW 
BEGIN
    INSERT INTOemployees_audit
    SET action = 'update',
     employeeNumber = OLD.employeeNumber,
        lastname = OLD.lastname,
        changedat = NOW(); 
END$$
DELIMITER ;*/

-- --------------------------------------------------------
-- TRIGGER PARA actualizar las cantidades de uso de una MATERIA PRIMA (cuando se inserte una nueva compra) --


-- --------------------------------------------------------
-- TRIGGER DE LA BBDD consutorio Dental --


-- --------------------------------------------------------
-- TRIGGER DE LA BBDD consutorio Dental --


-- --------------------------------------------------------
-- TRIGGER DE LA BBDD consutorio Dental --


-- PROCEDIMIENTOS DE LOGICA DE NEGOCIO ---
-- VALIDAR UN USUARIO --
use consultorio_dr_roblesvd;
call validar_Usuario('admin','admin');
DROP PROCEDURE validar_Usuario; -- ESTE PROCEDURE FUNCIONA EN LA NUEVA BASE DE DATOS
DELIMITER //
CREATE PROCEDURE validar_Usuario(
USERNAME VARCHAR(30),
CONTRASENA VARCHAR(30)
)
BEGIN	
	Select* from usuario u where u.nombre_usuario = USERNAME and u.contrasena = CONTRASENA;
END//

SELECT NOT EXISTS(SELECT * FROM usuario);


SELECT* FROM usuario WHERE nombre_usuario = 'admin' AND contrasena='admiasan' ;



use consultorio_dr_roblesvd;
Select* from usuario u persona p where u.ci_persona = p.ci; 
-- CREANDO LA TABLA LOG

CREATE TABLE log (
idlog int primary key auto_increment,
id_usuario int,
nombre_usuario varchar(30),
id_rol int,
accion varchar(30),
descripcion varchar(30),
fecha TIMESTAMP default now() 
);

insert into log values(null,1,'admin',1,'ingreso','sistema', default);

Select l.idlog,id_usuario,l.nombre_usuario,l.id_rol,r.nombre_rol,l.accion,l.descripcion,l.fecha,p.ci,p.nombre_per,p.paterno
From log l, usuario u, rol r, persona p
Where l.id_usuario = u.id_usu and
	  u.id_rol = r.id_rol and u.ci_persona = p.ci