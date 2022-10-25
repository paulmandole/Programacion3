-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-09-2022 a las 20:41:16
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
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo_de_barra` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL,
  `fecha_de_creacion` date DEFAULT NULL,
  `fecha_de_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo_de_barra`, `nombre`, `tipo`, `stock`, `precio`, `fecha_de_creacion`, `fecha_de_modificacion`) VALUES
(1000, 779361, 'Westmacot', 'liquido', 33, '16', '2021-02-09', '2020-09-26'),
(1001, 779362, 'Spirit', 'solido', 45, '70', '2020-09-18', '2020-04-14'),
(1002, 779363, 'Newgrosh', 'polvo', 14, '68', '2020-11-29', '2021-11-02'),
(1003, 779364, 'McNickle', 'polvo', 19, '54', '2020-11-28', '2020-04-17'),
(1004, 779365, 'Hudd', 'solido', 68, '27', '2020-12-19', '2020-06-19'),
(1005, 779366, 'Schrader', 'polvo', 17, '97', '2020-08-02', '2020-04-18'),
(1006, 779367, 'Bachellier', 'solido', 59, '69', '2021-01-30', '2020-06-07'),
(1007, 779368, 'Fleming', 'solido', 38, '67', '2020-10-26', '2020-10-03'),
(1008, 779369, 'Hurry', 'solido', 44, '43', '2020-07-04', '2020-05-30'),
(1009, 779310, 'Krauss', 'polvo', 73, '36', '2021-03-03', '2020-08-30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
