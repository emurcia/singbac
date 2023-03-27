-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-03-2023 a las 10:36:04
-- Versión del servidor: 5.6.41-84.1
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `singbac`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_agricultor`
--

CREATE TABLE `tab_agricultor` (
  `zona` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `dui_agricultor` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `nom_agricultor` text COLLATE latin1_spanish_ci NOT NULL,
  `ape_agricultor` text COLLATE latin1_spanish_ci NOT NULL,
  `propiedad` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `area_cultiva` double NOT NULL,
  `oficio` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `tel_agricultor` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `direccion` text COLLATE latin1_spanish_ci NOT NULL,
  `id_usuario_ingreso` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `hora_ingreso` time NOT NULL,
  `id_usuario_modifica` varchar(8) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `id_empresa` int(2) NOT NULL,
  `eliminado` int(1) NOT NULL,
  `ninos` int(2) NOT NULL,
  `adultos` int(2) NOT NULL,
  `terceraedad` int(2) NOT NULL,
  `canasta` varchar(2) COLLATE latin1_spanish_ci NOT NULL,
  `nom_depto` text COLLATE latin1_spanish_ci NOT NULL,
  `nom_municipio` text COLLATE latin1_spanish_ci NOT NULL,
  `spmaiz` int(1) NOT NULL,
  `spfrijol` int(1) NOT NULL,
  `spsorgo` int(1) NOT NULL,
  `spcafe` int(1) NOT NULL,
  `ssmaiz` int(1) NOT NULL,
  `ssfrijol` int(1) NOT NULL,
  `sssorgo` int(1) NOT NULL,
  `sscafe` int(1) NOT NULL,
  `epoca_siembra` text COLLATE latin1_spanish_ci NOT NULL,
  `nucleo_familiar` int(2) NOT NULL,
  `invierno` int(1) NOT NULL,
  `postrera` int(1) NOT NULL,
  `apante` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_ajuste`
--

