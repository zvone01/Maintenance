-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2019 at 06:30 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maintenance`
--

-- --------------------------------------------------------

--
-- Table structure for table `checkitems`
--

CREATE TABLE `checkitems` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE latin2_croatian_ci NOT NULL,
  `Description` varchar(255) COLLATE latin2_croatian_ci NOT NULL,
  `Unit_of_measure` varchar(50) COLLATE latin2_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `checkitems`
--

INSERT INTO `checkitems` (`ID`, `Name`, `Description`, `Unit_of_measure`) VALUES
(1, 'Test2', 'nestotamo', 'mg'),
(2, 'Test2', 'nestotamo', 'mg'),
(3, 'Test2', 'nestotamo', 'mg'),
(4, 'Test2', 'nestotamo', 'mg'),
(5, 'Test2', 'nestotamo', 'mg'),
(6, 'Test2', 'nestotamo', 'mg'),
(7, 'Test2', 'nestotamo', 'mg'),
(8, 'Test2', 'nestotamo', 'mg'),
(9, 'Test2', 'nestotamo', 'mg'),
(10, 'Test2', 'nestotamo', 'mg'),
(11, 'Test2', 'nestotamo', 'mg'),
(12, 'Test2', 'nestotamo', 'mg'),
(13, 'Test2', 'nestotamo', 'mg'),
(14, 'Test2', 'nestotamo', 'mg'),
(15, 'Check 1', '2', '2'),
(16, 'ere', '3434', '434'),
(17, 'ere', '3434', '434'),
(18, 'ere', '3434', '434'),
(19, 'ere', '3434', '434'),
(20, 'ere', '3434', '434'),
(21, 'checj 2', '', ''),
(22, 'fdgdfg', '', ''),
(23, '', '', ''),
(24, 'Check 1', '1', ''),
(25, 'Check 1', '1', ''),
(26, 'Check 2', '', ''),
(27, 'Check 2', '', ''),
(28, 'Check 3', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `ID` int(11) NOT NULL,
  `Template_ID` int(11) NOT NULL,
  `Machine_ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Date_Time` datetime NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Checked` tinyint(1) NOT NULL,
  `Value` float DEFAULT NULL,
  `Note` text COLLATE latin2_croatian_ci NOT NULL,
  `Failure_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checklist_templates`
--

CREATE TABLE `checklist_templates` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE latin2_croatian_ci DEFAULT NULL,
  `Frequency` int(11) NOT NULL,
  `Machine_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `checklist_templates`
--

INSERT INTO `checklist_templates` (`ID`, `Name`, `Frequency`, `Machine_ID`) VALUES
(1, 'Check 1', 1, 13),
(3, 'Nesto', 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `checklist_templates_items`
--

CREATE TABLE `checklist_templates_items` (
  `Item_ID` int(11) NOT NULL,
  `List_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `checklist_templates_items`
--

INSERT INTO `checklist_templates_items` (`Item_ID`, `List_ID`) VALUES
(1, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3);

-- --------------------------------------------------------

--
-- Table structure for table `failure`
--

CREATE TABLE `failure` (
  `ID` int(11) NOT NULL,
  `Note` text COLLATE latin2_croatian_ci NOT NULL,
  `Picture_link` varchar(255) COLLATE latin2_croatian_ci NOT NULL,
  `Date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE `machine` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE latin2_croatian_ci NOT NULL,
  `Description` varchar(255) COLLATE latin2_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`ID`, `Name`, `Description`) VALUES
(9, 'Test2', 'Name'),
(13, 'Stroj 1', 'Name'),
(14, 'Test255', ''),
(15, 'test', ''),
(16, 'Test2', ''),
(17, 'test2', ''),
(18, 'test', ''),
(19, 'Ime', ''),
(20, 'nest', '2'),
(21, 'Nesto Livo', 'lalala'),
(22, 'Test1235Login', '12313'),
(23, 'Novi Stroj', 'alalal');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE latin2_croatian_ci NOT NULL,
  `Surname` varchar(50) COLLATE latin2_croatian_ci NOT NULL,
  `Username` varchar(20) COLLATE latin2_croatian_ci NOT NULL,
  `Password` varchar(200) COLLATE latin2_croatian_ci NOT NULL,
  `Email` varchar(50) COLLATE latin2_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Name`, `Surname`, `Username`, `Password`, `Email`) VALUES
