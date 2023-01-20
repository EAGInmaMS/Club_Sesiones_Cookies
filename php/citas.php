<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Citas</title>
</head>

    <?php
        if(isset($_COOKIE['sesion'])){
            require_once("funciones.php");
            list($usu,$nom)=comprobar_sesion();
            $conexion=conectarservidor();
                echo "<body class='bodyprodserv'>";
                echo imprimir_menu($usu,$nom);
                echo "<main id='maincita'> <h1>Citas</h1>";
                // Este if comprueba si se quiere ir hacia atrás o hacia adelante, en el caso de ir hacia atrás, comprueba si se cambia de año, para restar 1, y en el caso de
                // ir hacia delante, si se cambia de año para sumar 1
                if(isset($_GET['mesant'])){
                    $mes=$_GET['mesant']-1;
                    $anio=$_GET['anio'];
                    if($mes==0){
                        $anio--;
                        $mes=12;
                    }
                    $n_mes=nom_mes($mes);
                    echo calendario($mes,$n_mes,$anio);
                }else if(isset($_GET['mespost'])){
                    $mes=$_GET['mespost']+1;
                    $anio=$_GET['anio'];
                    if($mes==13){
                        $anio++;
                        $mes=1;
                    }
                    $n_mes=nom_mes($mes);
                    echo calendario($mes,$n_mes,$anio);
                }else{
                    $mes=date("n");
                    $anio=date("Y");
                    $nombre_mes=nom_mes($mes);
                    echo calendario($mes,$nombre_mes,$anio);
                }
                
                if($usu==='a'){
                    echo "<div class='buscarinser'>";
                    echo form_buscar('cita');
                    echo btn_inser('insercita.php','CITA');
                    echo "</div>";

                    if(isset($_GET['cancelcita'])){
                        $socio=$_GET['cancelcita'];
                        $fecha=$_GET['fecha'];
                        $hora=$_GET['hora'];
            
                        $cancelarcita=$conexion->prepare("delete from citas where socio=? and fecha=? and hora=?");
                        $cancelarcita->bind_param("iss",$socio,$fecha,$hora);
                        $cancelarcita->execute();
                        $cancelarcita->close();
            
                        echo "<p>Cita cancelada correctamente</p>";
                    }
                    
                }
                if(isset($_GET["busqueda"])){
                    echo btn_volver('citas.php','volver');
                    $param=$_GET['buscar'];
                    // Esta comprobacion se utiliza para comprobar si se introduce una fecha, y, en el caso de que así sea, darle formato inglés, ya que en la base de datos se
                    // guarda con el formato inglés, pero el usuario introduce el formato español
                    $comprobacion="`^[0-9]{2}(/|-)[0-9]{2}(/|-)[0-9]{4}$`";
                    if(preg_match($comprobacion,$param)){
                        $dia=substr($param,0,2);
                        $mes=substr($param,3,2);
                        $anio=substr($param,6,4);
                        $param="$anio-$mes-$dia";
                    }else{
                        $param="%$_GET[buscar]%";
                    }
                    if($usu==='a'){
                        $busqueda=$conexion->prepare("select socio,usuario,telefono,descripcion,fecha,hora from socio s, servicio sv, citas c where c.socio=s.id and c.servicio=sv.id and (nombre like ? or descripcion like ? or fecha = ?)");
                        $busqueda->bind_result($id,$usuario,$tlf,$serv,$fecha,$hora);
                        $busqueda->bind_param("sss",$param,$param,$param);
                    }else{
                        $busqueda=$conexion->prepare("select telefono,descripcion,fecha,hora from socio s, servicio sv, citas c where c.socio=s.id and c.servicio=sv.id and usuario=? (nombre like ? or descripcion like ? or fecha = ?)");
                        $busqueda->bind_result($tlf,$serv,$fecha,$hora);
                        $busqueda->bind_param("ssss",$nom,$param,$param,$param);
                    }
                    $busqueda->execute();
                    $busqueda->store_result();
                    if($busqueda->affected_rows>0){
                        $info_bus="<table class='tablaprodserv'><thead><th>Socio</th><th>Telefono</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th></th></thead><tbody>";
                        while($busqueda->fetch()){
                            // Esta función cambia el formato de la fecha del inglés al español
                            $fechaconvertida=convertir_fecha($fecha);
                            $info_bus.="<tr>";
                            if($usu==='a'){
                                $info_bus.="<td>$usuario</td>";
                            }else{
                                $info_bus.="<td>$nom</td>";
                            }
                            $info_bus.="<td>$tlf</td>";
                            $info_bus.="<td>$serv</td>";
                            $info_bus.="<td>$fechaconvertida</td>";
                            $info_bus.="<td>$hora</td>";
                            if($usu==='a'){
                                // Esta función comprueba si la cita esta programada para un día futuro y solo entonces imprime el boton para cancelarla
                                if(borrar_cita($fecha)){
                                    $info_bus.="<td><a method='get' href='citas.php?cancelcita=$id&fecha=$fecha&hora=$hora'>Cancelar</a></td>";
                                }else{
                                    $info_bus.="<td></td>";
                                }
                            }
                            $info_bus.="</tr></tbody>";
                        }
                        $info_bus.="</table>";
        
                        echo $info_bus;
                    }else{
                        echo "<p>No hay datos que coincidan con tu busqueda</p>";
                    }
                    $busqueda->close();
                }else{
                    // Si se ha cambiado de mes, se muestran las citas de ese mes, sino, se coge la fecha actual y se muestran las citas del mes actual
                    if(isset($_GET['mes'])){
                        echo btn_volver('citas.php','volver');
                        $anio=$_GET['anio'];
                        $mes=$_GET['mes'];
                        $dia=$_GET['dia'];
                        if($usu==='a'){
                            $consulta="select * from citas where fecha='".$anio."-".$mes."-".$dia."' order by hora asc";
                        }else{
                            $consulta="select usuario,servicio,fecha,hora from citas,socio s where socio=s.id and socio=(select id from socio where usuario='".$nom."') and fecha='".$anio."-".$mes."-".$dia."' order by hora asc";
                        }
                        $seleccionado=$conexion->query($consulta);
                        
                        echo tabla_citas($seleccionado,$usu);
                    }else{
                        $hoy=date("Y-m-d",time());
                        $fmin=$anio."-".$mes."-01";
                        $fmax=$anio."-".$mes."-31";
                        $dia=substr($hoy,8,2);
                        if($usu==='a'){
                            $citas=$conexion->query("select * from citas where fecha='".$anio."-".$mes."-".$dia."' order by hora asc");
                        }else{
                            $citas=$conexion->query("select usuario,servicio,fecha,hora from citas,socio s where socio=s.id and socio=(select id from socio where usuario='".$nom."') and fecha='".$anio."-".$mes."-".$dia."' order by hora asc");
                        }
                        if($citas->num_rows==0){
                            $infocitas="<p class='mnsmod'>No hay citas para hoy</p>";
                        }else{
                            $infocitas=tabla_citas($citas,$usu);
                        }
                        echo $infocitas;
                    }
                }
                echo "</main>";
                $conexion->close();
        
                echo imprimir_footer();
            
        }else{
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=../index.php'>";
        }
        
    ?>
</body>
</html>