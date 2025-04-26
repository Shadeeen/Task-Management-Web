-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 15, 2025 at 05:00 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web1220169_atp`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int NOT NULL,
  `houseNo` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `street` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `houseNo`, `street`, `city`, `country`) VALUES
(24, '12', 'Al-taht', 'jerusalem', 'palestine'),
(25, '12', 'Al-taht', 'jerusalem', 'palestine'),
(26, '12', 'Al-taht', 'jerusalem', 'palestine'),
(27, '12', 'Al-taht', 'jerusalem', 'palestine'),
(28, '12', 'Al-taht', 'jerusalem', 'palestine'),
(29, '1236', 'silwan', 'jerusalem', 'palestine'),
(30, '1236', 'silwan', 'jerusalem', 'palestine'),
(31, '1236', 'silwan', 'jerusalem', 'palestine');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `project_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_description` text COLLATE utf8mb4_general_ci,
  `customer_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_budget` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `doc1_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc1_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc2_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc2_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc3_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `doc3_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `leaderId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_title`, `project_description`, `customer_name`, `total_budget`, `start_date`, `end_date`, `doc1_path`, `doc1_title`, `doc2_path`, `doc2_title`, `doc3_path`, `doc3_title`, `leaderId`) VALUES
('AAAA-11111', 'project1', 'software developed design ', 'ahmad', 10000, '2025-01-01', '2025-12-01', './uploaded_files/78dd57497afd77b8ab2ca8d3ad337c70.pdf', 'support doc1', './uploaded_files/78dd57497afd77b8ab2ca8d3ad337c70.pdf', 'support doc2', './uploaded_files/78dd57497afd77b8ab2ca8d3ad337c70.pdf', 'support doc3', 1000000033),
('BBBB-22222', 'project2', 'wed design', 'samer', 5000, '2024-01-01', '2024-04-20', './uploaded_files/8ea1a39ae343a7a8e4e6b960d52e8f3f.pdf', 'support doc1', './uploaded_files/8ea1a39ae343a7a8e4e6b960d52e8f3f.pdf', 'support doc2', './uploaded_files/8ea1a39ae343a7a8e4e6b960d52e8f3f.pdf', 'support doc3', 1000000033),
('CCCC-33333', 'project3', 'algorithms', 'hanan', 1000, '2026-01-01', '2026-02-02', './uploaded_files/d514def9830227065c6ed41bcd7a9a7d.pdf', 'support doc1', './uploaded_files/d514def9830227065c6ed41bcd7a9a7d.pdf', 'support doc2', './uploaded_files/d514def9830227065c6ed41bcd7a9a7d.pdf', 'support doc3', 1000000033),
('DDDD-55555', 'project5', 'testing a health app', 'subhi', 10000, '2025-01-01', '2025-12-30', './uploaded_files/fffbbd7987f6510f16332560add55f91.pdf', 'support doc1', NULL, NULL, NULL, NULL, NULL),
('EEEE-44444', 'project4', 'SW app about sport ', 'kamal', 5000, '2025-01-04', '2025-10-05', './uploaded_files/bdacecf4e7b170079a956449c82acf30.pdf', 'support doc1', './uploaded_files/bdacecf4e7b170079a956449c82acf30.pdf', 'support doc2', './uploaded_files/bdacecf4e7b170079a956449c82acf30.pdf', 'support doc3', NULL),
('FFFF-66666', 'project6', 'design web page', 'Nour', 1000, '2025-01-23', '2025-12-27', NULL, NULL, NULL, NULL, NULL, NULL, 1000000033);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `project_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `effort` int NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `priority` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `progress` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `description`, `project_id`, `start_date`, `end_date`, `effort`, `status`, `priority`, `progress`) VALUES
(1, 'task1_AAAA', 'you should design a good SW design for a company', 'AAAA-11111', '2025-01-02', '2025-06-30', 3000, 'in Progress', 'high', 7),
(2, 'task2_AAAA', 'testing', 'AAAA-11111', '2025-07-01', '2025-08-10', 5000, 'pending', 'high', NULL),
(6, 'task1_BBBB', 'a good design', 'BBBB-22222', '2024-01-02', '2024-01-30', 500, 'completed', 'low', NULL),
(7, 'task2_BBBB', 'testing', 'BBBB-22222', '2024-03-01', '2024-03-31', 1000, 'completed', 'medium', NULL),
(8, 'task3_CCCC', 'good ideas and algorithm\'s to develop ', 'CCCC-33333', '2026-01-01', '2025-01-31', 1000, 'in Progress', 'high', NULL),
(9, 'task2_CCCC', 'testing', 'CCCC-33333', '2026-01-31', '2026-02-02', 500, 'pending', 'low', NULL),
(10, 'task1-FFFF', 'design', 'FFFF-66666', '2025-02-25', '2025-08-12', 500, 'in Progress', 'medium', 30);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idNumber` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qualification` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `skills` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `address_id` int DEFAULT NULL,
  `userName` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id` int NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'image//user2.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idNumber`, `name`, `email`, `birthDate`, `role`, `qualification`, `skills`, `phone`, `address_id`, `userName`, `pass`, `id`, `photo`) VALUES
(10000000, 'shaden', 'shadeen.hamsa@gmail.com', '2004-03-01', 'Manager', 'BA', 'coding', 524568466, 24, 'shaden', 'SH12345n', 1000000032, 'me.jpg'),
(10000001, 'yousef', 'yousef.hamsa@gmail.com', '2003-01-14', 'Project-Leader', 'BA', 'coding', 522908695, 25, 'yousef', 'YO12345f', 1000000033, 'leader.jpg'),
(10000002, 'mohammad', 'mohammad.hamsa@gmail.com', '1990-07-27', 'Team-Member', 'BA', 'coding', 524841450, 26, 'mohammad', 'MO12345d', 1000000034, 'member.jpg'),
(10000003, 'mahmmud', 'mahmmud.hamsa@gmail.com', '2002-07-09', 'Team-Member', 'BA', 'coding', 505210086, 27, 'mahmmud', 'MA12345d', 1000000035, 'member2.jpg'),
(10000004, 'jumana', 'jumana.hamsa@gmail.com', '2002-05-06', 'Team-Member', 'BA', 'coding', 546615393, 28, 'jumana', 'JU12345a', 1000000036, 'member3.jpg'),
(10000010, 'Nour', 'nourhusseee44@gmail.com', '2004-12-15', 'Team-Member', 'accounting', 'reading financial statement', 528884269, 31, 'nourhuss', 'NO12345r', 1000000037, 'nour.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_tasks`
--

CREATE TABLE `user_tasks` (
  `user_id` int NOT NULL,
  `task_id` int NOT NULL,
  `member_role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `percentage` int DEFAULT NULL,
  `start_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tasks`
--

INSERT INTO `user_tasks` (`user_id`, `task_id`, `member_role`, `percentage`, `start_date`) VALUES
(1000000034, 10, 'designer', 30, '2025-02-25'),
(1000000036, 1, 'developer', 10, '2025-01-02'),
(1000000036, 10, 'designer', 30, '2025-02-25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `fk_leaderId` (`leaderId`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `fk_project_id` (`project_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idNumber`),
  ADD UNIQUE KEY `unique_id_number` (`id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD PRIMARY KEY (`user_id`,`task_id`),
  ADD KEY `task_id` (`task_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000000038;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_leaderId` FOREIGN KEY (`leaderId`) REFERENCES `users` (`id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);

--
-- Constraints for table `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD CONSTRAINT `user_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
