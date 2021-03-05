<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">ODONTObot</h3>

          
        </div>
        <div class="box-body">
          Bienvenido a ODONTObot
          <?php 
          $ci =$_SESSION["idPersona"];
            $Persona=Persona::getpersonabyci($ci);
           

            echo "<p style='text-align : center;'><font size=7>".$Persona['nombre_per']." ".$Persona['paterno']." ".$Persona['materno']."</font size></p";
            
           ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
</section>