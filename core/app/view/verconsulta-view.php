<!-- Main content -->
<?php //echo '<pre>'; print_r($_GET); echo '</pre>'; ?>
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Consulta</h3>
            <?php                             
                $id_historial=$_GET["id_his"];
                $id_consulta=$_GET["id_cons"];
                $id_pac=$_GET["ci_per"];
                $id_ficha=$_GET["id_ficha"];
                $array_consulta=Consulta::getSolaconsulta($id_ficha,$id_consulta,$id_historial);
                // echo '<pre>'; print_r($array_consulta); echo '</pre>';

                if (FormularioVida::ConsultaTieneFV($id_consulta,$id_historial)=="true") {
                    echo "<a href='index.php?view=verformulario_vida&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Formulario de vida</a>";
                }else{


                echo "<a href='index.php?view=verformulario_vida&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Formulario de vida</a>";
                }
                echo" ";
                 echo "<a href='index.php?view=verproducto_Consulta&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Productos Consulta</a>   ";
             ?>


            
            <?php
            $idficha = $_GET["id_ficha"];
            echo "<a href='index.php?view=ver_receta&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha&id=$idficha' type='button' class='btn btn-primary btn-md'>Receta</a>   ";
            echo" ";
            echo "<a href='index.php?view=verserv_cons&id=$idficha&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Servicios</a>  ";
            echo "<a href='index.php?view=ver_odont&id_his=$id_historial&id_cons=$id_consulta' type='button' class='btn btn-primary btn-md'>Odontograma</a>   ";

                 echo "<a href='index.php?view=vernotaventa&id_his=$id_historial&id_cons=$id_consulta' type='button' class='btn btn-primary btn-md'>Nota venta</a>   ";
            ?>
        </div>
        <div class="box-body">



        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=editconsulta">


                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Motivo: </label>

                    <div class="col-sm-8">
                        <?php
                            echo "<input value='".$array_consulta["motivo"]."' type='text' name='motivo' class='form-control' id='motivo' placeholder='ingrese nombre' readonly>";
                        ?>
                        
                        <?php
                            $idficha = $_GET["id_ficha"];
                            echo "<input type='hidden' name='ficha'value=".$idficha." class='form-control' id='ficha' placeholder='ingrese nombre'>";
                        ?>

                    </div>

                </div>

                <!-- CAMPO Descripcion-->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Diagnostico : </label>
                    <div class="col-sm-8">
                    <?php
                       echo" <input value='".$array_consulta["diagnostico"]."' type='text' name='diagnostico' class='form-control' id='diagnostico' placeholder='ingresar descripcion' readonly>";
                    ?>
                    </div>

                </div>

                <!-- CAMPO APELLIDO MATERNO -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Tratamiento: </label>
                    <div class="col-sm-8">
                    <?php
                        echo "<input value='".$array_consulta["tratamiento"]."' type='text' name='tratamiento' class='form-control' id='tratamiento' placeholder='ingresar descripcion' readonly>";
                    ?>
                    </div>

                </div>
                <div class="form-group">

                    <label class="control-label col-sm-2" for="fechaFicha">Fecha de retorno: </label>

                    <div class="col-sm-3">
                    <?php
                        echo "<input value ='".$array_consulta["fecha_retorno"]."' type='date' class='form-control' name='fechaFicha' id='fechaFicha' readonly>";
                    ?>
                    </div>

                </div>
                <div class="form-group">
                    
                </div>

            </form>
        </div>
        <!-- /.box-body -->


    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->