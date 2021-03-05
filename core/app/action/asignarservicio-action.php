<?php
    $servicio=$_POST["servicios"];
    $ci=$_POST["ci"];
    
  //  $nombre_serv=$_POST["nombre"];
  $servicio_serv=Odont_servicio::mostrarservicio($ci);

   foreach($servicio_serv as $key=>$value){
    $servicio_serv2=$servicio_serv["$key"];
    $Ser_=$servicio_serv2["id_serv"];
    Odont_servicio::eliminarservicio($ci,$Ser_);       
  }
    foreach ($servicio as $key => $value) {
      $res= Odont_servicio::asignarservicio($ci,$value);
    }
    core::alert("Servicios Asignados correctamente");        
    $url="index.php?view=odontologo";
    core::redir($url);
     