

<section class="content">
  <div class="box">
    <!-- CABEZA DE LA CAJA -->
    <div class="box-header with-border">

      <h3 class="text-center"> AGENDA</h3>

    </div>
    <!-- CUERPO DE LA CAJA -->
    <div class="box-body">

      <form class="form-horizontal" method="POST" action="index.php?view=agenda2">

        <!-- CAMPO NOMBRE -->
        <div class="form-group">

          <label class="control-label col-sm-2" for="ci">Escoja:  </label>

          <div class="col-sm-10">

             <select  class="form-control selectEmpleado" name="tiempo" required>
                  
                    <option value="">Selecione uno</option>

                     <option value="1">DIA</option>   
                     <option value="2">MES</option>   
                     <option value="3">AÑO</option>   
                     
                      </select>

          </div>

        </div>

        <?php $array_odont=Odontologo::mostrarOdontologo(); 
         // echo '<pre>'; print_r($array_odont); echo '</pre>';?>
         <div class="form-group">

          <label class="control-label col-sm-2" for="">Escoja odontologo:  </label>

          <div class="col-sm-10">

             <select  class="form-control selectEmpleado" name="odont" required>
                  <option value="">Selecionar Odontologo</option>
                    <?php 
                      foreach ($array_odont as $key => $value) {
                        $id_odont=$value["ci"];
                        echo "<option value=$id_odont>".$value["nombre_per"]." ".$value["paterno"]." ".$value["materno"]."</option>";
                      }

                     ?>
              </select>

          </div>

        </div>
        
        
        <!--=============================================
        =            Section comment block            =
        =============================================-->
          

        <div class="form-group"> 

          <div class="col-sm-offset-2 col-sm-10">

            <button type="submit" class="btn btn-primary btn-md">Mostrar agenda</button>
            <a href="index.php?view=inicio" type="button" class="btn btn-default btn-md">Cancelar</a>
          </div>
        </div>

      </form>
    </div>
    <!-- /.box-body -->
    
  </div>
  <!-- /.box -->

</section>
<!-- Caja-box-->

