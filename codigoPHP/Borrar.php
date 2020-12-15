<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once '../config/confDB.php';
if(!isset($_SESSION['usuarioDAW205LoginLogoffTema5'])){
    header('Location: Login.php');
}
if(isset($_REQUEST['Borrar'])){
    try{
    $miDB = new PDO(DNS, USER, PASSWORD);
    $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exp) {
        echo $exp->getCode();
        echo $exp->getMessage();
    }
    try{
    $sql2="DELETE FROM T01_Usuario WHERE T01_CodUsuario=:usuarioA";
    $consulta=$miDB->prepare($sql2);
    $consulta->bindParam(":usuarioA", $_SESSION['usuarioDAW205LoginLogoffTema5']);
    $consulta->execute();
    header('Location: ../Login.php');
    } catch (PDOException $exp) {
        echo $exp->getCode();
        echo $exp->getMessage();
        header('Location: Editar.php');
    } finally {
        unset($miDB);
    }
}
?>
<form action="Borrar.php" method="POST">
<input type="submit" value="Borrar" name="Borrar">

</form>
<input type="button" name="atras" value="atras" onclick="location='Editar.php'">