<!-- Main content -->
<section  class="content">

    <!-- CAJA DE INSERTAR UN INGRESO --> <!-- style="display: none;" -->
   <div class="box" >

        <div class="box-header with-border" style="background:#ffffff;">

             <h3 class="text-center">Registrando nota compra</h3>

        </div>
            
        
                <div class="box-body box-primary">
                    <div class="row">

                        <div class="col-md-12">
                            
                            <form class="form-horizontal" method="post" action="index.php?action=addnotacompra">

                                <div class="form-group">

                                    <!-- CAMPO NIT -->
                                    <label class="control-label col-sm-2" for="email">Nit: </label>

                                    <div class="col-sm-5">

                                        <input type="text" name ="nit" class="form-control" placeholder="ingrese nit de la empresa" required maxlength="50" autocomplete="off">

                                    </div>

                                </div>


                                <div class="form-group">
                                    <!-- CAMPO NOMBRE EMPRESA -->
                                    <label class="control-label col-sm-2" for="email">Nombre Emp.: </label>

                                    <div class="col-sm-6">

                                        <input type="text" name ="nombre" class="form-control" placeholder="ingrese nombre de la empresa" required maxlength="50" autocomplete="off">

                                    </div>

                                </div>

                                <div class="form-group">
                                    <!-- CAMPO Fecha -->
                                    <label class="control-label col-sm-2" for="email">Fecha : </label>

                                    <div class="col-sm-2">

                                        <input type="date" name ="fechaCompra" class="form-control" required >

                                    </div>

                                </div>
                                
                                
                             <br>               
                            <div class="form-group col-lg-12">

                                <div class="input-group">
                                    
                                    <button type="button" data-target="#modalProductos" data-toggle="modal" class="btn btn-success btnModal"> <i class="fa fa-search"> </i>  Materia Prima </button>
                                </div>
                            </div>
                            
                            <br>

                                <h4 class="text-center">Lista Materia Prima</h4>

                                <table class="table table-striped table-bordered table-hover dt-responsive tablaIngreso">
                                   <thead>
                                      <tr>
                                         <th>Nombre</th>
                                         <th>Descripcion</th>
                                         <th>Cantidad</th>
                                         <th>Precio</th>
                                         <th>Fecha ven.</th>
                                      </tr>
                                   </thead>

                                   <tbody class="cuerpo-tabla">
                                       
                                   </tbody>
                                   
                                </table>
                                
                                <div class="text-center">
                                    
                                   <div class="form-group col-md-12">
                                        <label>
                                            <input type="checkbox" class="calculo-nota"> Calculo Automatico
                                          </label> <br>  <br>
                                        <div class="btn-group btns">

                                            <a class="btn btn-md btn-default">Total: </a>
                                            <a class="btn btn-md btn-info mostrar-resultado">   0.0   Bs</a> 
                                            <input type="hidden" class="mostrar-resultado" id="total" name="total" required> 
                                          
                                            
                                        </div>
                                    </div>

                                      
                                </div>

                                <button type="submit" class="btn btn-success btn-sm disabled btnEnvio">Registrar </button>
                                <a href="index.php?view=registrocompra" class="btn btn-primary btn-sm">Cancelar</a>                 
                            </form>
                        </div>
                        <!-- end col-md-12 -->       
                    </div>
                      
                </div>
            
   </div>
   <!-- end of div.box  -->

</section>

 <!-- MODAL DE TABLA DE LAS MATERIAS PRIMAS -->

 <div id="modalProductos" class="modal fade" role="dialog">  
    <div class="modal-dialog modal-lg">

      <form class="form-horizontal" rol="form" method="post">  
        <!--contenido modal-->
        <div class="modal-content">
          
              <div class="modal-header" style="background-color: #3c8dbc;">

                  <button type="button" class="close" data-dismiss="modal">&times</button>

                  <h4  style="color: #ffff; font-size: 20px;" class="modal-title text-center">Tabla de Materias Primas</h4>

              </div>

              <div class="modal-body">

                <div class="box-body">

                    <table class="tablas table table-bordered table-hover" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 8px;">Selecionar</th>
                                <th>Categoria</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
            
                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $materiaP = MateriaPrima::mostrarMateriaPrima();
                                // echo '<pre>'; print_r($materiaP); echo '</pre>';

                                foreach ($materiaP as $key => $value) {

                                    echo "<tr>
                                            <td><button type='button' idMat='".$value["id_mat"]."'  nombreMat='".$value["nombre_mat"]."' 
                                            descripcionMat='".$value["descripcion_mat"]."' class='btn btn-warning btn-md btn-nota-compra'><i class='fa fa-check'></i></button></td>
                                            <td>".$value["nombre_mat"]."</td>
                                            <td>".$value["nombre_mat"]."</td>
                                            <td>".$value["descripcion_mat"]."</td>
                                            </tr>";
                                }

                             ?>
                        </tbody>
    
                       
                    </table>
                </div>

            </div>

            <div class="modal-footer" >

                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar</button>

            </div>

         </div>

      </form>

    </div> 
</div>




