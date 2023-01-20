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
    <title>Modificar Socio</title>
</head>
<body>
    <?php
    if(isset($_COOKIE['sesion'])){
        require_once("funciones.php");
        list($usu,$nom)=comprobar_sesion();
        if($usu==='a'){
            $conexion=conectarservidor();
            $cabecera=imprimir_menu($usu,$nom);
            echo $cabecera;
            echo "<h1>EDITAR DATOS</h1>";
            echo btn_volver('socios.php','volverinser');
            $id=$_GET['editsocio'];
            $datos=id_editar('socio',$id);
            while($fila=$datos->fetch_array(MYSQLI_ASSOC)){
                echo "
                <div class='formsinsertmod'>
                    <div class='fila1'>
                        <img src=$fila[Foto]>
                    </div>
                    <form method='post' action='#' enctype='multipart/form-data'>
                        <div class='centrar'>
                            <div class='columna1'>
                                <div>
                                    <label for='modnom'>Nombre:</label>
                                    <input name='modnom' type='text' value=$fila[Nombre]>
                                </div>
                                <div>
                                    <label for='modusu'>Usuario:</label>
                                    <input name='modusu' type='text' value=$fila[Usuario]>
                                </div>
                                <div>
                                    <label for='modtelf'>Telefono</label>
                                    <input name='modtelf' type='text' value=$fila[Telefono]>
                                </div>
                            </div>
                            <div class='columna2'>
                                <div>
                                    <label for='modedad'>Edad:</label>
                                    <input name='modedad' type='number' value=$fila[Edad]>
                                </div>
                                <div>
                                    <label for='modcontrasena'>Contraseña:</label>
                                    <input name='modcontrasena' type='password' value=$fila[Pass]>
                                </div>
                                <div>
                                    <label for='modfoto'>Foto:</label>
                                    <input name='modfoto' type='file' value=$fila[Foto]>
                                </div>
                            </div>
                        </div>
                        <input name='modenviar' type='submit'>
                    </form>
            </div>";
            // Guardo la ruta de la foto actual por si el dato modificado no es la foto
            $ruta=$fila['Foto'];
            }
        }else{
            echo "<h1>EDITAR DATOS</h1>";
            $idsocio=$conexion->prepare("select id from socio where usuario=?");
            $idsocio->bind_param("s",$nom);
            $idsocio->bind_result($id);
            $idsocio->execute();
            $idsocio->store_result();
            $idsocio->fetch();
            $idsocio->close();
            $datos=id_editar('socio',$id);
            while($fila=$datos->fetch_array(MYSQLI_ASSOC)){
                echo "
                <div class='formsinsertmod'>
                    <div class='fila1'>
                        <img src=$fila[Foto]>
                    </div>
                    <form method='post' action='#' enctype='multipart/form-data'>
                        <div class='centrar'>
                            <div class='columna1'>
                                <div>
                                    <label for='modnom'>Nombre:</label>
                                    <input disabled name='modnom' type='text' value=$fila[Nombre]>
                                </div>
                                <div>
                                    <label for='modusu'>Usuario:</label>
                                    <input disabled name='modusu' type='text' value=$fila[Usuario]>
                                </div>
                                <div>
                                    <label for='modtelf'>Telefono</label>
                                    <input name='modtelf' type='text' value=$fila[Telefono]>
                                </div>
                            </div>
                            <div class='columna2'>
                                <div>
                                    <label for='modedad'>Edad:</label>
                                    <input disabled name='modedad' type='number' value=$fila[Edad]>
                                </div>
                                <div>
                                    <label for='modcontrasena'>Contraseña:</label>
                                    <input name='modcontrasena' type='password'>
                                </div>
                                <div>
                                    <label for='modfoto'>Foto:</label>
                                    <input name='modfoto' type='file' value=$fila[Foto]>
                                </div>
                            </div>
                        </div>
                        <input name='modenviar' type='submit'>
                    </form>
            </div>";
            // Guardo la ruta de la foto actual por si el dato modificado no es la foto
            $ruta=$fila['Foto'];
            $nuevonom=$fila['Nombre'];
            $nuevaedad=$fila['Edad'];
            $nuevousu=$fila['Usuario'];
            $nuevapass=$fila['Pass'];
            }
        }

        if(isset($_POST['modenviar'])){
            // compruebo que el teléfono introducido es un teléfono válido
            $nuevotlf=$_POST['modtelf'];
            $comprobacion="`^(6|7)[0-9]{8}$`";
            if(preg_match($comprobacion,$nuevotlf)|| $nuevotlf==='0'){
                if($_POST['modcontrasena']!==''){
                    $nuevapass=$_POST['modcontrasena'];
                    $nuevapass=md5(md5($nuevapass));
                }
                $formato=$_FILES['modfoto']['type'];
                $nomfoto=$_FILES['modfoto']['name'];
                // Si ha cambiado la foto que había, compruebo que sea una foto, la guardo y la modifico
                if($nomfoto!==""){
                    $formato=($_FILES['modfoto']['type']);
                    if(comprobar_img($formato)){
                        $temp=$_FILES['modfoto']['tmp_name'];
                        $ruta="../img/$nomfoto";
                        move_uploaded_file($temp,$ruta);
                        $modificar=$conexion->prepare("update socio set Nombre=?,Edad=?,Usuario=?,Pass=?,Telefono=?,Foto=? where Id=?");
                        $modificar->bind_param("sissisi",$nuevonom,$nuevaedad,$nuevousu,$nuevapass,$nuevotlf,$ruta,$idsocio);
                        $modificar->execute();
                        $modificar->close();
                        echo "<p class='mnsmod'>datos actualizados con éxito</p>";
                        echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=socios.php'>";
                    }else{
                        echo"<p class='mnsmod'>Foto no válida</p>";
                    }
                }else{
                    $modificar=$conexion->prepare("update socio set Nombre=?,Edad=?,Usuario=?,Pass=?,Telefono=?,Foto=? where Id=?");
                    $modificar->bind_param("sissssi",$nuevonom,$nuevaedad,$nuevousu,$nuevapass,$nuevotlf,$ruta,$id);
                    $modificar->execute();
                    $modificar->close();
                    echo "<p class='mnsmod'>datos actualizados con éxito</p>";
                    //echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=socios.php'>";
                }
                
            }else{
                echo "<p class='mnsmod'>telefono no válido</p>";
            }
        }       
        
        }else{
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='3;URL=../index.php'>";
    }

    
    ?>
</body>
</html>