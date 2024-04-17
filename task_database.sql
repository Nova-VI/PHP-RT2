-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 12:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `Submission text` text NOT NULL,
  `Date` date NOT NULL,
  `User_Id` varchar(18) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `Submission text`, `Date`, `User_Id`) VALUES
(2, 'The website is user-friendly and easy to navigate.\n', '2024-04-17', '77937452a65ea53aaa'),
(3, 'I encountered a bug while updating tasks.', '2024-04-17', '77937452a65ea53aaa'),
(4, 'Great task organization features!', '2024-04-17', '24ac98bd45c3e80608'),
(5, 'The website\'s design is clean and professional.', '2024-04-17', '117625aeae4e65920e'),
(6, 'I had difficulty accessing the profile page.', '2024-04-17', 'dee6dd81e4eaa668fc'),
(7, 'Love the statistics feature!', '2024-04-17', 'b12454c839974b80d2'),
(8, 'The search function doesn\'t always work correctly.', '2024-04-17', '061efed625c81f0990'),
(9, 'Task sorting options are very helpful.', '2024-04-17', '061efed625c81f0990'),
(10, 'Responsive customer support team.', '2024-04-17', 'e72739347b93ed9c5b');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` varchar(128) NOT NULL,
  `title` varchar(256) NOT NULL,
  `description` text DEFAULT NULL,
  `creation_date` date NOT NULL,
  `end_date` date NOT NULL,
  `completion_date` date DEFAULT NULL,
  `status` varchar(128) NOT NULL,
  `user_id` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `title`, `description`, `creation_date`, `end_date`, `completion_date`, `status`, `user_id`) VALUES
('2094842cd62ef97ca8e24277e9a45057', 'Update training materials', 'Revise training materials for new employee onboarding.', '2024-03-29', '2024-04-25', '2024-04-01', 'Finished', 'e72739347b93ed9c5b'),
('29296ccee15cc3b26e22c0c550412c7b', 'Review marketing campaign', 'Analyze performance metrics and suggest improvements.', '2024-04-17', '2024-05-15', NULL, 'In Progress', '77937452a65ea53aaa'),
('2f40732f54c3964178eb183298058467', 'Update website content', 'Add new blog posts and update product descriptions.', '2024-04-17', '2024-04-30', NULL, 'In Progress', '77937452a65ea53aaa'),
('37f987cbcac4d9be5948eb1bb447ab5e', 'Attend tech conference', 'Participate in a tech conference to learn about industry best practices.', '2024-04-17', '2024-03-20', NULL, 'Overdue', '061efed625c81f0990'),
('3f5ae49e59c65e29a879279e2c014ae5', 'Conduct user testing', 'Organize and conduct user testing sessions for a new software release.', '2024-03-17', '2024-04-17', '2024-03-20', 'Finished', 'e72739347b93ed9c5b'),
('467e50d5c67dc3dc54f5145e7ad1808c', 'Finalize project proposal', 'Polish and finalize the project proposal for client presentation.', '2024-04-17', '2024-05-20', NULL, 'In Progress', 'e72739347b93ed9c5b'),
('54c8b53cf4b683db9dc768d32a017681', 'Develop new feature', 'Implement a new feature based on customer requests.', '2024-04-17', '2024-05-05', NULL, 'In Progress', '117625aeae4e65920e'),
('570a191373598ec8ca4d8e0938dfddc3', 'Prepare quarterly report', 'Compile financial data and create a report for stakeholders.', '2024-04-17', '2024-04-20', '2024-04-17', 'Finished', '77937452a65ea53aaa'),
('5c7513eab6dac284cd4e57fc856048c1', 'Optimize database queries', 'Improve performance by optimizing SQL queries.', '2024-04-12', '2024-04-16', '2024-04-13', 'Finished', '061efed625c81f0990'),
('5d9733db4172f4c0ab48de1c232e35c9', 'Update social media accounts', 'Post regular updates and engage with followers on social media platforms.', '2024-04-17', '2024-05-15', NULL, 'In Progress', 'b12454c839974b80d2'),
('654f131bdda11554241ccb9b798372c8', 'Review contract terms', 'Review and negotiate contract terms with a vendor.', '2024-04-17', '2024-03-27', NULL, 'Overdue', 'e72739347b93ed9c5b'),
('75581883090086b7448cb22ff0d8f404', 'Create API documentation', 'Document APIs for external developers to integrate with our platform.', '2024-04-17', '2024-03-29', NULL, 'Overdue', '061efed625c81f0990'),
('7a81fcd0c038898ff57a9c6ba784062e', 'Test software updates', 'Conduct thorough testing of recent software updates.', '2024-04-17', '2024-04-28', '2024-04-17', 'Finished', '117625aeae4e65920e'),
('900f0bbec6f17c36d8571b9f1d5d164b', 'Review project budget', 'Analyze project expenses and update budget projections.', '2024-04-17', '2024-01-30', NULL, 'Overdue', 'dee6dd81e4eaa668fc'),
('933cd71abbb6cd8a0eb2cecfd173363a', 'Code review', 'Review and provide feedback on code submitted by team members.', '2024-04-17', '2024-05-05', NULL, 'In Progress', '061efed625c81f0990'),
('9a25536ebc51c46534876941f88920d0', 'Conduct customer survey', 'Design and distribute a survey to gather feedback from customers.', '2024-04-17', '2024-10-05', NULL, 'In Progress', '24ac98bd45c3e80608'),
('c698aff431f9b75e6822410c37c74bc8', 'Plan team training session', 'Coordinate a training session for team members.', '2024-04-17', '2024-04-02', NULL, 'Overdue', 'dee6dd81e4eaa668fc'),
('ea406b80915631717abf55053309c3bf', 'Debug software issues', 'Identify and fix bugs reported by users.', '2024-04-17', '2024-04-25', '2024-04-17', 'Finished', 'dee6dd81e4eaa668fc'),
('f1f3ef9eaaec567e6e5a1b37ab79a762', 'Research new technology trends', 'Stay updated on the latest trends and innovations in the tech industry.', '2024-04-17', '2024-05-20', NULL, 'In Progress', 'dee6dd81e4eaa668fc'),
('f2a7b67a47511111503e008570a4e9f8', 'Test mobile app', 'Conduct usability testing for a mobile application.', '2024-04-17', '2024-04-28', '2024-04-17', 'Finished', 'b12454c839974b80d2'),
('f5ca7aecf8e419d2c3e1f88324eeca2b', 'Update inventory database', 'Add new products and update stock levels.', '2024-04-17', '2024-04-25', '2024-04-17', 'Finished', '24ac98bd45c3e80608'),
('fd74d49e771b950b5f1b534704c51dce', 'Attend project meeting', 'Participate in a project meeting to discuss progress and next steps.', '2024-04-17', '2024-04-15', NULL, 'Overdue', '117625aeae4e65920e');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(18) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `profile_image` varchar(256) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `username` varchar(128) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `profile_image`, `birth_date`, `username`, `role`) VALUES
('061efed625c81f0990', 'codingexpert@example.com', '$2y$10$U0JU5Muq.VPyefCqluFu2OrnZvfNYbeNate6zeJaZIw4W/tv2X/32', 'images/66203f24de633.png', '1997-03-12', 'codingexpert97', 'user'),
('117625aeae4e65920e', 'mike1988@email.com', '$2y$10$jCT/Ddj6DS.e9CGlElx3eewgPsaRhpp4QCMDmWdzPQlpdnLM2EuYa', 'images/66203c55d10e7.png', '1990-03-25', 'mike1988', 'user'),
('15838e21c824f9aaa6', 'admin@example.com', '$2y$10$IhR8xRPrK98PcyA7KivUyuZmFNdj/pOBgfhXo/dIoA9DWomHrFQcG', 'images/662040a5400df.png', '1985-01-01', 'admin', 'admin'),
('24ac98bd45c3e80608', 'sarah.smith@example.com', '$2y$10$uZfwoXyu2XgM5ETlZ4pFlu4Z5uVdtynTg.6yKcnCi2.ibYugzn6HC', 'images/66203bbdd9250.png', '1988-11-18', 'sarahsmith90', 'user'),
('77937452a65ea53aaa', 'johndoe95@example.com', '$2y$10$iFHAD83n8BT7kwtfRDtk7.ruZQ7yqA5yAsUTFJuugpm8cgahn8e3C', 'images/66203af923593.png', '1995-09-12', 'johndoe95', 'user'),
('b12454c839974b80d2', 'emily96@email.com', '$2y$10$LTinXsTsvhlBnk0MOw3mx.Or4ohWFlqUy8itzBDmxyn7EnF6k9RsC', 'images/66203de4887df.png', '1996-02-14', 'emily96', 'user'),
('dee6dd81e4eaa668fc', 'techwizard@example.com', '$2y$10$iYkNM/E/xfUn/SGEbl8QG.nrlnF4r4BTo5q2nlpH3FvVPSe56YMk6', 'images/66203d1b4bf8f.png', '1993-07-08', 'techwizard93', 'user'),
('e72739347b93ed9c5b', 'annie94@example.com', '$2y$10$OrqNt4Uffzq2lUj./Ob5bOMNe6Jc2rTqvYSRnjFEPfHyMr1DqX3NO', 'images/66203ffeb77df.png', '1994-06-20', 'annie94', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign Key` (`User_Id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`User_Id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
