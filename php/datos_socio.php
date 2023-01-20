<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <title>Mis Datos</title>
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
        }

        if($usu==='s'){
            $conexion=conectarservidor();
            $nom=$_SESSION['usuario'];
            $cabecera=imprimir_menu($usu,$nom);
            echo $cabecera;
            echo "<h1>Datos Personales</h1>";
            $datossocio=$conexion->prepare("select nombre,edad,telefono,foto from socio where usuario=?");
            $datossocio->bind_param("s",$nom);
            $datossocio->bind_result($nombre,$edad,$telefono,$foto);
            $datossocio->execute();
            $datossocio->store_result();
            while($datossocio->fetch()){
                echo "<article class='datossocio'>
                    <div class='fila1'>
                        <img src=$foto>
                    </div>
                    <div class='centrar'>
                        <div class='columna1'>
                            <div>
                                <p>Nombre: $nombre</p>
                            </div>
                            <div>
                                <p>Usuario: $nom</p>
                            </div>
                        </div>
                        <div class='columna2'>
                            <div>
                                <p>Edad: $edad</p>
                            </div>
                            <div>
                                <p>Contraseña: *********</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Telefono: $telefono</p>
                    </div>
                </article>";
            }

            echo "<div class='moddatos'>
            <a href='mod_socio.php'>EDITAR DATOS</a>
            </div>";
            $conexion->close();
        }else if($usu==='a'){
            echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
        }else{
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=formacceso.php'>";
        }
    ?>
</body>
</html>