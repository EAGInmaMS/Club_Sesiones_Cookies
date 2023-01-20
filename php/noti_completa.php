<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Noticia</title>
</head>
<body>
    <?php
        require_once("funciones.php");
        echo imprimir_menu();
        echo "<main>";
        echo btn_volver('noticias.php','volverinser');
        echo "<article id='noticompleta'>";
        if(isset($_GET['completa'])){
            $id_noti=$_GET['completa'];
            $conexion=conectarservidor();
            $noticia=id_editar('noticia',$id_noti);
            while($noti=$noticia->fetch_array(MYSQLI_ASSOC)){
                echo "<h1>$noti[Titulo]</h1>";
                echo "<img src=\"$noti[Imagen]\">";
                echo "<div id='fechnoti'>";
                $fecha=convertir_fecha($noti['Fecha_publicacion']);
                echo "<pre>$fecha</pre>";
                echo "</div>";
                echo "<div id='completa'>";
                echo "<p>$noti[Contenido]</p>";
                echo "</div>";

            }
        }else{
            echo "<p>La noticia no está disponible</p>";
        }

        echo "</article></main>";
        echo imprimir_footer();

        
    ?>
</body>
</html>