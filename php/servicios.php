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
    <title>Servicios</title>
</head>
<body class='bodyprodserv'>
   <?php
    require_once("funciones.php");
    session_start();
    if(isset($_COOKIE['sesion'])){
        list($usu,$nom)=comprobar_sesion('c');
    }else if(isset($_SESSION['tipo'])){
        list($usu,$nom)=comprobar_sesion('s');
    }else{
        $usu='n';
        $nom='';
        echo "<p class='mnsmod'>No tiene permiso para acceder. Redirigiendo</p>";
        echo "<META HTTP-EQUIV='REFRESH'CONTENT='4;URL=../index.php'>";
    }
    echo imprimir_menu($usu,$nom);
    $conexion=conectarservidor();
    echo "<main class='mainprodserv'>";
    echo "<h1>NUESTROS SERVICIOS</h1>";
    echo "<div class='buscarinser'>";
    echo form_buscar('servicio');
    if($usu==='a'){
        echo btn_inser('insert_serv.php','SERVICIO');
    }
    echo "</div>";
    
    if(isset($_GET["busqueda"])){
        echo btn_volver('servicios.php','volver');
        $param="%$_GET[buscar]%";
        $buscar=$conexion->prepare("select * from servicio where descripcion like ?");
        $buscar->bind_result($id,$descri,$durac,$preci);
        $buscar->bind_param("s",$param);
        $buscar->execute();
        $buscar->store_result();
        if($buscar->affected_rows>0){
            $info_bus="<table class='tablaprodserv'><thead><th>Nombre</th><th>Duración</th><th>Precio</th>";
            if($usu==='a'){
                $info_bus.="<th>Modificar</th>";
            }
            $info_bus.="</thead><tbody>";
            while($buscar->fetch()){
                $info_bus.="<tr>";
                $info_bus.="<td>$descri</td>";
                $info_bus.="<td>$durac</td>";
                $info_bus.="<td>$preci €</td>";
                if($usu==='a'){
                    $info_bus.="<td><a method='get' href='modserv.php?editserv=$id'>MODIFICAR</a></td>";
                }
                $info_bus.="</tr>";
            }
            $info_bus.="</tbody></table>";

            echo $info_bus;
        }else{
            echo "<p>No hay datos que coincidan con tu busqueda</p>";
        }
    }else{
        $servicios=consultar_datos("servicio");
        // Compruebo que sea un string, porque si no hay datos no devuelve un objeto y no podemos aplicar num_rows
        if(gettype($servicios)==="string"){
            $info="<p>$servicios</p>";
        }else{
            $info="<table class='tablaprodserv'><thead><th>Nombre</th><th>Duración</th><th>Precio</th>";
            if($usu==='a'){
                $info.="<th>Modificar</th>";
            }
            $info.="</thead><tbody>";
            while($cont=$servicios->fetch_array(MYSQLI_ASSOC)){
                $info.="<tr>";
                $info.="<td>$cont[Descripcion]</td>";
                $info.="<td>$cont[Duracion]</td>";
                $info.="<td>$cont[Precio]</td>";
                if($usu==='a'){
                    $info.="<td><a method='get' href='modserv.php?editserv=$cont[Id]'>MODIFICAR</a></td>";
                }
                $info.="</tr>";
            }
            $info.="</tbody></table>";
        }

        echo $info;
    }
    echo "</main>";
    $conexion->close();
    echo imprimir_footer();
   ?> 
</body>
</html>