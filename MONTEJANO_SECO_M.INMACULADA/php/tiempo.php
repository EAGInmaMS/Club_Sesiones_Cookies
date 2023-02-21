<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../js/app_tiempo.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../estilos/estilosmenu.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Tiempo</title>
</head>
<body id='page'>
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
        echo imprimir_menu($usu,$nom);
    ?>
    <div class="container-btn-mode">
        <div id="id-sun" class="btn-mode sun active">
            <i class="fas fa-sun"></i>
        </div>
        <div id="id-moon" class="btn-mode moon">
            <i class="fas fa-moon"></i>
        </div>
    </div>
    <h1>Tiempo Actual</h1>
    <table class="tablaprodserv" id="tablatiempo">
        <thead>
            <th>Indice de Contaminación</th>
            <th>Temperatura actual</th>
            <th>Humedad</th>
        </thead>
        <tbody id="contenedor_actual">

        </tbody>
    </table>
    <h1>Datos sobre Perros</h1>
    
    <div id="frase_perro">

    </div>
    <?php
        echo imprimir_footer();
    ?>
</body>
</html>