CREATE TABLE `tab_ajuste` (
  `id_ajuste` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `entrada` int(20) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `peso_bruto_entrada` double NOT NULL,
  `peso_tara_entrada` double NOT NULL,
  `peso_teorico_entrada` double NOT NULL,
  `peso_humedad_entrada` double NOT NULL,
  `peso_bruto_salida` double NOT NULL,
  `peso_tara_salida` double NOT NULL,
  `peso_teorico_salida` double NOT NULL,
  `peso_humedad_salida` double NOT NULL,
  `id_inventario` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `peso_humedad_inventario` double NOT NULL,
  `humedad_maximo_inventario` double NOT NULL,
  `nuevo_peso_bruto` double NOT NULL,
  `nuevo_peso_tara` double NOT NULL,
  `nuevo_peso_teorico` double NOT NULL,
  `nuevo_peso_humedad` double NOT NULL,
  `comentario_ajuste` text COLLATE latin1_spanish_ci NOT NULL,
  `id_usuario2_ajuste` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_usuario_ajuste` date NOT NULL,
  `hora_usuario_ajuste` time NOT NULL,
  `id_usuario_autoriza` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_usuario_autoriza` date NOT NULL,
  `hora_usuario_autoriza` time NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_almacenaje`
--

CREATE TABLE `tab_almacenaje` (
  `id_almacenaje` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `entrada` int(20) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_servicio` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `peso_teorico` double NOT NULL,
  `tipo_peso` int(2) NOT NULL,
  `peso_bruto` double NOT NULL,
  `peso_tara` double NOT NULL,
  `id_variable` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `peso_vol` double NOT NULL,
  `humedad` double NOT NULL,
  `temperatura` double NOT NULL,
  `grano_entero` double NOT NULL,
  `grano_quebrado` double NOT NULL,
  `dan_hongo` double NOT NULL,
  `impureza` double NOT NULL,
  `grano_chico` double NOT NULL,
  `grano_picado` double NOT NULL,
  `plaga_viva` double NOT NULL,
  `plaga_muerta` double NOT NULL,
  `stress_crack` double NOT NULL,
  `olor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '1 En espera, 2 completo',
  `id_transportista` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `vapor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nom_analista` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `neto_sin_humedad` double NOT NULL COMMENT 'realizar formula para calcular',
  `id_empresa` int(11) NOT NULL,
  `neto_sin_humedad_maximo` double NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `id_usuario_mod_indicador` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fec_mod_indicador` date NOT NULL,
  `hor_mod_indicador` time NOT NULL,
  `nuevo_indicador` int(1) NOT NULL COMMENT '0 no almacenado, 1 almacenado ',
  `peso_completo` int(1) NOT NULL COMMENT '0 no, 1 si '
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_bascula`
--

CREATE TABLE `tab_bascula` (
  `id_bascula` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `entrada` int(20) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_transportista` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_producto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_subproducto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `opcion_peso` int(2) NOT NULL COMMENT '1 peso bruto, 2 peso tara, 3 peso unico',
  `peso_bruto` double(12,2) NOT NULL,
  `peso_tara` double(12,2) NOT NULL,
  `peso_unico` double(12,2) NOT NULL,
  `destino` text COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_bitacora`
--

CREATE TABLE `tab_bitacora` (
  `id_bitacora` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_usuario` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `estado_bitacora` int(2) NOT NULL COMMENT '0 sesion activa, 1 sesion cerrada'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_checaje`
--

CREATE TABLE `tab_checaje` (
  `id` int(11) NOT NULL,
  `var1` double(12,2) DEFAULT NULL,
  `var2` double(12,2) DEFAULT NULL,
  `var3` double(12,2) DEFAULT NULL,
  `var4` double(12,2) DEFAULT NULL,
  `var5` double(12,2) DEFAULT NULL,
  `var6` double(12,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_cliente`
--

CREATE TABLE `tab_cliente` (
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_cliente` text COLLATE latin1_spanish_ci NOT NULL,
  `dir_cliente` text COLLATE latin1_spanish_ci NOT NULL,
  `tel_cliente` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `ape_responsable` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nom_responsable` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `dir_responsable` text COLLATE latin1_spanish_ci NOT NULL,
  `tel_responsable` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(11) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `bandera` int(2) NOT NULL,
  `tipo_cliente` int(1) NOT NULL,
  `otros_indicadores` int(1) NOT NULL,
  `asignado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_contador`
--

CREATE TABLE `tab_contador` (
  `codigo` int(10) NOT NULL,
  `total` int(11) NOT NULL,
  `entrada_almacen` int(11) NOT NULL,
  `salida_almacen` int(11) NOT NULL,
  `servicio_bascula` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `reversion_entrada` int(11) NOT NULL,
  `reversion_salida` int(11) NOT NULL,
  `cierre_lote` int(11) NOT NULL,
  `num_lote` int(11) NOT NULL,
  `num_ajuste` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci COMMENT='perdida tabalmacen 14, tabsalida 5, tabbascula 32 por prueba';

--
-- Volcado de datos para la tabla `tab_contador`
--

INSERT INTO `tab_contador` (`codigo`, `total`, `entrada_almacen`, `salida_almacen`, `servicio_bascula`, `id_empresa`, `reversion_entrada`, `reversion_salida`, `cierre_lote`, `num_lote`, `num_ajuste`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_detalle_cliente`
--

CREATE TABLE `tab_detalle_cliente` (
  `id_cliente_principal` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_cliente_secundario` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_detalle_menu`
--

CREATE TABLE `tab_detalle_menu` (
  `id_nivel` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tab_detalle_menu`
--

INSERT INTO `tab_detalle_menu` (`id_nivel`, `id_menu`, `id_empresa`) VALUES
('NIV-0011', 93, 1),
('NIV-0011', 1, 1),
('NIV-0011', 110, 1),
('NIV-0011', 93, 1),
('NIV-0011', 90, 1),
('NIV-0011', 91, 1),
('NIV-0011', 92, 1),
('NIV-0011', 110, 1),
('NIV-0011', 111, 1),
('NIV-0021', 1, 1),
('NIV-0021', 110, 1),
('NIV-0021', 111, 1),
('NIV-0021', 67, 1),
('NIV-0021', 69, 1),
('NIV-0021', 70, 1),
('NIV-0021', 71, 1),
('NIV-0021', 72, 1),
('NIV-0021', 73, 1),
('NIV-0021', 74, 1),
('NIV-0021', 75, 1),
('NIV-0021', 76, 1),
('NIV-0021', 77, 1),
('NIV-0021', 78, 1),
('NIV-0021', 80, 1),
('NIV-0021', 81, 1),
('NIV-0031', 1, 1),
('NIV-0031', 110, 1),
('NIV-0031', 111, 1),
('NIV-0031', 10, 1),
('NIV-0031', 11, 1),
('NIV-0031', 21, 1),
('NIV-0031', 31, 1),
('NIV-0031', 12, 1),
('NIV-0031', 22, 1),
('NIV-0031', 32, 1),
('NIV-0031', 20, 1),
('NIV-0031', 11, 1),
('NIV-0031', 21, 1),
('NIV-0031', 31, 1),
('NIV-0031', 12, 1),
('NIV-0031', 22, 1),
('NIV-0031', 32, 1),
('NIV-0031', 30, 1),
('NIV-0031', 11, 1),
('NIV-0031', 21, 1),
('NIV-0031', 31, 1),
('NIV-0031', 12, 1),
('NIV-0031', 22, 1),
('NIV-0031', 32, 1),
('NIV-0031', 40, 1),
('NIV-0031', 41, 1),
('NIV-0031', 42, 1),
('NIV-0031', 43, 1),
('NIV-0031', 44, 1),
('NIV-0031', 45, 1),
('NIV-0031', 46, 1),
('NIV-0031', 50, 1),
('NIV-0031', 51, 1),
('NIV-0031', 50, 1),
('NIV-0031', 51, 1),
('NIV-0031', 52, 1),
('NIV-0031', 60, 1),
('NIV-0031', 61, 1),
('NIV-0031', 62, 1),
('NIV-0031', 67, 1),
('NIV-0031', 69, 1),
('NIV-0031', 70, 1),
('NIV-0031', 71, 1),
('NIV-0031', 72, 1),
('NIV-0031', 73, 1),
('NIV-0031', 74, 1),
('NIV-0031', 75, 1),
('NIV-0031', 76, 1),
('NIV-0031', 77, 1),
('NIV-0031', 78, 1),
('NIV-0031', 80, 1),
('NIV-0031', 81, 1),
('NIV-0011', 67, 1),
('NIV-0011', 70, 1),
('NIV-0011', 71, 1),
('NIV-0011', 72, 1),
('NIV-0011', 73, 1),
('NIV-0011', 74, 1),
('NIV-0011', 75, 1),
('NIV-0011', 76, 1),
('NIV-0011', 77, 1),
('NIV-0011', 80, 1),
('NIV-0011', 81, 1),
('NIV-0011', 21, 1),
('NIV-0011', 31, 1),
('NIV-0011', 22, 1),
('NIV-0011', 32, 1),
('NIV-0011', 20, 1),
('NIV-0011', 30, 1),
('NIV-0011', 69, 1),
('NIV-0011', 40, 1),
('NIV-0011', 41, 1),
('NIV-0011', 42, 1),
('NIV-0011', 44, 1),
('NIV-0011', 43, 1),
('NIV-0011', 45, 1),
('NIV-0011', 46, 1),
('NIV-0011', 50, 1),
('NIV-0011', 51, 1),
('NIV-0011', 50, 1),
('NIV-0011', 51, 1),
('NIV-0011', 52, 1),
('NIV-0011', 10, 1),
('NIV-0011', 11, 1),
('NIV-0011', 21, 1),
('NIV-0011', 31, 1),
('NIV-0011', 12, 1),
('NIV-0011', 22, 1),
('NIV-0011', 32, 1),
('NIV-0011', 60, 1),
('NIV-0011', 61, 1),
('NIV-0011', 62, 1),
('NIV-0011', 78, 1),
('NIV-0041', 1, 1),
('NIV-0041', 110, 1),
('NIV-0041', 111, 1),
('NIV-0041', 80, 1),
('NIV-0041', 82, 1),
('NIV-0011', 82, 1),
('NIV-0011', 100, 1),
('NIV-0011', 101, 1),
('NIV-0031', 100, 1),
('NIV-0031', 101, 1),
('NIV-0011', 102, 1),
('NIV-0031', 102, 1),
('NIV-0011', 103, 1),
('NIV-0031', 103, 1),
('NIV-0011', 83, 1),
('NIV-0031', 83, 1),
('NIV-0011', 104, 1),
('NIV-0031', 104, 1),
('NIV-0051', 1, 1),
('NIV-0051', 110, 1),
('NIV-0051', 111, 1),
('NIV-0051', 10, 1),
('NIV-0051', 12, 1),
('NIV-0051', 22, 1),
('NIV-0051', 32, 1),
('NIV-0051', 11, 1),
('NIV-0051', 21, 1),
('NIV-0051', 31, 1),
('NIV-0051', 20, 1),
('NIV-0051', 11, 1),
('NIV-0051', 21, 1),
('NIV-0051', 31, 1),
('NIV-0051', 12, 1),
('NIV-0051', 22, 1),
('NIV-0051', 32, 1),
('NIV-0051', 30, 1),
('NIV-0051', 11, 1),
('NIV-0051', 21, 1),
('NIV-0051', 31, 1),
('NIV-0051', 12, 1),
('NIV-0051', 22, 1),
('NIV-0051', 32, 1),
('NIV-0051', 40, 1),
('NIV-0051', 41, 1),
('NIV-0051', 42, 1),
('NIV-0051', 43, 1),
('NIV-0051', 44, 1),
('NIV-0051', 45, 1),
('NIV-0051', 46, 1),
('NIV-0051', 50, 1),
('NIV-0051', 51, 1),
('NIV-0051', 50, 1),
('NIV-0051', 51, 1),
('NIV-0051', 52, 1),
('NIV-0051', 60, 1),
('NIV-0051', 61, 1),
('NIV-0051', 62, 1),
('NIV-0051', 67, 1),
('NIV-0051', 69, 1),
('NIV-0051', 70, 1),
('NIV-0051', 71, 1),
('NIV-0051', 72, 1),
('NIV-0051', 73, 1),
('NIV-0051', 74, 1),
('NIV-0051', 75, 1),
('NIV-0051', 76, 1),
('NIV-0051', 77, 1),
('NIV-0051', 78, 1),
('NIV-0051', 80, 1),
('NIV-0051', 81, 1),
('NIV-0051', 82, 1),
('NIV-0051', 83, 1),
('NIV-0051', 100, 1),
('NIV-0051', 101, 1),
('NIV-0051', 102, 1),
('NIV-0051', 103, 1),
('NIV-0051', 104, 1),
('NIV-0011', 68, 1),
('NIV-0031', 68, 1),
('NIV-0061', 1, 1),
('NIV-0061', 110, 1),
('NIV-0061', 111, 1),
('NIV-0071', 1, 1),
('NIV-0071', 110, 1),
('NIV-0071', 111, 1),
('NIV-0071', 85, 1),
('NIV-0011', 85, 1),
('NIV-0011', 86, 1),
('NIV-0071', 86, 1),
('NIV-0011', 84, 1),
('NIV-0031', 84, 1),
('NIV-0031', 63, 1),
('NIV-0011', 63, 1),
('NIV-0011', 105, 1),
('NIV-0011', 79, 1),
('NIV-0031', 105, 1),
('NIV-0031', 79, 1),
('NIV-0021', 100, 1),
('NIV-0021', 79, 1),
('NIV-0011', 64, 1),
('NIV-0011', 65, 1),
('NIV-0031', 64, 1),
('NIV-0031', 65, 1),
('NIV-0021', 64, 1),
('NIV-0021', 65, 1),
('NIV-0081', 1, 1),
('NIV-0081', 71, 1),
('NIV-0081', 72, 1),
('NIV-0081', 10, 1),
('NIV-0081', 11, 1),
('NIV-0081', 21, 1),
('NIV-0081', 31, 1),
('NIV-0081', 30, 1),
('NIV-0081', 12, 1),
('NIV-0081', 22, 1),
('NIV-0081', 32, 1),
('NIV-0081', 20, 1),
('NIV-0081', 11, 1),
('NIV-0081', 21, 1),
('NIV-0081', 31, 1),
('NIV-0081', 12, 1),
('NIV-0081', 22, 1),
('NIV-0081', 32, 1),
('NIV-0081', 11, 1),
('NIV-0081', 21, 1),
('NIV-0081', 31, 1),
('NIV-0081', 12, 1),
('NIV-0081', 22, 1),
('NIV-0081', 32, 1),
('NIV-0081', 40, 1),
('NIV-0081', 41, 1),
('NIV-0081', 42, 1),
('NIV-0081', 43, 1),
('NIV-0081', 45, 1),
('NIV-0081', 44, 1),
('NIV-0081', 46, 1),
('NIV-0081', 50, 1),
('NIV-0081', 51, 1),
('NIV-0081', 50, 1),
('NIV-0081', 51, 1),
('NIV-0081', 52, 1),
('NIV-0081', 60, 1),
('NIV-0081', 61, 1),
('NIV-0081', 62, 1),
('NIV-0081', 63, 1),
('NIV-0081', 64, 1),
('NIV-0081', 65, 1),
('NIV-0081', 67, 1),
('NIV-0081', 68, 1),
('NIV-0081', 69, 1),
('NIV-0081', 70, 1),
('NIV-0081', 73, 1),
('NIV-0081', 74, 1),
('NIV-0081', 75, 1),
('NIV-0081', 76, 1),
('NIV-0081', 77, 1),
('NIV-0081', 78, 1),
('NIV-0081', 79, 1),
('NIV-0081', 80, 1),
('NIV-0081', 81, 1),
('NIV-0081', 82, 1),
('NIV-0081', 83, 1),
('NIV-0081', 84, 1),
('NIV-0081', 100, 1),
('NIV-0081', 101, 1),
('NIV-0081', 102, 1),
('NIV-0081', 103, 1),
('NIV-0081', 104, 1),
('NIV-0081', 105, 1),
('NIV-0081', 110, 1),
('NIV-0081', 111, 1),
('NIV-0091', 1, 1),
('NIV-0091', 110, 1),
('NIV-0091', 111, 1),
('NIV-0091', 67, 1),
('NIV-0091', 71, 1),
('NIV-0091', 72, 1),
('NIV-0091', 73, 1),
('NIV-0091', 74, 1),
('NIV-0091', 75, 1),
('NIV-0091', 76, 1),
('NIV-0091', 77, 1),
('NIV-0091', 78, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_detalle_servicio`
--

CREATE TABLE `tab_detalle_servicio` (
  `id_detalle` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `num_lote` int(11) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_producto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_subproducto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `cant_producto` int(11) NOT NULL,
  `id_origen` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_servicio` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '0 activo, 1 inactivo',
  `num_servicio` int(2) NOT NULL COMMENT 'correlativo de los servicios que se le asignaron al lote'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_indicadoresdespacho`
--

CREATE TABLE `tab_indicadoresdespacho` (
  `id_indicadoressalida` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_salida` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `humedad` double NOT NULL,
  `humedad_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `humedad_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `temperatura` double NOT NULL,
  `temperatura_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `temperatura_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_bola` double NOT NULL,
  `grano_bola_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_bola_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_chico` double NOT NULL,
  `grano_chico_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_chico_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_roto` double NOT NULL,
  `grano_roto_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `grano_roto_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `impureza` double NOT NULL,
  `impureza_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `impureza_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `otras_variedades` double NOT NULL,
  `otras_variedades_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `otras_variedades_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `piedras` double NOT NULL,
  `piedras_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `piedras_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `infestacion` double NOT NULL,
  `infestacion_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `infestacion_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `retencion_malla` double NOT NULL,
  `retencion_malla_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `retencion_malla_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `suma_granos_danados` double NOT NULL,
  `suma_granos_danados_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `suma_granos_danados_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `calor` double NOT NULL,
  `calor_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `calor_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `insecto` double NOT NULL,
  `insecto_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `insecto_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `hongo` double NOT NULL,
  `hongo_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `hongo_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `germinacion` double NOT NULL,
  `germinacion_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `germinacion_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `peso_100_granos` double NOT NULL,
  `peso_100_granos_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `peso_100_granos_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `longitud_20_granos` double NOT NULL,
  `longitud_20_granos_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `longitud_20_granos_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `densidad` double NOT NULL,
  `densidad_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `densidad_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `aflotoxinas` double NOT NULL,
  `aflotoxinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `aflotoxinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `fumonisinas` double NOT NULL,
  `fumonisinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `fumonisinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `vomitoxinas` double NOT NULL,
  `vomitoxinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `vomitoxinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `stress_crack` double NOT NULL,
  `stress_crack_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `stress_crack_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `flotadores` double NOT NULL,
  `flotadores_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `flotadores_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `nom_analista` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_indicadoresrecepcion`
--

CREATE TABLE `tab_indicadoresrecepcion` (
  `id_indicadores` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_almacenaje` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `humedad` double NOT NULL,
  `humedad_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `humedad_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `temperatura` double NOT NULL,
  `temperatura_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `temperatura_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_bola` double NOT NULL,
  `grano_bola_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_bola_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_chico` double NOT NULL,
  `grano_chico_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_chico_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_roto` double NOT NULL,
  `grano_roto_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `grano_roto_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `impureza` double NOT NULL,
  `impureza_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `impureza_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `otras_variedades` double NOT NULL,
  `otras_variedades_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `otras_variedades_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `piedras` double NOT NULL,
  `piedras_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `piedras_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `infestacion` double NOT NULL,
  `infestacion_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `infestacion_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `retencion_malla` double NOT NULL,
  `retencion_malla_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `retencion_malla_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `suma_granos_danados` double NOT NULL,
  `suma_granos_danados_rojo` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `suma_granos_danados_verde` int(1) NOT NULL COMMENT ' 0, no, 1, si ',
  `calor` double NOT NULL,
  `calor_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `calor_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `insecto` double NOT NULL,
  `insecto_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `insecto_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `hongo` double NOT NULL,
  `hongo_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `hongo_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `germinacion` double NOT NULL,
  `germinacion_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `germinacion_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `peso_100_granos` double NOT NULL,
  `peso_100_granos_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `peso_100_granos_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `longitud_20_granos` double NOT NULL,
  `longitud_20_granos_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `longitud_20_granos_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `densidad` double NOT NULL,
  `densidad_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `densidad_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `aflotoxinas` double NOT NULL,
  `aflotoxinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `aflotoxinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `fumonisinas` double NOT NULL,
  `fumonisinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `fumonisinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `vomitoxinas` double NOT NULL,
  `vomitoxinas_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `vomitoxinas_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `stress_crack` double NOT NULL,
  `stress_crack_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `stress_crack_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `flotadores` double NOT NULL,
  `flotadores_rojo` int(1) NOT NULL COMMENT '0, no, 1, si',
  `flotadores_verde` int(1) NOT NULL COMMENT '0, no, 1, si',
  `nom_analista` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_inventario`
--

CREATE TABLE `tab_inventario` (
  `id_inventario` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `capacidad_lote` double NOT NULL,
  `movimiento_lote` double NOT NULL COMMENT 'SI ALMACENA SUMA, SI SACA RESTA. ',
  `peso_sin_humedad` double NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `peso_sin_humedad_maximo` double NOT NULL,
  `num_ajuste` int(3) NOT NULL COMMENT 'Suma el numero de ajustes realizados.'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_kardex`
--

CREATE TABLE `tab_kardex` (
  `id_kardex` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_almacenaje` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_salida` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_lote`
--

CREATE TABLE `tab_lote` (
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `num_lote` int(11) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_producto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_subproducto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `cant_producto` int(11) NOT NULL,
  `id_origen` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '0 activo, 1 inactivo',
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `id_usuario_desactiva` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_desactiva` date NOT NULL,
  `hora_desactiva` time NOT NULL,
  `comentario_cierre` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_medida`
--

CREATE TABLE `tab_medida` (
  `id_medida` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_medida` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `conversion` double NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tab_medida`
--

INSERT INTO `tab_medida` (`id_medida`, `nom_medida`, `conversion`, `id_empresa`, `id_usuario2`, `ocupado`, `fecha_usuario`, `hora_usuario`, `id_usuario_modifica`, `fecha_modifica`, `hora_modifica`) VALUES
('UMED-0001', '', 0, 1, '', 0, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00'),
('UMED-0011', 'TONELADAS', 1000, 1, 'USU-0111', 1, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_menu`
--

CREATE TABLE `tab_menu` (
  `id_menu` int(11) NOT NULL,
  `opcion_menu` varchar(50) CHARACTER SET utf8 NOT NULL,
  `url_menu` varchar(100) CHARACTER SET utf8 NOT NULL,
  `nivel_menu` int(11) NOT NULL,
  `acceso_menu` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tab_menu`
--

INSERT INTO `tab_menu` (`id_menu`, `opcion_menu`, `url_menu`, `nivel_menu`, `acceso_menu`, `id_empresa`) VALUES
(1, 'Inicio', 'f_principal.php', 1, 0, 1),
(10, 'Recepción', 'f_principal.php', 1, 0, 1),
(11, 'Nuevo Peso', 'http://localhost/bascula/?direccion=https://singbac.sigenesis.net/forms/f_almacenaje.php', 2, 0, 1),
(12, 'Completar Peso', '../forms/f_almacenaje_cola.php', 2, 0, 1),
(20, 'Despacho', 'f_principal.php', 1, 0, 1),
(21, 'Nuevo Peso', 'http://localhost/bascula/?direccion=https://singbac.sigenesis.net/forms/f_salida.php', 2, 0, 1),
(22, 'Completar Peso', '../forms/f_salida_cola.php', 2, 0, 1),
(30, 'Báscula', 'f_principal.php', 1, 0, 1),
(31, 'Nuevo Peso', 'http://localhost/bascula/?direccion=https://singbac.sigenesis.net/forms/f_bascula.php', 2, 0, 1),
(32, 'Completar Peso', '../forms/f_bascula_cola.php', 2, 0, 1),
(40, 'Catalógo', 'f_principal.php', 1, 0, 1),
(41, 'Clientes', '../forms/f_cliente.php', 2, 0, 1),
(42, 'Transportistas', '../forms/f_transportistas.php', 2, 0, 1),
(43, 'Origen', '../forms/f_origen.php', 2, 0, 1),
(44, 'Servicios', '../forms/f_servicios.php', 2, 0, 1),
(45, 'Silo', '../forms/f_silo.php', 2, 0, 1),
(46, 'Lote', '../forms/f_lote.php', 2, 0, 1),
(50, 'Productos', 'f_principal.php', 1, 0, 1),
(51, 'Productos', '../forms/f_producto.php', 2, 0, 1),
(52, 'Subproductos', '../forms/f_subproducto.php', 2, 0, 1),
(60, 'Herramientas', 'f_principal.php', 1, 0, 1),
(61, 'Medidas de Peso', '../forms/f_moneda_medida.php', 2, 0, 1),
(62, 'Variables de Control', '../forms/f_variables.php', 2, 0, 1),
(63, 'Modificar Indicadores', '../forms/f_mod_indicadores.php', 2, 0, 1),
(64, 'Indicadores - Recepción', '../forms/f_otros_indicadores.php', 2, 0, 1),
(65, 'Indicadores - Despacho', '../forms/f_otros_indicadoresdes.php', 2, 0, 1),
(67, 'Reportería', 'f_principal.php', 1, 0, 1),
(68, 'Producto por Cliente', '../forms/f_rep_bascula_producto_cliente.php', 2, 0, 1),
(69, 'Servicio de Báscula', '../forms/f_rep_bascula.php', 2, 0, 1),
(70, 'Báscula por Producto', '../forms/f_rep_bascula_producto.php', 2, 0, 1),
(71, 'Recepción de Granos', '../forms/f_rep_almacen.php', 2, 0, 1),
(72, 'Despacho de Granos', '../forms/f_rep_despacho.php', 2, 0, 1),
(73, 'Ingreso por Lotes', '../forms/f_rep_ingreso_lote.php', 2, 0, 1),
(74, 'Despacho por Lotes', '../forms/f_rep_despacho_lote.php', 2, 0, 1),
(75, 'Movimientos Diarios', '../forms/f_rep_diario.php', 2, 0, 1),
(76, 'Saldos por Lotes', '../forms/f_rep_saldo.php', 2, 0, 1),
(77, 'Control de Calidad - Entrada', '../forms/f_rep_calidad_entrada.php', 2, 0, 1),
(78, 'Control de Calidad - Salida', '../forms/f_rep_calidad.php', 2, 0, 1),
(79, 'Otros indicadores', '../forms/f_rep_otrosindi.php', 2, 0, 1),
(80, 'Estadisticas', 'f_principal.php', 1, 0, 1),
(81, 'Silos', '../forms/f_maqueta.php', 2, 0, 1),
(82, 'Indicadores', '../forms/dashboard.php', 2, 0, 1),
(83, 'Monitoreo', '../forms/f_monitoreo.php', 2, 0, 1),
(84, 'Ingresos - Egresos', '../forms/f_ingresosegresos.php', 2, 0, 1),
(85, 'Agricultor', '../forms/f_agricultor.php', 2, 0, 1),
(86, 'Consulta', '../forms/f_rep_agricultor.php', 2, 0, 1),
(90, 'Seguridad', 'f_principal.php', 1, 0, 1),
(91, 'Usuarios', '../forms/f_usuarios.php', 2, 0, 1),
(92, 'Niveles de Usuarios', '../forms/f_nivel.php', 0, 0, 1),
(93, 'Permisos', '../forms/f_permisos_menu.php', 2, 0, 1),
(100, 'Otros', 'f_principal.php', 1, 0, 1),
(101, 'Comprobantes', '../forms/f_comprobantes.php', 2, 0, 1),
(102, 'Reversión', '../forms/f_reversion.php', 2, 0, 1),
(103, 'Cierre de Lote', '../forms/f_cierre_lote.php', 2, 0, 1),
(104, 'Ajuste de Lote', '../forms/f_ajuste.php', 2, 0, 1),
(105, 'Asignar cliente', '../forms/f_permisos_cliente.php', 2, 0, 1),
(110, 'Cerrar Sesión', '', 1, 0, 1),
(111, 'Principal', 'f_principal.php', 2, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_nivel`
--

CREATE TABLE `tab_nivel` (
  `id_nivel` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_nivel` text COLLATE latin1_spanish_ci NOT NULL,
  `desc_nivel` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `ingresar` int(2) NOT NULL COMMENT '0 sin permiso, 1 autorizado',
  `modificar` int(2) NOT NULL COMMENT '0 sin permiso, 1 autorizado',
  `eliminar` int(2) NOT NULL COMMENT '0 sin permiso, 1 autorizado',
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL COMMENT 'usuario que almacena',
  `ocupado` int(11) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL COMMENT 'usuario que modifica',
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tab_nivel`
--

INSERT INTO `tab_nivel` (`id_nivel`, `nom_nivel`, `desc_nivel`, `id_empresa`, `ingresar`, `modificar`, `eliminar`, `id_usuario2`, `ocupado`, `fecha_usuario`, `hora_usuario`, `id_usuario_modifica`, `fecha_modifica`, `hora_modifica`) VALUES
('NIV-0011', 'MASTER', '', 1, 1, 1, 1, '', 1, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00'),
('NIV-0021', 'REPORTERIA', ' SOLO ACCESO AL MODULO DE REPORTES, EN FECHA 25 DE AGOSTO SE LE OTORGA PERMISO PARA ALMACENAR DATOS', 1, 0, 1, 0, '', 1, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00'),
('NIV-0031', 'ADMINISTRADOR', ' TENDRA ACCESO A TODO EL MENU', 1, 1, 1, 1, '', 1, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00'),
('NIV-0041', 'EMPRESA / CLIENTE', ' SE UTILIZA PARA QUE EL EMPRESARIO PUEDA ACCESAR A SU INFORMACION (SILOS, LOTES, PRODUCTOS Y SUBPRODUCTOS, TRANSPORTISTAS, SERVICIOS) ESTA INFORMACION PUEDE SER DE MANERA GENERAL O FILTRADA POR FECHA.', 1, 0, 0, 0, 'USU-0011', 1, '2017-07-07', '11:20:57', 'USU-0011', '2017-07-07', '11:20:57'),
('NIV-0051', 'ADMINISTRADOR 2', 'SOLO PERMITE REALIZAR CONSULTAS ', 1, 0, 0, 0, 'USU-0011', 1, '2018-08-20', '12:11:11', 'USU-0011', '2018-08-20', '12:11:11'),
('NIV-0061', 'BORRAR', ' ', 1, 1, 1, 1, 'USU-0011', 0, '2020-04-16', '22:32:35', 'USU-0011', '2020-04-16', '22:32:35'),
('NIV-0071', 'DIGITADOR', ' ', 1, 1, 1, 1, 'USU-0011', 1, '2020-04-19', '20:40:53', 'USU-0011', '2020-04-19', '20:40:53'),
('NIV-0081', 'ADMINISTRADOR - ALMACENAR', ' NIVEL SOLO PARA ALMACENAR DATOS', 1, 1, 0, 0, 'USU-0011', 1, '2021-11-11', '18:37:56', 'USU-0011', '2021-11-11', '18:37:56'),
('NIV-0091', 'REPORTES ALIMENTOS S.A', ' REPORTES PARA EL CLIENTE ALIMENTOS S.A', 1, 0, 0, 0, 'USU-0011', 1, '2022-01-11', '09:01:23', 'USU-0011', '2022-01-11', '09:01:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_origen`
--

CREATE TABLE `tab_origen` (
  `id_origen` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_origen` text COLLATE latin1_spanish_ci NOT NULL,
  `desc_origen` text COLLATE latin1_spanish_ci NOT NULL,
  `tipo_origen` int(1) NOT NULL COMMENT '1 Nacional, 2 Internacional',
  `nom_barco` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_producto`
--

CREATE TABLE `tab_producto` (
  `id_producto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_producto` text COLLATE latin1_spanish_ci NOT NULL,
  `nom_productor` text COLLATE latin1_spanish_ci NOT NULL,
  `desc_producto` text COLLATE latin1_spanish_ci,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(11) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `humedad` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_reversion`
--

CREATE TABLE `tab_reversion` (
  `id_reversion` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_almacenaje` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `entrada` int(20) NOT NULL,
  `control` int(20) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_servicio` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `peso_teorico` double NOT NULL,
  `tipo_peso` int(2) NOT NULL,
  `peso_bruto` double NOT NULL,
  `peso_tara` double NOT NULL,
  `id_variable` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `peso_vol` double NOT NULL,
  `humedad` double NOT NULL,
  `temperatura` double NOT NULL,
  `grano_entero` double NOT NULL,
  `grano_quebrado` double NOT NULL,
  `dan_hongo` double NOT NULL,
  `impureza` double NOT NULL,
  `grano_chico` double NOT NULL,
  `grano_picado` double NOT NULL,
  `plaga_viva` double NOT NULL,
  `plaga_muerta` double NOT NULL,
  `stress_crack` double NOT NULL,
  `olor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `destino` text COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '1 En espera, 2 completo',
  `id_transportista` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `vapor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nom_analista` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `neto_sin_humedad` double NOT NULL COMMENT 'realizar formula para calcular',
  `id_empresa` int(11) NOT NULL,
  `neto_sin_humedad_maximo` double NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `tipo_reversion` int(2) NOT NULL COMMENT '1 Recepcion, 2 Despacho',
  `usuario_revierte` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_revierte` date NOT NULL,
  `hora_revierte` time NOT NULL,
  `comentario` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_salida`
--

CREATE TABLE `tab_salida` (
  `id_salida` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `entrada` int(20) NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_lote` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_servicio` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `hora_salida` time NOT NULL,
  `peso_teorico` double NOT NULL,
  `tipo_peso` int(2) NOT NULL,
  `peso_bruto` double NOT NULL,
  `peso_tara` double NOT NULL,
  `id_variable` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `peso_vol` double NOT NULL,
  `humedad` double NOT NULL,
  `temperatura` double NOT NULL,
  `grano_entero` double NOT NULL,
  `grano_quebrado` double NOT NULL,
  `dan_hongo` double NOT NULL,
  `impureza` double NOT NULL,
  `grano_chico` double NOT NULL,
  `grano_picado` double NOT NULL,
  `plaga_viva` double NOT NULL,
  `plaga_muerta` double NOT NULL,
  `stress_crack` double NOT NULL,
  `olor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `destino` text COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '1 En espera, 2 completo',
  `id_transportista` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `vapor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `nom_analista` text COLLATE latin1_spanish_ci NOT NULL,
  `peso_sin_humedad` double NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `nuevo_indicador` int(1) NOT NULL COMMENT ' 	0 no asignado, 1 asignado ',
  `peso_completo` int(1) NOT NULL COMMENT ' 	0 no asignado, 1 asignado ',
  `despacho_ajuste` int(1) NOT NULL COMMENT '0 no ajuste, 1 si ajuste',
  `id_subproducto` varchar(11) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_servicio`
--

CREATE TABLE `tab_servicio` (
  `id_servicio` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_servicio` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `desc_servicio` text COLLATE latin1_spanish_ci NOT NULL,
  `precio_servicio` double NOT NULL,
  `id_medida` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '0 disponible 1 errado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_silo`
--

CREATE TABLE `tab_silo` (
  `id_silo` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_silo` text COLLATE latin1_spanish_ci NOT NULL,
  `desc_silo` text COLLATE latin1_spanish_ci NOT NULL,
  `dir_silo` text COLLATE latin1_spanish_ci NOT NULL,
  `cap_silo` double NOT NULL,
  `foto_silo` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `bandera` int(2) NOT NULL COMMENT '0 activo, 1 inactivo',
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_subproducto`
--

CREATE TABLE `tab_subproducto` (
  `id_subproducto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nom_subproducto` text COLLATE latin1_spanish_ci NOT NULL,
  `desc_subproducto` text COLLATE latin1_spanish_ci,
  `id_producto` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(11) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_transportista`
--

CREATE TABLE `tab_transportista` (
  `id_transportista` varchar(18) COLLATE latin1_spanish_ci NOT NULL,
  `dpi_transportista` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `ape_transportista` text COLLATE latin1_spanish_ci NOT NULL,
  `nom_transportista` text COLLATE latin1_spanish_ci NOT NULL,
  `dir_transportista` text COLLATE latin1_spanish_ci NOT NULL,
  `tel_transportista` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `placa_vehiculo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `color_vehiculo` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `cap_vehiculo` double NOT NULL,
  `obs_vehiculo` text COLLATE latin1_spanish_ci NOT NULL,
  `id_cliente` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_variables`
--

CREATE TABLE `tab_variables` (
  `id_variable` varchar(11) COLLATE latin1_spanish_ci NOT NULL DEFAULT '',
  `nom_variable` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `peso_vol` double NOT NULL,
  `humedad` double NOT NULL,
  `temperatura` double NOT NULL,
  `grano_entero` double NOT NULL,
  `grano_quebrado` double NOT NULL,
  `dan_hongo` double NOT NULL,
  `impureza` double NOT NULL,
  `grano_chico` double NOT NULL,
  `grano_picado` double NOT NULL,
  `plaga_viva` double NOT NULL,
  `plaga_muerta` double NOT NULL,
  `stress_crack` double NOT NULL,
  `olor` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `observacion` text COLLATE latin1_spanish_ci NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(2) NOT NULL,
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_modifica` date NOT NULL,
  `hora_modifica` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tab_variables`
--

INSERT INTO `tab_variables` (`id_variable`, `nom_variable`, `peso_vol`, `humedad`, `temperatura`, `grano_entero`, `grano_quebrado`, `dan_hongo`, `impureza`, `grano_chico`, `grano_picado`, `plaga_viva`, `plaga_muerta`, `stress_crack`, `olor`, `observacion`, `id_empresa`, `id_usuario2`, `ocupado`, `fecha_usuario`, `hora_usuario`, `id_usuario_modifica`, `fecha_modifica`, `hora_modifica`) VALUES
('VAR-0001', 'SELECCION OPCION', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'NULL', '', 1, '', 0, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00'),
('VAR-0011', 'BASICO', 0, 26, 50, 10, 10, 10, 25, 10, 10, 5, 25, 40, 'NORMAL', 'BASICO', 1, '', 1, '0000-00-00', '00:00:00', '', '0000-00-00', '00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_empresa`
--

CREATE TABLE `t_empresa` (
  `id_empresa` int(11) NOT NULL,
  `nombre_empresa` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `direccion_empresa` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `tel_empresa` varchar(15) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pbx_empresa` varchar(15) COLLATE latin1_spanish_ci DEFAULT NULL,
  `logo_empresa` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `moneda1_empresa` varchar(2) COLLATE latin1_spanish_ci DEFAULT 'Q' COMMENT 'Es el simbolo de la moneda',
  `moneda2_empresa` varchar(2) COLLATE latin1_spanish_ci DEFAULT '$' COMMENT 'Es el simbolo de la moneda',
  `moneda1_nombre_empresa` varchar(35) COLLATE latin1_spanish_ci DEFAULT 'QUETZALES' COMMENT 'NOMBRE DE LA MONEDA1',
  `moneda2_nombre_empresa` varchar(35) COLLATE latin1_spanish_ci DEFAULT 'DOLARES' COMMENT 'NOMBRE DE LA MONEDA2',
  `factor_conv_empresa` varchar(1) COLLATE latin1_spanish_ci DEFAULT '/' COMMENT 'para convertir de la moneda 1 a 2 se usa entre "/" o por "*"',
  `tipo_cambio_empresa` double(12,2) DEFAULT '7.80' COMMENT 'el valor de cambio de una moneda a otra',
  `impuesto_empresa` double(12,2) DEFAULT NULL,
  `estado` int(2) NOT NULL COMMENT '1 activo, 2 desactivado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `t_empresa`
--

INSERT INTO `t_empresa` (`id_empresa`, `nombre_empresa`, `direccion_empresa`, `tel_empresa`, `pbx_empresa`, `logo_empresa`, `moneda1_empresa`, `moneda2_empresa`, `moneda1_nombre_empresa`, `moneda2_nombre_empresa`, `factor_conv_empresa`, `tipo_cambio_empresa`, `impuesto_empresa`, `estado`) VALUES
(1, 'SINGBAC - SISTEMA DE INVENTARIO DE GRANOS BASICOS', NULL, NULL, NULL, '', 'Q', '$', 'QUETZALES', 'DOLARES', '/', 7.80, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `t_usuarios`
--

CREATE TABLE `t_usuarios` (
  `id_usuario` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `nombre_usuario` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `correo_usuario` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `pass_usuario` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `activo_usuario` int(11) DEFAULT NULL COMMENT '''0'' inactivo, ''1'' activo',
  `id_nivel` varchar(11) COLLATE latin1_spanish_ci NOT NULL COMMENT '1 MASTER, 2 ADMINISTRADOR, 3 OPERADOR, 4 REPORTERIA',
  `id_empresa` int(11) NOT NULL,
  `id_usuario2` varchar(11) COLLATE latin1_spanish_ci NOT NULL,
  `ocupado` int(11) NOT NULL COMMENT '0 sin transacciones, 1 ya hizo transacciones',
  `fecha_usuario` date NOT NULL,
  `hora_usuario` time NOT NULL,
  `id_usuario_modifica` varchar(11) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Usuario que modifica el registro',
  `fecha_modifica` date NOT NULL COMMENT 'Fecha ultima modificacion',
  `hora_modifica` time NOT NULL COMMENT 'Hora ultima modificacion',
  `token` varchar(100) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `t_usuarios`
--

INSERT INTO `t_usuarios` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `pass_usuario`, `activo_usuario`, `id_nivel`, `id_empresa`, `id_usuario2`, `ocupado`, `fecha_usuario`, `hora_usuario`, `id_usuario_modifica`, `fecha_modifica`, `hora_modifica`, `token`) VALUES
('USU-0011', 'ROBERTO RAMIREZ ORTIZ', 'robertodjramirez@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 'NIV-0011', 1, '', 1, '2017-05-01', '00:00:00', 'USU-0011', '2018-07-05', '14:46:28', 'ei0fnholco8j3m0tkvdpgkvo50'),
('USU-0031', 'AQUINO', 'aquino@ie-networks.com', '112f8f89f5eea66b670c1aa0fc10f33a', 0, 'NIV-0031', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2017-05-24', '15:01:23', 'utvge4rqrochali0hosiov74j2'),
('USU-0041', 'BYRON HERRERA', 'bherrare@granosbasicosca.com', '73bd2f993b267efcd2f96595d77b2d2e', 0, 'NIV-0021', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2017-05-25', '08:56:27', ''),
('USU-0051', 'MILTON MORALES', 'mmorales@granosbasicosca.com', 'cdc6d511b99df88eb736499a37b70bc1', 0, 'NIV-0031', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0031', '2017-05-25', '15:10:06', ''),
('USU-0061', 'VICTOR ORTIZ', 'vortiz@granosbasicosca.com', '97d4e71b01e1562e0d018666c497b4f0', 1, 'NIV-0031', 1, 'USU-0031', 1, '2017-05-11', '00:00:00', 'USU-0011', '2017-05-25', '15:12:19', 'upc8d6vajan2eld3bvb5ts3ht3'),
('USU-0071', 'MARIO HERNÁNDEZ', 'mhernandez@granosbasicosca.com', '9002f0358ebb6d2c4b06fad445d28ee5', 0, 'NIV-0031', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2021-11-11', '18:19:27', 'h0ek9725lblpgbcq8ss2vvapa3'),
('USU-0081', 'EDGAR RAMOS', 'eramos@granosbasicosca.com', '83b2bcfe2e60ebc8f0f2d85de7d9d8d3', 0, 'NIV-0031', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2017-05-25', '16:25:25', 'vl1j2os1fvdkh4c1vu1vpjmmo2'),
('USU-0101', 'FRITO LAY', 'fritolay@granosbasicosca.com', 'fb4c8918499cc9af8976125ba9c88863', 1, 'NIV-0021', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2019-10-17', '12:56:17', '37htsqm7edfmcl2qg3hl02oi46'),
('USU-0111', 'ELIAS TENI', 'eteni@sylos.com', '4e6258d66b665936af288c637f860da0', 1, 'NIV-0031', 1, 'USU-0011', 1, '2017-05-11', '00:00:00', 'USU-0011', '2021-11-11', '19:09:26', '4qht0849m41un1nefp5bk8ct73'),
('USU-0131', 'CEMIX DE CENTROAMERICA S.A.', 'cemix@sylos.com', '202cb962ac59075b964b07152d234b70', 0, 'NIV-0041', 1, 'USU-0011', 0, '2017-07-13', '10:24:11', 'USU-0011', '2017-08-09', '11:17:23', 'cpvl7d7emp7mqhgf8c905p1104'),
('USU-0141', 'COMERCIALIZADORA GENERAL', 'cgeneral@sylos.com', '70d93ca37305d28f57aae698f2dc5d02', 0, 'NIV-0041', 1, 'USU-0011', 0, '2017-07-13', '10:27:19', 'USU-0011', '2017-07-13', '10:27:19', 'b7tltlrhurnb41tbdgd25cp676'),
('USU-0151', 'GORELLANA', 'orellanagustavo4@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0, 'NIV-0031', 1, 'USU-0031', 0, '2017-07-27', '10:04:51', 'USU-0011', '2017-07-27', '10:10:57', 'jk2428fgg604bf16j9o1eguso6'),
('USU-0161', 'MOLINOS VENECIA', 'mvenecia@sylos.com', '32adca77212e3833041eb685d5308ee5', 0, 'NIV-0041', 1, 'USU-0011', 0, '2017-08-10', '09:26:26', 'USU-0011', '2017-08-10', '09:26:26', 's2sslgpipalcsqpict22povvl6'),
('USU-0171', 'FRITO LAY', 'fritolay01@sylos.com', 'a8422fcccd8be3de202ec0f992b3333f', 0, 'NIV-0041', 1, 'USU-0011', 0, '2017-08-10', '10:36:06', 'USU-0011', '2018-12-14', '10:43:37', 'ps4reg8n5d464p84pvb55fu292'),
('USU-0181', 'ADRIANA RAMIREZ', 'adri@sylos.com', '5e082012573775c13199192bf00694e7', 0, 'NIV-0011', 1, 'USU-0011', 0, '2017-09-20', '10:33:20', 'USU-0011', '2017-09-20', '10:33:20', 'pqb1nmdqlrl2v85b1222u4o6a7'),
('USU-0211', 'EVER MURCIA', 'emurcia@singbac.com', 'e7456069bbdc5505e5353b1ad8d6b4f6', 1, 'NIV-0031', 1, 'USU-0011', 0, '2019-03-17', '18:21:56', 'USU-0011', '2019-03-17', '18:21:56', '2j0lot5204csp9o59ngu1qhng5'),
('USU-0221', 'EDENILSON SILVA', 'ede@digitador.com', '69ed56901945f65ceb01388a9a7b46a6', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-19', '22:22:32', 'USU-0011', '2022-04-04', '22:03:56', 't454thsegt37sl8nao8egmjsf0'),
('USU-0231', 'MOISES AYALA', 'moises@digitador.com', '8f8ad28dd6debff410e630ae13436709', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-19', '22:26:07', 'USU-0011', '2022-04-04', '21:23:36', '1vvqdsut5jbll6vmmm4qus2tu7'),
('USU-0241', 'JESUS DURAN', 'jesus@digitador.com', 'f61d7dce25e108554b081620cb7261eb', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-19', '22:27:55', 'USU-0011', '2020-04-19', '22:27:55', '1buhbfv9tq91uq6f9458djies5'),
('USU-0251', 'JORGE ACEVEDO', 'jorge@digitador.com', 'aa3b3d2a9249b6fa369d34527205b1b7', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-19', '23:22:48', 'USU-0011', '2022-04-04', '21:53:45', 'ettqu0t2pcimn6sa0im5m0vsp2'),
('USU-0261', 'FLOR ', 'flor@digitador.com', '5afeac54349d4eec2cf0cee2841df07c', 0, 'NIV-0071', 1, 'USU-0181', 0, '2020-04-20', '01:21:41', 'USU-0011', '2022-04-04', '21:57:51', 'phc73agtv3tngr87o1a2ud36b4'),
('USU-0271', 'ZULMA ORTIZ', 'zulma@digitador.com', '4b80f5e15180b9aa9d264211e0050eab', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '06:28:07', 'USU-0011', '2020-04-20', '06:28:07', 't6gmlmjl631o2tpsaus2st0mh3'),
('USU-0281', 'BRAYAN', 'brayan@digitador.com', '30230e097028139197ef907bd03b0486', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '06:31:02', 'USU-0011', '2022-04-04', '22:14:43', 'jc5c793n28delv1guoptmke2u4'),
('USU-0291', 'ISAIAS URQUILLA', 'isaias@digitador.com', '50e956be067f5f7e3de59ee47fff16c1', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:20:42', 'USU-0011', '2020-04-20', '13:20:42', 'khulm0pmf80vco7mjsdj6h0ed7'),
('USU-0301', 'ANDERSON MEJIA', 'anderson@digitador.com', 'c7376834330380fbd1c33e89f980e898', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:22:57', 'USU-0011', '2020-04-20', '13:22:57', '0j0u68k8kqoihf2vmgrq3bk1d0'),
('USU-0311', 'ALCIDES RODRIGUEZ', 'alcides@digitador.com', '6563e7a1433366df925ed133e0d94a41', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:25:30', 'USU-0011', '2020-04-20', '13:25:30', 'btmcle00pligd7n8lelnebmgm4'),
('USU-0321', 'LASTENIA', 'lastenia@digitador.com', 'de4a1e9ca289664d41a993f8462caa9b', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:28:50', 'USU-0011', '2020-04-20', '13:28:50', 'rvpcc6aqef251k7csbfir596k2'),
('USU-0331', 'ALEXIS GONZALEZ', 'alexis@digitador.com', '5468e5e12c511c5f978950cd6e5b8d8a', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:32:12', 'USU-0011', '2020-04-20', '13:32:12', '9fqr8533lm7426bqfr9j9efj80'),
('USU-0341', 'SWAN', 'swan@digitador.com', '73bd2a696ad6eb789dcb031e8bea8605', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-20', '13:37:58', 'USU-0011', '2020-04-20', '13:37:58', '4m1u03g5vdhhdgnjca613o1uq0'),
('USU-0351', 'SUPERVISOR', 'supervisor@digitar.com', '09348c20a019be0318387c08df7a783d', 1, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-21', '00:48:59', 'USU-0011', '2022-10-23', '13:05:07', 'eiv1ckm0ru7lpod7dpt78o8te7'),
('USU-0361', 'XIOMARA', 'xiomara@digitar.com', '87ca8192dd4c78120856fdeccc6b7e56', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-21', '15:55:54', 'USU-0011', '2020-04-21', '15:55:54', 'edqi3uapmt73pof7i2f2870pp5'),
('USU-0371', 'XIOMARA', 'xiomara123@digitar.com', '126bafb996f68577c48df3ca71b97692', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-04-21', '16:19:11', 'USU-0011', '2020-04-21', '16:19:11', 'romloll456munnomjdda3rh1e0'),
('USU-0381', 'ELIAS HENRIQUEZ', 'elias@digitar.com', 'a995f5696e0dbafc854e801cdce0dc25', 0, 'NIV-0071', 1, 'USU-0011', 0, '2020-05-04', '16:44:15', 'USU-0011', '2020-05-04', '16:44:15', 'kp31ff4qemd0m4b0pkmqfcmuk0'),
('USU-0391', 'HAROLD GARCIA', 'haroldgarcia@granosbasicosca.com', '5df195a1ccc1c40267d8d76b136e3599', 1, 'NIV-0031', 1, 'USU-0011', 0, '2021-11-11', '18:17:26', 'USU-0011', '2022-05-02', '19:36:41', '9shcb13abepa4p7s9hl34mejo1'),
('USU-0401', 'CRISTIAN MORALES', 'cmorales@granosbasicosca.com', 'ffeb041f615f9105468dd966d7115656', 1, 'NIV-0031', 1, 'USU-0011', 0, '2021-11-11', '18:21:29', 'USU-0011', '2021-11-15', '07:40:42', 'h6coq0ec9tum51rdub8dn1l5g3'),
('USU-0411', 'ALIMENTOS S.A.', 'alimentos@granosbasicosca.com', 'a27f5807ebf7a94a009cdd4f706fc930', 1, 'NIV-0091', 1, 'USU-0011', 0, '2022-01-11', '09:03:39', 'USU-0011', '2022-01-11', '09:03:39', 'i6da4qh18iq8p0a4en4fabk160');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tab_ajuste`
--
ALTER TABLE `tab_ajuste`
  ADD PRIMARY KEY (`id_ajuste`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_lote_2` (`id_lote`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_usuario2_ajuste` (`id_usuario2_ajuste`),
  ADD KEY `id_inventario` (`id_inventario`);

--
-- Indices de la tabla `tab_almacenaje`
--
ALTER TABLE `tab_almacenaje`
  ADD PRIMARY KEY (`id_almacenaje`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_lote_2` (`id_lote`),
  ADD KEY `id_variable` (`id_variable`),
  ADD KEY `id_variable_2` (`id_variable`),
  ADD KEY `id_variable_3` (`id_variable`),
  ADD KEY `id_transportista` (`id_transportista`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_bascula`
--
ALTER TABLE `tab_bascula`
  ADD PRIMARY KEY (`id_bascula`),
  ADD KEY `id_cliente` (`id_transportista`,`id_producto`,`id_subproducto`),
  ADD KEY `id_cliente_2` (`id_transportista`,`id_producto`,`id_subproducto`),
  ADD KEY `id_transportista` (`id_transportista`),
  ADD KEY `id_transportista_2` (`id_transportista`),
  ADD KEY `id_cliente_3` (`id_transportista`,`id_producto`,`id_subproducto`),
  ADD KEY `id_cliente_4` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_subproducto` (`id_subproducto`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_bitacora`
--
ALTER TABLE `tab_bitacora`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_checaje`
--
ALTER TABLE `tab_checaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tab_cliente`
--
ALTER TABLE `tab_cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_contador`
--
ALTER TABLE `tab_contador`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_detalle_cliente`
--
ALTER TABLE `tab_detalle_cliente`
  ADD KEY `id_nivel` (`id_cliente_principal`),
  ADD KEY `id_menu` (`id_cliente_secundario`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_cliente_principal` (`id_cliente_principal`),
  ADD KEY `id_cliente_secundario` (`id_cliente_secundario`);

--
-- Indices de la tabla `tab_detalle_menu`
--
ALTER TABLE `tab_detalle_menu`
  ADD KEY `id_nivel` (`id_nivel`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_detalle_servicio`
--
ALTER TABLE `tab_detalle_servicio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_origen` (`id_origen`),
  ADD KEY `id_subproducto` (`id_subproducto`),
  ADD KEY `id_lote_2` (`id_cliente`,`id_producto`,`id_subproducto`,`id_origen`,`id_servicio`,`id_silo`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_indicadoresdespacho`
--
ALTER TABLE `tab_indicadoresdespacho`
  ADD PRIMARY KEY (`id_indicadoressalida`),
  ADD KEY `id_lote` (`id_salida`),
  ADD KEY `id_lote_2` (`id_salida`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_usuario2` (`id_usuario2`),
  ADD KEY `id_usuario_modifica` (`id_usuario_modifica`);

--
-- Indices de la tabla `tab_indicadoresrecepcion`
--
ALTER TABLE `tab_indicadoresrecepcion`
  ADD PRIMARY KEY (`id_indicadores`),
  ADD KEY `id_lote` (`id_almacenaje`),
  ADD KEY `id_lote_2` (`id_almacenaje`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_usuario2` (`id_usuario2`),
  ADD KEY `id_usuario_modifica` (`id_usuario_modifica`);

--
-- Indices de la tabla `tab_inventario`
--
ALTER TABLE `tab_inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_kardex`
--
ALTER TABLE `tab_kardex`
  ADD PRIMARY KEY (`id_kardex`),
  ADD KEY `id_almacenaje` (`id_almacenaje`),
  ADD KEY `id_salida` (`id_salida`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_lote`
--
ALTER TABLE `tab_lote`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_origen` (`id_origen`),
  ADD KEY `id_cliente_2` (`id_cliente`,`id_producto`,`id_subproducto`,`id_origen`,`id_silo`),
  ADD KEY `id_subproducto` (`id_subproducto`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_medida`
--
ALTER TABLE `tab_medida`
  ADD PRIMARY KEY (`id_medida`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_menu`
--
ALTER TABLE `tab_menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD UNIQUE KEY `id_menu` (`id_menu`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_menu_2` (`id_menu`);

--
-- Indices de la tabla `tab_nivel`
--
ALTER TABLE `tab_nivel`
  ADD PRIMARY KEY (`id_nivel`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_origen`
--
ALTER TABLE `tab_origen`
  ADD PRIMARY KEY (`id_origen`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_producto`
--
ALTER TABLE `tab_producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_reversion`
--
ALTER TABLE `tab_reversion`
  ADD PRIMARY KEY (`id_reversion`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_lote_2` (`id_lote`),
  ADD KEY `id_variable` (`id_variable`),
  ADD KEY `id_variable_2` (`id_variable`),
  ADD KEY `id_variable_3` (`id_variable`),
  ADD KEY `id_transportista` (`id_transportista`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_cliente_3` (`id_cliente`),
  ADD KEY `id_cliente_2` (`id_cliente`);

--
-- Indices de la tabla `tab_salida`
--
ALTER TABLE `tab_salida`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_lote` (`id_lote`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_silo` (`id_silo`),
  ADD KEY `id_lote_2` (`id_lote`),
  ADD KEY `id_variable` (`id_variable`),
  ADD KEY `id_variable_2` (`id_variable`),
  ADD KEY `id_variable_3` (`id_variable`),
  ADD KEY `id_transportista` (`id_transportista`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_servicio`
--
ALTER TABLE `tab_servicio`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_medida` (`id_medida`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_silo`
--
ALTER TABLE `tab_silo`
  ADD PRIMARY KEY (`id_silo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_subproducto`
--
ALTER TABLE `tab_subproducto`
  ADD PRIMARY KEY (`id_subproducto`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_transportista`
--
ALTER TABLE `tab_transportista`
  ADD PRIMARY KEY (`id_transportista`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `tab_variables`
--
ALTER TABLE `tab_variables`
  ADD PRIMARY KEY (`id_variable`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Indices de la tabla `t_empresa`
--
ALTER TABLE `t_empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `t_usuarios`
--
ALTER TABLE `t_usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tab_checaje`
--
ALTER TABLE `tab_checaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tab_ajuste`
--
ALTER TABLE `tab_ajuste`
  ADD CONSTRAINT `tab_ajuste_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_ajuste_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `tab_lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_ajuste_ibfk_3` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_ajuste_ibfk_6` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_ajuste_ibfk_7` FOREIGN KEY (`id_usuario2_ajuste`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_ajuste_ibfk_8` FOREIGN KEY (`id_inventario`) REFERENCES `tab_inventario` (`id_inventario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_almacenaje`
--
ALTER TABLE `tab_almacenaje`
  ADD CONSTRAINT `tab_almacenaje_ibfk_1` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `tab_servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_4` FOREIGN KEY (`id_variable`) REFERENCES `tab_variables` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_5` FOREIGN KEY (`id_lote`) REFERENCES `tab_lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_6` FOREIGN KEY (`id_transportista`) REFERENCES `tab_transportista` (`id_transportista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_almacenaje_ibfk_7` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_bitacora`
--
ALTER TABLE `tab_bitacora`
  ADD CONSTRAINT `tab_bitacora_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_bitacora_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_cliente`
--
ALTER TABLE `tab_cliente`
  ADD CONSTRAINT `tab_cliente_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_contador`
--
ALTER TABLE `tab_contador`
  ADD CONSTRAINT `tab_contador_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_detalle_cliente`
--
ALTER TABLE `tab_detalle_cliente`
  ADD CONSTRAINT `tab_detalle_cliente_ibfk_1` FOREIGN KEY (`id_cliente_principal`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_cliente_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_cliente_ibfk_3` FOREIGN KEY (`id_cliente_secundario`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_detalle_menu`
--
ALTER TABLE `tab_detalle_menu`
  ADD CONSTRAINT `tab_detalle_menu_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `tab_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_menu_ibfk_3` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_menu_ibfk_4` FOREIGN KEY (`id_menu`) REFERENCES `tab_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_detalle_servicio`
--
ALTER TABLE `tab_detalle_servicio`
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `tab_servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_3` FOREIGN KEY (`id_origen`) REFERENCES `tab_origen` (`id_origen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `tab_producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_5` FOREIGN KEY (`id_subproducto`) REFERENCES `tab_subproducto` (`id_subproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_6` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_detalle_servicio_ibfk_7` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_indicadoresdespacho`
--
ALTER TABLE `tab_indicadoresdespacho`
  ADD CONSTRAINT `tab_indicadoresdespacho_ibfk_1` FOREIGN KEY (`id_salida`) REFERENCES `tab_salida` (`id_salida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresdespacho_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresdespacho_ibfk_3` FOREIGN KEY (`id_usuario2`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresdespacho_ibfk_4` FOREIGN KEY (`id_usuario_modifica`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_indicadoresrecepcion`
--
ALTER TABLE `tab_indicadoresrecepcion`
  ADD CONSTRAINT `tab_indicadoresrecepcion_ibfk_1` FOREIGN KEY (`id_almacenaje`) REFERENCES `tab_almacenaje` (`id_almacenaje`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresrecepcion_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresrecepcion_ibfk_3` FOREIGN KEY (`id_usuario2`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_indicadoresrecepcion_ibfk_4` FOREIGN KEY (`id_usuario_modifica`) REFERENCES `t_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_inventario`
--
ALTER TABLE `tab_inventario`
  ADD CONSTRAINT `tab_inventario_ibfk_1` FOREIGN KEY (`id_lote`) REFERENCES `tab_lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_inventario_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_kardex`
--
ALTER TABLE `tab_kardex`
  ADD CONSTRAINT `tab_kardex_ibfk_1` FOREIGN KEY (`id_almacenaje`) REFERENCES `tab_almacenaje` (`id_almacenaje`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_kardex_ibfk_2` FOREIGN KEY (`id_salida`) REFERENCES `tab_salida` (`id_salida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_kardex_ibfk_3` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_lote`
--
ALTER TABLE `tab_lote`
  ADD CONSTRAINT `tab_lote_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tab_producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_lote_ibfk_2` FOREIGN KEY (`id_origen`) REFERENCES `tab_origen` (`id_origen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_lote_ibfk_3` FOREIGN KEY (`id_subproducto`) REFERENCES `tab_subproducto` (`id_subproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_lote_ibfk_4` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_lote_ibfk_5` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_lote_ibfk_6` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_medida`
--
ALTER TABLE `tab_medida`
  ADD CONSTRAINT `tab_medida_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_menu`
--
ALTER TABLE `tab_menu`
  ADD CONSTRAINT `tab_menu_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_nivel`
--
ALTER TABLE `tab_nivel`
  ADD CONSTRAINT `tab_nivel_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_origen`
--
ALTER TABLE `tab_origen`
  ADD CONSTRAINT `tab_origen_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_producto`
--
ALTER TABLE `tab_producto`
  ADD CONSTRAINT `tab_producto_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_reversion`
--
ALTER TABLE `tab_reversion`
  ADD CONSTRAINT `tab_reversion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_2` FOREIGN KEY (`id_lote`) REFERENCES `tab_lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_3` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_4` FOREIGN KEY (`id_servicio`) REFERENCES `tab_servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_5` FOREIGN KEY (`id_variable`) REFERENCES `tab_variables` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_6` FOREIGN KEY (`id_transportista`) REFERENCES `tab_transportista` (`id_transportista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_reversion_ibfk_7` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`);

--
-- Filtros para la tabla `tab_salida`
--
ALTER TABLE `tab_salida`
  ADD CONSTRAINT `tab_salida_ibfk_1` FOREIGN KEY (`id_silo`) REFERENCES `tab_silo` (`id_silo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `tab_servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_4` FOREIGN KEY (`id_variable`) REFERENCES `tab_variables` (`id_variable`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_5` FOREIGN KEY (`id_lote`) REFERENCES `tab_lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_6` FOREIGN KEY (`id_transportista`) REFERENCES `tab_transportista` (`id_transportista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_salida_ibfk_7` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_servicio`
--
ALTER TABLE `tab_servicio`
  ADD CONSTRAINT `tab_servicio_ibfk_1` FOREIGN KEY (`id_medida`) REFERENCES `tab_medida` (`id_medida`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_servicio_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_silo`
--
ALTER TABLE `tab_silo`
  ADD CONSTRAINT `tab_silo_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_subproducto`
--
ALTER TABLE `tab_subproducto`
  ADD CONSTRAINT `tab_subproducto_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `tab_producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_subproducto_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_transportista`
--
ALTER TABLE `tab_transportista`
  ADD CONSTRAINT `tab_transportista_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `tab_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tab_transportista_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tab_variables`
--
ALTER TABLE `tab_variables`
  ADD CONSTRAINT `tab_variables_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `t_usuarios`
--
ALTER TABLE `t_usuarios`
  ADD CONSTRAINT `t_usuarios_ibfk_1` FOREIGN KEY (`id_empresa`) REFERENCES `t_empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `t_usuarios_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `tab_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
