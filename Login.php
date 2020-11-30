<?php
        require_once 'core/libreriaValidacion.php';//Importamos la librería de validación para comprobar que los campos se introducen correctamente
        require_once('config/confDB.php');
        session_start();
        $entradaOK = true;
        
        $arrayErrores = [ //Recoge los errores del formulario
            'campoAlfabetico' => null,
            'campoPassword' => null            
        ]; 
        $arrayFormulario = [ //Recoge los datos del formulario
            'campoAlfabetico' => null,
            'campoPassword' => null
        ];
        if (isset($_POST['iniciarSesion'])) { //Código que se ejecuta cuando se envía el formulario
            $arrayErrores['campoAlfabetico'] = validacionFormularios::comprobarAlfabetico($_POST['campoAlfabetico'], 250, 1, 1);  //Máximo, mínimo y opcionalidad
            $arrayErrores['campoPassword'] = validacionFormularios::validarPassword($_POST['campoPassword'], 6, 1); //Longitud mínima y opcionalidad                   
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
            $arrayFormulario['campoAlfabetico'] = $_POST['campoAlfabetico'];
            $arrayFormulario['campoPassword'] = $_POST['campoPassword'];
        } else { //Código que se ejecuta antes de rellenar el formulario
            ?>
            <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
                <fieldset>
                    <legend>Login</legend>
                    <div>
                        <label>Usuario: </label>
                        <input type = "text" name = "campoAlfabetico" placeholder="Nombre de usuario"
                               value="<?php if($arrayErrores['campoAlfabetico'] == NULL && isset($_POST['campoAlfabetico'])){ echo $_POST['campoAlfabetico'];} ?>"><br>
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
                        <input type = "password" name = "campoPassword" placeholder = "Mínimo 6 caracteres"
                               value="<?php if($arrayErrores['campoPassword'] == NULL && isset($_POST['campoPassword'])){ echo $_POST['campoPassword'];} ?>"><br>
                    </div>
                    <div>
                    <?php
                    if ($arrayErrores['campoPassword'] != NULL) {
                        echo $arrayErrores['campoPassword']; //Mensaje de error que tiene el $arrayErrores
                    }
                    ?>
                    </div>
                    <div>
                        <br><input type = "submit" name = "iniciarSesion" value = "Iniciar Sesion">
                    </div>
                </fieldset>
            </form>
        <?php } ?>
    </body>
</html>  
            