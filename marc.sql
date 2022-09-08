-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2022 a las 10:08:06
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
-- Base de datos: `marc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blank_pages`
--

CREATE TABLE `blank_pages` (
  `id` int(11) NOT NULL,
  `content` mediumtext NOT NULL DEFAULT '<h1>BLANK EXAMPLE</h1><p>&nbsp;</p><p style=\\"text-align:center;\\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\\"image image_resized image-style-side\\" style=\\"width:49.3%;\\"><img src=\\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\\" alt=\\"Our team\\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\\"table\\" style=\\"width:78.17%;\\"><table><colgroup><col style=\\"width:17.43%;\\"><col style=\\"width:13.11%;\\"><col style=\\"width:12.72%;\\"><col style=\\"width:11.3%;\\"><col style=\\"width:10.5%;\\"><col style=\\"width:23.07%;\\"><col style=\\"width:11.87%;\\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\\"http://localhost/TFG/blog.html\\">blog </a>with all the necessary information&nbsp;</p>'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `blank_pages`
--

INSERT INTO `blank_pages` (`id`, `content`) VALUES
(1, '<h1>HOME EXAMPLE</h1><p>&nbsp;</p><p style=\\\"text-align:center;\\\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\\\"image image_resized image-style-side\\\" style=\\\"width:49.3%;\\\"><img src=\\\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\\\" alt=\\\"Our team\\\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\\\"table\\\" style=\\\"width:78.17%;\\\"><table><colgroup><col style=\\\"width:17.43%;\\\"><col style=\\\"width:13.11%;\\\"><col style=\\\"width:12.72%;\\\"><col style=\\\"width:11.3%;\\\"><col style=\\\"width:10.5%;\\\"><col style=\\\"width:23.07%;\\\"><col style=\\\"width:11.87%;\\\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\\\"http://localhost/TFG/blog.html\\\">blog </a>with all the necessary information&nbsp;</p>'),
(2, '<h1>Bilingual Personality Disorderrrrrr</h1><figure class=\\\"image image-style-side\\\"><img src=\\\"https://c.cksource.com/a/1/img/docs/sample-image-bilingual-personality-disorder.jpg\\\" alt=\\\"Imagen rara\\\"></figure><p>This may be the first time you hear about this made-up disorder but it actually isn’t so far from the truth. Even the studies that were conducted almost half a century show that <strong>the language you speak has more effects on you than you realise</strong>.</p><p>One of the very first experiments conducted on this topic dates back to 1964. <a href=\\\"https://www.researchgate.net/publication/9440038_Language_and_TAT_content_in_bilinguals\\\">In the experiment</a> designed by linguist Ervin-Tripp who is an authority expert in psycholinguistic and sociolinguistic studies, adults who are bilingual in English in French were showed series of pictures and were asked to create 3-minute stories. In the end participants emphasized drastically different dynamics for stories in English and French.</p><p>Another ground-breaking experiment which included bilingual Japanese women married to American men in San Francisco were asked to complete sentences. The goal of the experiment was to investigate whether or not human feelings and thoughts are expressed differently in <strong>different language mindsets</strong>. Here is a sample from the the experiment:</p><figure class=\\\"table\\\" style=\\\"width:100%;\\\"><table><colgroup><col style=\\\"width:32.82%;\\\"><col style=\\\"width:32.82%;\\\"><col style=\\\"width:34.36%;\\\"></colgroup><thead><tr><th>&nbsp;</th><th>English</th><th>Japanese</th></tr></thead><tbody><tr><td>Real friends should</td><td>Be very frank</td><td>Help each other</td></tr><tr><td>I will probably become</td><td>A teacher</td><td>A housewife</td></tr><tr><td>When there is a conflict with family</td><td>I do what I want</td><td>It\\\'s a time of great unhappiness</td></tr></tbody></table></figure><p>More recent <a href=\\\"https://books.google.pl/books?id=1LMhWGHGkRUC\\\">studies</a> show, the language a person speaks affects their cognition, behaviour, emotions and hence <strong>their personality</strong>. This shouldn’t come as a surprise <a href=\\\"https://en.wikipedia.org/wiki/Lateralization_of_brain_function\\\">since we already know</a> that different regions of the brain become more active depending on the person’s activity at hand. Since structure, information and especially <strong>the culture</strong> of languages varies substantially and the language a person speaks is an essential element of daily life.</p>'),
(13, '<h1>BLANK EXAMPLE</h1><p>&nbsp;</p><p style=\\\"text-align:center;\\\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\\\"image image_resized image-style-side\\\" style=\\\"width:49.3%;\\\"><img src=\\\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\\\" alt=\\\"Our team\\\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\\\"table\\\" style=\\\"width:78.17%;\\\"><table><colgroup><col style=\\\"width:17.43%;\\\"><col style=\\\"width:13.11%;\\\"><col style=\\\"width:12.72%;\\\"><col style=\\\"width:11.3%;\\\"><col style=\\\"width:10.5%;\\\"><col style=\\\"width:23.07%;\\\"><col style=\\\"width:11.87%;\\\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\\\"http://localhost/TFG/blog.html\\\">blog </a>with all the necessary information&nbsp;</p>'),
(14, '<h1>BLANK EXAMPLE</h1><p>&nbsp;</p><p style=\\\"text-align:center;\\\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\\\"image image_resized image-style-side\\\" style=\\\"width:49.3%;\\\"><img src=\\\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\\\" alt=\\\"Our team\\\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\\\"table\\\" style=\\\"width:78.17%;\\\"><table><colgroup><col style=\\\"width:17.43%;\\\"><col style=\\\"width:13.11%;\\\"><col style=\\\"width:12.72%;\\\"><col style=\\\"width:11.3%;\\\"><col style=\\\"width:10.5%;\\\"><col style=\\\"width:23.07%;\\\"><col style=\\\"width:11.87%;\\\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\\\"http://localhost/TFG/blog.html\\\">blog </a>with all the necessary information&nbsp;</p>'),
(15, '<h1>BLANK EXAMPLE</h1><p>&nbsp;</p><p style=\\\"text-align:center;\\\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\\\"image image_resized image-style-side\\\" style=\\\"width:49.3%;\\\"><img src=\\\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\\\" alt=\\\"Our team\\\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\\\"table\\\" style=\\\"width:78.17%;\\\"><table><colgroup><col style=\\\"width:17.43%;\\\"><col style=\\\"width:13.11%;\\\"><col style=\\\"width:12.72%;\\\"><col style=\\\"width:11.3%;\\\"><col style=\\\"width:10.5%;\\\"><col style=\\\"width:23.07%;\\\"><col style=\\\"width:11.87%;\\\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\\\"http://localhost/TFG/blog.html\\\">blog </a>with all the necessary information&nbsp;</p>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blogs`
--

CREATE TABLE `blogs` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `user`) VALUES
(1, 'Test', 'Description test', 'Marc'),
(3, 'blog test', 'lorem ipsum', 'Marc');

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
(1, 'Test post', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2022-08-19 17:56:11'),
(2, 'Test post 2', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\\\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2022-08-26 19:34:42');

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
(1, 'test', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` int(6) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `color` varchar(60) NOT NULL,
  `start` datetime NOT NULL DEFAULT current_timestamp(),
  `end` datetime NOT NULL DEFAULT current_timestamp(),
  `calendar_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `title`, `description`, `color`, `start`, `end`, `calendar_id`) VALUES
(5, 'Test', 'dsfasdf', 'DeepSkyBlue', '2022-08-09 00:00:00', '2022-08-10 03:00:00', 1),
(6, 'Test', 'sdasdad', 'YellowGreen', '2022-08-10 01:16:00', '2022-08-17 01:00:00', 1),
(7, 'Test', 'RTRETE', 'HotPink', '2022-08-11 00:00:00', '2022-08-11 06:00:00', 1),
(8, 'Test', 'yfgh', 'BlueViolet', '2022-08-19 00:00:00', '2022-08-19 12:00:00', 1),
(9, 'Test', 'yfgh', 'Gold', '2022-08-19 00:00:00', '2022-08-19 12:00:00', 1),
(10, 'Test', 'fdsads', 'Crimson', '2022-08-28 00:00:00', '2022-08-29 00:00:00', 1),
(11, 'Ganar a Marc al BTK3', '', 'DeepSkyBlue', '2022-09-02 16:45:00', '2022-09-02 16:50:00', 1),
(12, 'Por el culo...', '', 'DeepSkyBlue', '2022-09-05 00:00:00', '2022-09-10 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums`
--

CREATE TABLE `forums` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL,
  `user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forums`
--

INSERT INTO `forums` (`id`, `title`, `user`) VALUES
(1, 'Test', 'Marc'),
(2, 'Ejemplo', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories`
--

CREATE TABLE `forum_categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `name`) VALUES
(2, 'C++'),
(1, 'Dfsd'),
(4, 'Hola'),
(3, 'Test');

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
(2, 2),
(2, 3);

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
(1, 'Post test', '2022-08-19 17:49:47', 1, 'Marc'),
(2, 'Post test', '2022-08-21 17:03:20', 1, 'leyo'),
(3, 'lo que sea', '2022-08-22 16:21:55', 2, 'Marc');

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
(4, 'Reply test', '2022-08-27 14:02:13', 2, 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galleries`
--

CREATE TABLE `galleries` (
  `id` int(6) NOT NULL,
  `title` varchar(60) NOT NULL,
  `type` varchar(60) NOT NULL DEFAULT 'Grid Gallery View',
  `description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `type`, `description`) VALUES
(1, 'Example', 'Grid Gallery View', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'),
(6, 'Test gallery', 'Grid Gallery View', 'LOREM IPSUM'),
(7, 'Test gallery 2', 'Grid Gallery View', '');

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
  `discord_user` varchar(60) NOT NULL,
  `age` int(6) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `birthday` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `email`, `user_name`, `password`, `rol`, `valid`, `discord_user`, `age`, `description`, `birthday`) VALUES
('Guest', '', 'Guest', '$2y$10$lcGpuHzh5ipwqlvckGF3u.g6Lsn1Ge9yaZa8mx6EEDsjHD48Hj.nG', 'reader', 0, '', 0, '', '2022-08-27'),
('leyo', 'leyo2@gmail.com', '', '$2y$10$pS/m42sAwv5jT63ot5jmN.yaSeVA4Z.p/rIh1xxW6qjNHIBcTLExu', 'writer', 0, '', 0, '', '2022-08-27'),
('Marc', 'leyo@gmail.com', '', '$2y$10$gjLbJTEVx4eFUCCz1O6NEucdFjG5qlAD98DuaZVHdMpimc6X7mgPa', 'admin', 0, 'TestUser#1234', 23, 'USJ studen', '1998-11-11');

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
  ADD KEY `fk_blogs_user` (`user`);

--
-- Indices de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_blog` (`blog_id`);

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
  ADD KEY `fk_calendar_cal_events` (`calendar_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `fk_blogs_user` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `fk_id_blog` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD CONSTRAINT `fk_calendar_cal_events` FOREIGN KEY (`calendar_id`) REFERENCES `calendars` (`id`);

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
  ADD CONSTRAINT `fk_id_forum_posts` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_forum_posts` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  ADD CONSTRAINT `fk_id_forum_posts_responses` FOREIGN KEY (`forum_post_id`) REFERENCES `forum_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_forum_responses` FOREIGN KEY (`user`) REFERENCES `users` (`user`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
