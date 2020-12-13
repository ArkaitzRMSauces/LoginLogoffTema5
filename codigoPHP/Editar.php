<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../config/confDB.php';
require_once '../core/libreriaValidacion.php';
    if(!isset($_SESSION['usuarioDAW205LoginLogoffTema5'])){
    header('Location: ../Login.php');
    }

$entradaOK=true;
$aErrores=[];
try{
    $miDB = new PDO(DNS, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (Exception $exp){
            echo $exp->getMessage();
            echo "ERROR";
        }
    try{
        $sql="Select * FROM T01_Usuario WHERE T01_CodUsuario=:cod";
        $consulta=$miDB->prepare($sql);
        $consulta->bindValue(":cod", $_SESSION['usuarioDAW205LoginLogoffTema5']);
        $consulta->execute();
    } catch (PDOException $exp) {
        echo $exp->getMessage();
        echo $exp->getCode();
    }
    $rs=$consulta->fetchObject();
if(isset($_REQUEST['Enviar'])){
    $aErrores['desc']= validacionFormularios::comprobarAlfaNumerico($_REQUEST['desc'], 250, 1, 1);
}else{
    $entradaOK=false;
}
if($entradaOK){
    try{
    $miDB = new PDO(DNS, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exp) {
        echo $exp->getCode();
        echo $exp->getMessage();
    }
    try{
    $sql2="Update T01_Usuario SET T01_DescUsuario=:desc WHERE T01_CodUsuario=:usuarioA";
    $consulta=$miDB->prepare($sql2);
    $consulta->bindParam(":usuarioA", $_REQUEST['usuario2']);
    $consulta->bindParam(":desc", $_REQUEST['desc']);
    $consulta->execute();
    header('Location: Programa.php');
    } catch (PDOException $exp) {
        echo $exp->getCode();
        echo $exp->getMessage();
        header('Location: Editar.php');
    } finally {
        unset($miDB);
    }
}else{
?>
<form action="Editar.php" method="POST" enctype="multipart/form-data" name="Formulario">
    <label for="usuario">usuario</label>
    <input type="text" name="usuario" id="usuario" disabled value="<?php echo $rs->T01_CodUsuario?>">
    <input type="hidden" name="usuario2" id="usuario2" value="<?php echo $rs->T01_CodUsuario?>">
    <br><br>
    <label for="desc">Descipcion usuario</label>
    <input type="text" name="desc" id="desc" value="<?php echo $rs->T01_DescUsuario?>">
    <br><br>
    <input type="submit" value="Enviar" name="Enviar">
    <input type="button" onclick="location='CambiarContraseña.php'" value="Cambiar Contraseña">
    <input type="button" onclick="location='Borrar.php'" value="Borrar Usuario">
    <input type="button" onclick="location='Programa.php'" value="Atras">
</form>

<?php
        foreach ($aErrores as $key => $value) {
                echo "Error en ".$key." ".$value;
            }
}