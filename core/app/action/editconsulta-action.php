<?php
    echo '<pre>'; print_r($_POST); echo '</pre>';

    $idficha=$_POST["ficha"];

    $sql = "select id_historial,id_con from consulta where id_ficha=:idficha";
    $con = Database::getConexion();
    $stmt = $con->prepare($sql);
    $stmt->bindValue(":idficha", $idficha,PDO::PARAM_STR);
    $stmt->execute();
    $array=$stmt->fetch();

    echo '<pre>'; print_r($array); echo '</pre>';
    $id_historial=$array["id_historial"];
    $id_consulta=$array["id_con"];
    $motivo=$_POST["motivo"];
    $diagnostico=$_POST["diagnostico"];
    $tratamiento=$_POST["tratamiento"];
    $fecharetorno=$_POST["fechaFicha"];

    // $id_consulta=Consulta::getconsultabyficha($idficha);
    $Consulta=Consulta::edit_consulta($id_historial,$motivo,$diagnostico,$tratamiento,$fecharetorno,$idficha,$id_consulta);
    echo '<pre>'; print_r($Consulta); echo '</pre>';

    $url="index.php?view=consulta";
    Core::redir($url);
