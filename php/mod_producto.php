<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300&display=swap" rel="stylesheet">
    <title>Editar Producto</title>
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
        $cabecera=imprimir_menu($usu,$nom);
        echo $cabecera;
        echo "<h1>EDITAR PRODUCTO</h1>";
        echo btn_volver('Productos.php','volverinser');
        $idprod=$_GET['editprod'];
        $conex=conectarservidor();
        $info=id_editar('producto',$idprod);
        while($fila=$info->fetch_array(MYSQLI_ASSOC)){
            echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
                <div class='fila1'>
                <label for='nomprod'>Nombre:</label>
                <input type='text' name='nomprod' value=$fila[Nombre]>
                </div>
                <div class='fila1'>
                <label for='precioprod'>Precio:</label>
                <input name='precioprod' type='number' step=.01 value=$fila[Precio]>
                </div>
                <input name='editprod' type='submit'>
            </form>";
        }
        if(isset($_POST['editprod'])){
            $nombre=$_POST['nomprod'];
            $precio=$_POST['precioprod'];
            if($nombre==='' || $precio<=0){
                echo "<p class='mnsmod'>Datos incorrectos</p>";
            }else{
                $modificar=$conex->prepare("update producto set Nombre=?,Precio=? where Id=?");
                $modificar->bind_param("sdi",$nombre,$precio,$idprod);
                $modificar->execute();
                $modificar->close();
                echo "<p class='mnsmod'>datos actualizados con éxito</p>";
                echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=Productos.php'>";
            }
        }

        $conex->close();
    }
    
    ?>
</body>
</html>