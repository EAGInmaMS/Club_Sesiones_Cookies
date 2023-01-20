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
    <title>Insertar Producto</title>
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
        $cabecera=imprimir_menu($usu,$nom);
        echo $cabecera;
        echo "<h1>INSERTAR PRODUCTO</h1>";
        echo btn_volver('Productos.php','volverinser');
        $num=obtener_id("'producto'");
        echo "<form class='formsinsertmod' method='post' action='#' enctype='multipart/form-data'>
            <div class='fila1'>
                <label for='idprod'>ID:</label>
                <input name='idprod' value=$num disabled type='number'>
            </div>
            <div class='fila1'>
                <label for='nomprod'>Nombre:</label>
                <input type='text' name='nomprod'>
            </div>
            <div class='fila1'>
                <label for='precprod'>Precio:</label>
                <input type='number' step=.01 name='precprod'>
            </div>
            <input type='submit' name='inserprod'>
        </form>";

        if(isset($_POST['inserprod'])){
            $id='';
            $nom=$_POST['nomprod'];
            $pre=$_POST['precprod'];
            if($nom==='' || $pre<=0){
                echo "<p class='mnsmod'>Datos incorrectos</p>";
            }else{
            // Compruebo si han insertado un precio con ',' porque en la base de datos se guarda con '.' y daría fallo
                if(preg_match("`,`",$pre)){
                    $pre=str_replace(",",".",$pre);
                }
                $inser=$conexion->prepare("insert into producto values(?,?,?)");
                $inser->bind_param("isd",$id,$nom,$pre);
                $inser->execute();
                $inser->close();
                $inser="<p class='mnsmod'>Datos insertados correctamente</p>";
                echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=Productos.php'>";
    
                echo $inser;
            }
        }

        $conexion->close();
    }else{
        echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
    }
        
    ?>
</body>
</html>