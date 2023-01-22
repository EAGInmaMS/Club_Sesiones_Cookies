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
    <title>INSERTAR TESTIMONIO</title>
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
            echo imprimir_menu($usu,$nom);
            echo "<h1>INSERTAR TESTIMONIO</h1>";
            echo btn_volver('testimonios.php','volverinser');
            $num=obtener_id("'testimonio'");
            $socio=consultar_datos("socio");
            echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
                    <div class='fila1'>
                        <label for='idtesti'>ID:</label>
                        <input name='idtesti' value=$num disabled type='number'>
                    </div>
                    <div id='autorfecha'>
                        <div>
                            <label for='autortesti'>Autor:</label>
                            <select name='autortesti' for='autortesti'>";
                                while($opt=$socio->fetch_array(MYSQLI_ASSOC)){
                                    if($opt['Id']>0){
                                        echo "<option value=$opt[Id]>$opt[Nombre]</option>";
                                    }
                                }
                            echo "</select>
                        </div>
                    </div>
                    <div class='mensaje'>
                        <textarea name='contentesti' id='contenidotestimonio' cols='30' row='10' placeholder='Escribe aquí tu testimonio'></textarea>
                    </div>
                    <input type='submit' name='insertesti'>
                </form>";

                if(isset($_POST['insertesti'])){
                    $id='';
                    $autor=$_POST['autortesti'];
                    $contenido=$_POST['contentesti'];
                    $fecha=date('Y-m-d',time());
                    // No dejo que gaurden testimonios con una fecha futura porque no tendría mucho sentido
                        $inser=$conexion->prepare("insert into testimonio values(?,?,?,?)");
                        $inser->bind_param("iiss",$id,$autor,$contenido,$fecha);
                        $inser->execute();
                        $inser->close();
                        $inser="<p class='mnsmod'>Datos insertados correctamente</p>";
            
                    echo $inser;
                    echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=testimonios.php'>";
                }

                $conexion->close();
        }
        
    ?>
</body>
</html>