<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

    <?php 

      $usuario = Usuario::getUsuarioByID($_SESSION["idUsuario"]);
        $permisos = Usuario::getPermisos($_SESSION["idUsuario"]);
        // echo '<pre>'; print_r($permisos); echo '</pre>';
     ?>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">

        <li ><a href="index.php?view=inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
    
    
        <!-- PAQUETE ADM. PERSONAL -->
        <?php 

            if(Usuario::existePermiso($permisos,"ADM Personal")){
                echo '<li class="treeview">
                        <a href="#">
                          <i class="fa fa-dashboard"></i> <span>ADM Personal</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                          <li class="active"><a href="index.php?view=empleado"><i class="fa fa-group"></i>Empleados</a></li>
                          <li><a href="index.php?view=usuario"><i class="fa fa-user"></i>Usuario</a></li>
                          <li><a href="index.php?view=servicio"><i class="fa fa-cogs"></i>Servicios</a></li>
                          <li><a href="index.php?view=especialidad"><i class="fa fa-circle-o"></i>Especialidad</a></li>
                          <li><a href="index.php?view=horario"><i class="fa fa-hourglass-start"></i>Horarios</a></li>
                        </ul>
                      </li>';
            }

        // <!-- PAQUETE ADM. Reserva -->

            if(Usuario::existePermiso($permisos,"ADM Reservas")){
              echo'<li class="treeview">
                      <a href="#">
                        <i class="fa fa-calendar"></i> <span>ADM Reserva</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu" style="display: none;">
                        <li class="active"><a href="index.php?view=paciente"><i class="fa fa-male"></i>Paciente</a></li>
                        <li><a href="index.php?view=patologia"><i class="fa fa-code-fork"></i>Patologia</a></li>
                        <li><a href="index.php?view=addfichaBuscar"><i class="fa fa-circle-o"></i>Ficha</a></li>
                        <li><a href="index.php?view=agenda"><i class="fa fa-circle-o"></i>Agenda</a></li>
                      </ul>
                    </li>
            ';
              }

        // <!-- PAQUETE ADM Consulta -->
              if(Usuario::existePermiso($permisos,"ADM Consultas")){

                echo'<li class="treeview">
                      <a href="#">
                        <i class="fa fa-dashboard"></i> <span>ADM Consulta</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu" style="display: none;">
                        <li class="active"><a href="index.php?view=consulta"><i class="fa fa-circle-o"></i>Consultas </a></li>
                        <li class="active"><a href="index.php?view=producto"><i class="fa fa-circle-o"></i>Productos </a></li>
                        <li class="active"><a href="index.php?view=historial_paciente"><i class="fa fa-circle-o"></i>Historial</a></li>
                      </ul>
                    </li>
                    ';

                }
        // <!-- PAQUETE ADM INVENTARIO -->
              if(Usuario::existePermiso($permisos,"ADM INVENTARIO")){

                echo'<li class=" treeview">
                        <a href="#">
                          <i class="fa fa-barcode"></i> <span>Inventario</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                          <li class="active"><a href="index.php?view=MateriaPrima"><i class="fa fa-circle-o"></i> Materia Prima</a></li>
                          <li><a href="#"><i class="fa fa-circle-o"></i>Nota Compra</a></li>
                        </ul>
                      </li>';
              }
        // <!-- PAQUETE DE SEGURIDAD -->
              if(Usuario::existePermiso($permisos,"SEGURIDAD")){

                echo'<li class="treeview">
                      <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Seguridad</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu" style="display: none;">
                        <li class="active"><a href="index.php?view=log"><i class="fa fa-user-secret"></i>Bitacora</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Backup</a></li>
                      </ul>
                    </li>';
              }
              // <!-- PAQUETE DE FLUJO DE CAJA -->
              if(Usuario::existePermiso($permisos,"FLUJO DE CAJA")){

                echo'<li class="treeview">
                      <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Flujo de Caja</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu" style="display: none;">
                         <li><a href="index.php?view=registrocompra"><i class="fa fa-user"></i>Compras</a></li> 
                         <li><a href="index.php?view=registroventa"><i class="fa fa-user"></i>Registrar Ventas</a></li> 
                      </ul>
                    </li>';
              }
        

              // <!-- PAQUETE DE SEGURIDAD -->
              if(Usuario::existePermiso($permisos,"INVENTARIO")){

                echo' <li class="treeview">
                        <a href="#">
                          <i class="fa fa-dashboard"></i> <span>ADM Stock</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                          <li class="active"><a href="index.php?view=MateriaPrima"><i class="fa fa-group"></i>Materia Prima</a></li>
                         
                          
                          
                         
                        </ul>
                      </li>';
              }
         ?>
          
        <li ><a href="index.php?view=salir"><i class="fa fa-user-secret"></i> <span>Salir</span></a></li>
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>