--
-- Database: `Framework_PHP`
--
CREATE DATABASE IF NOT EXISTS `Framework_PHP` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `Framework_PHP`;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT '1',
  `is_admin` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `tmp_password` varchar(32) DEFAULT NULL,
  `tmp_password_expires` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `lastSeen` datetime DEFAULT NULL,
  `lastLogin` timestamp NULL DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `locked` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `password` (`password`);

