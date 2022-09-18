-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2022 a las 00:26:42
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
-- Base de datos: `el_reino_del_terror`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blank_pages`
--

CREATE TABLE `blank_pages` (
  `id` int(6) UNSIGNED NOT NULL,
  `content` longtext DEFAULT '<h1>BLANK PAGE EXAMPLE</h1><p>&nbsp;</p><p style="text-align:center;"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class="image image_resized image-style-side" style="width:49.3%;"><img src="https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png" alt="Our team"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class="table" style="width:78.17%;"><table><colgroup><col style="width:17.43%;"><col style="width:13.11%;"><col style="width:12.72%;"><col style="width:11.3%;"><col style="width:10.5%;"><col style="width:23.07%;"><col style="width:11.87%;"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href="http://localhost/TFG/blog.html">blog </a>with all the necessary information&nbsp;</p>'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `blank_pages`
--

INSERT INTO `blank_pages` (`id`, `content`) VALUES
(1, '<h1>Pleitesía a nuestro líder supremo Gonzalo</h1><figure class=\\\"image image-style-side\\\"><img src=\\\"https://i.gifer.com/3J5S.gif\\\"></figure><p>Solo los pocos elegidos por el líder supremo pueden pertenecer a este reinado para nada dictatorial donde todos podemos tener nuestra libre opinion, siempre y cuando le guste al líder, sino EJECUCION!!!!</p><p>Los miembros de este grupo pueden tener los siguientes roles:</p><ul><li>Líder supremo</li><li>Administrador del reino</li><li>Tesorero</li><li>Bufón</li></ul><figure class=\\\"image\\\"><img src=\\\"https://c.tenor.com/sG4QeAFtXTYAAAAC/gustar-romano.gif\\\"></figure><p style=\\\"text-align:center;\\\">A quien no le va a gustar El reino del Terror de Gonzalo?</p>'),
(2, '<h1>&nbsp;</h1><p>&nbsp;</p><figure class=\\\"image image_resized\\\" style=\\\"width:60.66%;\\\"><img src=\\\"https://pbs.twimg.com/media/Fc9YAYrX0Akm8Hh?format=jpg&amp;name=large\\\"></figure>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

CREATE TABLE `blogs` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(2000) DEFAULT '',
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `user`) VALUES
(1, 'Campaña de rol', 'Seguimiento de las sesiones de las partidas de rol', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `blog_id` int(6) UNSIGNED NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `blog_id`, `date`) VALUES
(1, 'Partida 1', 'Supo que tuvo Padres que murieron asesinados por no trabajar\\r\\n\\\"bien\\\"en su esclavitud, ella no sintió nada por ese acontecimiento,\\r\\npero pasó 2 dias sin dejar de soltar lágrimas, sin quejarse o hacer\\r\\nruido, o a cambio recibiría malos tratos por llamar la atención a los\\r\\ndemás. Antes de su muerte, le enseñó un idioma que sería el de las\\r\\ncriaturas feéricas, con esa enseñanza a corta edad, en Marixta,\\r\\ndonde vivió casi toda su vida como esclava, recogiendo materiales,\\r\\nempujando carrozas con otros niños o gente mayor con pocas\\r\\nesperanzas de vida.', 1, '2022-09-18 20:30:28'),
(2, 'Partida 2', 'Nunca tuvo un nombre, o que ella recuerde, siendo nombrada<br>\\\"Angelito\\\" por sus pequeñas y débiles alas sucias. Su rostro siempre<br>estaba cubierto por la sombra de su cabello blanco con barro, se<br>acostumbró a la violencia por ver la gente del pueblo matar y/o moria<br>para sobrevivir, haciéndose insensible ante su presencia agresiva. Su<br>vida en ese entonces siempre era caos, trabajar, algo sangrienta,<br>discusiones por presios de esclavos y otras cosas que en la<br>actualidad sigue sin comprender esas condiciones, no sentía dolor<br>emocional en \\\"su hogar\\\" tuvo amigos en horarios libres notando un<br>poco su hiperactividad amistosa y peleas a palos que ganaba i<br>siempre, pero era a la que más reclamaban.<br><img src=\\\"https://i.ytimg.com/vi/RzttYCJaIyA/maxresdefault.jpg\\\" width=\\\"50%\\\"></img>', 1, '2022-09-18 20:31:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendars`
--

