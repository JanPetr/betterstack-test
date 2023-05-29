-- Optimization of data type in MySQL.
-- This migration assumes that the data already inserted into the table fit into `varchar(255)` data type.
-- Otherwise the migration cannot be run.
ALTER TABLE `users`
    CHANGE `name` `name` varchar(255) NOT NULL AFTER `id`,
    CHANGE `email` `email` varchar(255) NOT NULL AFTER `name`,
    CHANGE `city` `city` varchar(255) NOT NULL AFTER `email`;
