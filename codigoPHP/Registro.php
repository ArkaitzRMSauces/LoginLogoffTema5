<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../config/confDB.php';
require_once '../core/libreriaValidacion.php';
$entradaOK=true;
$aErrores=[];
if(isset($_REQUEST['Enviar'])){
    $aErrores['usuario']= validacionFormularios::comprobarAlfaNumerico($_REQUEST['usuario'], 15, 1, 1);
    $aErrores['desc']= validacionFormularios::comprobarAlfaNumerico($_REQUEST['desc'], 250, 1, 1);
    $aErrores['contrasena']= validacionFormularios::comprobarAlfaNumerico($_REQUEST['contrasena'], 64, 4, 1);
    foreach ($aErrores as $key => $value) {
        if($value!=null){
            $entradaOK=false;
        }
    try{
        $miDB = new PDO(DNS, USER, PASSWORD);
        $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        echo $ex->getCode();
        echo $ex->getMessage();
    }
    try{
        $sql="SELECT * FROM T01_Usuario WHERE T01_CodUsuario=:usuario";
        $consulta=$miDB->prepare($sql);
        $consulta->bindParam(":usuario", $_REQUEST['usuario']);
        $consulta->execute();
    } catch (PDOException $ex) {
        echo $ex->getCode();
        echo $ex->getMessage();
    } finally {
        unset($miDB);
    }
    if($consulta->rowCount()==1){
        $aErrores['dUsuario']="Existe";
        $entradaOK=false;
    }
    }
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
    $sql="INSERT INTO T01_Usuario (T01_CodUsuario, T01_DescUsuario, T01_Password, T01_NumConexiones) Values(:usuario,:desc,:contra,:num)";
    $consulta=$miDB->prepare($sql);
    $consulta->bindParam(":usuario", $_REQUEST['usuario']);
    $consulta->bindParam(":desc", $_REQUEST['desc']);
    $consulta->bindParam(":contra", hash('sha256', $_REQUEST['usuario'].$_REQUEST['contrasena']));
    $consulta->bindValue(":num", 1);
    $consulta->execute();
    session_start();
    $_SESSION['usuarioDAW205LoginLogoffTema5']=$_REQUEST['usuario'];
    $_SESSION['descripcion']=$_REQUEST['desc'];
    $_SESSION['perfil']='usuario';
    $fechaActual=new DateTime();
    $valor=$fechaActual->format('Y-m-d H:i:s');
    $_SESSION['ultimaConexion']=$valor;
    $_SESSION['numConexiones']=1;
    if(!isset($_COOKIE['idioma'])){
        setcookie('idioma', "español", time()+120);
    }
    header('Location: Programa.php');
    } catch (PDOException $exp) {
        echo $exp->getCode();
        echo $exp->getMessage();
        header('Location: registro.php');
    } finally {
        unset($miDB);
    }
}else{
?>
<form action="Registro.php" method="POST" enctype="multipart/form-data" name="Formulario">
    <label for="usuario">usuario</label>
    <input type="text" name="usuario" id="usuario">
    <br><br>
    <label for="desc">Descipcion usuario</label>
    <input type="text" name="desc" id="desc">
    <br><br>
    <label for="contrasena">Contraseña</label>
    <input type="password" name="contrasena" id="contrasena">
    <br><br>
    <input type="submit" value="Enviar" name="Enviar">
    <input type="button" name="atras" value="atras" onclick="location='../Login.php'">
</form>
<?php
        foreach ($aErrores as $key => $value) {
            if($value!=null){
                echo "Error en ".$key." ".$value;
            }
            }
}