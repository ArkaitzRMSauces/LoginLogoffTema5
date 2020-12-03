<?php
if(isset($_REQUEST['detalle'])){
    header('Location: Detalle.php');
    exit;
}
/**
 *   @author: Arkaitz Rodriguez Martinez
 *   @since: 1/12/2020
 *   Programa: LOGINLOGOFF-TEMA5
*/
session_start(); // inicia una sesion, o recupera una existente
if(!isset($_SESSION['usuarioDAW205LoginLogoffTema5'])){
    header('Location: ../Login.php');
    exit;
}
if(isset($_REQUEST['cerrarSesion'])){ // si se ha pulsado el botton de cerrar sesion
    session_destroy(); // destruye todos los datos asociados a la sesion
    header("Location: ../Login.php"); // redirige al index del tema 5
    exit;    
}
if(!isset($_COOKIE['idioma'])){ // si no existe la cookie 'idioma'
    setcookie('idioma','es',time()+2592000); // crea la cookie 'idioma' con el valor 'es' para 30 dias
    setcookie('saludo','Hola',time()+2592000); // crea la cookie 'saludo' con el valor 'Hola' para 30 dias
}


require_once '../core/libreriaValidacion.php'; // incluyo la libreria de validacion para validar los campos del formulario
require_once '../config/confDB.php';
try {
   $miDB = new PDO(DNS, USER, PASSWORD); // creo un objeto PDO con la conexion a la base de datos

    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establezco el atributo para la apariciopn de errores y le pongo el modo para que cuando haya un error se lance una excepcion

    $sqlUsuario = "SELECT T01_NumConexiones, T01_DescUsuario FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario"; 

    $consultaUsuario = $miDB->prepare($sqlUsuario); // prepara la consulta
    $parametros = [':CodUsuario' => $_SESSION['usuarioDAW205LoginLogoffTema5'] // creo el array de parametros con el valor de los parametros de la consulta
                  ];

    $consultaUsuario->execute($parametros); // ejecuto la consulta pasando los parametros del array de parametros
    
    $oUsuario = $consultaUsuario->fetchObject(); // guarda en la variable un objeto con los datos solicitados en la consulta
    
    $numConexiones = $oUsuario->T01_NumConexiones; // variable que tiene el numero de conexiones sacado de la base de datos
    $descUsuario = $oUsuario->T01_DescUsuario;
} catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
    echo "<h3>Mensaje de ERROR</h3>";
    echo "Error: " . $mensajeError->getMessage() . "<br>";
    echo "Código de error: " . $mensajeError->getCode();
} finally {
    unset($miDB);
}
$entradaOK=true; // declaro la variable que determina si esta bien la entrada de los campos introducidos por el usuario

$erroresIdioma=null; //declaro e inicializo la variable de errores

$idioma=null; //declaro e inicializo la variable del idioma

if(isset($_REQUEST["Enviar"])){ // compruebo que el usuario le ha dado a al boton de enviar y valido la entrada de todos los campos
    $erroresIdioma= validacionFormularios::validarElementoEnLista($_REQUEST['idioma'], ['es','en','fr']); // valido el campo que ha seleccionado el usuario

    if($erroresIdioma != null){ // compruebo si hay algun mensaje de error 
        $entradaOK=false; // le doy el valor false a $entradaOK
    }
}else{ // si el usuario no le ha dado al boton de enviar
    $entradaOK=false; // le doy el valor false a $entradaOK
}

if($entradaOK){ // si la entrada esta bien recojo los valores introducidos y hago su tratamiento
    $idioma=$_REQUEST['idioma']; // asigno a la variable el valor recibido del formulario
    setcookie('idioma',$idioma,time()+2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    
    if ($idioma=="en") { // si el idioma seleccionado es 'en'
        setcookie('saludo','Hello',time()+2592000);  // modifica el valor de la cookie 'saludo' para 30 dias
    }
    if ($idioma=="fr") { // si el idioma seleccionado es 'fr'
        setcookie('saludo','Salut',time()+2592000);  // modifica el valor de la cookie 'saludo'  para 30 dias
    }
    if ($idioma=="es"){ // si el idioma seleccionado es 'es'
        setcookie('saludo','Hola',time()+2592000);  // modifica el valor de la cookie 'saludo'  para 30 dias
    }
    header('Location: Programa.php'); // redirige a la misma pagina
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <header>
            <h1>Sesion iniciada</h1>
            <h2><?php echo $_COOKIE['saludo'] . " " . $descUsuario; ?> </h2>
            <h2><?php if($numConexiones!=1){
                echo "Numero de conexiones: " . $numConexiones;
                echo "<br>Ultima conexion: " . date('d/m/Y H:i:s', $_SESSION['fechaHoraUltimaConexionAnteriorDAW205LoginLogoffTema5']);   
            }else{
                echo "Primera conexion";
            }
            ?></h2>
        </header>
        <main>
            <form name="formularioIdioma" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div>
                    <label for ="idioma">Idioma: </label>
                    <select id="idioma" name="idioma">
                        <option value="es" <?php echo (($_COOKIE['idioma']) == 'es') ? 'selected' : null; ?> >Castellano</option>
                        <option value="en" <?php echo (($_COOKIE['idioma']) == 'en') ? 'selected' : null; ?> >English</option>
                        <option value="fr" <?php echo (($_COOKIE['idioma']) == 'fr') ? 'selected' : null; ?> >Français</option>
                    </select>
                    <?php
                        echo(!is_null($erroresIdioma)) ? $erroresIdioma : null;   // si el campo es erroneo se muestra un mensaje de error
                    ?>
                    <button type="submit" name="Enviar" value="enviar"> Enviar</button>
                </div>
                
            </form>
            <br>
            <form  name="logout" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <button type="submit" name='cerrarSesion' value="Cerrar Sesion">Cerrar Sesion</button>
                <button type="submit" name='detalle' value="Detalles">Detalles</button>
            </form>
        </main>
    </body>
</html>