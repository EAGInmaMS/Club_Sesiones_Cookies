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
    <title>Insertar Noticia Nueva</title>
</head>
<body>
    <?php
        if(isset($_COOKIE['sesion'])){
            require_once("funciones.php");
            list($usu,$nom)=comprobar_sesion();
            if($usu==='a'){
                $conexion=conectarservidor();
                echo imprimir_menu();
                echo "<h1>INSERTAR NOTICIA</h1>";
                echo btn_volver('noticias.php','volverinser');
                $num=obtener_id("'noticia'");
                echo "<form class='formsinsertmod' method='post' action='noticias.php' enctype='multipart/form-data'>
                    <div class='fila1'>
                    <label for='titulo'>Titulo de la noticia:</label>
                    <input name='titulo' type='text'>
                    </div>
                    <div class='fila1'>
                    <label for=imgnoti>Imagen de la noticia:</label>
                    <input name='imgnoti' type='file'>
                    </div>
                    <div class='fila1'>
                    <label for='fecha'>Fecha de publicacion:</label>
                    <input name='fecha' type='date'>
                    </div>
                    <div>
                    <textarea name='contenido' cols='45' rows='15' placeholder='Inserte aquí el contenido de la noticia'></textarea>
                    </div>
                    <input name='insernoti' type='submit'>
                </form>";

                if(isset($_POST['insernoti'])){
                    $formato=$_FILES['imgnoti']['type'];
                    if(comprobar_img($formato)){
                        $titulo=$_POST['titulo'];
                        $contenido=$_POST['contenido'];
                        $fecha_publi=$_POST['fecha'];
                        $nomfoto=$_FILES['imgnoti']['name'];
                        $temp=$_FILES['imgnoti']['tmp_name'];
                        $ruta="../img/$nomfoto";
                        move_uploaded_file($temp,$ruta);
                        $id='';
                        $insernoti=$conexion->prepare("insert into noticia values(?,?,?,?,?)");
                        $insernoti->bind_param("issss",$id,$titulo,$contenido,$ruta,$fecha_publi);
                        $insernoti->execute();
                        $insernoti->close();
                        echo "<p>datos insertados correctamente</p>";
                    }else{
                        echo "<p>imagen no válida</p>";
                    }
                }
            }else{
                echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=../index.php'>";
            }
            
        }else{
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='1;URL=../index.php'>";
        }
        

    ?>
</body>
</html>