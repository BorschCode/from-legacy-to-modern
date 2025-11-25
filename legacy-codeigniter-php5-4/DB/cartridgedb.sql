-- SQL Dump for cartridge database

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `cartridgedb` (
                               `id` int(11) NOT NULL,
                               `owner` varchar(50) NOT NULL COMMENT 'Location or owner according to inventory records',
                               `brand` varchar(50) NOT NULL COMMENT 'Manufacturer of the cartridge',
                               `marks` varchar(50) NOT NULL COMMENT 'Model of the cartridge assigned by the manufacturer',
                               `weight_before` int(10) NOT NULL COMMENT 'Weight before sending to the service center',
                               `weight_after` int(10) NOT NULL COMMENT 'Weight after refilling',
                               `date_outcome` date NOT NULL COMMENT 'Date sent to the service center',
                               `date_income` date NOT NULL COMMENT 'Date received from the service center',
                               `servicename` varchar(30) NOT NULL COMMENT 'Service center performing repair/refill',
                               `comments` varchar(50) NOT NULL COMMENT 'Comments describing the cartridge status',
                               `technical_life` tinyint(4) NOT NULL COMMENT 'Cartridge condition: in use or decommissioned',
                               `code` varchar(30) NOT NULL COMMENT 'Unique cartridge code or inventory number',
                               `inservice` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Service status: 1 - in service, 0 - not in service (auto-calculated)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

ALTER TABLE `cartridgedb`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `cartridgedb`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
