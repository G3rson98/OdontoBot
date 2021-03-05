<?php
    //echo '<pre>'; print_r($_POST); echo '</pre>';
    $idficha=$_POST["id"];
    $servicio=$_POST["servicios"];
    $precios=$_POST["precio"];


    $id_historial=$_POST["id_his"];
    $id_consulta=$_POST["id_cons"];
    $id_pac=$_POST["ci_per"];
    $id_ficha=$_POST["id_ficha"];
    
    
                                    $sql = "select id_historial,id_con from consulta where id_ficha=:idficha";
                                    $con = Database::getConexion();
                                    $stmt = $con->prepare($sql);
                                    $stmt->bindValue(":idficha", $idficha,PDO::PARAM_STR);
                                    $stmt->execute();
                                    $array=$stmt->fetch();

    $id_historial=$array["id_historial"];
    $id_consulta=$array["id_con"];
    $array_precios;
    $contador=0;
    foreach($precios as $key=>$value){
      
      if ($value!= ""){
        $array_precios[$contador]=$value;
        $contador+=1;
      }
      
    }
    
    $servicio_serv = consulta_servicio::mostrarservicio($id_consulta,$id_historial);

    if (count($servicio_serv)>0){
            foreach($servicio_serv as $key=>$value){
              $servicio_serv2=$servicio_serv["$key"];
              $Ser_=$servicio_serv2["id_serv"];
              consulta_servicio::eliminarservicio($id_consulta,$id_historial,$Ser_);       
            }
     }
     // echo '<pre>'; print_r($servicio); echo '</pre>';
    foreach ($servicio as $key => $value) {
     
       $servicio_nuevo=$value;
       $precio=$array_precios[$key];
       $res=consulta_servicio::asignarservicio($servicio_nuevo,$id_historial,$id_consulta,$precio);
       
    }

    //___________________________________Christian _________________________________________________
        
    foreach($servicio as $key => $value){
    // echo $value;
        $id_serv=$value;
          if(Trigger::set_actualizar_mat_prima($id_serv)){
   
        }else{
    
        }        
      }
    if($res){
      // se inserto correctamente

      $url="<script> history.go(-2); </script>";
      Core::alert("se inserto correctamente");
      Core::imprimir($url); exit;
    }








    // core::alert("Servicios Asignados correctamente");        
    // $url="index.php?view=addconsulta&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha&id=$idficha";
    // core::redir($url);
     