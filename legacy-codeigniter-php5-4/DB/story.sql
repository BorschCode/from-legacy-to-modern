-- SQL Dump for cartridge database (table: story)

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `story` (
                         `id` int(10) NOT NULL COMMENT 'Unique record ID from the database',
                         `id_item` int(10) NOT NULL COMMENT 'Linked item ID from cartridgedb',
                         `owner` varchar(40) NOT NULL DEFAULT 'Log start' COMMENT 'Location or owner according to inventory records',
                         `weight_before` int(10) NOT NULL COMMENT 'Weight before sending to the service center',
                         `weight_after` int(10) NOT NULL COMMENT 'Weight after refilling',
                         `date_outcome` date NOT NULL COMMENT 'Date sent to the service center',
                         `date_income` date NOT NULL COMMENT 'Date received from the service center',
                         `servicename` varchar(50) NOT NULL DEFAULT 'Log start' COMMENT 'Service center performing repair/refill',
                         `technical_life` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Cartridge condition: active (1) or inactive (0)',
                         `log` text NOT NULL COMMENT 'Short change history: records only keys and values that were modified',
                         `log_full` text NOT NULL COMMENT 'Full change log: records all data before and after each edit',
                         `date_of_changes` date NOT NULL COMMENT 'Date when changes were made'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

ALTER TABLE `story`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `story`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Unique record ID from the database';
