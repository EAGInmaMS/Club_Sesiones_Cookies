<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Insertar socio</title>
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
        $cabecera=imprimir_menu($usu,$nom);
        echo $cabecera;
        echo "<h1>INSERTAR SOCIO</h1>";
        echo btn_volver('socios.php','volverinser');
        $num=obtener_id("'socio'");
        echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
            <div class='fila1'>
                <label for='idsocio'>ID:</label>
                <input name='idsocio' value=$num disabled type='number'>
            </div>
            <div class='centrar'>
            <div class='columna1'>
                <div>
                    <label for='nom'>Nombre:</label>
                    <input name='nom' type='text'>
                </div>
                <div>
                    <label for='usu'>Usuario:</label>
                    <input name='usu' type='text'>
                </div>
                <div>
                    <label for='telf'>Telefono</label>
                    <input name='telf' type='text'>
                </div>
            </div>
            <div class='columna2'>
                <div>
                    <label for='edad'>Edad:</label>
                    <input name='edad' type='number'>
                </div>
                <div>
                    <label for='contraseña'>Contraseña:</label>
                    <input name='contraseña' type='password'>
                </div>
                <div>
                    <label for='foto'>Foto:</label>
                    <input name='foto' type='file'>
                </div>
            </div>
            </div>
            <input name='enviar' type='submit'>
        </form>";

        if(isset($_POST["enviar"])){
            $usuario=$_POST["usu"];
            $usuario=mb_strtolower($usuario, 'UTF-8');
            $nombre=$_POST["nom"];
            $edad=$_POST["edad"];
            $buscarusu=$conexion->prepare("select usuario from socio where usuario=?");
            $buscarusu->bind_result($nomusu);
            $buscarusu->bind_param("s",$usuario);
            $buscarusu->execute();
            $buscarusu->store_result();
            $contraseña=$_POST["contraseña"];
            if($usuario==='' || $contraseña==='' || $nombre==='' || $edad===''){
                echo "<p class='mnsmod'>Faltan datos</p>";
            }else if($buscarusu->affected_rows>0){
                echo "<p class='mnsmod'>Usuario ya existente</p>";
                $buscarusu->close();
            }else{
                $buscarusu->close();
                $comprobacion="`^(6|7)[0-9]{8}$`";
                $telefono=$_POST["telf"];
                if(preg_match($comprobacion,$telefono)|| $telefono===''){
                    $id="";
                    $passcodi=md5(md5($contraseña));
                    $formato=($_FILES['foto']['type']);
                    $imgvali=true;
                    if($formato===''){
                        $ruta='';
                    }else{
                        if(comprobar_img($formato)){
                            $nomfoto=$_FILES['foto']['name'];
                            $temp=$_FILES['foto']['tmp_name'];
                            $ruta="../img/$nomfoto";
                            move_uploaded_file($temp,$ruta);
                        }else{
                            $imgvali=false;
                            $inser="<p class='mnsmod'>Foto no válida</p>";
                        }
                    }
                    if($imgvali){
                        $inser=$conexion->prepare("insert into socio values(?,?,?,?,?,?,?)");
                        $inser->bind_param("isissss",$id,$nombre,$edad,$_POST['usu'],$passcodi,$telefono,$ruta);
                        $inser->execute();
                        $inser->close();
                        $inser="<p class='mnsmod'>Datos insertados correctamente</p>";
                        echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=socios.php'>";
                    }
                    
                    echo $inser;
                }else{
                    echo "<p class='mnsmod'>Teléfono no válido</p>"; 
                }
            }
            
        }

        $conexion->close();
    }else{
        echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
    }
    
    ?>
</body>
</html>