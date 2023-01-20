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
            $conexion=conectarservidor();
            echo imprimir_menu($usu,$nom);
            echo "<main id='mainnoti'>";
            echo "<h1>NOTICIAS</h1>";
            echo "<div class='inser'>";
            echo btn_inser('inser_noti.php','NOTICIA');
            echo "</div>";

            // Primero establecemos el número de noticias que va a aparecer por página
            $notispag=4;
            $pagina=1;
            if(isset($_GET["pagina"])){
                $pagina=$_GET["pagina"];
            }
            // Establecemos el limit y el offset para después realizar la consulta
            $limit=$notispag;
            $offset=($pagina-1)*$notispag;
            $totalpags=$conexion->query("select count(*) as conteo from noticia");
            // Y sacamos el número de noticias que hay en la base de datos
            while($num=$totalpags->fetch_array(MYSQLI_ASSOC)){
                $numnotis=$num['conteo'];
            }
            if($numnotis==0){
                echo "<p>No hay ninguna noticia</p>";
            }else{
                // Redondeamos para que salga el numero de páginas que van a aparecer
                $pags=ceil($numnotis/$notispag);
                $info=$conexion->prepare("select * from noticia order by fecha_publicacion desc limit ? offset ?");
                $info->bind_param("ii",$limit,$offset);
                $info->bind_result($id,$titulo,$contenido,$imagen,$fecha);
                $info->execute();
                echo "<div id='contenidonoti'>";
                echo "<section id='contnoticias'>";
                while($info->fetch()){
                        $contenido=substr($contenido,0,100);
                        echo "<article>";
                        echo "<img src=\"$imagen\">";
                        echo "<p>$titulo</p>";
                        $fechac=convertir_fecha($fecha);
                        echo "<p>$fechac</p>";
                        echo "<p>$contenido</p>";
                        echo "<a method='get' href='noti_completa.php?completa=$id'>VER MÁS</a>";

                        echo "</article>";
                }
                $info->close();
                echo "</section> </div>";

                echo "<div id='pagnoti'><p>Página $pagina de $pags</p></div>";

                echo "<ul class='listapags'>";
                for($x=1;$x<=$pags;$x++){
                    // Si la página es igual al valor de x le ponemos la clase 'active' al li para saber qué pagina estamos mostrando
                    if($x==$pagina){
                        echo "<li class='active'><a href='./noticias.php?pagina=$x'>$x</a></li>";
                    }else{
                        echo "<li><a href='./noticias.php?pagina=$x'>$x</a></li>";
                    }
                }
                echo "</ul>";
                }
                echo"</main>";
                echo imprimir_footer();
        }else{
            echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
        }
        
        
        ?>
        
    
</body>
</html>