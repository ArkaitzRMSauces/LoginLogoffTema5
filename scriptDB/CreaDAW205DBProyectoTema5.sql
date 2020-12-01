/**
 * Author:  Arkaitz Rodriguez
 * Created: 25-11-2020
*/
/*
    Creamos Base de datos si no existe, en el caso de que exista no la crearemos
*/
CREATE DATABASE IF NOT EXISTS DAW205DBProyectoTema5;

/*
    Seleccionamos la base de datos que acabamos de crear
*/
USE DAW205DBProyectoTema5;

/*
    Creamos tabla si no existe y los campos correspondientes, 
    en el caso de que exista no la crearemos,
    usaremos el motor InnoDB para la integridad referencial
*/
CREATE TABLE IF NOT EXISTS T02_Departamento(
    T02_CodDepartamento varchar(3) primary key,
    T02_DescDepartamento varchar(255),
    T02_FechaBaja date,
    T02_VolumenNegocio float
)engine=InnoDB;
CREATE TABLE IF NOT EXISTS T01_Usuario(
    T01_CodUsuario VARCHAR(15) PRIMARY KEY,
    T01_DescUsuario VARCHAR(25) NOT NULL,
    T01_Password VARCHAR(64) NOT NULL,
    T01_Perfil enum('administrador', 'usuario') DEFAULT 'usuario', -- Valor por defecto usuario
    T01_FechaHoraUltimaConexion INT,
    T01_NumConexiones INT DEFAULT 0,
    T01_ImagenUsuario MEDIUMBLOB
)engine=InnoDB;

/*
    Creamos usuario en el caso de que no exista
*/
CREATE USER IF NOT EXISTS 'usuarioDAW205DBProyectoTema5'@'%' IDENTIFIED BY 'paso';

/*
    Damos permisos al usuario para poder administrar la base de datos
*/
GRANT ALL PRIVILEGES ON DAW205DBProyectoTema5.* TO 'usuarioDAW205DBProyectoTema5'@'%';
