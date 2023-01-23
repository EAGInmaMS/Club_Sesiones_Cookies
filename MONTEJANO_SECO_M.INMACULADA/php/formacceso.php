<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Acceder</title>
</head>
<body>
    <?php
        require_once("funciones.php");
        $conexion=conectarservidor();
        echo imprimir_menu('n','');
        if(isset($_GET['cerrar'])){
            session_start();
            if(isset($_COOKIE['sesion'])){
                setcookie("sesion",null,-444444,'/');
                session_destroy();
            }else if(isset($_SESSION['tipo'])){
                session_destroy();
            }
            
            echo "<p class='mnsmod'>Cerrando Sesión</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=formacceso.php'>";

        }else{
            echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
                <div class='fila1'>
                    <label for='usuario'>Usuario:</label>
                    <input name='usuario' type='text'>
                </div>
                <div class='fila1'>
                    <label for='pass'>Contraseña:</label>
                    <input name='pass' type='password'>
                </div>
                <div>
                    <input class='check' name='mantener' type='checkbox'>Mantener la sesión iniciada
                </div>
                <input name='enviar' type='submit'>
            </form>";
            echo imprimir_footer();

            if(isset($_POST['enviar'])){
                $nomusu=$_POST['usuario'];
                $nomusu=mb_strtolower($nomusu, 'UTF-8');
                $contraseña=$_POST['pass'];
                $buscarus=$conexion->prepare("select pass from socio where usuario=?");
                $buscarus->bind_result($contra);
                $buscarus->bind_param("s",$nomusu);
                $buscarus->execute();
                $buscarus->store_result();
                if($buscarus->affected_rows>0){
                    $contraseña=md5(md5($contraseña));
                    while($buscarus->fetch()){
                        if($contraseña===$contra){
                            session_start();
                            $_SESSION['usuario']=$nomusu;
                            if($nomusu==='admin'){
                                $_SESSION['tipo']='a';
                                $_SESSION['usuario']='Administrador';
                            }else{
                                $_SESSION['tipo']='s';
                            }
                            
                            if(isset($_POST['mantener'])){
                                $datos=session_encode();
                                setcookie("sesion",$datos,strtotime('+3days'),'/');
                            }
                            echo "<p class='mnsmod'>¡Bienvenido!</p>";
                            echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=../index.php'>";
                        }else{
                            echo "<p class='mnsmod'>Contraseña incorrecta</p>";
                        }
                    }
                    
                }else{
                    echo "<p class='mnsmod'>Usuario no existente</p>";
                }
                $buscarus->close();

            }
        }
        

        $conexion->close();
    ?>
</body>
</html>