(12, 'Tomislav', 'Gacina', 'TomislavG', '$2y$10$yu87ZvxwQNQmZY9gFAGwFuVTn2t0oBMEscx8UVxOQ2BwSo0K308Ui', 'tomi@tomi.com'),
(14, 'Zvone', 'D', 'ZvoneD', '$2y$10$2fNWkNU39m8ofG2xyUJP/..SCnx/n7INfuPGqFlb/GDt9eodHDYiu', 'a@a.com'),
(15, 'Ante', 'Gotovina', 'AnteG', '$2y$10$l.LycB63leaHyFwICdYqquKFXiq/ZCNHSXYSScAKKlX3VODc0wSQC', '123@jesifra.com');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) COLLATE latin2_croatian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`ID`, `Name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes_user`
--

CREATE TABLE `usertypes_user` (
  `UserID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2 COLLATE=latin2_croatian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checkitems`
--
ALTER TABLE `checkitems`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`ID`,`Template_ID`,`Machine_ID`,`Item_ID`,`User_ID`,`Failure_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Failure_ID` (`Failure_ID`),
  ADD KEY `Machine_ID` (`Machine_ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `Template_ID` (`Template_ID`);

--
-- Indexes for table `checklist_templates`
--
ALTER TABLE `checklist_templates`
  ADD PRIMARY KEY (`ID`,`Machine_ID`),
  ADD KEY `Machine_ID` (`Machine_ID`);

--
-- Indexes for table `checklist_templates_items`
--
ALTER TABLE `checklist_templates_items`
  ADD PRIMARY KEY (`Item_ID`,`List_ID`),
  ADD KEY `Item_ID` (`Item_ID`),
  ADD KEY `List_ID` (`List_ID`);

--
-- Indexes for table `failure`
--
ALTER TABLE `failure`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `machine`
--
ALTER TABLE `machine`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checkitems`
--
ALTER TABLE `checkitems`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `checklist_templates`
--
ALTER TABLE `checklist_templates`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failure`
--
ALTER TABLE `failure`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `machine`
--
ALTER TABLE `machine`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `checklist_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`ID`),
  ADD CONSTRAINT `checklist_ibfk_2` FOREIGN KEY (`Failure_ID`) REFERENCES `failure` (`ID`),
  ADD CONSTRAINT `checklist_ibfk_3` FOREIGN KEY (`Machine_ID`) REFERENCES `machine` (`ID`),
  ADD CONSTRAINT `checklist_ibfk_4` FOREIGN KEY (`Item_ID`) REFERENCES `checkitems` (`ID`),
  ADD CONSTRAINT `checklist_ibfk_5` FOREIGN KEY (`Template_ID`) REFERENCES `checklist_templates` (`ID`);

--
-- Constraints for table `checklist_templates`
--
ALTER TABLE `checklist_templates`
  ADD CONSTRAINT `checklist_templates_ibfk_1` FOREIGN KEY (`Machine_ID`) REFERENCES `machine` (`ID`);

--
-- Constraints for table `checklist_templates_items`
--
ALTER TABLE `checklist_templates_items`
  ADD CONSTRAINT `checklist_templates_items_ibfk_1` FOREIGN KEY (`Item_ID`) REFERENCES `checkitems` (`ID`),
  ADD CONSTRAINT `checklist_templates_items_ibfk_2` FOREIGN KEY (`List_ID`) REFERENCES `checklist_templates` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
