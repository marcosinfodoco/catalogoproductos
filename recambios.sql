-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2016 a las 19:21:44
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recambios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `crucesreferencias`
--

CREATE TABLE `crucesreferencias` (
  `id` int(11) NOT NULL,
  `idReferenciaCruz` int(11) NOT NULL,
  `idRecambio` int(11) NOT NULL,
  `idFabricanteCruz` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fabricantesrecambios`
--

CREATE TABLE `fabricantesrecambios` (
  `id` int(11) NOT NULL,
  `Nombre` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `Descripcion` varchar(100) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiasrecambios`
--

CREATE TABLE `familiasrecambios` (
  `id` int(11) NOT NULL,
  `id_Padre` int(11) NOT NULL,
  `Familia_es` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recambios`
--

CREATE TABLE `recambios` (
  `id` int(11) NOT NULL,
  `Descripcion` text NOT NULL,
  `coste` decimal(11,2) NOT NULL,
  `margen` int(3) NOT NULL,
  `iva` int(2) NOT NULL,
  `pvp` decimal(11,2) NOT NULL,
  `IDFabricante` int(11) NOT NULL,
  `FechaActualiza` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recambiosfamilias`
--

CREATE TABLE `recambiosfamilias` (
  `id` int(11) NOT NULL,
  `IdRecambio` int(111) NOT NULL,
  `IdFamilia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciascruzadas`
--

CREATE TABLE `referenciascruzadas` (
  `id` int(11) NOT NULL,
  `RecambioID` int(11) NOT NULL,
  `IdFabricanteCru` int(11) NOT NULL,
  `RefFabricanteCru` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `crucesreferencias`
--
ALTER TABLE `crucesreferencias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fabricantesrecambios`
--
ALTER TABLE `fabricantesrecambios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `familiasrecambios`
--
ALTER TABLE `familiasrecambios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recambios`
--
ALTER TABLE `recambios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recambiosfamilias`
--
ALTER TABLE `recambiosfamilias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `referenciascruzadas`
--
ALTER TABLE `referenciascruzadas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `crucesreferencias`
--
ALTER TABLE `crucesreferencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT de la tabla `fabricantesrecambios`
--
ALTER TABLE `fabricantesrecambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;
--
-- AUTO_INCREMENT de la tabla `familiasrecambios`
--
ALTER TABLE `familiasrecambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `recambios`
--
ALTER TABLE `recambios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=664;
--
-- AUTO_INCREMENT de la tabla `recambiosfamilias`
--
ALTER TABLE `recambiosfamilias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=664;
--
-- AUTO_INCREMENT de la tabla `referenciascruzadas`
--
ALTER TABLE `referenciascruzadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1241;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
