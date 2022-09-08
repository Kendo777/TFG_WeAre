-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-09-2022 a las 07:07:58
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
-- Base de datos: `we_are`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `valid` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `email`, `password`, `valid`) VALUES
('Marc', 'leyo@gmail.com', '$2y$10$gjLbJTEVx4eFUCCz1O6NEucdFjG5qlAD98DuaZVHdMpimc6X7mgPa', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `web_pages`
--

CREATE TABLE `web_pages` (
  `id` int(6) NOT NULL,
  `web_name` varchar(60) NOT NULL,
  `web_current_name` varchar(60) NOT NULL,
  `web_database` varchar(60) NOT NULL,
  `web_user` varchar(60) NOT NULL,
  `date_creation` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `web_pages`
--

INSERT INTO `web_pages` (`id`, `web_name`, `web_current_name`, `web_database`, `web_user`, `date_creation`) VALUES
(1, 'Marc', 'Marc', 'marc', 'Marc', '2022-08-19'),
(18, 'test', 'test', 'test', 'Marc', '2022-08-31'),
(35, 'reinodelterror', 'Reino del terror ', 'reinodelterror', 'Marc', '2022-09-01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `web_pages`
--
ALTER TABLE `web_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_web_pages_users` (`web_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `web_pages`
--
ALTER TABLE `web_pages`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `web_pages`
--
ALTER TABLE `web_pages`
  ADD CONSTRAINT `fk_web_pages_users` FOREIGN KEY (`web_user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
