-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 20 2020 г., 15:00
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ariadnarec`
--

-- --------------------------------------------------------

--
-- Структура таблицы `doctors_type`
--

CREATE TABLE `doctors_type` (
  `ID` int(12) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `COMMENT` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `doctors_type`
--

INSERT INTO `doctors_type` (`ID`, `NAME`, `COMMENT`) VALUES
(2, 'Городской', 'Тип врача \"Взрослый\"'),
(3, 'Детский', 'Тип врача \"Детский\"'),
(5, 'Сольвычегодск', 'Регистратура Сольвычегодска');

-- --------------------------------------------------------

--
-- Структура таблицы `kiosk_params`
--

CREATE TABLE `kiosk_params` (
  `ID` int(12) NOT NULL,
  `NAME` varchar(100) DEFAULT NULL,
  `VALUE` varchar(100) DEFAULT NULL,
  `COMMENT` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `kiosk_params`
--

INSERT INTO `kiosk_params` (`ID`, `NAME`, `VALUE`, `COMMENT`) VALUES
(1, 'SEARCH_BY_POLICE', '0', NULL),
(2, 'FILTER_INET', '1', NULL),
(3, 'PRINT_CH_KIND', '2', '1 - чековый Custom, 2 - чековый обычный, 3 - статталон А5 двуст., 4 - А4, односторонний'),
(4, 'SEPARATE_TERMINALS', '0', 'Отвечает за разделение на несколько терминалов'),
(5, 'DOCTORS_TYPE', '1', 'Определяет, есть ли разделение на тип врачей (например, взрослый или детский). '),
(6, 'STRUCTURE_SEPARATE', '0', 'Разделение по структурным подразделениям ЛПУ (например, филиалы)');

-- --------------------------------------------------------

--
-- Структура таблицы `lpu`
--

CREATE TABLE `lpu` (
  `ID` int(12) NOT NULL,
  `NAME` varchar(256) NOT NULL,
  `ADDRESS` varchar(512) DEFAULT NULL,
  `SITE_URL` varchar(256) DEFAULT NULL,
  `PHONE` varchar(64) DEFAULT NULL,
  `MAP_URL` varchar(256) DEFAULT NULL,
  `PHOTO` mediumblob DEFAULT NULL,
  `XMLSERVER_URL` varchar(256) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lpu`
--

INSERT INTO `lpu` (`ID`, `NAME`, `ADDRESS`, `SITE_URL`, `PHONE`, `MAP_URL`, `PHOTO`, `XMLSERVER_URL`) VALUES
(5, 'Коряжма. Городская центральная больница', NULL, NULL, NULL, NULL, NULL, '10.0.0.197:9999');

-- --------------------------------------------------------

--
-- Структура таблицы `main_buttons`
--

CREATE TABLE `main_buttons` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(500) DEFAULT NULL,
  `PAGE_URL` varchar(500) DEFAULT NULL,
  `STAT` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `main_buttons`
--

INSERT INTO `main_buttons` (`ID`, `NAME`, `PAGE_URL`, `STAT`) VALUES
(1, 'Наши врачи', 'refs/_html/our_doctors.htm', 0),
(2, 'Запись', 'speciality.php?mode=1&dms=0', 1),
(3, 'Расписание', 'speciality.php?mode=2', 1),
(4, 'Объявления', 'refs/_html/news.htm', 0),
(11, 'Платные услуги', 'speciality.php?mode=1&dms=1', 0),
(10, 'Прейскурант', 'pricelist.php', 0),
(12, 'Отмена записи', 'pat_numbers.php', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `doctors_type`
--
ALTER TABLE `doctors_type`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `kiosk_params`
--
ALTER TABLE `kiosk_params`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `lpu`
--
ALTER TABLE `lpu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `main_buttons`
--
ALTER TABLE `main_buttons`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `doctors_type`
--
ALTER TABLE `doctors_type`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `kiosk_params`
--
ALTER TABLE `kiosk_params`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `lpu`
--
ALTER TABLE `lpu`
  MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `main_buttons`
--
ALTER TABLE `main_buttons`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
