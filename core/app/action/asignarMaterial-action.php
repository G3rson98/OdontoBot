<?php
$idServicio=$_POST["id_ser"];
$VectorMateriales=$_POST["cantUsada"];
$VectorIdMateriales=$_POST["idmat"];
   foreach ($VectorMateriales as $key => $value) {
      if ($value!=0) {  
     servMat::asignarMateriales($idServicio,$VectorIdMateriales["$key"],$value);
      }
}
core::alert("Materiales Agregados"); 
$url="index.php?view=servicio";
core::redir($url);
     
?>

