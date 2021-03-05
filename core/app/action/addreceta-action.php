<?php
    $idficha=$_POST["id"];
    $descripcion=$_POST["descripcion"];
    $id_historial=$_POST["id_his"];
    $id_consulta=$_POST["id_cons"];
    $id_pac=$_POST["ci_per"];
    $id_ficha=$_POST["id_ficha"];    
    // $recetaaa=Receta::getreceta($id_historial,$id_consulta);
     echo '<pre>'; print_r($_POST); echo '</pre>';
     echo '<pre>'; print_r($_GET); echo '</pre>';

    $receta=new Receta($descripcion,$id_consulta,$id_historial);
    // echo '<pre>'; print_r(); echo '</pre>';
    $c = count(Receta::getReceta($id_historial,$id_consulta));
    echo '<pre>'; print_r($c); echo '</pre>';
    if($c>0){
        $receta->editreceta();
    }else{
        $receta->addReceta();
    }    
        core::alert("Receta edito con Exito");        
    $url="index.php?view=addconsulta&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha&id=$idficha";
    core::redir($url);

   
    //     core::alert("Receta Guardad con Exito");        
    // $url="index.php?view=addconsulta&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha&id=$idficha";
    // core::redir($url);
        
        