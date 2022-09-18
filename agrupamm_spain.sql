-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2022 a las 00:26:57
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
-- Base de datos: `agrupamm_spain`
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
(1, '<h1>&nbsp;</h1><figure class=\\\"image image_resized\\\" style=\\\"width:56.65%;\\\"><img src=\\\"https://www.novatrans.es/wp-content/uploads/2021/03/agrupamm-spain.jpg\\\"></figure>'),
(2, '<h1>BLANK PAGE EXAMPLE</h1><p>&nbsp;</p><p style=\"text-align:center;\"><u>Thank you for choosing</u><strong><u> WE ARE</u></strong></p><figure class=\"image image_resized image-style-side\" style=\"width:49.3%;\"><img src=\"https://blog.darwinbox.com/hubfs/MicrosoftTeams-image%20%2824%29-1.png\" alt=\"Our team\"></figure><p>We Are proposes generate a platform with which users can</p><p>&nbsp;create their own web page without programming knowledge. The platform will offer a series of components that can be added to the web. The resulting website will be highly customizable and can be modified by adding new information and sections, modifying them, deleting them and managing privacy.</p><p>We offer modern solutions to help you to make presence on the Internet</p><p>The main components are:</p><ul><li>Galleries</li><li>Blogs</li><li>Forums</li><li>Calendars</li><li>Blank pages</li><li>User administration</li></ul><h4>WE ARE has two plans for web pages</h4><figure class=\"table\" style=\"width:78.17%;\"><table><colgroup><col style=\"width:17.43%;\"><col style=\"width:13.11%;\"><col style=\"width:12.72%;\"><col style=\"width:11.3%;\"><col style=\"width:10.5%;\"><col style=\"width:23.07%;\"><col style=\"width:11.87%;\"></colgroup><thead><tr><th>Plan</th><th>Galleries</th><th>Blogs</th><th>Forums</th><th>Calendars</th><th>Blank pages</th><th>Users</th></tr></thead><tbody><tr><td><strong>Basic plan</strong></td><td>Only 1</td><td>Unlimited</td><td>Unlimited</td><td>Only 1</td><td>Only 1 (and Home page)</td><td>Unlimited</td></tr><tr><td><strong>Advanced plan</strong></td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td><td>Unlimited</td></tr></tbody></table></figure><p>For more information you can always read our <a href=\"http://localhost/TFG/blog.html\">blog </a>with all the necessary information&nbsp;</p>'),
(3, '<h1>Sobre nosotros</h1><p>&nbsp;</p><p>Agrupamm es una empresa familiar con grandes conocimientos del sector de la logística y distribución por carretera y aplica una filosofía de servicio diferente a sus competidores.</p><figure class=\\\"image\\\"><img src=\\\"data:image/jpeg;base64,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\\\"></figure><p>Se rodea de profesionales altamente cualificados tanto en el ámbito logístico como a nivel de conducción y manipulación del producto creando una oferta altamente demandada.</p><figure class=\\\"image image_resized\\\" style=\\\"width:45.23%;\\\"><img src=\\\"https://www.transporte3.com/images/galerias/articulo/Scania-HAM-5e8637cd10ee5.jpg\\\"></figure><p>Agrupamm se especializa en el transporte de <strong><u>hidrocarburos </u></strong>incorporando todas las novedades que surgen para el mismo asi como la constante formación del personal que compone su plantilla.</p><p><img src=\\\"https://serprogas.com.gt/wp-content/uploads/2020/07/descarga-de-combustible.jpg\\\"></p><hr><p>Puede contactar con nosotros a traves de :</p><p>Telefono: 123456789</p><p>Email: <a href=\\\"mailto:ejemplo@agrupamm.es\\\">ejemplo@agrupamm.es</a></p><p>O localizarnos en :&nbsp;</p><p><span style=\\\"background-color:rgb(255,255,255);color:rgb(91,91,91);\\\">Av. Castejón de Valdejasa, 65, 50830 Villanueva de Gállego, Zaragoza</span></p>');

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
(1, 'Comunidad autónoma de Aragón', 'Localidades de Aragon donde se realizan actualmente transporte', 'Marc'),
(2, 'Comunidad autónoma de Cataluña', 'Localidades de Cataluña donde se realizan actualmente transporte', 'Marc'),
(3, 'Comunidad autónoma del País Vasco', 'Localidades del País Vasco donde se realizan actualmente transporte', 'Marc'),
(4, 'Noticias Agrupamm Spain', 'La actualidad de Agrupamm Spain', 'Marc');

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
(1, 'Zaragoza', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d95398.1166755271!2d-1.030263032746488!3d41.65161194045109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5914dd5e618e91%3A0x49df13f1158489a8!2sZaragoza!5e0!3m2!1ses!2ses!4v1663110257616!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 1, '2022-09-14 01:04:30'),
(2, 'Calatayud', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11979.834189493396!2d-1.651873108552281!3d41.35325471827555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5b8f354129566d%3A0x634a2ef98b744830!2sCalatayud%2C%20Zaragoza!5e0!3m2!1ses!2ses!4v1663110293895!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 1, '2022-09-14 01:04:59'),
(3, 'Tarazona', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11877.605977509556!2d-1.7344895083094467!3d41.90572701751851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5baccd41219e47%3A0xd2e48371a6137590!2s50500%20Tarazona%2C%20Zaragoza!5e0!3m2!1ses!2ses!4v1663110317207!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 1, '2022-09-14 01:05:22'),
(4, 'Tarragona', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96174.66233763835!2d1.2110901433120869!3d41.124522441037705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a3fcc7a237c59b%3A0x400fae021a56150!2sTarragona!5e0!3m2!1ses!2ses!4v1663110341391!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 2, '2022-09-14 01:05:46'),
(5, 'Amposta', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d96174.66233763835!2d1.2110901433120869!3d41.124522441037705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a0fe73e6ca863b%3A0x1f27f3cf79a6d7b2!2s43870%20Amposta%2C%20Tarragona!5e0!3m2!1ses!2ses!4v1663110366279!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 2, '2022-09-14 01:06:12'),
(6, 'Reus', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24034.158863611217!2d1.0896585259264318!3d41.150462524328894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a150e4b86d9e5d%3A0x2e2190d249deced2!2sReus%2C%20Tarragona!5e0!3m2!1ses!2ses!4v1663110383854!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 2, '2022-09-14 01:06:29'),
(7, 'Irun', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46432.88755952671!2d-1.8267239343886796!3d43.334028258067285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51088ba8674817%3A0x86ff9f9180d14bb8!2zSXLDum4sIEdpcHV6a29h!5e0!3m2!1ses!2ses!4v1663175649830!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 3, '2022-09-14 19:14:21'),
(8, 'Elgoibar', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46527.49780345379!2d-2.4450787852471745!3d43.21014765946181!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd51d430e2d4e509%3A0x4e50d0f532c00f6b!2sElg%C3%B3ibar%2C%20Gipuzkoa!5e0!3m2!1ses!2ses!4v1663175687030!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 3, '2022-09-14 19:15:17'),
(9, 'Burutain', '<iframe src=\\\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d296731.3318363718!2d-1.7700378191732484!3d42.94105754677242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd50ec039f89609f%3A0xa018c67a2b52bc0!2s31798%20Burut%C3%A1in%2C%20Navarra!5e0!3m2!1ses!2ses!4v1663175735242!5m2!1ses!2ses\\\" width=\\\"600\\\" height=\\\"450\\\" style=\\\"border:0;\\\" allowfullscreen=\\\"\\\" loading=\\\"lazy\\\" referrerpolicy=\\\"no-referrer-when-downgrade\\\"></iframe>', 3, '2022-09-14 19:15:47'),
(10, 'El precio de la gasolina y diésel hoy domingo', 'Hoy domingo 18 de septiembre las gasolinas más baratas de la provincia de Las Palmas las puedes encontrar en Gran Canaria para la Gasolina 98 a 1,359€ el litro en la estación de servicio CANARY OIL de Calle Las Adelfas, esquina Los Olivos 8 en el municipio de Agüimes, seguida de la estación de servicio SANTANA DOMINGUEZ a 1,400€ el litro, situada en el municipio de Agüimes en Calle Los Cactus 15 en la isla de Gran Canaria.\\r\\n\\r\\nEn la isla de Gran Canaria podrás encontrar la Gasolina 95 más barata de toda la provincia de Las Palmas a 1,185€ el litro en CANARY OIL en Calle Las Adelfas, esquina Los Olivos 8 del municipio de Agüimes en la isla de Gran Canaria, seguida de la gasolinera PETROPRIX de AVENIDA DEL SURESTE, 1 de Gran Canaria situada en el municipio de Agüimes con un precio de 1,185€ el litro.', 4, '2022-09-18 11:59:31'),
(11, 'La gasolina registra una nueva caída y marca su precio más b', '<img src=\\\"https://estaticosgn-cdn.deia.eus/clip/ac927756-b211-49d5-9d8d-44709b9a7da3_16-9-discover-aspect-ratio_default_0.jpg\\\" width=\\\"50%\\\"></img><br>La gasolina registró una nueva caída durante la última semana hasta registrar un precio medio de 1,579 euros el litro -aplicando el descuento de 20 céntimos del Gobierno-, situándose en niveles no registrados desde el pasado mes de enero, mientras que el gasóleo también baja tras tres semanas consecutivas al alza.<br><br>Asimismo, según los datos difundidos este jueves por el Boletín Petrolero de la Unión Europea (UE), que recoge el precio medio registrado en más de 11.400 estaciones de servicio del Estado entre el 6 y el 12 de septiembre, el precio de ambos carburantes sigue por debajo de la barrera de los 2 euros el litro incluso sin la bonificación pública.<br><br>Con estos valores, el coste de la gasolina ha disminuido un 2 % en los últimos siete días, mientras que el gasóleo es un 1 % más barato que hace una semana.<br><br>Durante la última semana, la gasolina marcó su precio más bajo desde finales de enero, cuando se pagaba a 1,538 euros el litro, mientras que el gasóleo ha dado un pequeño respiro tras encadenar tres subidas consecutivas coincidiendo con el final de agosto, periodo de mucho tráfico en las carreteras.', 4, '2022-09-18 12:00:37');

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
(1, 'Calendar Example', 'Description Example'),
(2, 'Calendario de Agrupamm Spain', '');

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
(1, 2, 'Vacaciones Juan Carlos', '', 'Green', '2022-09-14 01:19:58', '2022-09-18 01:19:13'),
(3, 2, 'La diada', '', 'Crimson', '2022-09-11 00:00:00', '2022-09-12 00:00:00'),
(4, 2, 'La diada pass', '', 'Crimson', '2022-09-12 00:00:00', '2022-09-13 00:00:00'),
(5, 2, 'Incorporacion nueva', 'Incorporacion nueva en la oficina', 'HotPink', '2022-09-15 00:00:00', '2022-09-16 00:00:00');

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
(1, 'Dudas de transporte', 'Marc'),
(2, 'Dudas de precios', 'Marc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories`
--

CREATE TABLE `forum_categories` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_categories_relation`
--

CREATE TABLE `forum_categories_relation` (
  `forum_id` int(6) UNSIGNED NOT NULL,
  `forum_category_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(1, 'Cualquier duda que tenga sobre el transporte que realizamos puede preguntar en este foro:\\n*Puede transportar a cierta localidad?\\n*Operan en otra comunidad?\\n*Cuanto tarda el transporte hasta cierta localidad?', '2022-09-14 00:34:27', 1, 'Marc'),
(2, 'Todo precio de transporte esta calculado en función a los kilómetros de origen-destino. \\r\\nSi tiene alguna duda sobre cuanto le costara el transporte, por favor introduzca la localidad de destino y le calcularemos el precio\\r\\n', '2022-09-14 00:34:27', 2, 'Marc');

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
(1, 'Example', 'Grid Gallery View', 'Description Example');

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
  `valid` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `email`, `user_name`, `password`, `rol`, `valid`) VALUES
('Guest', '', '', '$2y$10$cDJwYvTjWtWe4dhUcAZwoeq.01juA6GlH5VwnvOAr4/QtxS2uRIjq', 'reader', 0),
('Marc', 'leyo@gmail.com', 'Agrupamm Spain', '$2y$10$gjLbJTEVx4eFUCCz1O6NEucdFjG5qlAD98DuaZVHdMpimc6X7mgPa', 'admin', 0);

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `calendars`
--
ALTER TABLE `calendars`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `forums`
--
ALTER TABLE `forums`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `forum_categories`
--
ALTER TABLE `forum_categories`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `forum_responses`
--
ALTER TABLE `forum_responses`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

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
