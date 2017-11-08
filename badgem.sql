-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3308
-- Время создания: Ноя 08 2017 г., 17:20
-- Версия сервера: 5.7.16
-- Версия PHP: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `create_badgem`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'testing', NULL, NULL),
(2, 'sdfsdf', NULL, NULL),
(3, 'sdfsdf', NULL, NULL),
(4, 'sdfssfsdfdsf', NULL, NULL),
(5, 'Cartoons', NULL, NULL),
(6, 'The Good Kids', NULL, NULL),
(7, 'Flags', NULL, NULL),
(8, 'Celeb Badges', NULL, NULL),
(9, 'Looney Tunes', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `tags` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `name`, `user_id`, `cat_id`, `tags`, `title`, `approved`, `created_at`, `updated_at`) VALUES
(2, 'bradley1.png', 1, 8, 'Name Tag', 'Bradley Cooper', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(3, 'Bradley_Cooper02.png', 1, 0, 'Celebrity Art', 'Bradley Cooper', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(4, 'Leverkusen Border.png', 1, 0, 'Futbol', 'Leverkusen', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(5, 'afc-Bournemouth-Border.png', 1, 0, 'Futbol', 'Bournemouth', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(6, 'Crystal-Palace-FC-Border.png', 1, 0, 'Futbol', 'Crystal Palace', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(7, 'Huddersfield-Town-Border.png', 1, 0, 'Futbol', 'Huddersfield Town', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(8, 'curry1.png', 1, 8, 'Name Tag', 'Steph Curry', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(9, 'kanye02.png', 1, 0, 'Celebrity Art', 'Kanye', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(10, 'portland.png', 1, 0, 'NBA', 'Portland Trailblazers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(11, 'Tiger02.png', 1, 0, 'Celebrity Art', 'Tiger Woods', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(12, 'timberwolves.png', 1, 0, 'NBA', 'Minnesota Timberwolves', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(13, 'wizards07.png', 1, 0, 'NBA', 'Washington Wizards', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(14, 'thunder.png', 1, 0, 'NBA', 'Oklahoma City Thunder', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(15, 'walter1.png', 1, 8, 'Name Tag', 'Walter White', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(16, 'tupac1.png', 1, 8, 'Name Tag', 'Tupac Shakur', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(17, 'ryan1.png', 1, 8, 'Name Tag', 'Ryan Gosling', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(18, 'nph1.png', 1, 8, 'Name Tag', 'Neil Patrick Harris', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(19, 'floyd1.png', 1, 8, 'Name Tag', 'Floyd Mayweather', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(20, 'nicholas1.png', 1, 8, 'Name Tag', 'Nicholas Cage', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(21, 'eminem1.png', 1, 8, 'Name Tag, Eminem', 'Marshall Mathers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(22, 'tiger2.png', 1, 8, 'Name Tag', 'Tiger Woods', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(23, 'gordon1.png', 1, 8, 'Name Tag', 'Gordon Ramsey', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(24, 'suns.png', 1, 0, 'NBA', 'Phoenix Suns', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(25, 'pistons.png', 1, 0, 'NBA', 'Detroit Pistons', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(26, 'spurs.png', 1, 0, 'NBA', 'San Antonio Spurs', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(27, 'jordan4.png', 1, 0, 'Celebrity Art', 'Michael Jordan', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(28, 'rockets.png', 1, 0, 'NBA', 'Houston Rockets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(29, 'pelicans.png', 1, 0, 'NBA', 'New Orleans Pelicans', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(30, 'kim3.png', 1, 0, 'Celebrity Art', 'Kim Kardashian', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(31, 'Bradley_Cooper-04.png', 1, 0, 'Celebrity Art', 'Bradly Cooper', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(32, 'pacers.png', 1, 0, 'NBA', 'Indiana Pacer', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(33, 'snoop05.png', 1, 0, 'Celebrity Art', 'Snoop Doggy Dog', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(34, 'kanye04.png', 1, 0, 'Celebrity Art', 'Kanye', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(35, 'Heisenberg04.png', 1, 0, 'Celebrity Art', 'Heisenberg', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(36, 'nuggets.png', 1, 0, 'NBA', 'Denver Nuggets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(37, 'nets.png', 1, 0, 'NBA', 'Brooklyn Nets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(38, 'mavs.png', 1, 0, 'NBA', 'Dallas Mavericks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(39, 'clippers.png', 1, 0, 'NBA', 'Los Angeles Clippers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(40, 'magic.png', 1, 0, 'NBA', 'Orlando Magic', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(41, 'knicks.png', 1, 0, 'NBA', 'New York Knicks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(42, 'kings.png', 1, 0, 'NBA', 'Sacramento Kings', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(43, 'jazz.png', 1, 0, 'NBA', 'Utah Jazz', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(44, 'hornets.png', 1, 0, 'NBA', 'Charlotte Hornets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(45, 'heat.png', 1, 0, 'NBA', 'Miami Heat', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(46, 'hawks.png', 1, 0, 'NBA', 'Atlanta Hawks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(47, 'grizzlies.png', 1, 0, 'NBA', 'Memphis Grizzlies', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(48, 'cavaliers.png', 1, 0, 'NBA', 'Cleveland Cavaliers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(49, 'bucks.png', 1, 0, 'NBA', 'Milwaukee Bucks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(50, '76ers.png', 1, 0, 'NBA', 'Philadelphia 76ers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(51, 'Power_Up01.png', 1, 0, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(52, 'babybugs.png', 1, 0, 'Disney', 'Baby Bugs', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(53, 'celtics.png', 1, 0, 'NBA', 'Boston Celtics', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(54, 'lakers2.png', 1, 0, 'NBA', 'Los Angeles Lakers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(55, 'jiggpuff.png', 1, 0, 'Pokemon', 'Jigglypuff', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(56, 'snorlax.png', 1, 0, 'Pokemon', 'Snorlax', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(57, 'littlepika.png', 1, 0, 'Pokemon', 'Guitar Pika', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(58, 'eevee.png', 1, 0, 'Pokemon', 'Eevee', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(59, 'meowth.png', 1, 0, 'Pokemon', 'Meowth', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(60, 'bulbasaur.png', 1, 0, 'Pokemon', 'Bulbasaur', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(61, 'gorilla.png', 1, 0, 'Animal', 'Gorilla', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(62, 'pussinboots.png', 1, 0, 'Musketeer', 'Puss in Boots', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(63, 'sheep.png', 1, 0, 'Animal', 'Sheep', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(64, 'elephant.png', 1, 0, 'Animal', 'Elephant', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(65, 'Girona-FC-Border.png', 1, 0, 'Futbol', 'Girona FC', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(66, 'mickey2.png', 1, 0, 'Disney', 'Mickey Mouse', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(67, 'Beltis Border.png', 1, 0, 'Futbol', 'Beltis', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(68, 'Celta Border.png', 1, 0, 'Futbol', 'Celta', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(69, 'La-Coruna-Border.png', 1, 0, 'Futbol', 'La Coruna', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(70, 'Las-Palmas-Border.png', 1, 0, 'Futbol', 'Las Palmas', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(71, 'Osasuna-Border.png', 1, 0, 'Futbol', 'Osasuna', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(72, 'Real-Madrid-Border.png', 1, 0, 'Futbol', 'Real Madrid', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(73, 'minnie2.png', 1, 0, 'Disney', 'Minnie Mouse', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(74, 'S.D.-Eibar-Border.png', 1, 0, 'Futbol', 'S.D. Eibar', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(75, 'Sportinggijon Border.png', 1, 0, 'Futbol', 'Sportinggijon', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(76, 'Vallodolid Border.png', 1, 0, 'Futbol', 'Vallodilad', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(77, 'Villarreal Border.png', 1, 0, 'Futbol', 'Villareal', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(78, 'goofy.png', 1, 0, 'Disney', 'Goofy', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(79, 'Manchester-United-Border.png', 1, 0, 'Futbol', 'Manchester United ', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(80, 'Middlesbrough-Border.png', 1, 0, 'Futbol', 'MIddlesbrough', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(81, 'covered.png', 1, 0, 'Fun Adults', 'I Got You Covered', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(82, 'kanye1.png', 1, 8, 'Name Tag', 'Kanye West', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(83, 'drake1.png', 1, 8, 'Name Tag', 'Drizzy Drake', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(84, 'jordan1.png', 1, 8, 'Name Tag', 'Michael Jordan', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(85, 'emilia.png', 1, 8, 'Name Tag', 'Emilia Clarke', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(86, 'duck1.png', 1, 0, 'Disney', 'Donald Duck', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(87, 'pluto1.png', 1, 0, 'Disney', 'Pluto', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(88, 'avalanche.png', 1, 0, 'NHL', 'Colorado Avalanche', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(89, 'badass4.png', 1, 0, 'Pop Art', 'Badass', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(90, 'ducks.png', 1, 0, 'Disney', 'Ducks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(91, 'kinglazyfuck10.png', 1, 0, 'Pop Art', 'King Lazy Fuck', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(92, 'lola.png', 1, 0, 'Disney', 'Lola Bunny', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(93, 'babytaz.png', 1, 0, 'Disney', 'Baby Taz', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(94, 'skunk.png', 1, 0, 'Disney', 'Skunk', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(95, 'raptorshield.png', 1, 0, 'NBA', 'Toronto Raptors', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(96, 'puffwhale.png', 1, 0, 'Pop Art', 'Puff The Magic Whale', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(97, 'blackhawks.png', 1, 0, 'NHL', 'Chicago Blackhawks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(98, 'stars.png', 1, 0, 'NHL', 'Dallas Stars', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(99, 'friendzone_05.png', 1, 0, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(100, 'thrashers.png', 1, 0, 'NHL', 'Atlanta Thrashers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(101, 'coyotes.png', 1, 0, 'NHL', 'Phoenix Coyotes', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(102, 'hurricane1.png', 1, 0, 'NHL', 'Carolina Hurricane', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(103, 'panthers1.png', 1, 0, 'NHL', 'Florida Panthers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(104, 'goldenknights1.png', 1, 0, 'NHL', 'Las Vegas Golden Knigts', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(105, 'blues.png', 1, 0, 'NHL', 'St Louis Blues', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(106, 'sharks.png', 1, 0, 'NHL', 'San Jose Sharks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(107, 'bluejackets.png', 1, 0, 'NHL', 'Columbus Blue Jackets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(108, 'lightning.png', 1, 0, 'NHL', 'Tampa Bay Lightning', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(109, 'devils.png', 1, 0, 'NHL', 'New Jersey Devils', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(110, 'predators.png', 1, 0, 'NHL', 'Nashville Predators', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(111, 'islanders.png', 1, 0, 'NHL', 'New York Islanders', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(112, 'thegoodkids11.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(113, 'thegoodkids12.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(114, 'thegoodkids13.png', 1, 6, '', 'Thegoodkids', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(115, 'lakings.png', 1, 0, 'NHL', 'Los Angeles Kings', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(116, 'wild.png', 1, 0, 'NHL', 'Minnesota Wild', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(117, 'sabres.png', 1, 0, 'NHL', 'Buffalo Sabres', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(118, 'capitals.png', 1, 0, 'NHL', 'Washington Capitals', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(119, 'anaheimducks.png', 1, 0, 'NHL', 'Anaheim Ducks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(120, 'senators.png', 1, 0, 'NHL', 'Ottawa Senators', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(121, 'jets.png', 1, 0, 'NHL', 'Winnepeg Jets', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(122, 'flames.png', 1, 0, 'NHL', 'Calgary Flames', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(123, 'redwings.png', 1, 0, 'NHL', 'Detroit Red Wings', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(124, 'flyers.png', 1, 0, 'NHL', 'Philadelphia Flyers', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(125, 'mapleleafs.png', 1, 0, 'NHL', 'Toronto Maple Leafs', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(126, 'Moghreb-Final-Border.png', 1, 0, 'Futbol', 'Moghreb', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(127, 'canucks.png', 1, 0, 'NHL', 'Vancouver Canucks', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(128, 'liverpool copy 1.png', 1, 0, 'Futbol', 'Liverpool', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(129, 'bostonbruins.png', 1, 0, 'NHL', 'Boston Bruins', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(130, 'thegoodkids18.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(131, 'TGK_KKK_05.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(132, 'TGK_Halloween_03.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(133, 'Bugs-Bunny Final.png', 1, 9, 'Looney Tunes', 'Bugs Bunny', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(134, 'Yosemite-Sam-Final.png', 1, 9, 'Looney Tunes', 'Yosemite Sam', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(135, 'Tweety-Final.png', 1, 9, 'Looney Tunes', 'Tweety Bird', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(136, 'Tazmanian-Devil-Final.png', 1, 9, 'Looney Tunes', 'Tazmanian Devil', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(137, 'Wile-E-Coyote-Final.png', 1, 9, 'Looney Tunes', 'Wile E Coyote', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(138, 'Pepe-Le-Pew-Final.png', 1, 9, 'Looney Tunes', 'Pepe Le Pew', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(139, 'Martin-the-Martian-Final.png', 1, 9, 'Looney Tunes', 'Martin the Martian ', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(140, 'TGK_Dora_05.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(141, 'thegoodkids19.png', 1, 6, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(142, 'Von-Vulture-Final.png', 1, 9, 'Looney Tunes', 'Von Vulture', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(143, 'Daffy-Duck-Final.png', 1, 9, 'Looney Tunes', 'Daffy Duck ', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(144, 'Foghorn-Leghorn-Final.png', 1, 9, 'Looney Tunes', 'Foghorn Leghorn', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(145, 'Belgium-Flag-Final.png', 1, 7, 'Flags', 'Belgium National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(146, 'Brazil-Flag-Final.png', 1, 7, 'Flags', 'Brazil National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(147, 'Australia-Flag-Final.png', 1, 7, 'Flags', 'Australia National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(148, 'TGK_Kill_Panda.png', 1, 0, '', '', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(149, 'Cambodia-Flag-Final.png', 1, 7, 'Flags', 'Cambodia National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(150, 'Canada-Flag-Final.png', 1, 7, 'Flags', 'Canada National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(151, 'Columbia-Flag-Final.png', 1, 7, 'Flags', 'Columbia National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(152, 'China-Flag-Final.png', 1, 7, 'Flags', 'China National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(153, 'Croatia-Flag-Final.png', 1, 7, 'Flags', 'Croatia National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(154, 'Cuba-Flag-Final.png', 1, 7, 'Flags', 'Cuba National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(155, 'Egypt-Flag-Final.png', 1, 7, 'Flags', 'Egypt National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(156, 'France-Flag-Final.png', 1, 7, 'Flags', 'France National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(157, 'jackiechan.png', 1, 8, 'Name Tag', 'Jackie Chan', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(158, 'marilyn.png', 1, 8, 'Name Tag', 'Marilyn Monroe ', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(159, 'Germany-Final-Flag.png', 1, 7, 'Flags', 'Germany National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(160, 'Greece-Flag-Final.png', 1, 7, 'Flags', 'Greece National Flag', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(161, 'bradpitt.png', 1, 8, 'Name Tag', 'Brad Pitt', 1, '2017-11-08 11:17:12', '2017-11-08 11:17:12'),
(162, 'leonardo.png', 1, 8, 'Name Tag', 'Leonardo DiCaprio', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(163, 'tomhardy.png', 1, 8, 'Name Tag', 'Tom Hardy', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(164, 'cena.png', 1, 8, 'Name Tag', 'John Cena', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(165, 'India-Flag-Final.png', 1, 7, 'Flags', 'India National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(166, 'Ireland-Flag-Final.png', 1, 7, 'Flags', 'Ireland National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(167, 'Jamaica-Flag-Final.png', 1, 7, 'Flags', 'Jamaica National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(168, 'Japan-Flag-Final.png', 1, 7, 'Flags', 'Japan National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(169, 'Korea-Flag-Final.png', 1, 7, 'Flags', 'Korea National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(170, 'Mexico-Flag-Final.png', 1, 7, 'Flags', 'Mexico National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(171, 'Netherlands-Flag-Final.png', 1, 7, 'Flags', 'Netherlands National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(172, 'Norway-Flag-Final.png', 1, 7, 'Flags', 'Norway National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(173, 'Philippines-Flag-Final.png', 1, 7, 'Flags', 'Philippines National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(174, 'Russia-Flag-Final.png', 1, 7, 'Flags', 'Russia National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(175, 'Spain-Flag-Final.png', 1, 7, 'Flags', 'Spain National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(176, 'Sweden-Flag-Final.png', 1, 7, 'Flags', 'Sweden National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(177, 'Thailand-Flag-Final.png', 1, 7, 'Flags', 'Thailand National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(178, 'United-Kingdom-Flag-Final.png', 1, 7, 'Flags', 'United Kingdom National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(179, 'United-States-Flag-Final.png', 1, 7, 'Flags', 'United States National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(180, 'Vietnam-Flag-Final.png', 1, 7, 'Flags', 'Vietnam National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(181, 'Argentina-Flag-Final.png', 1, 7, 'Flags', 'Argentina National Flag', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(182, 'Thizz_nov7.png', 1, 0, '', '', 0, '2017-11-08 11:17:13', '2017-11-08 11:17:13'),
(183, 'TGK_2.0-02.png', 1, 6, '', '', 1, '2017-11-08 11:17:13', '2017-11-08 11:17:13');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2017_11_08_110110_create_categories_table', 1),
(4, '2017_11_08_110931_create_images_table', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
