-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2025 a las 16:21:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ifts15`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `añocursada`
--

CREATE TABLE `añocursada` (
  `id_añoCursada` int(11) NOT NULL,
  `año` int(1) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(11) NOT NULL DEFAULT 0,
  `idCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `añocursada`
--

INSERT INTO `añocursada` (`id_añoCursada`, `año`, `habilitado`, `cancelado`, `idCreate`, `idUpdate`) VALUES
(1, 1, 1, 0, '2025-09-16 20:54:25', '2025-09-16 20:54:25'),
(2, 2, 1, 0, '2025-09-16 20:54:25', '2025-09-16 20:54:25'),
(3, 3, 1, 0, '2025-09-16 20:54:25', '2025-09-16 20:54:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `id_carrera` int(11) NOT NULL,
  `carrera` varchar(255) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(11) NOT NULL DEFAULT 0,
  `idCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id_carrera`, `carrera`, `habilitado`, `cancelado`, `idCreate`, `idUpdate`) VALUES
(1, 'Realizador y Productor Televisiva', 1, 0, '2025-09-16 20:52:31', '2025-09-16 22:30:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision`
--

CREATE TABLE `comision` (
  `id_comision` int(11) NOT NULL,
  `comision` varchar(1) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(11) NOT NULL DEFAULT 0,
  `idCreate` datetime NOT NULL DEFAULT current_timestamp(),
  `idUpdate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `comision`
--

INSERT INTO `comision` (`id_comision`, `comision`, `habilitado`, `cancelado`, `idCreate`, `idUpdate`) VALUES
(1, 'A', 1, 0, '2025-09-16 17:53:28', '2025-09-16 17:54:47'),
(2, 'B', 1, 0, '2025-09-16 17:53:28', '2025-09-16 17:54:57'),
(3, 'C', 1, 0, '2025-09-16 17:53:28', '2025-09-16 17:55:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `novedades`
--

CREATE TABLE `novedades` (
  `id_novedades` int(11) NOT NULL,
  `novedad` varchar(250) NOT NULL,
  `idCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `novedades`
--

INSERT INTO `novedades` (`id_novedades`, `novedad`, `idCreate`, `idUpdate`, `habilitado`, `cancelado`) VALUES
(1, 'funciona novedades!!!!!', '2025-10-15 15:20:52', '2025-10-15 15:20:52', 1, 0),
(2, '65465465465465', '2025-10-22 14:50:25', '2025-10-22 14:50:25', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id_persona` int(11) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `nombre` varchar(30) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `dni` varchar(11) NOT NULL,
  `edad` int(3) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(1) NOT NULL DEFAULT 0,
  `idCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `apellido`, `fecha_nacimiento`, `nombre`, `telefono`, `dni`, `edad`, `habilitado`, `cancelado`, `idCreate`, `idUpdate`) VALUES
(1, 'prueba', NULL, 'prueba', '1156423659', '265528963', 18, 1, 0, '2025-09-17 22:24:24', '2025-09-17 22:24:24'),
(2, 'meli', '1978-10-16', 'melu', '115236547', '25365215', 46, 1, 0, '2025-09-29 14:02:46', '2025-09-29 14:02:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 1,
  `cancelado` int(1) NOT NULL DEFAULT 0,
  `idcCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`, `habilitado`, `cancelado`, `idcCreate`, `idUpdate`) VALUES
(1, 'Alumno', 1, 0, '2025-09-16 20:51:28', '2025-09-16 21:02:22'),
(2, 'Profesor', 1, 0, '2025-09-16 20:51:28', '2025-09-16 21:02:29'),
(3, 'Administrativo', 1, 0, '2025-09-16 20:51:28', '2025-09-16 21:02:35'),
(4, 'Directivo', 1, 0, '2025-09-16 20:51:28', '2025-09-16 21:02:41'),
(5, 'Administrador', 1, 0, '2025-10-14 15:42:13', '2025-10-14 15:42:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `id_comision` int(11) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `id_añoCursada` int(11) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `habilitado` int(1) NOT NULL DEFAULT 0,
  `cancelado` int(1) NOT NULL DEFAULT 1,
  `idCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `idUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `clave`, `id_comision`, `id_carrera`, `id_añoCursada`, `id_rol`, `id_persona`, `habilitado`, `cancelado`, `idCreate`, `idUpdate`) VALUES
(1, 'prueba@gmail.com', '$2y$12$sVaFyYEqkJ9GQk9XFoQMxuOcbIwXltz5yai4P6fxu4VKRlWBGo8Ou', 2, 1, 2, 3, 1, 1, 0, '2025-09-17 22:24:25', '2025-10-15 15:19:56'),
(2, 'melu@hotmail.com', '$2y$10$cfNr0Jv92/A/G3Gnt55rY.86vFvL2Y4XGRMeRyEOJJnJ9RFeI3ZG2', 2, 1, 3, 1, 2, 1, 0, '2025-09-29 14:02:46', '2025-09-29 14:02:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `añocursada`
--
ALTER TABLE `añocursada`
  ADD PRIMARY KEY (`id_añoCursada`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`id_carrera`);

--
-- Indices de la tabla `comision`
--
ALTER TABLE `comision`
  ADD PRIMARY KEY (`id_comision`);

--
-- Indices de la tabla `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`id_novedades`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`,`id_persona`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_carrera` (`id_carrera`,`id_añoCursada`),
  ADD KEY `id_comision` (`id_comision`),
  ADD KEY `id_añoCursada` (`id_añoCursada`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `añocursada`
--
ALTER TABLE `añocursada`
  MODIFY `id_añoCursada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comision`
--
ALTER TABLE `comision`
  MODIFY `id_comision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `novedades`
--
ALTER TABLE `novedades`
  MODIFY `id_novedades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`id_añoCursada`) REFERENCES `añocursada` (`id_añoCursada`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_4` FOREIGN KEY (`id_comision`) REFERENCES `comision` (`id_comision`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_5` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
