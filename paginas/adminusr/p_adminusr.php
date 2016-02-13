<div class="pad10 contenedor">
            <div class="marB20">
                <h4>
                    Panel administrativo de Tiendas
                </h4>
                <br>
                <br>
                <div class="pull-right">
                   <a class="admin-reg-user" href="#" data-toggle='modal' data-target='#usr-reg-admin' data-rol-type='select'  data-tipo='1' >
						<button class="btn2 btn-default t16" style="">Agregar Usuario</button>
					</a>
                </div>
            </div>
            <div class="tabbable tabs-up">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-shop-active" data-toggle="tab" data-status="1" class="tab-shop" style="outline: inherit;">Tiendas Activas</a>
                    </li>
                    <li>
                        <a href="#tab-shop-inactive" data-toggle="tab" data-status="3" class="tab-shop" style="outline: inherit;">Tiendas Suspendidas</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-shop-active">
                    <div id="lista-shop-active">
                        <table class="table table-striped text-center table-hover">
                            <tr>
                                <th class="text-center">
                                    Seudonimo
                                </th>
                                <th class="text-center">
                                    Razon Social
                                </th>
                                <th class="text-center">
                                    Direcci&#243;n
                                </th>
                                <th colspan="3" class="text-center">
                                    Acciones
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">
                                <?php
                                $status     =1; //NO TRAER USER STATUS SUSPENDIDO

                                if (!isset($usua)) {
                                    $usua = new usuario($_SESSION['id']);
                                }

                                $usuarios_activos=$usua->getUsuarios($status,NULL,NULL);

                                $total=$usuarios_activos->rowCount();
                                $totalPaginas=ceil($total/25);
                                $contador=0;

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12' data-paginaactual='1' data-total="<?php echo $total;?>">
                        <center>
                            <ul class='pagination'>
                                <li id="anterior2" name="anterior2" class="hidden">
                                    <a href='#' aria-label='Previous' class='navegador' data-funcion='anterior2'></a>
                                </li>
                                <li id="anterior1" name="anterior1" class="hidden">
                                    <a href='#' aria-label='Previous' class='navegador' data-funcion='anterior1'></a> <?php
                                    $oculto="";
                                    $activo="active";
                                    for($i=1;$i<=$totalPaginas;$i++):
                                    ?>
                                </li>
                                <li class="<?php echo $activo; echo $oculto;?>">
                                    <a class="botonPagina" href='#' data-status="1" data-container="#lista-shop-active" data-pagina="<?php echo $i;?>"><?php echo $i;?></a>
                                </li><?php
                                $activo="";
                                if($i==10)
                                $oculto=" hidden";
                                endfor;
                                ?><?php
                                if($totalPaginas>1):
                                ?>
                                <li id="siguiente1" name="siguiente1">
                                    <a href='#' aria-label='Next' class='navegador' data-funcion='siguiente1'></a> <?php
                                    endif;
                                    ?> <?php
                                    if($totalPaginas>10):
                                    ?>
                                </li>
                                <li id="siguiente2" name="siguiente2">
                                    <a href='#' aria-label='Next' class='navegador' data-funcion='siguiente2'></a> <?php
                                    endif;
                                    ?>
                                </li>
                            </ul>
                        </center>
                    </div>
                </div>
                <div class="tab-pane" id="tab-shop-inactive">
                    <div id="lista-shop-inactive">
                        <table class="table table-striped text-center table-hover">
                            <tr>
                                <th class="text-center">
                                    Seudonimo
                                </th>
                                <th class="text-center">
                                    Razon Social
                                </th>
                                <th class="text-center">
                                    Direcci&#243;n
                                </th>
                                <th colspan="2" class="text-center">
                                    Acciones
                                </th>
                            </tr>
                            <tbody id="ajaxContainer">
                                <?php
                                $status     =3; //NO TRAER USER STATUS SUSPENDIDO 
                                $usuarios_inactivos=$usua->getUsuarios($status,NULL,NULL);
                                $total=$usuarios_inactivos->rowCount();
                                $totalPaginas=ceil($total/25);
                                $contador=0;

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div id="paginacion" name="paginacion" class='col-xs-12 col-sm-12 col-md-12 col-lg-12' data-paginaactual='1' data-total="<?php echo $total;?>">
                        <center>
                            <ul class='pagination'>
                                <li id="anterior2" name="anterior2" class="hidden">
                                    <a href='#' aria-label='Previous' class='navegador' data-funcion='anterior2'></a>
                                </li>
                                <li id="anterior1" name="anterior1" class="hidden">
                                    <a href='#' aria-label='Previous' class='navegador' data-funcion='anterior1'></a> <?php
                                    $oculto="";
                                    $activo="active";
                                    for($i=1;$i<=$totalPaginas;$i++):
                                    ?>
                                </li>
                                <li class="<?php echo $activo; echo $oculto;?>">
                                    <a class="botonPagina" href='#' data-status="3" data-container="#lista-shop-inactive" data-pagina="<?php echo $i;?>"><?php echo $i;?></a>
                                </li><?php
                                $activo="";
                                if($i==10)
                                $oculto=" hidden";
                                endfor;
                                ?><?php
                                if($totalPaginas>1):
                                ?>
                                <li id="siguiente1" name="siguiente1">
                                    <a href='#' aria-label='Next' class='navegador' data-funcion='siguiente1'></a> <?php
                                    endif;
                                    ?> <?php
                                    if($totalPaginas>10):
                                    ?>
                                </li>
                                <li id="siguiente2" name="siguiente2">
                                    <a href='#' aria-label='Next' class='navegador' data-funcion='siguiente2'></a> <?php
                                    endif;
                                    ?>
                                </li>
                            </ul>
                        </center>
                    </div>
                </div>
            </div>
        </div>