<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        function conectarservidor(){
            $conexion= new mysqli('localhost','root','','club');
            $conexion->set_charset("utf8");
    
            return $conexion;
        }

        function imprimir_menu($u,$n){
            if($u==='n'){
                $cabecera="<header>
                    <nav>
                        <a href='../index.php'><img src='../img/NUEVO_LOGO_verde_180x.avif'></a>
                        <a href='Productos.php'>Productos</a>
                        <a href='servicios.php'>Servicios</a>
                        <a href='formacceso.php'>Acceder</a>
                    </nav>
                </header>";
            }else{
                $cabecera="<header>
                    <nav>
                        <a href='../index.php'><img src='../img/NUEVO_LOGO_verde_180x.avif'></a>";
                        if($u==='s'){
                            $cabecera.="<a href='datos_socio.php'>Mis Datos Personales</a>";
                        }else{
                            $cabecera.="<a href='socios.php'>Socios</a>";
                        }
                        $cabecera.="<a href='Productos.php'>Productos</a>
                        <a href='servicios.php'>Servicios</a>";
                        if($u==='s'){
                            $cabecera.="<a href='citas.php'>Mis Citas</a>";
                        }else{
                            $cabecera.="<a href='citas.php'>Citas</a>
                                        <a href='noticias.php'>Noticias</a>
                                        <a href='testimonios.php'>Testimonios</a>";
                        }
                        $cabecera.="<a href='formacceso.php?cerrar=s'>Cerrar Sesion de $n</a>
                    </nav>
                </header>";
            }
        return $cabecera;
        }

        function imprimir_menu_home($u,$n){
            if($u==='n'){
                $cabecera="<header>
                    <nav>
                        <a href='index.php'><img src='img/NUEVO_LOGO_verde_180x.avif'></a>
                        <a href='php/Productos.php'>Productos</a>
                        <a href='php/servicios.php'>Servicios</a>
                        <a href='php/formacceso.php'>Acceder</a>
                    </nav>
                </header>";
            }else{
                $cabecera="<header>
                    <nav>
                        <a href='index.php'><img src='img/NUEVO_LOGO_verde_180x.avif'></a>";
                        if($u==='s'){
                            $cabecera.="<a href='php/datos_socio.php'>Mis Datos Personales</a>";
                        }else{
                            $cabecera.="<a href='php/socios.php'>Socios</a>";
                        }
                        $cabecera.="<a href='php/Productos.php'>Productos</a>
                        <a href='php/servicios.php'>Servicios</a>";
                        if($u==='s'){
                            $cabecera.="<a href='php/citas.php'>Mis Citas</a>";
                        }else{
                            $cabecera.="<a href='php/citas.php'>Citas</a>
                                        <a href='php/noticias.php'>Noticias</a>
                                        <a href='php/testimonios.php'>Testimonios</a>";
                        }
                        $cabecera.="<a href='php/formacceso.php?cerrar=s'>Cerrar Sesion de $n</a>
                    </nav>
                </header>";
            }
        return $cabecera;
        }

        function imprimir_footer(){
            $pie="<footer>
            <p>© Copyright 2022, Todos los derechos reservados</p>
            <i class='fa-brands fa-twitter'></i>
            <i class='fa-brands fa-facebook-f'></i>
            <a href=''>Aviso Legal</a>
            <a href=''>Politica De Privacidad</a>
            <a href=''>Politica de Cookies</a>
            </footer>";

            return $pie;
        }

        function comprobar_sesion($t){
            if($t==='c'){
                session_decode($_COOKIE['sesion']);
            }
                $usu=$_SESSION['tipo'];
                $nom=$_SESSION['usuario'];
            return [$usu,$nom];
        }

        function consultar_datos($tabla){
            $conex=conectarservidor();
            $consulta="select * from ".$tabla;
            if($tabla==='producto'){
                $consulta.=" order by nombre asc";
            }else if($tabla==='servicio'){
                $consulta.=" order by descripcion asc";
            }
            $datos=$conex->query($consulta);
            $info;
            if($datos->num_rows==0){
                $info="no hay datos que coincidan con su consulta";
            }else{
                $info=$datos;
            }

            return $info;

            $conex->close();
        }

        function btn_inser($ruta,$nom){
            $enlace="<a href=$ruta>INSERTAR $nom</a>";

            return $enlace;
        }

        function form_buscar($page){
            $formu="<form method='get' action='#' id='fbuscar'>
                        <input name='buscar' type='text' placeholder='Buscar $page'>
                        <input name='busqueda' type='submit'>
                    </form>";
            return $formu;
        }

        function btn_volver($link,$id){
            $volver="<div id='$id'><a href='$link'>VOLVER</a></div>";

            return $volver;
        }

        function comprobar_img($tipo){
            $imagen=false;
            $tipo=strtok($tipo,"/");
            if($tipo==="image"){
                $imagen=true;
                if(!file_exists("../img")){
                    mkdir("../img");
                }
            }
            return $imagen;
        }

        function obtener_id($tabla){
            $conex=conectarservidor();
            $consulta="select auto_increment as id from information_schema.tables where table_schema='club' and table_name=$tabla";
            $datos=$conex->query($consulta);
            while($fila=$datos->fetch_array(MYSQLI_ASSOC)){
                $num=$fila['id'];
            }

            return $num;

            $conex->close();
        }

        // Esta funcion se utiliza para sacar los datos de una determinada fila para los formularios de modificar datos
        function id_editar($tabla,$id){
            $conex=conectarservidor();
            $consulta="select * from $tabla where id=$id";
            $datos=$conex->query($consulta);

            return $datos;

            $conex->close();
        }

        function calendario($mes,$nombre,$anio){
            if($mes<1 || $mes>12){
                $calendario="<p>Fecha Incorrecta</p>";
            }else{
                $conex=conectarservidor();
                // variables para sacar el dia de la semana en el que empieza el mes
                $p_dia=mktime(0,0,0,$mes,1,$anio);
                $p_dia=strftime("%u",$p_dia);
                // Los días del mes totales según el mes
                $dias_mes=[31,28,31,30,31,30,31,31,30,31,30,31];
                // Saco los días de ese mes que tienen alguna cita programada
                $fmin=$anio."-".$mes."-01";
                $fmax=$anio."-".$mes."-31";
                $consulta="select * from citas where fecha>='".$fmin."' and fecha<='".$fmax."'";
                $diascita=$conex->query($consulta);
                // Y los meto en un array para que luego, cuando salgan por pantalla, el fondo sea de un color diferente
                while($fila=$diascita->fetch_array(MYSQLI_ASSOC)){
                    $dias[]=substr($fila['fecha'],-2);
                }
                $calendario="<table id='calendario'><thead><th><a method='get' href=\"citas.php?mesant=$mes&anio=$anio\"><<</a></th><th colspan='5'>$nombre de $anio</th><th><a method='get' href=\"citas.php?mespost=$mes&anio=$anio\">>></a></th></thead>";
                $calendario.="<tbody><tr><td>Lunes</td><td>Martes</td><td>Miercoles</td><td>Jueves</td><td>Viernes</td><td>Sabado</td><td>Domingo</td></tr><tr>";
                // Contador que controla el número de día de la semana
                $contador=1;
                // Bucle para las celdas de la primera semana del mes que tienen que estar vacías
                while($contador<$p_dia){
                    $calendario.="<td></td>";
                    $contador++;
                }
                // Bucle para imprimir los días del mes
                for($i=1;$i<=$dias_mes[$mes-1];$i++){
                    // If para empezar una nueva fila si se ha llegado a 7 (domingo)
                    if($contador%7==0){
                        // si la consulta no ha devuelto ninguna fila, significa que ese mes no hay cita, por lo que se imprimen los días normales
                        if($diascita->num_rows==0){
                            $calendario.="<td>$i</td></tr><tr>";
                        // Pero si hay resultados, hay que comprobar si ese día hay cita, por lo que comprobamos si el numero de dia del mes esta en el array y, si es así, le agregamos una clase
                        // para ponerle otros estilos en el css
                        }else{
                            if(in_array($i,$dias)){
                                $calendario.="<td class='cita'><a method='get' href=\"citas.php?anio=$anio&mes=$mes&dia=$i\">$i</a></td></tr><tr>";
                            }else{
                                $calendario.="<td>$i</td></tr><tr>";
                            }
                        }
                        $contador=1;
                    }else{
                        if($diascita->num_rows==0){
                            $calendario.="<td>$i</td>";
                        }else{
                            if(in_array($i,$dias)){
                                $calendario.="<td class='cita'><a method='get' href=\"citas.php?anio=$anio&mes=$mes&dia=$i\">$i</a></td>";
                            }else{
                                $calendario.="<td>$i</td>";
                            }
                        }
                        $contador++;
                    }
                }
                $calendario.="</tbody>";
                $calendario.="</table>";
                $conex->close();
            }

            return $calendario;
        }

        function nom_mes($mes){
            if($mes>=1 && $mes<=12){
                $noms_mes=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                $nom=$noms_mes[$mes-1];

                return $nom;
            }
        }

        // Comprueba si una cita es futura, para ver si se puede cancelar o no
        function borrar_cita($fecha){
            $factual=strftime("%Y-%m-%d",time());
            if($fecha>$factual){
                $borrar=true;
            }else{
                $borrar=false;
            }

            return $borrar;
        }

        // Función para cambiar el formato de una fecha del inglés al español
        function convertir_fecha($fecha){
            $dia=substr($fecha,-2);
            $mes=substr($fecha,5,2);
            $anio=substr($fecha,0,4);
            $fechac=$dia."-".$mes."-".$anio;

            return $fechac;

        }

        function tabla_citas($resultado_consulta,$usu){
            $conexion=conectarservidor();
            $tabla="<table class='tablaprodserv'><thead><th>Socio</th><th>Telefono</th><th>Servicio</th><th>Fecha</th><th>Hora</th>";
            if($usu==='a'){
                $tabla.="<th></th>";
            }
            $tabla.="</thead><tbody>";
                while($cita=$resultado_consulta->fetch_array(MYSQLI_ASSOC)){
                    if($usu==='a'){
                        $soci=$cita['socio'];
                    }else{
                        $soci=$cita['usuario'];
                    }
                    $servi=$cita['servicio'];
                    if($usu==='a'){
                        $consul="select usuario,telefono,descripcion from socio s,servicio sv where s.id=".$soci." and sv.id=".$servi;
                    }else{
                        $consul="select telefono,descripcion from socio s,servicio sv where s.usuario='".$soci."' and sv.id=".$servi;
                    }
                    $datos_soci_servs=$conexion->query($consul);
                    while($datos=$datos_soci_servs->fetch_array(MYSQLI_ASSOC)){
                        if($usu==='a'){
                            $tabla.="<tr><td>$datos[usuario]</td>";
                        }else{
                            $tabla.="<tr><td>$soci</td>";
                        }
                        $tabla.="<td>$datos[telefono]</td>";
                        $tabla.="<td>$datos[descripcion]</td>";
                    }
                    $fechaconvertida=convertir_fecha($cita['fecha']);
                    $tabla.="<td>$fechaconvertida</td>";
                    $tabla.="<td>$cita[hora]</td>";
                    if($usu=='a'){
                        if(borrar_cita($cita['fecha'])){
                            $tabla.="<td><a method='get' href='citas.php?cancelcita=$soci&fecha=$cita[fecha]&hora=$cita[hora]'>Cancelar</a></td>";
                        }else{
                            $tabla.="<td></td>";
                        }
                    }

                    $tabla.="</tr></tbody>";
                }

                $tabla.="</table>";

                return $tabla;
        }
    ?>
</body>
</html>