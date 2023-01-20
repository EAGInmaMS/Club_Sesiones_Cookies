<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <title>Fuertafit</title>
</head>
<body>
    <?php
        require_once("php/funciones.php");
        session_start();
        if(isset($_COOKIE['sesion'])){
            list($usu,$nom)=comprobar_sesion('c');
        }elseif(isset($_SESSION['tipo'])){
            list($usu,$nom)=comprobar_sesion('s');
        }else{
            $usu='n';
            $nom='';
        }
        $cabecera=imprimir_menu_home($usu,$nom);
        $conexion=conectarservidor();
        echo $cabecera;
        echo "<div id='imgcabe'>
                <div id='contenidocabe'>
                    <h1>CONSIGUE TU MEJOR VERSIÓN</h1>
                    <p>Adoptamos los planes de entrenamiento a cada objetivo y persona</p>
                    <p>El gimnasio que quieres, el que tú quieres</p>
                </div>
            </div>";
        echo "<section id='ultimahora'>";
        echo "<h2>Últimas noticias</h2>";
        echo "<div>";
        $hoy=date("Y-m-d",time());
        $consulta="select id,contenido,imagen,titulo from noticia where fecha_publicacion<='$hoy' order by fecha_publicacion desc limit 3";
        $noticias=$conexion->query($consulta);
        if($noticias->num_rows==0){
            echo "<p class='mnsmod'>Aún no hay noticias publicadas</p>";
        }else{
            while($noti=$noticias->fetch_array(MYSQLI_ASSOC)){
                echo "<article>";
                $contenido=substr($noti['contenido'],0,50);
                $imagen=str_replace("../","",$noti['imagen']);
                $id=$noti['id'];
                echo "<img src=\"$imagen\">";
                echo "<h3>$noti[titulo]</h3>";
                echo "<p>$contenido</p>";
                echo "<a method='get' href='php/noti_completa.php?completa=$id'>VER MÁS</a>";
                echo "</article>";
            }
        }
        echo "</div>";
        echo "</section>";
        echo "<section id='newprod'>
            <div>
                <h2>¡PRUEBA NUESTRO NUEVO PRODUCTO!</h2>
                <p>¡No te quedes sin probar el nuevo producto de GFUEL disponible en nuestro club!</p>
                <p>¡El precio te sorprendera!</p>
                <a href='html/landing.html'>SABER MÁS</a>
                </div>
            </section>";
        echo "<section id='testimonios'>";
        echo "<h2>TESTIMONIOS DE NUESTROS USUARIOS</h2>";
        echo "<div>";
        $consulta="select * from testimonio order by rand() limit 1";
        $testi_ale=$conexion->query($consulta);
        if($testi_ale->num_rows==0){
            echo "<p id='notesti'>Aun no hay testimonios</p>";
        }else{
            while($testimonio=$testi_ale->fetch_array(MYSQLI_NUM)){
                $autor=$testimonio[1];
                $consulta="select nombre from socio where id=".$autor;
                $nombre_socio=$conexion->query($consulta);
                while($nom=$nombre_socio->fetch_array(MYSQLI_ASSOC)){
                    echo "<p id='nomsocio'>$nom[nombre]</p>";
                }
                echo "<p>$testimonio[2]</p>";
            };
            echo "</div>";
        }
        echo "</section>";
        echo "<section id='contacto'>";
        echo "<h2>Solicitar Información</h2>";
        echo "<form>
            <div class='fila'>
            <input name='nom' type='text' placeholder='Nombre' required>
            <input name='ape' type='text' placeholder='Apellidos'>
            </div>
            <div class='fila'>
            <input name='mail' type='email' placeholder='Email' required>
            <input name='tlf' type='number' placeholder='Teléfono'>
            </div>
            <div class='mensaje'>
            <textarea name='mnsj' cols=30 rows=15 placeholder='Consulta' required></textarea>
            </div>
            <div id='condiciones'>
            <input type='checkbox'> Acepto las condiciones de uso y politicas de privacidad
            </div>
            <input type='submit' name='consulta'>
        </form>";
        echo"</section>";

        $pie=imprimir_footer();
        echo $pie;
    ?> 
</body>
</html>