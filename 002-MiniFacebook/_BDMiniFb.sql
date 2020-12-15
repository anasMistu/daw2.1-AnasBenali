-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-11-2020 a las 13:20:58
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `MiniFb`
--
CREATE DATABASE IF NOT EXISTS `MiniFb` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `MiniFb`;

--
-- Estructura de la tabla `Publicacion`
--

CREATE TABLE `Publicacion` (
                               `id` int(11) NOT NULL,
                               `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
                               `emisorId` int(11) NOT NULL,
                               `destinatarioId` int(11) DEFAULT NULL,
                               `destacadoHasta` timestamp NULL DEFAULT NULL,
                               `asunto` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
                               `contenido` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `Publicacion`
--

INSERT INTO `Publicacion` (`id`, `fecha`, `emisorId`, `destinatarioId`, `destacadoHasta`, `asunto`, `contenido`) VALUES
(1, '2020-12-10 12:37:54', 1, NULL, NULL, 'Hola a todos', '¡Hola!\r\nSoy nuevo en el Minifacebook y quiero hacer amigüitos.\r\nUn saludete.\r\nJavi'),
(2, '2020-12-10 12:37:54', 2, 1, NULL, '¡Hola Javi!', 'Bienvenido, aquí estamos, aprendiendo PHP.'),
(3, '2020-12-10 12:38:40', 3, NULL, NULL, 'Me abuuuurroo', 'Lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum lorem ipsum.');

-- --------------------------------------------------------

--
-- Estructura de la tabla `Usuario`
--

CREATE TABLE `Usuario` (
                           `id` int(11) NOT NULL,
                           `identificador` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
                           `contrasenna` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
                           `codigoCookie` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
                           `tipoUsuario` int(11) NOT NULL,
                           `fotoDePerfil` varchar(80) DEFAULT NULL ,
                           `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
                           `apellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `Usuario`
--

# noinspection SqlNoDataSourceInspection

INSERT INTO `Usuario` (`id`, `identificador`, `contrasenna`, `codigoCookie`, `tipoUsuario`, `nombre`, `apellidos`) VALUES
(1, 'jlopez', '$2y$10$AlnAMeg1n6OSAuMzaR7gtuySV/2MWNkdLFRv7PfN8AggdYBZTY0ei', NULL, 0, 'José', 'López'),
(2, 'mgarcia', '$2y$10$.ECdUtViS3YqSOfVFLR3FeP14rfOgk3XCui45dZr0V/NsaBkZmm4i', NULL, 0, 'María', 'García'),
(3, 'fpi', '$2y$10$pRkiuKRBlW3y5rhH27Hl0.QUp1eaCjJT56D18j8zKAg64.uiNVomm', NULL, 0, 'Felipe', 'Pi');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Publicacion`
--
ALTER TABLE `Publicacion`
    ADD PRIMARY KEY (`id`),
    ADD KEY `destinatarioId` (`destinatarioId`),
    ADD KEY `emisorId` (`emisorId`);




--
-- Indices de la tabla `Usuario`
--
ALTER TABLE `Usuario`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `identificador` (`identificador`);

-- AUTO_INCREMENT de la tabla `Publicacion`
--
ALTER TABLE `Publicacion`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `Usuario`
--
ALTER TABLE `Usuario`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
SET FOREIGN_KEY_CHECKS=1;

--
-- Filtros para la tabla `Publicacion`
--
ALTER TABLE `Publicacion`
    ADD CONSTRAINT `Publicacion_ibfk_1` FOREIGN KEY (`destinatarioId`) REFERENCES `Usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `Publicacion_ibfk_2` FOREIGN KEY (`emisorId`) REFERENCES `Usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;