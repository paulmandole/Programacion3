-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2022 a las 02:05:52
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `utn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `fecha_de_registro` date DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `clave`, `mail`, `fecha_de_registro`, `localidad`) VALUES
(1009, 'Esteban', 'Madou', '2345', 'dkantor0@example.com', '2021-07-01', 'Quilmes'),
(1010, 'German', 'Gerram', '1234', 'german@gmail.com', '2020-02-01', 'Berazategui'),
(1011, 'Deloris', 'Fosis', '5678', 'deloris@gmail.com', '2020-03-01', 'Avellaneda'),
(1012, 'Brok', 'Neiner', '4567', 'brok@gmail.com', '2020-04-01', 'Quilmes'),
(1013, 'Garrick', 'Brent', '6789', 'garrick@gmail.com', '2020-05-01', 'Moron'),
(1014, 'Bili', 'Baus', '123', 'bili@gmail.com', '2020-06-01', 'Moreno'),
(1015, 'Esteban', 'Madou', '2345', 'dkantor0@example.com', '2021-07-01', 'Quilmes'),
(1016, 'German', 'Gerram', '1234', 'german@gmail.com', '2020-02-01', 'Berazategui'),
(1017, 'Deloris', 'Fosis', '5678', 'deloris@gmail.com', '2020-03-01', 'Avellaneda'),
(1018, 'Brok', 'Neiner', '4567', 'brok@gmail.com', '2020-04-01', 'Quilmes'),
(1019, 'Garrick', 'Brent', '6789', 'garrick@gmail.com', '2020-05-01', 'Moron'),
(1020, 'Bili', 'Baus', '123', 'bili@gmail.com', '2020-06-01', 'Moreno');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1021;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
