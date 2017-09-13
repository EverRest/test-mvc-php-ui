-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Вер 13 2017 р., 16:20
-- Версія сервера: 5.6.34-log
-- Версія PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `admin_test`
--

-- --------------------------------------------------------

--
-- Структура таблиці `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
(1, 'Bill'),
(2, 'John'),
(5, 'Peter'),
(6, 'Max');

-- --------------------------------------------------------

--
-- Структура таблиці `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `language` varchar(50) NOT NULL,
  `year` int(4) NOT NULL,
  `code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `books`
--

INSERT INTO `books` (`id`, `author_id`, `genre_id`, `title`, `photo`, `language`, `year`, `code`) VALUES
(1, 1, 2, 'book1', 'uploads/IMG_2120.JPG.jpg', 'fsdfsdaf', 212, '543546'),
(2, 1, 1, 'sfsafsafsaf', 'uploads/IMG_2121.JPG.jpg', 'dasdsa21', 312, '423432423'),
(3, 1, 2, 'fkjdskjlfsdkfksdfd', 'uploads/IMG_2303.JPG.jpg', 'bxas', 2131, '3213'),
(4, 5, 2, 'jlkjljl;j', 'uploads/IMG_2117.JPG.jpg', 'dsdfsd', 2001, '2131312'),
(5, 1, 2, 'Sweet Home Alabama', 'uploads/IMG_0765.JPG.jpg', 'ukr', 2002, '978-2-12-345680-3'),
(6, 1, 2, 'Common feel the noize', 'uploads/IMG_0326.JPG.jpg', 'rus', 1994, '978-2-12-345680-3'),
(7, 1, 2, 'Maugli', 'uploads/IMG_0297.JPG.jpg', 'eng', 1900, '978-2-12-345680-3'),
(8, 1, 2, '1984', 'uploads/IMG_0803.JPG.jpg', 'rus', 1984, '978-2-12-345680-3'),
(9, 1, 2, 'A Doll\'s House', 'uploads/IMG_0483.JPG.jpg', 'nor', 1854, '978-2-12-345680-3'),
(10, 6, 2, 'Bible', 'uploads/IMG_0756.JPG.jpg', 'pol', 50, '978-2-12-345680-3'),
(11, 2, 1, 'Dekameron', 'uploads/IMG_7731.JPG.jpg', 'rus', 2017, '978-2-12-345680-3'),
(12, 5, 2, 'Terra Inkognita', 'uploads/IMG_7656.JPG.jpg', 'eng', 2017, '978-2-12-345680-3'),
(13, 2, 1, 'Heart Full of Pride', 'uploads/IMG_7100.JPG.jpg', 'ukr', 1995, '978-2-12-345680-3'),
(14, 6, 2, 'Tarzan', 'uploads/IMG_5370.JPG.jpg', 'eng', 1933, '978-2-12-345680-3'),
(15, 6, 1, 'Tarzan 3', 'uploads/IMG_1486.JPG.jpg', 'ukr', 1933, '978-2-12-345680-3'),
(16, 6, 1, 'Clockwork Orange', 'uploads/IMG_1527.JPG.jpg', 'eng', 1966, '978-2-12-345680-3'),
(17, 6, 1, 'United We Stand', 'uploads/IMG_0834.JPG.jpg', 'ukr', 2010, '978-2-12-345680-3');

-- --------------------------------------------------------

--
-- Структура таблиці `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'sci-fi'),
(2, 'fantasy');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Індекси таблиці `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблиці `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблиці `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `authors`
--
ALTER TABLE `authors`
  ADD CONSTRAINT `authors_ibfk_1` FOREIGN KEY (`id`) REFERENCES `books` (`author_id`) ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `genres`
--
ALTER TABLE `genres`
  ADD CONSTRAINT `genres_ibfk_1` FOREIGN KEY (`id`) REFERENCES `books` (`genre_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
