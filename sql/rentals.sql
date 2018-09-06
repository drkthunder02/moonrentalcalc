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
    UNIQUE KEY `id` (`id`),
    PRIMARY KEY (`id`)
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
  `Thulium` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Inserts into table `ItemComposition`
--

INSERT INTO `ItemComposition` (`Name`, `ItemId`, `m3Size`, `BatchSize`, `Tritanium`, `Pyerite`, `Mexallon`, `Isogen`, `Nocxium`, `Zydrine`, `Megacyte`, `Morphite`, `HeavyWater`, `LiquidOzone`, `NitrogenIsotopes`, `HeliumIsotopes`, `HydrogenIsotopes`, `OxygenIsotopes`, `StrontiumClathrates`, `AtmosphericGases`, `EvaporiteDeposits`, `Hydrocarbons`, `Silicates`, `Cobalt`, `Scandium`, `Titanium`, `Tungsten`, `Cadmium`, `Platinum`, `Vanadium`, `Chromium`, `Technetium`, `Hafnium`, `Caesium`, `Mercury`, `Dysprosium`, `Neodymium`, `Promethium`, `Thulium`) VALUES
('Flawless Arkonor', 46678, '16.00', 100, 24200, 0, 2750, 0, 0, 0, 352, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Cubic Bistot', 46676, '16.00', 100, 0, 13800, 0, 0, 0, 518, 115, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Pellucid Crokite', 46677, '16.00', 100, 24150, 0, 0, 0, 874, 155, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Jet Ochre', 46675, '8.00', 100, 11500, 0, 0, 1840, 130, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Brilliant Gneiss', 46679, '5.00', 100, 0, 2530, 2760, 345, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Lustrous Hedbergite', 46680, '3.00', 100, 0, 1150, 0, 230, 115, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Scintillating Hemorphite', 46681, '3.00', 100, 2530, 0, 0, 115, 138, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Immaculate Jaspet', 46682, '2.00', 100, 0, 0, 403, 0, 86, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Resplendant Kernite', 46683, '12.00', 100, 154, 0, 307, 154, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Platinoid Omber', 46684, '0.60', 100, 920, 115, 0, 98, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Sparkling Plagioclase', 46685, '0.35', 100, 123, 245, 123, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Opulent Pyroxeres', 46686, '0.31', 100, 404, 29, 58, 0, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Glossy Scordite', 46687, '0.15', 100, 398, 199, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Dazzling Spodumain', 46688, '16.00', 100, 64400, 13858, 2415, 518, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Stable Veldspar', 46689, '0.10', 100, 477, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Zeolites', 45490, '10.00', 100, 4000, 8000, 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Sylvite', 45491, '10.00', 100, 8000, 4000, 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Bitumens', 45492, '10.00', 100, 6000, 6000, 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Coesite', 45493, '10.00', 100, 10000, 2000, 400, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 65, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Cobaltite', 45494, '10.00', 100, 7500, 10000, 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Euxenite', 45495, '10.00', 100, 10000, 7500, 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Titanite', 45496, '10.00', 100, 15000, 2500, 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Scheelite', 45497, '10.00', 100, 12500, 5000, 500, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Otavite', 45498, '10.00', 100, 5000, 0, 1500, 500, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Sperrylite', 45499, '10.00', 100, 10000, 0, 2000, 2000, 0, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Vanadinite', 45500, '10.00', 100, 0, 5000, 750, 1250, 0, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0),
('Chromite', 45501, '10.00', 100, 0, 5000, 1250, 750, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0, 0, 0, 0, 0, 0),
('Carnotite', 45502, '10.00', 100, 0, 0, 1000, 1250, 0, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, 0, 0, 0, 0),
('Zircon', 45503, '10.00', 100, 0, 0, 1750, 500, 0, 0, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 10, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, 0, 0, 0),
('Pollucite', 45504, '10.00', 100, 0, 0, 1250, 1000, 0, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, 0, 0),
('Cinnabar', 45506, '10.00', 100, 0, 0, 1500, 750, 0, 0, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, 0),
('Xenotime', 45510, '10.00', 100, 0, 0, 0, 0, 200, 100, 50, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0, 20, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 22, 0, 0, 0),
('Monazite', 45511, '10.00', 100, 0, 0, 0, 0, 50, 150, 150, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0, 0, 0, 20, 0, 0, 0, 10, 0, 0, 0, 0, 0, 22, 0, 0),
('Loparite', 45512, '10.00', 100, 0, 0, 0, 0, 100, 200, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 20, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 22, 0),
('Ytterbite', 45513, '10.00', 100, 0, 0, 0, 0, 50, 100, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 20, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 22);

--
-- Table structure for Moons
--

CREATE TABLE IF NOT EXISTS `Moons` (
    `id` int(10) AUTO_INCREMENT,
    `System` varchar(10),
    `Planet` varchar(10),
    `Moon` varchar(10),
    `FirstOre` varchar(50),
    `FirstQuantity` int(3),
    `SecondOre` varchar(50),
    `SecondQuantity` int(3),
    `ThirdOre` varchar(50),
    `ThirdQuantity` int(3),
    `FourthOre` varchar(50),
    `FourthQuantity` int(3),
    `RentalCorp` varchar(50),
    `RentalEnd` int(12),
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Default Entries
--

INSERT INTO `Moons` (`System`, `Planet`, `Moon`, `FirstOre`, `FirstQuantity`, `SecondOre`, `SecondQuantity`, `ThirdOre`, `ThirdQuantity`, `FourthOre`, `FourthQuantity`) VALUES
('LN-56V', '1', '1', 'Cubic Bistot', 43, 'Euxenite', 20, 'Immaculate Jaspet', 27, 'Sperrylite', 10),
('LN-56V', '3', '1', 'Cubic Bistot', 35, 'Stable Veldspar', 35, 'Sylvite', 10, 'Ziron', 20),
('LN-56V', '3', '5', 'Euxenite', 10, 'Sparkling Plagioclase', 34, 'Sperrylite', 32, 'Vanadinite', 24),
('LN-56V', '5', '7', 'Loparite', 21, 'Monazite', 20, 'Pellucid Crokite', 31, 'Scintillating Hemorphite', 29),
('LN-56V', '5', '15', 'Carnotite', 25, 'Opulent Pyroxeres', 45, 'Zircon', 31, 'None', 0),
('JDAS-0', '5', '13', 'Otavite', 41, 'Pellucid Crokite', 30, 'Zeolites', 8, 'Zircon', 20),
('JA-O6J', '10', '1', 'Dazzling Spodumain', 23, 'Flawless Arkonor', 23, 'Vanadinite', 18, 'Ytterbite', 36),
('CX65-5', '5', '13', 'Cinnabar', 33, 'Lustrous Hedbergite', 26, 'Opulent Pyroxeres', 8, 'Pellucid Crokite', 31),
('CX65-5', '5', '14', 'Glossy Scordite', 19, 'Pellucid Crokite', 57, 'Ytterbite', 22, 'None', 0),
('CX65-5', '6', '4', 'Cinnabar', 23, 'Immaculate Jaspet', 35, 'Sylvite', 8, 'Zeolites', 32),
('CX65-5', '7', '3', 'Cinnabar', 17, 'Flawless Arkonor', 44, 'Glossy Scordite', 26, 'Scheelite', 11),
('6X7-JO', '7', '6', 'Chromite', 19, 'Pellucid Crokite', 23, 'Vanadinite', 18, 'Ytterbite', 40),
('OGL8-Q', '3', '10', 'Brilliant Gneiss', 24, 'Cinnabar', 32, 'Resplendant Kernite', 18, 'Ziron', 26),
('OGL8-Q', '5', '2', 'Brilliant Gneiss', 27, 'Cinnabar', 23, 'Scintillating Hemorphite', 39, 'Zeolites', 11),
('J-ODE7', '5', '15', 'Cinnabar', 20, 'Coesite', 44, 'Sperrylite', 35, 'None', 0),
('WQH-4K', '3', '2', 'Cubic Bistot', 21, 'Loparite', 10, 'Opulent Pyroxeres', 41, 'Sparkling Plagioclase', 29),
('WQH-4K', '6', '18', 'Flawless Arkonor', 21, 'Immaculate Jaspet', 22, 'Loparite', 36, 'Sperrylite', 20),
('WQH-4K', '7', '2', 'Pellucid Crokite', 32, 'Resplendant Kernite', 15, 'Scintillating Hemorphite', 42, 'Ytterbite', 11),
('Q-S7ZD', '3', '1', 'Cinnbar', 36, 'Lustrous Hedbergite', 26, 'Resplendant Kernite', 28, 'Sparkling Plagioclase', 10),
('Q-S7ZD', '5', '12', 'Platinoid Omber', 55, 'Ytterbite', 45, 'None', 0, 'None', 0),
('GJ0-OJ', '8', '14', 'Opulent Pyroxeres', 31, 'Scintillating Hemorphite', 28, 'Stable Veldspar', 8, 'Cinnabar', 33),
('GJ0-OJ', '8', '17', 'Cinnabar', 20, 'Cubic Bistot', 29, 'Lustrous Hedbergite', 42, 'Scheelite', 8),
('XVV-21', '10', '4', 'Glossy Scordite', 17, 'Platinoid Omber', 20, 'Stable Veldspar', 22, 'Ytterbite', 42),
('O7-7UX', '3', '2', 'Dazzling Spodumain', 35, 'Euxenite', 10, 'Lustrous Hedbergite', 36, 'Zircon', 18);