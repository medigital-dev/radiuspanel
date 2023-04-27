-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2023 at 09:09 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `radius`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$KVNOSkgZX6g2G/vjfRkfwumJHuS7XjmuZhu3soLWGqFR715JmgSPq');

-- --------------------------------------------------------

--
-- Table structure for table `nas`
--

DROP TABLE IF EXISTS `nas`;
CREATE TABLE IF NOT EXISTS `nas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nasname` varchar(128) NOT NULL,
  `shortname` varchar(32) DEFAULT NULL,
  `type` varchar(30) DEFAULT 'other',
  `ports` int DEFAULT NULL,
  `secret` varchar(60) NOT NULL DEFAULT 'secret',
  `server` varchar(64) DEFAULT NULL,
  `community` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT 'RADIUS Client',
  PRIMARY KEY (`id`),
  KEY `nasname` (`nasname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
CREATE TABLE IF NOT EXISTS `organization` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `name` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `division` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `class` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `registered_at` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radacct`
--

DROP TABLE IF EXISTS `radacct`;
CREATE TABLE IF NOT EXISTS `radacct` (
  `radacctid` bigint NOT NULL AUTO_INCREMENT,
  `acctsessionid` varchar(64) NOT NULL DEFAULT '',
  `acctuniqueid` varchar(32) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `realm` varchar(64) DEFAULT '',
  `nasipaddress` varchar(15) NOT NULL DEFAULT '',
  `nasportid` varchar(15) DEFAULT NULL,
  `nasporttype` varchar(32) DEFAULT NULL,
  `acctstarttime` datetime DEFAULT NULL,
  `acctupdatetime` datetime DEFAULT NULL,
  `acctstoptime` datetime DEFAULT NULL,
  `acctinterval` int DEFAULT NULL,
  `acctsessiontime` int UNSIGNED DEFAULT NULL,
  `acctauthentic` varchar(32) DEFAULT NULL,
  `connectinfo_start` varchar(50) DEFAULT NULL,
  `connectinfo_stop` varchar(50) DEFAULT NULL,
  `acctinputoctets` bigint DEFAULT NULL,
  `acctoutputoctets` bigint DEFAULT NULL,
  `calledstationid` varchar(50) NOT NULL DEFAULT '',
  `callingstationid` varchar(50) NOT NULL DEFAULT '',
  `acctterminatecause` varchar(32) NOT NULL DEFAULT '',
  `servicetype` varchar(32) DEFAULT NULL,
  `framedprotocol` varchar(32) DEFAULT NULL,
  `framedipaddress` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`radacctid`),
  UNIQUE KEY `acctuniqueid` (`acctuniqueid`),
  KEY `username` (`username`),
  KEY `framedipaddress` (`framedipaddress`),
  KEY `acctsessionid` (`acctsessionid`),
  KEY `acctsessiontime` (`acctsessiontime`),
  KEY `acctstarttime` (`acctstarttime`),
  KEY `acctinterval` (`acctinterval`),
  KEY `acctstoptime` (`acctstoptime`),
  KEY `nasipaddress` (`nasipaddress`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radcheck`
--

DROP TABLE IF EXISTS `radcheck`;
CREATE TABLE IF NOT EXISTS `radcheck` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupcheck`
--

DROP TABLE IF EXISTS `radgroupcheck`;
CREATE TABLE IF NOT EXISTS `radgroupcheck` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radgroupreply`
--

DROP TABLE IF EXISTS `radgroupreply`;
CREATE TABLE IF NOT EXISTS `radgroupreply` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`(32))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radpostauth`
--

DROP TABLE IF EXISTS `radpostauth`;
CREATE TABLE IF NOT EXISTS `radpostauth` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `pass` varchar(64) NOT NULL DEFAULT '',
  `reply` varchar(32) NOT NULL DEFAULT '',
  `authdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radreply`
--

DROP TABLE IF EXISTS `radreply`;
CREATE TABLE IF NOT EXISTS `radreply` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL DEFAULT '',
  `attribute` varchar(64) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '=',
  `value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `username` (`username`(32))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radusergroup`
--

DROP TABLE IF EXISTS `radusergroup`;
CREATE TABLE IF NOT EXISTS `radusergroup` (
  `username` varchar(64) NOT NULL DEFAULT '',
  `groupname` varchar(64) NOT NULL DEFAULT '',
  `priority` int NOT NULL DEFAULT '1',
  KEY `username` (`username`(32))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
