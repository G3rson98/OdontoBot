<section class="content">
	

   <div id="ingreso-detallado" class="box" >

        <div class="box-header with-border" style="background:#ffffff;">

             <h3 class="text-center">Registrando ingreso almacén</h3>
             <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalInsertarEmpleado">Agregar empleado</button>              -->

        </div>

        <div class="box-body box-primary">
            <div class="row">

                <div class="col-md-12">
                <?php 
                    // $detalleIngreso = ControladorIngresos::MostrarIngresos();
                    // // echo '<pre>'; print_r($detalleIngreso); echo '</pre>';
                    // $nombreProveedor = ModeloProveedor::mdlMostrarProveedorById($detalleIngreso["idproveedor"]);

                ?>
                    
                   <div class="form-group has-success col-xs-12 col-sm-8 col-md-10 col-lg-9">
                        <label >Proveedor</label>
                        <div class="input-group">

                            <!-- <?php echo'<input type="text" class="form-control input-md" value="'.$nombreProveedor["nombre"].'" readonly>';?> -->
                             <input type="text" class="form-control input-md" value="" readonly>   

                            <span class="input-group-addon"> <i class="fa fa-code"></i> </span>

                            
                        </div>
                      
            
                    </div>

                    <div class="form-group has-error col-xs-12 col-sm-4 col-md-2 col-lg-3">

                        <label >Impuesto</label>
                        <div class="input-group">
                           <!-- <?php echo '<input type="text" class="form-control" value="'.$datosConfig["porcentaje"].'" readonly>';?> -->
                             <input type="text" class="form-control input-md" value="" readonly>   

                            <span class="input-group-addon">%</span> 
                        </div>

                    </div>


                    <div class="form-group has-success col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label >Comprobante</label>
                        <div class="input-group">

                            <!-- <?php echo'<input type="text" class="form-control input-md" value="'.$detalleIngreso["comprobante"].'" readonly>';?> -->
                             <input type="text" class="form-control input-md" value="" readonly>   

                            <span class="input-group-addon"> <i class="fa fa-code"></i> </span>
                            
                        </div>
                      
            
                    </div>

                    <div class="form-group has-success col-xs-12 col-sm-3 col-md-3 col-lg-3">

                        <label>Serie/Folio</label>
                        <div class="input-group">
                            <!-- <?php echo'<input type="text" class="form-control input-md" value="'.$detalleIngreso["serieComprobante"].'" readonly>';?> -->
                             <input type="text" class="form-control input-md" value="" readonly>   

                            <span class="input-group-addon">%</span> 
                        </div>

                    </div>

                     <div class="form-group has-success col-xs-12 col-sm-3 col-md-3 col-lg-3">

                        <label >Numero</label>
                        <div class="input-group">
                            <!-- <?php echo'<input type="text" class="form-control input-md" value="'.$detalleIngreso["numeroComprobante"].'" readonly>';?> -->
                             <input type="text" class="form-control input-md" value="" readonly>   

                            <span class="input-group-addon">%</span> 
                        </div>

                    </div>
                    
                
                    
    
                        <h4 class="text-center">Lista de detallada del ingreso</h4>

                        <table class="table table-striped table-bordered table-hover dt-responsive tablaIngreso">
                           <thead>
                              <tr>
                                <th>#</th>
                                 <th>Producto</th>
                                 <th>Codigo</th>
                                 <th>Serie</th>
                                 <th>Descripcion</th>
                                 <th>Stock ingreso</th>
                                 <th>P compra</th>
                                 <th>P Venta</th>
                              </tr>
                           </thead>
                           <tbody>
                            <!-- <?php 
                                 if($detalleIngreso){
                                    //si len = 20 no tiene productos ingresado [9]
                                    $len= count($detalleIngreso) - 20 + 9; $j=1;
                                    // echo '<pre>'; print_r($detalleIngreso); echo '</pre>';
                                    for ($i=10; $i <= $len; $i++) {
                                        $producto = $detalleIngreso[$i];

                                        echo'<tr>
                                                <td>'.$j.'</td>
                                                <td>'.$producto["nombre_producto"].'</td>
                                                <td>'.$producto["codigo"].'</td>
                                                <td>'.$producto["serie"].'</td>
                                                <td>'.$producto["descripcion"].'</td>
                                                <td>'.$producto["stockIngreso"].'</td>
                                                <td>'.$producto["precioIngreso"].'</td>
                                                <td>'.$producto["precioVenta"].'</td>
                                            </tr>'; 
                                        $j++;
                                    }
                                }
                             
                                          
                            ?>  -->
                                                           
                           </tbody>

                        </table>
                        <br>
                        <br>
                        <br>
                        

                        <div class="text-center">

                           <div class="form-group col-md-12">
                                <div class="btn-group">
                                    <button type="" class="btn btn-md" style="border-color:#FA5D5D; background:#F3C8CB;">   SubTotal:   </button>
                                    <?php 
                                        // if(isset($detalleIngreso)){
                                        //         echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">'.($detalleIngreso["monto_total"]-$detalleIngreso["impuesto"]).'</button>';

                                        // }else{
                                        //     echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">  0.0 </button>';
                                            
                                        // }
                                    ?>   
                                </div>
                           

                            
                                <div class="btn-group">
                                   
                                        <button type="" class="btn btn-md" style="border-color:#FA5D5D; background:#F3C8CB;">   IGV %   </button>
                                    
                                    <?php
                                        //  if(isset($detalleIngreso)){
                                        //         echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">'.$detalleIngreso["impuesto"].'</button>';

                                        // }else{
                                        //     echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">  0.0 </button>';
                                            
                                        // }

            
                                    ?>  
                                </div>

                                <div class="btn-group">
                                    <button type="" class="btn btn-md" style="border-color:#FA5D5D; background:#F3C8CB;">   Total:   </button>
                                    <?php 
                                        // if(isset($detalleIngreso)){
                                        //         echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">'.$detalleIngreso["monto_total"].'</button>';

                                        // }else{
                                        //     echo'<button type="" class="btn btn-md" style="border-color:#FA5D5D;">  0.0 </button>';
                                            
                                        // }
                                    
                                    ?>   
                                </div>
                            </div>

                              
                        </div>

                        <button type="" class="btn btn-primary btnAtras"> Atras</button>
            
                </div>
                <!-- end col-md-12 -->       
            </div>
                  
        </div>
   </div>
</section>