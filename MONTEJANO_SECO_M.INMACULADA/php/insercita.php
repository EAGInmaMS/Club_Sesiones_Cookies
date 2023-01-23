<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php
    require_once("funciones.php");
    session_start();
    if(isset($_COOKIE['sesion'])){
        list($usu,$nom)=comprobar_sesion('c');
    }else if(isset($_SESSION['tipo'])){
        list($usu,$nom)=comprobar_sesion('s');
    }else{
        $usu='n';
        echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
    }
    if($usu==='a'){
        $conexion=conectarservidor();
        echo imprimir_menu('a','Administrador');
        echo "<h1>CREAR CITA</h1>";
        echo btn_volver('citas.php','volverinser');
        $socios=consultar_datos('socio');
        $servicios=consultar_datos('servicio');
        echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
            <div class='centrar'>
                <div class='columna1'>
                    <div>
                        <label for='sociocita'>Socio:</label>
                        <select name='sociocita' for='sociocita'>";
                        while($opt=$socios->fetch_array(MYSQLI_ASSOC)){
                            if($opt['Id']>0){
                                echo "<option value=$opt[Id]>$opt[Nombre]</option>";
                            }
                        }
                        echo "</select>
                    </div>
                    <div>
                        <label for='fechacita'>Fecha:</label>
                        <input type='date' name='fechacita'>
                    </div>
                </div>
                <div class='columna2'>
                    <div>
                        <label for='servcita'>Servicio:</label>
                        <select name='servcita' for='servcita'>";
                        while($opcion=$servicios->fetch_array(MYSQLI_ASSOC)){
                            echo "<option value=$opcion[Id]>$opcion[Descripcion]</option>";
                        }
                        echo "</select>
                    </div>
                    <div>
                        <label for='horacita'>Hora:</label>
                        <input type='time' name='horacita'>
                    </div>
                </div>
            </div>
            <input type='submit' name='insercita'>
        </form>";

        if(isset($_POST['insercita'])){
            $socio=$_POST['sociocita'];
            $servicio=$_POST['servcita'];
            $fecha=$_POST['fechacita'];
            $hora=$_POST['horacita'];
            $comprobacion=$conexion->prepare("select * from citas where socio=? and fecha=? and hora=?");
            $comprobacion->bind_result($so,$se,$fe,$ho);
            $comprobacion->bind_param("iss",$socio,$fecha,$hora);
            $comprobacion->execute();
            $comprobacion->store_result();
            if($comprobacion->num_rows>0){
                echo "<p class='mnsmod'>Cita ya programada</p>";
            }else{
                $insertcita=$conexion->prepare("insert into citas values(?,?,?,?)");
                $insertcita->bind_param("iiss",$socio,$servicio,$fecha,$hora);
                $insertcita->execute();
                $insertcita->close();
                echo "<p class='mnsmod'>Datos insertados correctamente</p>";
                echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=citas.php'>";
            }
        }
    }else if($usu==='s'){
        echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
    }
        
        
    ?>
</body>
</html>