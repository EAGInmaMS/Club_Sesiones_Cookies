-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2022 a las 17:23:08
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `socio` bigint(20) NOT NULL,
  `servicio` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`socio`, `servicio`, `fecha`, `hora`) VALUES
(1, 1, '2022-11-13', '13:49:00'),
(2, 1, '2022-11-13', '13:49:00'),
(3, 2, '2022-11-30', '14:48:00'),
(4, 2, '2022-10-20', '11:48:00'),
(4, 2, '2022-11-21', '14:20:00'),
(9, 2, '2022-11-21', '11:06:00'),
(12, 1, '2021-11-30', '16:09:00'),
(12, 3, '2022-10-12', '12:12:00'),
(12, 3, '2023-01-27', '19:21:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `Id` bigint(20) NOT NULL,
  `Titulo` varchar(70) COLLATE latin1_spanish_ci NOT NULL,
  `Contenido` varchar(4000) COLLATE latin1_spanish_ci NOT NULL,
  `Imagen` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`Id`, `Titulo`, `Contenido`, `Imagen`, `Fecha_publicacion`) VALUES
(15, 'jajajaj jalloweeen ', 'jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen ', '../img/fondo.png', '2022-11-09'),
(16, 'jajajaj jalloweeen ', 'jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen ', '../img/descarga.jpg', '2022-12-30'),
(23, 'jajajaj jalloweeen ', 'jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen jajajaj jalloweeen ', '../img/gestion-de-gimnasios.jpg', '2022-11-08'),
(24, 'koi ', 'koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi koi ', '../img/koi-780x470.webp', '2023-01-27'),
(25, 'Miercoles', 'LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie ', '../img/3.jpg', '2022-12-14'),
(27, 'Miercoles', 'LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie LA mejor serie ', '../img/1.jpg', '2022-12-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Id` bigint(20) NOT NULL,
  `Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Precio` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Id`, `Nombre`, `Precio`) VALUES
(16, 'Nombre de cosa', '45.00'),
(17, 'hOLA', '78.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `Id` bigint(20) NOT NULL,
  `Descripcion` varchar(70) COLLATE latin1_spanish_ci NOT NULL,
  `Duracion` int(3) NOT NULL,
  `Precio` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`Id`, `Descripcion`, `Duracion`, `Precio`) VALUES
(1, 'Masaje', 20, '20.17'),
(2, 'Coasa', 78, '9.50'),
(3, 'ñññññññ', 34, '34.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `Id` bigint(20) NOT NULL,
  `Nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Edad` tinyint(2) NOT NULL,
  `Usuario` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `Pass` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` int(9) NOT NULL,
  `Foto` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`Id`, `Nombre`, `Edad`, `Usuario`, `Pass`, `Telefono`, `Foto`) VALUES
(1, 'sdvfsd', 35, 'wgaerg', 'gdefgrfg', 660258258, '../img/rosalia-1663923566.jpg'),
(2, 'prueba2', 34, 'gvraeg', 'sdgdfg', 660000000, '../img/descarga.jpg'),
(3, 'prueba3', 34, 'gvraegh', 'dgbnfxvghm', 698752364, '../img/descarga.jpg'),
(4, 'rgvdfvg', 0, '', '', 655555555, '../img/descarga.jpg'),
(9, 'rdthrt', 85, 'rtdhrth', 'rtdhtrfyh', 666666999, '../img/rubi.jpeg'),
(11, 'prueba22', 34, '45rsdvf', 'sdfsdf', 666999881, '../img/FT1tVkWWQAATRno.jpg'),
(12, 'Antonio', 67, 'degvbderfbdr', '348753', 786543219, '../img/fondo.png'),
(13, 'fdzghdfzhfgxh', 56, 'fgdshfdhg', 'dfbfxbgnxg', 614748364, '../img/kojima-780x470.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `Id` bigint(20) NOT NULL,
  `Autor` bigint(20) NOT NULL,
  `Contenido` varchar(140) COLLATE latin1_spanish_ci NOT NULL,
  `Fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`Id`, `Autor`, `Contenido`, `Fecha`) VALUES
(17, 12, 'Que divertido Hayowin', '2022-11-01'),
(18, 2, 'Vaya puto asco Jayowin', '2022-11-08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`socio`,`servicio`,`fecha`),
  ADD KEY `cit_serv` (`servicio`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `test_soc` (`Autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `cit_serv` FOREIGN KEY (`servicio`) REFERENCES `servicio` (`Id`),
  ADD CONSTRAINT `cit_soc` FOREIGN KEY (`socio`) REFERENCES `socio` (`Id`);

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `test_soc` FOREIGN KEY (`Autor`) REFERENCES `socio` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
