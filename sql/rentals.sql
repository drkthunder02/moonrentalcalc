/**
 * Author:  Chris Mancuso
 * Created: February 21, 2017
 */

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `WarpedRentals`
--

-- Table for configuration settings `Config`
--

CREATE TABLE IF NOT EXISTS `Config` (
    `RentalTax` decimal(5,2),
    `RefineRate` decimal(5,2),
    `RentalTime` int(12),
    UNIQUE KEY `RentalTax` (`RentalTax`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `OrePrices`
--

CREATE TABLE IF NOT EXISTS `OrePrices` (
    `id` int(10) AUTO_INCREMENT,
    `Name` varchar(31) DEFAULT NULL,
    `ItemId` int(10) NOT NULL,
    `BatchPrice` decimal(10,2) DEFAULT '0.00',
    `UnitPrice` decimal(10,2) DEFAULT '0.00',
    `m3Price` decimal(10,2) DEFAULT '0.00',
    `Time` int(16) NOT NULL,
    UNIQUE KEY `ItemId` (`ItemId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `Prices`
--

CREATE TABLE IF NOT EXISTS `Prices` (
    `id` int(10) AUTO_INCREMENT,
    `Name` varchar(31) DEFAULT NULL,
    `ItemId` int(10) NOT NULL,
    `Price` decimal(10,2) NOT NULL DEFAULT '0.00',
    `Time` int(16) NOT NULL,
    UNIQUE KEY `id` (`id`),
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ItemComposition`
--

CREATE TABLE IF NOT EXISTS `ItemComposition` (
    `Name` varchar(31) DEFAULT NULL,
    `ItemId` int(10) NOT NULL,
    `m3Size` decimal(10,2) NOT NULL DEFAULT '0.00',
    `BatchSize` int(12) NOT NULL DEFAULT '100',
    `Tritanium` int(12) DEFAULT '0',
    `Pyerite` int(12) DEFAULT '0',
    `Mexallon` int(12) DEFAULT '0',
    `Isogen` int(12) DEFAULT '0',
    `Nocxium` int(12) DEFAULT '0',
    `Zydrine` int(12) DEFAULT '0',
    `Megacyte` int(12) DEFAULT '0',
    `Morphite` int(12) DEFAULT '0',
    `HeavyWater` int(11) NOT NULL DEFAULT '0',
    `LiquidOzone` int(11) NOT NULL DEFAULT '0',
    `NitrogenIsotopes` int(11) NOT NULL DEFAULT '0',
    `HeliumIsotopes` int(11) NOT NULL DEFAULT '0',
    `HydrogenIsotopes` int(11) NOT NULL DEFAULT '0',
    `OxygenIsotopes` int(11) NOT NULL DEFAULT '0',
    `StrontiumClathrates` int(11) NOT NULL DEFAULT '0',
    `AtmosphericGases` int(11) NOT NULL DEFAULT '0',
    `EvaporiteDeposits` int(11) NOT NULL DEFAULT '0',
    `Hydrocarbons` int(11) NOT NULL DEFAULT '0',
    `Silicates` int(11) NOT NULL DEFAULT '0',
    `Cobalt` int(11) NOT NULL DEFAULT '0',
    `Scandium` int(11) NOT NULL DEFAULT '0',
    `Titanium` int(11) NOT NULL DEFAULT '0',
    `Tungsten` int(11) NOT NULL DEFAULT '0',
    `Cadmium` int(11) NOT NULL DEFAULT '0',
    `Platinum` int(11) NOT NULL DEFAULT '0',
    `Vanadium` int(11) NOT NULL DEFAULT '0',
    `Chromium` int(11) NOT NULL DEFAULT '0',
    `Technetium` int(11) NOT NULL DEFAULT '0',
    `Hafnium` int(11) NOT NULL DEFAULT '0',
    `Caesium` int(11) NOT NULL DEFAULT '0',
    `Mercury` int(11) NOT NULL DEFAULT '0',
    `Dysprosium` int(11) NOT NULL DEFAULT '0',
    `Neodymium` int(11) NOT NULL DEFAULT '0',
    `Promethium` int(11) NOT NULL DEFAULT '0',
    `Thulium` int(11) NOT NULL DEFAULT '0',
    UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;