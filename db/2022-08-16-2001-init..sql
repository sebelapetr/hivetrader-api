-- Adminer 4.8.1 MySQL 10.4.24-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `actions`;
CREATE TABLE `actions` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `name` varchar(20) NOT NULL,
                           `right_id` int(11) NOT NULL,
                           PRIMARY KEY (`id`),
                           KEY `right_id` (`right_id`),
                           CONSTRAINT `actions_ibfk_3` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `actions` (`id`, `name`, `right_id`) VALUES
                                                     (1,	'read',	1),
                                                     (2,	'read',	2),
                                                     (3,	'read',	3);

DROP TABLE IF EXISTS `rights`;
CREATE TABLE `rights` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(20) NOT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `rights` (`id`, `name`) VALUES
                                        (1,	'dashboard'),
                                        (2,	'users'),
                                        (3,	'rights');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `int_name` varchar(10) NOT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`id`, `int_name`) VALUES
    (1,	'ADMIN');

DROP TABLE IF EXISTS `roles_x_actions`;
CREATE TABLE `roles_x_actions` (
                                   `role_id` int(11) NOT NULL,
                                   `action_id` int(11) NOT NULL,
                                   KEY `role_id` (`role_id`),
                                   KEY `action_id` (`action_id`),
                                   CONSTRAINT `roles_x_actions_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
                                   CONSTRAINT `roles_x_actions_ibfk_4` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles_x_actions` (`role_id`, `action_id`) VALUES
                                                           (1,	2),
                                                           (1,	3),
                                                           (1,	1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `email` varchar(50) NOT NULL,
                         `password` varchar(100) DEFAULT NULL,
                         `name` varchar(20) NOT NULL,
                         `surname` varchar(20) NOT NULL,
                         `role_id` int(11) NOT NULL,
                         `active` tinyint(1) NOT NULL,
                         `reset_token` varchar(30) DEFAULT NULL,
                         `phone_number` varchar(20) NOT NULL,
                         `last_login` datetime DEFAULT NULL,
                         `created_at` datetime NOT NULL,
                         `default_lang` varchar(5) NOT NULL,
                         PRIMARY KEY (`id`),
                         KEY `role_id` (`role_id`),
                         CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `role_id`, `active`, `reset_token`, `phone_number`, `last_login`, `created_at`, `default_lang`) VALUES
    (1,	'petrsebel@seznam.cz',	'$2y$10$oA6Du5OAxSx1C/5mJKmqpOEDB8quZWLsS/lzJlb10NU8Hb.T.DSpe',	'Petr',	'Šebela',	1,	1,	NULL,	'777542365',	'2022-08-16 19:41:48',	'2022-08-16 19:42:00',	'cs');

-- 2022-08-16 18:01:24