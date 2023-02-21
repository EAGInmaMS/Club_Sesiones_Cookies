<?php
    header('Content-Type: application/json');
    header("Acces-Control-Allow-Origin: *");
    require_once("funciones.php");

    // Primero establecemos el número de noticias que va a aparecer por página
    sleep(1);
    $notispag=4;
    $limite=$_GET["limite"] ?? $notispag=4;;
    $offset=$_GET["offset"] ?? 0;

    $conexion=conectarservidor();

    $datos=[];

    $totalpags=$conexion->query("select count(*) as conteo from noticia");
    // Y sacamos el número de noticias que hay en la base de datos
    while($num=$totalpags->fetch_array(MYSQLI_ASSOC)){
        $numnotis=$num['conteo'];
    }

    $info["total"]=$numnotis;

    $sentencia=$conexion->prepare("select * from noticia order by fecha_publicacion desc limit $offset, $limite");
    $sentencia->execute();
    $resultado=$sentencia->get_result();

    while($fila=$resultado->fetch_assoc()){
        $datos[]=$fila;
    }
    $info["datos"]=$datos;

    $patron_url=explode("?",$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])[0];
    $nuevo_offset=$offset+$limite;
    if($nuevo_offset<$numnotis){
        $sig_offset=$nuevo_offset;
        if($nuevo_offset+$limite>$numnotis){
            $sig_limite=$numnotis-$nuevo_offset;
        }else{
            $sig_limite=$limite;
        }
        $info["siguiente"]=$patron_url."?offset=$sig_offset&limite=$sig_limite";
    }else{
        $info["siguiente"]="null";
    }

    $nuevo_offset=$offset-$limite;
    if($offset==0){
        $info["anterior"]="null";
    }else{
        if($nuevo_offset>0){
            $ant_limite=$notispag;
            $nuevo_offset=$offset-$notispag;
            $ant_offset=$nuevo_offset;
        }else{
            $ant_limite=$offset;
            $ant_offset=0;
        }
        $info["anterior"]=$patron_url."?offset=$ant_offset&limite=$ant_limite";
    }

    echo json_encode($info);
?>