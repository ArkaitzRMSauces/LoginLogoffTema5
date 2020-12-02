<?php
/**
 *   @author: Arkaitz Rodriguez Martinez
 *   @since: 30/11/2020
 *   Login: LOGINLOGOFF-TEMA5
*/
        if(isset($_REQUEST['salir'])){
            header('Location: ../proyectoDWES/indexProyectoDWES.php');
            exit;
        }
        require_once 'core/libreriaValidacion.php';//Importamos la librería de validación para comprobar que los campos se introducen correctamente
        require_once('config/confDB.php');
        $entradaOK = true;
        
        $arrayErrores = [ //Recoge los errores del formulario
            'campoAlfabetico' => null,
            'campoPassword' => null            
        ]; 
        $arrayFormulario = [ //Recoge los datos del formulario
            'campoAlfabetico' => null,
            'campoPassword' => null
        ];
        $errorInicioSesion = null;
        if (isset($_REQUEST['iniciarSesion'])) { //Código que se ejecuta cuando se envía el formulario
            $arrayErrores['campoAlfabetico'] = validacionFormularios::comprobarAlfabetico($_REQUEST['campoAlfabetico'], 250, 1, 1);  //Máximo, mínimo y opcionalidad            
            $arrayErrores['campoPassword'] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['campoAlfabetico'], 250, 1, 1);  //Máximo, mínimo y opcionalidad            
        foreach ($arrayErrores as $campo => $error) { //Recorre el array en busca de mensajes de error
                if ($error != null) { //Si lo encuentra vacia el campo y cambia la condiccion
                    $entradaOK = false; //Cambia la condiccion de la variable
                }
            }
        } else {
            $entradaOK = false;
        }
        if ($entradaOK) { // Si el formulario se ha rellenado correctamente
            // Cargamos en el $arrayFormulario el valos de aquellos campos que se han rellenado correctamente            
            $arrayFormulario['campoAlfabetico'] = $_REQUEST['campoAlfabetico'];
            $arrayFormulario['campoPassword'] = $_REQUEST['campoPassword'];
            try {
                // Datos de la conexión a la base de datos
                $miDB = new PDO(DNS, USER, PASSWORD);
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Cómo capturar las excepciones y muestre los errores
                $usuario = $_REQUEST['campoAlfabetico'];
                $password = $_REQUEST['campoPassword'];
                $consultaSQL = "SELECT * FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario and T01_Password = :password";
                $resultadoSQL = $miDB->prepare($consultaSQL);
                $resultadoSQL->bindValue(":codUsuario", $usuario);
                $resultadoSQL->bindValue(':password', hash('sha256', $usuario . $password));
                $resultadoSQL->execute();
                if ($resultadoSQL->rowCount() == 1) { //te recorre todas las campos de la base, y si uno es como dice el query pues se ejecuta el if
                    $sqlUpdateDatosUsuario = "UPDATE T01_Usuario SET T01_NumConexiones = (T01_NumConexiones + 1) , T01_FechaHoraUltimaConexion = :FechaHoraUltimaConexion WHERE T01_CodUsuario=:CodUsuario";

                    $consultaUpdateDatosUsuario = $miDB->prepare($sqlUpdateDatosUsuario); // prepara la consulta
                    $parametros = [':FechaHoraUltimaConexion' => time(), // time() devuelve el timestamp de el tiempo actual
                                   ':CodUsuario' => $_REQUEST['campoAlfabetico'] // creo el array de parametros con el valor de los parametros de la consulta
                                  ]; 

                    $consultaUpdateDatosUsuario->execute($parametros); // ejecuto la consulta pasando los parametros del array de parametros


                    $sqlUsuario = "SELECT T01_CodUsuario, T01_DescUsuario, T01_NumConexiones, T01_FechaHoraUltimaConexion FROM T01_Usuario WHERE T01_CodUsuario=:CodUsuario" ;

                    $consultaUsuario = $miDB->prepare($sqlUsuario); // prepara la consulta
                    $parametros = [':CodUsuario' => $_REQUEST['campoAlfabetico'],// creo el array de parametros con el valor de los parametros de la consulta
                                  ]; 

                    $consultaUsuario->execute($parametros); // ejecuto la consulta pasando los parametros del array de parametros

                    $oUsuario = $consultaUsuario->fetchObject();
                    session_start(); // inicia una sesion, o recupera una existente
                    $_SESSION['usuarioDAW205LoginLogoffTema5'] = $oUsuario->T01_CodUsuario;
                    $_SESSION['fechaHoraUltimaConexionAnteriorDAW205LoginLogoffTema5'] = $oUsuario->T01_FechaHoraUltimaConexion;
                    if(!isset($_COOKIE['idioma'])){ // si no existe la cookie 'idioma'
                        setcookie('idioma','es',time()+2592000); // crea la cookie 'idioma' con el valor 'es' para 30 dias
                        setcookie('saludo','Hola',time()+2592000); // crea la cookie 'saludo' con el valor 'Hola' para 30 dias
                    }
                    header('Location: codigoPHP/Programa.php');
                    exit;
                }else{
                    $errorInicioSesion="Credenciales incorrectas";
                }
            } catch (PDOException $mensajeError) { //Cuando se produce una excepcion se corta el programa y salta la excepción con el mensaje de error
                echo "<h3>Mensaje de ERROR</h3>";
                echo "Error: " . $mensajeError->getMessage() . "<br>";
                echo "Código de error: " . $mensajeError->getCode();
            } finally {
                unset($miDB);
            }
        } else { //Código que se ejecuta antes de rellenar el formulario
            ?>
            <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post" style="width:15%;">
                <fieldset>
                    <legend>Login</legend>
                    <div>
                        <label>Usuario: </label>
                        <input type = "text" name = "campoAlfabetico" placeholder="Nombre de usuario"
                               value="<?php if($arrayErrores['campoAlfabetico'] == NULL && isset($_REQUEST['campoAlfabetico'])){ echo $_REQUEST['campoAlfabetico'];} ?>"><br>
                    </div>
                    <div>
                    <?php
                    if ($arrayErrores['campoAlfabetico'] != NULL) {
                        echo $arrayErrores['campoAlfabetico']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <br>
                    <div>
                        <label>Contaseña: </label>
                        <input type = "password" name = "campoPassword" placeholder = "Contraseña"
                               value="<?php if($arrayErrores['campoPassword'] == NULL && isset($_REQUEST['campoPassword'])){ echo $_REQUEST['campoPassword'];} ?>"><br>
                    </div>
                    <div>
                    <?php
                    if ($arrayErrores['campoPassword'] != NULL) {
                        echo $arrayErrores['campoPassword']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <div>
                        <?php
                            echo ($errorInicioSesion != NULL) ? $errorInicioSesion : NULL;
                        ?>
                        <br><input type = "submit" name = "iniciarSesion" value = "Iniciar Sesion">
                        <input type = "submit" name = "salir" value = "Volver">
                    </div>
                </fieldset>
            </form>
        <?php } ?>
    </body>
</html>  
            
