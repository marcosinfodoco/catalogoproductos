-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2016 a las 19:21:30
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `importarrecambios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listaprecios`
--

CREATE TABLE `listaprecios` (
  `linea` int(11) NOT NULL,
  `RefFabPrin` text NOT NULL,
  `Descripcion` text NOT NULL,
  `Coste` decimal(11,2) NOT NULL,
  `Estado` text NOT NULL,
  `RecambioID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciascruzadas`
--

CREATE TABLE `referenciascruzadas` (
  `linea` int(11) NOT NULL,
  `RefProveedor` text COLLATE utf8_spanish_ci NOT NULL,
  `Fabr_Recambio` text COLLATE utf8_spanish_ci NOT NULL,
  `Ref_Fabricante` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` text COLLATE utf8_spanish_ci NOT NULL,
  `RecambioID` int(11) NOT NULL,
  `IdFabricanteRec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciascruzadas_back`
--

CREATE TABLE `referenciascruzadas_back` (
  `linea` int(11) NOT NULL,
  `RefProveedor` text COLLATE utf8_spanish_ci NOT NULL,
  `Fabr_Recambio` text COLLATE utf8_spanish_ci NOT NULL,
  `Ref_Fabricante` text COLLATE utf8_spanish_ci NOT NULL,
  `Estado` text COLLATE utf8_spanish_ci NOT NULL,
  `RecambioID` int(11) NOT NULL,
  `IdFabricanteRec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referenciascversiones`
--

CREATE TABLE `referenciascversiones` (
  `RefProveedor` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `MarcaDescrip` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `ModeloVersion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `VersionAcabado` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `kw` int(2) NOT NULL,
  `cv` int(3) NOT NULL,
  `Cm3` int(4) NOT NULL,
  `Ncilindros` int(2) NOT NULL,
  `FechaInici` date NOT NULL,
  `FechaFinal` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `TipoCombustible` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
