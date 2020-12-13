<?php
/**
 *   @author: Arkaitz Rodriguez Martinez
 *   @since: 10/12/2020
 *   Login: LOGINLOGOFF-TEMA5
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
if(isset($_REQUEST['detalle'])){
    header('Location: Detalle.php');
    exit;
}
if(isset($_REQUEST['editar'])){
    header('Location: Editar.php');
    exit;
}
if (!isset($_COOKIE['idioma'])) { // si se ha pulsado el botton de cerrar sesion
    setcookie('idioma','es', time() + 2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    header('Location: Programa.php');
    exit;
}
if (isset($_REQUEST['es'])) { // si se ha pulsado el botton de cerrar sesion
    setcookie('idioma', $_REQUEST['es'], time() + 2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    header('Location: Programa.php');
    exit;
}

if (isset($_REQUEST['en'])) { // si se ha pulsado el botton de cerrar sesion
    setcookie('idioma', $_REQUEST['en'], time() + 2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    header('Location: Programa.php');
    exit;
}

if (isset($_REQUEST['fr'])) { // si se ha pulsado el botton de cerrar sesion
    setcookie('idioma', $_REQUEST['fr'], time() + 2592000); // modifica la cookie 'idioma' con el valor recibido del formulario para 30 dias
    header('Location: Programa.php');
    exit;
}
/**
 *   @author: Arkaitz Rodriguez Martinez
 *   @since: 1/12/2020
 *   Programa: LOGINLOGOFF-TEMA5
*/
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
    $aLang=[ // array de las traducciones
        'es' => 'Hola',
        'fr' => 'Salut',
        'en' => 'Hello',
    ];
} catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
    echo "<h3>Mensaje de ERROR</h3>";
    echo "Error: " . $mensajeError->getMessage() . "<br>";
    echo "Código de error: " . $mensajeError->getCode();
} finally {
    unset($miDB);
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <header>
            <h1>Sesion iniciada</h1>
            <h2><?php echo $aLang[$_COOKIE['idioma']] . " " . $descUsuario; ?> </h2>
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
                    <button type="submit" name="es" value="es">Castellano</button>                
                    <button type="submit" name="en" value="en">English</button>
                    <button type="submit" name="fr" value="fr">Français</button>
                </div>
            </form>
            <br>
            <form  name="logout" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <button type="submit" name='editar' value="Editar Perfil">Editar Perfil</button>
                <button type="submit" name='cerrarSesion' value="Cerrar Sesion">Cerrar Sesion</button>
                <button type="submit" name='detalle' value="Detalles">Detalles</button>
            </form>
        </main>
    </body>
</html>