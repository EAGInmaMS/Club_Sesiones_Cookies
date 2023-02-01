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
    <title>NOTICIAS</title>
</head>
<body id='bodynoti'>
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
            header('Content-Type:application/json');
            header("Acces-Control-Allow-Origin: *");
            $conexion=conectarservidor();
            $datos=[];
            echo imprimir_menu($usu,$nom);
            echo "<main id='mainnoti'>";
            echo "<h1>NOTICIAS</h1>";
            echo "<div class='inser'>";
            echo btn_inser('inser_noti.php','NOTICIA');
            echo "</div>";

            // Primero establecemos el número de noticias que va a aparecer por página
            sleep(1);
            $notispag=4;
            $limite=$_GET["limite"] ?? $notispag=4;;
            $offset=$_GET["offset"] ?? 0;

            $totalpags=$conexion->query("select count(*) as conteo from noticia");
            // Y sacamos el número de noticias que hay en la base de datos
            while($num=$totalpags->fetch_array(MYSQLI_ASSOC)){
                $numnotis=$num['conteo'];
            }
            if($numnotis==0){
                echo "<p>No hay ninguna noticia</p>";
            }else{
                // Redondeamos para que salga el numero de páginas que van a aparecer
                $info=$conexion->prepare("select * from noticia order by fecha_publicacion desc limit $offset, $limite");
                $info->execute();
                $resultado=$info->get_result();
                echo "<div id='contenidonoti'>";
                echo "<section id='contnoticias'>";
                while($fila=$resultado->fetch_assoc()){
                        $datos[]=$fila;
                }
                
                $patron_url=explode("?",$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])[0];

                echo "</section> </div>";

                echo "<a id='antes' href=''>ANTERIOR</a>";
                echo "<a id='posterior' href=''>SIGUIENTE</a>";
                echo"</main>";

                $nuevo_offset=$offset+$limite;
                if($nuevo_offset<$numnotis){
                    $sig_offset=$nuevo_offset;
                    if($nuevo_offset$limite>$numnotis){
                        $sig_limite=$numnotis-$nuevo_offset;
                    }else{
                        $sig_limite=$limite;
                    }
                }
                echo imprimir_footer();
        }else if($usu==='s'){
            echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
        }
        
        
        ?>
        
    
</body>
</html>