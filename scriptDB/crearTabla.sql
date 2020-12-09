/**
 * Author:  Arkaitz Rodriguez
 * Created: 27-10-2020
*/

/*
    Seleccionamos la base de datos que acabamos de crear
*/
USE db771560304;

/*
    Creamos tabla si no existe y los campos correspondientes, 
    en el caso de que exista no la crearemos,
    usaremos el motor InnoDB para la integridad referencial
*/

/*
APP MTO DEPARTAMENTOS
CREATE TABLE IF NOT EXISTS Departamento(
    CodDepartamento varchar(3) primary key,
    DescDepartamento varchar(255),
    FechaBaja date,
    VolumenNegocio float
)engine=InnoDB;
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