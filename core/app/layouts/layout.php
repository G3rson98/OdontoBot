<!-- se inicio session -->
<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <!-- HEAD core/app/layouts/-->
   <?php require_once "core/app/layouts/head.php"; ?>   
<!--=============================================
=            BODY            =
=============================================-->

<body class="hold-transition skin-blue sidebar-mini login-page">
<?php   
if( isset($_SESSION["nombreUsuario"]) ){ 

  echo '<div class="wrapper">';


/*==============================
=            HEADER            =
==============================*/
  require_once "core/app/layouts/header.php";

/*==============================
= Left side column. contains the logo and sidebar            =
==============================*/

  require_once "core/app/layouts/sidebar.php";


  // <!-- Content Wrapper. Contains page content -->
echo'  <div class="content-wrapper">';
    // <!--=============================================
    // =            SECCION DEL CONTENIDO            =
    // =============================================-->
      if(isset($_GET["view"])){
        // echo '<pre>'; print_r("existe view"); echo '</pre>';
          if($_GET["view"] != "inicio"){

            View::load($_GET["view"]); 

          }else if($_GET["view"] == "inicio"){


            include "core/app/view/inicio-view.php";

          }
      }
   
      
    // <!--=====  End of SECCION DEL CONTENIDO  ======-->
echo'</div>';
  // <!-- /.content-wrapper -->

  // <!-- Main Footer -->
    include "core/app/layouts/footer.php"; 
 echo '</div>';
// <!-- ./wrapper -->

    }else{ 

       //no se inicio sesion muestra LOGIN
      View::load("login"); 

    } 

  ?>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="assets/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- fullCalendar -->
<script src="assets/moment/moment.js"></script>
<script src="assets/fullcalendar/dist/fullcalendar.min.js"></script>

<!-- NUESTRO SCRIPT  -->
<script src="assets/odorecurso/js/layout.js"></script>
<script src="assets/odorecurso/js/plantilla.js"></script>
<script src="assets/odorecurso/js/usuario.js"></script>
<script src="assets/odorecurso/js/notacompra.js"></script>

</body>
</html>    

