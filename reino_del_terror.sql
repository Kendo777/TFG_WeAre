-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2021 a las 23:20:34
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reino_del_terror`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `job` varchar(128) NOT NULL,
  `birthday` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `members`
--

INSERT INTO `members` (`id`, `name`, `lastName`, `nickname`, `job`, `birthday`, `description`, `email`, `password`) VALUES
(1, 'ElDictadorSecreto', '', NULL, '', '0000-00-00', '', '', '$2y$10$uLkNk/nd8Wz7eVa3hwqzcutElUa08qwB7tO2PEP4/b8q.qivuT8P6'),
(2, 'Marc', 'Lozano Martinez', NULL, 'Bufon Real', '1998-11-11', '', '', '$2y$10$pvceZpQM/tmljpcCYphtOOyc0LjHPW3wcLuE.sZRaqswTv1VkUibW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
