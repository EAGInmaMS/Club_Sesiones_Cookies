-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2023 a las 08:50:11
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
(30, 8, '2023-01-27', '16:40:00'),
(30, 9, '2023-02-16', '10:27:00'),
(35, 9, '2023-01-18', '11:27:00');

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
(28, 'Para la vuelta al \'gym\', toma nota', 'Enero está lleno de propósitos y uno de los más repetidos por todo el mundo es apuntarse al gimnasio. Si ya has pasado el umbral de pagar la matrícula, comprarte el material y abonar la primera mensualidad, hay algo importante en lo que, quizá, no has reparado: el candado para la taquilla. Hay gimnasios en los que este artículo se proporciona y los modelos que dan son numéricos y seguros, pero, hay otros establecimientos donde es obligatorio que cada persona lleve un candado de casa por seguridad. Si este último es tu caso, igual te preguntas: ¿cuáles son los candados más seguros para una taquilla? Desde 20deCompras hemos señalado una lista de características que deben tener los candados para que sean seguros y cómodos para un gimnasio, así como varias opciones por si todavía no tienes uno.', '../img/candado-taquilla-numerico-pixabay.jpeg', '2023-01-17'),
(29, 'La seleccionadora italiana de rítmica, a juicio', 'La histórica seleccionadora italiana de gimnasia femenina, Emanuela Maccarani, que lleva al frente del equipo casi 27 años; y su ayudante, Olga Tishina, serán juzgadas por la justicia deportiva por someter a vejaciones y malos tratos psicológicos a las integrantes del equipo nacional que entrenaban bajo sus órdenes.\r\n\r\nLas entrenadoras recibieron este miércoles la notificación en las que se las comunicaba que serán llevadas a juicio tras las investigaciones llevadas a cabo por la Fiscalía de la Federación de Gimnasia de Italia (FGI).', '../img/el-equipo-italiano-en-los-jjoo-de-tokio-2020.jpeg', '2023-01-27'),
(31, '10 regalos de Navidad para amantes del fitness', 'Si estás buscado el regalo perfecto para un apasionado/a del deporte hay muchas ideas más allá de la ropa de entrenamiento o equipación para el gimnasio.\r\n\r\nEn Myprotein tienen un amplio catálogo con el que inspirarte y, además, puedes beneficiarte de un ahorro extra del 42% gracias a nuestro código descuento MyProtein exclusivo.', '../img/fotonoticia.jpeg', '2022-12-15'),
(32, 'Anorexia... la pandemia que nadie quiere ver', 'Es probable que gran parte de las personas que lean este artículo puedan estar viviendo en primera persona, o en un familiar, o en un compañer@ de clase o de trabajo, lo que supone un Trastorno de Conducta Alimentaria (TCA)… ¡incluso muchos sin saberlo! \r\n\r\nPensamos en la anorexia y se nos vienen a la cabeza imágenes de adolescentes extremadamente delgadas, cuando en realidad ese es el último estadio al que se ven abocados los pacientes, siendo aún muy superior el número de mujeres que hombres, cuando ya la enfermedad ha atrapado absolutamente a la persona, su vida es ya un infierno, e incluso en muchos casos corre peligro. \r\n\r\n', '../img/bulimia-anorexia.jpeg', '2022-12-01');

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
(18, 'Pesas', '45.00'),
(19, 'Set Mancuernas', '67.00'),
(20, 'Mancuernas 20Kg', '56.98');

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
(6, 'Entrenamiento', 45, '45.00'),
(8, 'Masaje de espalda', 67, '90.00'),
(9, 'Piscina', 34, '20.78');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `Id` bigint(20) NOT NULL,
  `Nombre` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Edad` tinyint(2) NOT NULL,
  `Usuario` varchar(30) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Pass` varchar(80) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Telefono` varchar(9) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Foto` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`Id`, `Nombre`, `Edad`, `Usuario`, `Pass`, `Telefono`, `Foto`) VALUES
(0, 'Administrador', 0, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '', ''),
(30, 'Antonio', 18, 'toño2001', '06aa6cff19411c58bcc4a43508f03f5f', '698741238', '../img/fotoperfil.webp'),
(35, 'Alba', 23, 'meieff', 'a6181340338ed9d68a2edab60b004525', '678534215', '../img/8081307-foto-genérica-de-una-mujer-casualmente-vestido-con-una-camisa-azul-y-blue-jeans-.webp');

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
(19, 30, 'El mejor gimnasio en el que he estado sin duda', '2023-01-19'),
(21, 35, 'La piscina es enorme!', '2023-01-23');

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
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
