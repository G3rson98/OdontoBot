<?php

$ci=$_GET["id"];
$id_ficha=$_GET["ficha"];
        $sql = "SELECT * FROM historial where ci_paciente=:ci";
        $con = Database::getConexion();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":ci", $ci,PDO::PARAM_INT);
        $stmt->execute();
    $historial=$stmt->fetch();
    // echo '<pre>'; print_r($historial); echo '</pre>';

$id_historial=$historial["0"];    

 $id_cons;
$prueba=Consulta::getconsultabyficha($id_ficha);
echo '<pre>'; print_r($prueba); echo '</pre>';
if ($prueba["0"]==0){    
    $consulta=new Consulta($id_historial," "," "," "," ",$id_ficha);
    $consulta->crear_consulta();    
    echo '<pre>'; print_r("No"); echo '</pre>'; 
    $consulta_creada=Consulta::getconsultabyficha($id_ficha);
    $id_cons=$consulta_creada["id_con"] ;
    echo '<pre>'; print_r($id_cons); echo '</pre>'; 
}else{
    echo '<pre>'; print_r("SI"); echo '</pre>';
    $id_cons=$prueba["id_con"] ;
    echo '<pre>'; print_r($id_cons); echo '</pre>';
}

$url="index.php?view=addconsulta&ci_per=$ci&id_ficha=$id_ficha&id_his=$id_historial&id_cons=$id_cons&id=$id_ficha";
Core::redir($url);

