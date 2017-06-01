SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `zeal` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `zeal`;

DROP TABLE IF EXISTS `Usuarios`;
CREATE TABLE `Usuarios` (
  `codUsuario` int(11) NOT NULL,
  `usuario` varchar(32) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `token` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`codUsuario`);


ALTER TABLE `Usuarios`
  MODIFY `codUsuario` int(11) NOT NULL AUTO_INCREMENT
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
