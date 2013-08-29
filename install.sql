-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Авг 29 2013 г., 16:32
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `role_privilege`
--

CREATE TABLE IF NOT EXISTS `role_privilege` (
  `role_id` int(10) unsigned NOT NULL,
  `resource` varchar(32) NOT NULL,
  `privilege` varchar(32) NOT NULL,
  KEY `role_id` (`role_id`,`resource`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role_privilege`
--

INSERT INTO `role_privilege` (`role_id`, `resource`, `privilege`) VALUES
(4, 'Main', 'debug'),
(4, 'User', 'management'),
(4, 'Admin', 'read'),
(4, 'Admin', 'management'),
(4, 'Admin', 'setting'),
(4, 'User', 'setting'),
(3, 'Main', 'debug'),
(3, 'User', 'management'),
(3, 'Admin', 'read');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
