<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>ODONTO</b>Bot</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg , background">Ingrese sus datos para iniciar sesión</p>

    <form accept-charset="UTF-8" role="form" method="post" action="index.php?view=processlogin">

      <div class="form-group has-feedback">

        <input type="text"  name="nombre_usu" class="form-control" placeholder="Usuario" autocomplete="off">

        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <input type="password" name="password" class="form-control" placeholder="Password">

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

      </div>
      <div class="row">
        <?php 
            if(Core::$mensaje){
              Core::mensajeMostrar("error", "ingresar", "Usuario o contraseña no validos");
            }
         ?>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
      </div>

      
    </form>
    <?php 
        // $sql = "Select*from persona";
        // $con = Database::getConexion();
        // $ver = $con->prepare($sql);
        // $ver->execute();
        // echo '<pre>'; print_r($ver->fetchAll()); echo '</pre>';

     ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->