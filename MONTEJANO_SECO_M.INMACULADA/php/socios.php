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
    <title>Socios</title>
</head>
<body id='bodysocios'>
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
            echo "<main id='mainsocios'> <h1>SOCIOS DEL CLUB</h1>";
            echo "<div class='buscarinser'>";
            echo form_buscar('socio');
            echo btn_inser('insert_socio.php','SOCIO');
            echo "</div>";
            $conexion=conectarservidor();

            if(isset($_GET["busqueda"])){
                echo btn_volver('socios.php','volver');
                $param="%$_GET[buscar]%";
                $buscar=$conexion->prepare("select * from socio where nombre like ? or telefono like ?");
                $buscar->bind_result($id,$nom,$edad,$usua,$contr,$tlf,$foto);
                $buscar->bind_param("ss",$param,$param);
                $buscar->execute();
                $buscar->store_result();
                if($buscar->affected_rows>0){
                    $info_bus="<section class='socio'>";
                    while($buscar->fetch()){
                        if($id>0){
                            $info_bus.="<article>";
                            $info_bus.="<div id='socioimg'>";
                            $info_bus.="<img src='$foto'>";
                            $info_bus.="</div>";
                            $info_bus.="<div id='sociodatos'>";
                            $info_bus.="<p>Nombre: $nom</p><p>Edad: $edad</p><p>Usuario: $usua</p><p>Teléfono: $tlf</p>";
                            $info_bus.="</div>";
                            $info_bus.="<a method='get' href='mod_socio.php?editsocio=$id'>MODIFICAR</a>";
                            $info_bus.="</article>";
                            $info_bus.="<hr>";
                        }else if($buscar->affected_rows==1 && $id==0){
                            echo "<p>No hay datos que coincidan con tu busqueda</p>";
                        }
                        
                    }
                    $info_bus.="</section>";

                    echo $info_bus;
                }else{
                    echo "<p>No hay datos que coincidan con tu busqueda</p>";
                }

            }else{
                $socios=consultar_datos("socio");
                // Compruebo si lo que se ha devuelto es un string, porque si no hay datos insertados aún, no devuelve un objeto y no se le puede aplicar num_rows
                if(gettype($socios)==="string"){
                    echo "<p>$socios</p>";
                }else{
                    $info="<section class='socio'>";
                        while($fila=$socios->fetch_array(MYSQLI_ASSOC)){
                            if($fila['Id']>0){
                                $info.="<article>";
                                $info.="<div id='socioimg'>";
                                $info.="<img src=\"$fila[Foto]\">";
                                $info.="</div>";
                                $info.="<div id='sociodatos'>";
                                $info.="<p>Nombre: $fila[Nombre]</p><p>Edad: $fila[Edad]</p><p>Usuario: $fila[Usuario]</p><p>Teléfono: $fila[Telefono]</p>";
                                $info.="</div>";
                                $info.="<a method='get' href='mod_socio.php?editsocio=$fila[Id]'>MODIFICAR</a></article>";
                                $info.="<hr>";
                            }else if($socios->num_rows==1 && $fila['Id']==0){
                                echo "<p>No hay socios aún</p>";
                            }
                        }

                    $info.="</section>";
                    echo $info;
                }
                    
            }
            echo "</main>";
            echo imprimir_footer();

            $conexion->close();
        }else if($usu==='s'){
            echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
            echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
        }
        
        

    ?>
</body>
</html>