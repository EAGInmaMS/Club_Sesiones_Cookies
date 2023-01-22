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
    <title>Testimonios</title>
</head>
<body id='bodytesti'>
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
            echo imprimir_menu($usu,$nom);
            $conexion=conectarservidor();
            echo "<main id='maintesti'>";
            echo "<h1>TESTIMONIOS DE NUESTROS CLIENTES</h1>";
            echo "<div class='inser'>";
            echo btn_inser('inser_test.php','TESTIMONIO');
            echo "</div>";
            
            $consulta="select * from testimonio order by fecha desc";
            $datos_consul=$conexion->query($consulta);
            if($datos_consul->num_rows==0){
                echo "<p>No hay datos que coincidan con su consulta</p>";
            }else{
                $info=$datos_consul;
                $info_test="<section id='datostesti'>";
                while($cont=$info->fetch_array(MYSQLI_ASSOC)){
                    $info_test.="<article>";
                    $info_test.="<div id='autorfecha'>";
                    $autor=$cont['Autor'];
                    $consulta="select nombre from socio where id=".$autor;
                    $nombre_socio=$conexion->query($consulta);
                    while($nom=$nombre_socio->fetch_array(MYSQLI_ASSOC)){
                        $info_test.="<p>$nom[nombre]</p>";
                    }
                    $fechac=convertir_fecha($cont['Fecha']);
                    $info_test.="<p>$fechac</p>";
                    $info_test.="</div>";
                    $info_test.="<p>$cont[Contenido]</p>";

                    $info_test.="</article>";
                    
                }
                $info_test.="</section>";
                echo $info_test;
            }
            echo "</main>";
            $conexion->close();
            echo imprimir_footer();
        }else if($usu==='s'){
            echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
        }
        

    ?>
</body>
</html>