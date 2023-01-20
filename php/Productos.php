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
    <title>Productos</title>
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
        }
        $conexion=conectarservidor();
        echo imprimir_menu($usu,$nom);
        echo "<main class='mainprodserv'> <h1>PRODUCTOS</h1>";
        echo "<div class='buscarinser'>";
        echo form_buscar('producto');
        if($usu==='a'){
            echo btn_inser('insert_prod.php','PRODUCTO');
            if(isset($_GET['deleprod'])){
                $idpro=$_GET['deleprod'];
                $borrar=$conexion->prepare("delete from producto where id=?");
                $borrar->bind_param("i",$idpro);
                $borrar->execute();
                $borrar->close();
                $borrar="<p>Producto borrado</p>";
    
                echo $borrar;
            }
        }
        echo "</div>";
        
        if(isset($_GET["busqueda"])){
            echo btn_volver('Productos.php','volver');
            $param="%$_GET[buscar]%";
            if(preg_match("`,`",$param)){
                $param=str_replace(",",".",$param);
            }
            $buscar=$conexion->prepare("select * from producto where nombre like ? or precio like ?");
            $buscar->bind_result($id,$nom,$prec);
            $buscar->bind_param("ss",$param,$param);
            $buscar->execute();
            $buscar->store_result();
            if($buscar->affected_rows>0){
                $info_bus="<table class='tablaprodserv'><thead><th>Nombre</th><th>Precio</th>";
                if($usu==='a'){
                    $info_bus.="<th colspan='2'>MODIFICAR/BORRAR</th>";
                }
                $info_bus.="</thead><tbody>";
                while($buscar->fetch()){
                    $info_bus.="<tr>";
                    $info_bus.="<td>$nom</td>";
                    $info_bus.="<td>$prec</td>";
                    if($usu==='a'){
                        $info_bus.="<td><a method='get' href='mod_producto.php?editprod=$id'>MODIFICAR</a></td>";
                        $info_bus.="<td><a method='get' href='Productos.php?deleprod=$id'>BORRAR</a></td>";
                    }
                    $info_bus.="</tr>";
                }
                $info_bus.="</tbody></table>";
                $buscar->close();
                echo $info_bus;
            }else{
                echo "<p>No hay datos que coincidan con tu busqueda</p>";
            }
        }else{
            $productos=consultar_datos("producto");
            echo "<table class='tablaprodserv'><thead><th>Nombre</th><th>Precio</th>";
            if($usu==='a'){
                echo "<th colspan='2'>MODIFICAR/BORRAR</th>";
            }
            echo "</thead>";
            if(gettype($productos)==="string"){
                $info="<tbody><tr><td colspan='4'>$productos</td></tr></tbody>";
            }else{
                $info="<tbody>";
                while($cont=$productos->fetch_array(MYSQLI_ASSOC)){
                    $info.="<tr>";
                    $info.="<td>$cont[Nombre]</td>";
                    $info.="<td>$cont[Precio]</td>";
                    if($usu==='a'){
                        $info.="<td><a method='get' href='mod_producto.php?editprod=$cont[Id]'>MODIFICAR</a></td>";
                    $info.="<td><a method='get' href='Productos.php?deleprod=$cont[Id]'>BORRAR</a></td>";
                    }
                    $info.="</tr>";
                }
            }
            echo $info;
            echo "</tbody></table>";
        }
        echo imprimir_footer();
        $conexion->close();
        
        
    ?>
</body>
</html>