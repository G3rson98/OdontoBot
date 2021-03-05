<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Odontograma</h3>
        </div>
        <div class="box-body">

            <?php
            $id_historial = $_GET["id_his"];
            $id_consulta = $_GET["id_cons"];
            $sql = "select nro,nombre_pie,nombre_car,estado_diag from odontograma,pieza_dental,cara_dental,c_p_dental
                  where	odontograma.id_odo=pieza_dental.id_odont
                  and		pieza_dental.id_odont=odontograma.id_odo
                  and		pieza_dental.nro=c_p_dental.id_pieza
                  and		pieza_dental.id_odont=c_p_dental.id_odont
                  and 	    c_p_dental.id_cara=cara_dental.id_car
                  and		odontograma.id_historial=:hist_id
                  and		odontograma.id_consulta=:id_con";
            $con = Database::getConexion();
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":hist_id", $id_historial, PDO::PARAM_INT);
            $stmt->bindValue(":id_con", $id_consulta, PDO::PARAM_INT);
            $stmt->execute();
            $resp = $stmt->fetchAll();

            ?>
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                <thead>
                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nro Pieza</th>
                        <th>Nombre de Pieza dental</th>
                        <th>Cara dental</th>
                        <th>diagnostico</th>
                    </tr>

                </thead>
                <tbody>
                    <?php

                    foreach ($resp as $key => $value) {
                        echo "<tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $value["nro"] . "</td>";                    
                        echo "
                            <td>" . $value["nombre_pie"] ."</td>";
                        echo "
                            <td>" . $value["nombre_car"] . "</td>
                            <td>" . $value["estado_diag"]  . "</td>";
                            
                        echo "</tr>";
                    }

                    ?>
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nro Pieza dental</th>
                        <th>Nombre de Pieza dental</th>
                        <th>Cara dental</th>
                        <th>diagnostico</th>
                    </tr>

                </tfoot>

            </table>
            <a href="javascript:history.go(-1)" class="btn btn-primary btn-sm">atras</a>

        </div>
                    
    </div>

</section>