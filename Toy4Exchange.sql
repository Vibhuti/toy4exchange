
-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2015 at 01:35 PM
-- Server version: 5.5.32-cll-lve
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ToyExchange`
--
CREATE DATABASE IF NOT EXISTS `ToyExchange` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ToyExchange`;

-- --------------------------------------------------------

--
-- Table structure for table `BillingInfo`
--

DROP TABLE IF EXISTS `BillingInfo`;
CREATE TABLE IF NOT EXISTS `BillingInfo` (
  `InvoiceNo` bigint(20) NOT NULL AUTO_INCREMENT,
  `InvoiceDate` datetime NOT NULL,
  `InvoiceAmount` float NOT NULL,
  `ChargedAmount` float NOT NULL,
  `CCNO` bigint(20) NOT NULL,
  `UID` int(11) NOT NULL,
  PRIMARY KEY (`InvoiceNo`),
  KEY `UID` (`UID`),
  KEY `CCNO` (`CCNO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `CreditInfo`
--

DROP TABLE IF EXISTS `CreditInfo`;
CREATE TABLE IF NOT EXISTS `CreditInfo` (
  `CCNO` bigint(20) NOT NULL,
  `ExpiryDate` datetime NOT NULL,
  `CSV` int(11) NOT NULL,
  `CardType` varchar(25) NOT NULL,
  `HolderName` varchar(50) NOT NULL,
  `BillingZip` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  PRIMARY KEY (`CCNO`),
  KEY `UID` (`UID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Profiles`
--

DROP TABLE IF EXISTS `Profiles`;
CREATE TABLE IF NOT EXISTS `Profiles` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `ID` int(11) NOT NULL,
  `FirstName` varchar(25) NULL,
  `LastName` varchar(25) NULL,
  `DOB` date NULL,
  `Gender` varchar(6) NULL,
  `Address1` varchar(50) NULL,
  `Address2` varchar(50) DEFAULT NULL,
  `City` varchar(25) NULL,
  `State` varchar(25) NULL,
  `Zip` int(11) NULL,
  `PhoneNo` varchar(25) NULL,
  `ProfilePic` varchar(50) DEFAULT NULL,
  `Credits` varchar(10) NOT NULL DEFAULT '0',
  `ToysOwned` int(11) NOT NULL DEFAULT '0',
  `ToysShared` int(11) NOT NULL DEFAULT '0',
  `CreatedOn` datetime NOT NULL  DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PID`),
  KEY `ID` (`ID`)
) AUTO_INCREMENT=100001 ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ToyLibrary`
--

DROP TABLE IF EXISTS `ToyLibrary`;
CREATE TABLE IF NOT EXISTS `ToyLibrary` (
  `TID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `EstimatedValue` float DEFAULT NULL,
  `Image` varchar(50) DEFAULT NULL,
  `OwnerID` int(11) NOT NULL,
  `Status` varchar(25) NOT NULL DEFAULT 'Visible',
  `Condition` varchar(25) NOT NULL,
  `AddedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`TID`),
  KEY `OwnerID` (`OwnerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(25) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `EmailID` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `SQues` varchar(50) NOT NULL,
  `SAns` varchar(50) NOT NULL,
  `UserActivationID` varchar(64) DEFAULT NULL,
  `PasswordResetToken` varchar(64) DEFAULT NULL,
  `PasswordResetTime` datetime DEFAULT NULL,
  `RememberMeToken` varchar(64) DEFAULT NULL,
  `FailedLoginAttempts` tinyint(4) NOT NULL DEFAULT '0',
  `FailedLoginDate` datetime DEFAULT NULL,
  `RegistrationDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `RegistrationIP` varchar(20) NOT NULL DEFAULT '127.0.0.1',
  `IsActive` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BillingInfo`
--
ALTER TABLE `BillingInfo`
  ADD CONSTRAINT `BillingInfo_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `Users` (`ID`),
  ADD CONSTRAINT `BillingInfo_ibfk_2` FOREIGN KEY (`CCNO`) REFERENCES `CreditInfo` (`CCNO`);

--
-- Constraints for table `CreditInfo`
--
ALTER TABLE `CreditInfo`
  ADD CONSTRAINT `CreditInfo_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `Profiles`
--
ALTER TABLE `Profiles`
  ADD CONSTRAINT `Profiles_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `Users` (`ID`);

--
-- Constraints for table `ToyLibrary`
--
ALTER TABLE `ToyLibrary`
  ADD CONSTRAINT `ToyLibrary_ibfk_1` FOREIGN KEY (`OwnerID`) REFERENCES `Profiles` (`PID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
