<?php
    $servicio=$_POST["servicios"];
    $ci=$_POST["ci"];   
    $servicio_serv=pas_pat::mostrarpatologia($ci);
    
    $descripcion=$_POST["descripcion"];
    $array_desc;
    $contador=0;
  foreach ($descripcion as $key=>$value){
      if ($value != ""){
        $array_desc[$contador]=$value;
        $contador+=1;
      }

  }
  echo '<pre>'; print_r($array_desc); echo '</pre>';

   foreach($servicio_serv as $key=>$value){
    $servicio_serv2=$servicio_serv["$key"];
    $Ser_=$servicio_serv2["id_pat"];
    pas_pat::eliminarpatologia($Ser_,$ci);       
  }

    echo '<pre>'; print_r($servicio); echo '</pre>';
    foreach ($servicio as $key => $value) { 
      $desc=$array_desc[$key];
      $res= pas_pat::asignarpatologia($value,$ci,$desc);
    }
     core::alert("Patologia Asignada correctamente");        
      $url="index.php?view=paciente";
     core::redir($url);
     