CREATE TABLE `calendars` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calendars`
--

INSERT INTO `calendars` (`id`, `title`, `description`) VALUES
(1, 'Calendar Example', 'Description Example');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` int(6) UNSIGNED NOT NULL,
  `calendar_id` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(2000) DEFAULT '',
  `color` varchar(20) NOT NULL,
  `start` datetime DEFAULT current_timestamp(),
  `end` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `calendar_id`, `title`, `description`, `color`, `start`, `end`) VALUES
(1, 1, 'Defensa Marc', '', 'Crimson', '2022-09-19 00:00:00', '2022-09-20 00:00:00'),
(2, 1, 'Japan Madrid', '', 'DeepSkyBlue', '2022-09-23 00:00:00', '2022-09-26 00:00:00'),
(3, 1, 'Fiestas Zuera', '', 'LimeGreen', '2022-09-16 00:00:00', '2022-09-19 00:00:00'),
(4, 1, 'Se queda', '', 'BlueViolet', '2022-09-17 00:00:00', '2022-09-18 00:00:00'),
(5, 1, 'Casa Rural', '', 'Gold', '2022-09-06 00:00:00', '2022-09-09 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums`
--

CREATE TABLE `forums` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forums`
--

INSERT INTO `forums` (`id`, `title`, `user`) VALUES
(1, 'Quedamos para fiestas de San Mateo o que?', 'Marc'),
(2, 'Se vienen fiestas de Zuera... alguien se apunta?', 'Marc'),
(3, 'Amigo invisible', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories`
--

CREATE TABLE `forum_categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `name`) VALUES
(4, 'Amigoinvisible'),
(1, 'Quedada'),
(3, 'Zuera');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories_relation`
--

CREATE TABLE `forum_categories_relation` (
  `forum_id` int(6) UNSIGNED NOT NULL,
  `forum_category_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forum_categories_relation`
--

INSERT INTO `forum_categories_relation` (`forum_id`, `forum_category_id`) VALUES
(1, 1),
(2, 1),
(2, 3),
(3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id` int(6) UNSIGNED NOT NULL,
  `content` varchar(2000) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `forum_id` int(6) UNSIGNED NOT NULL,
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `content`, `date`, `forum_id`, `user`) VALUES
(1, 'Pues eso que dias quedamos?', '2022-09-18 20:32:13', 1, 'Marc'),
(2, 'Os hace?', '2022-09-18 20:32:47', 2, 'Marc'),
(3, 'Responded solo aquellos que vayan a participar porfavor', '2022-09-18 20:33:23', 3, 'Marc'),
(4, 'Sorry yo hoy no puedo', '2022-09-18 20:52:06', 1, 'Gonzalo'),
(5, 'Si se hace se puede quedar a dormir gente a mi casa', '2022-09-18 20:52:42', 2, 'Gonzalo'),
(6, 'Yo puedo, pero todos los regalos son para mi', '2022-09-18 20:53:03', 3, 'Gonzalo'),
(7, 'Yo si, por eso vivo ahi xd', '2022-09-18 20:54:13', 1, 'Clhoe'),
(8, 'Sorry ya he quedado', '2022-09-18 20:54:33', 2, 'Clhoe'),
(9, 'YOOOOOOOOOOO', '2022-09-18 20:55:01', 3, 'Clhoe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_responses`
--

CREATE TABLE `forum_responses` (
  `id` int(6) UNSIGNED NOT NULL,
  `content` varchar(2000) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `forum_post_id` int(6) UNSIGNED NOT NULL,
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forum_responses`
--

INSERT INTO `forum_responses` (`id`, `content`, `date`, `forum_post_id`, `user`) VALUES
(1, 'VENTE!!!! TT', '2022-09-18 20:54:01', 4, 'Clhoe'),
(2, 'Me pido camaaaa', '2022-09-18 20:54:24', 5, 'Clhoe'),
(3, 'INJUSTICIAAAAAAAA', '2022-09-18 20:54:47', 6, 'Clhoe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galleries`
--

CREATE TABLE `galleries` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `type` varchar(60) DEFAULT 'Grid Gallery View',
  `description` varchar(2000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `type`, `description`) VALUES
(1, 'Viaje a Artieda', 'Grid Gallery View', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `rol` varchar(60) DEFAULT 'reader',
  `valid` int(4) NOT NULL,
  `discord` varchar(60) DEFAULT NULL,
  `cumple` date DEFAULT NULL,
  `edad` int(4) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `email`, `user_name`, `password`, `rol`, `valid`, `discord`, `cumple`, `edad`, `description`) VALUES
('Clhoe', 'clohoe@reino.es', 'Clhoe', '$2y$10$x.XeMieixJ2j4hL3K3/58uX.2JC0do1sM1d4Oye0Sut3kkbQWuM7e', 'writer', 0, 'popilla#1234', '2022-09-18', 23, 'Pop pop popilla'),
('Gonzalo', 'gon@reino.es', 'Gonzalo', '$2y$10$KtEdskFgpxyryf5YxE81Ee3VeKfRH5z7h4NCAagB7qmQ2AhtMPGKK', 'admin', 0, 'gon#1234', '2022-09-18', 22, 'Lider Supremo'),
('Guest', '', '', '$2y$10$iW0E4eIjjQJCPrbDQnpAOO.OYu8eOtVIMMcScn6jz0ucjRCi7gbeq', 'reader', 0, NULL, NULL, NULL, NULL),
('Marc', 'leyo@gmail.com', '', '$2y$10$gjLbJTEVx4eFUCCz1O6NEucdFjG5qlAD98DuaZVHdMpimc6X7mgPa', 'admin', 0, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blank_pages`
--
ALTER TABLE `blank_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blog_user` (`user`);

--
-- Indices de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blog_post_blog` (`blog_id`);

--
-- Indices de la tabla `calendars`
--
ALTER TABLE `calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_calendar` (`calendar_id`);

--
-- Indices de la tabla `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_forum` (`user`);

--
-- Indices de la tabla `forum_categories`
--
ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `forum_categories_relation`
--
ALTER TABLE `forum_categories_relation`
  ADD KEY `fk_forum_id_category` (`forum_id`),
  ADD KEY `fk_forum_category_id` (`forum_category_id`);

--
-- Indices de la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_forum_posts` (`user`),
  ADD KEY `fk_id_forum_posts` (`forum_id`);

--
-- Indices de la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_forum_responses` (`user`),
  ADD KEY `fk_id_forum_posts_responses` (`forum_post_id`);

--
-- Indices de la tabla `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blank_pages`
--
ALTER TABLE `blank_pages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_blog_user` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION;

--
-- Filtros para la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `fk_blog_post_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD CONSTRAINT `fk_event_calendar` FOREIGN KEY (`calendar_id`) REFERENCES `calendars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `forums`
--
ALTER TABLE `forums`
  ADD CONSTRAINT `fk_user_forum` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `forum_categories_relation`
--
ALTER TABLE `forum_categories_relation`
  ADD CONSTRAINT `fk_forum_category_id` FOREIGN KEY (`forum_category_id`) REFERENCES `forum_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_forum_id_category` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `fk_id_forum_posts` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_forum_posts` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  ADD CONSTRAINT `fk_id_forum_posts_responses` FOREIGN KEY (`forum_post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_forum_responses` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
