<?php
/**
 *   @author: Arkaitz Rodriguez Martinez
 *   @since: 1/12/2020
 *   Detalle: LOGINLOGOFF-TEMA5
*/
session_start(); // inicia una sesion, o recupera una existente
if(!isset($_SESSION['usuarioDAW205LoginLogoffTema5'])){
    header('Location: Programa.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Detalles</title>
    </head>
    <body>
        <a href="Programa.php"><button>Salir</button></a>        
        <table>
            <tbody>
                <tr>
                    <th>VARIABLES GLOBALES</th>
                </tr>
            </tbody>
        </table>
        <h2 >_COOKIE</h2>
        <?php if(!empty($_COOKIE)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_COOKIE as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>
        
        <h2 >_SESSION</h2>
        <?php if(!empty($_SESSION)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_SESSION as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>
        <h2>_SERVER</h2>
        <?php if(!empty($_SERVER)){ ?>
        <table>
            <tbody>
                <?php 
                    foreach ($_SERVER as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>
        <h2 >_GET</h2>
        <?php if(!empty($_GET)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_GET as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>
        
        
        <h2 >_POST</h2>
        <?php if(!empty($_POST)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_POST as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>

        <h2 >_FILES</h2>
        <?php if(!empty($_FILES)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_FILES as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>
        
        <h2 >_ENV</h2>
        <?php if(!empty($_ENV)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_ENV as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>

        <h2 >_REQUEST</h2>
        <?php if(!empty($_REQUEST)){ ?>
        <table >
            <tbody>
                <?php 
                    foreach ($_REQUEST as $clave => $valor){
                ?>
                <tr>
                    <td><?php echo $clave ?></td>
                    <td><?php echo $valor ?></td>
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
        <?php }?>

        
        <?php            
            phpinfo();
        ?> 
    </body>
</html>