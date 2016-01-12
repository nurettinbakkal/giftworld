# giftworld

## Note

Create database as below and edit Config/DatabaseConfig-dev.php and rename as DatabaseConfig.php

Rules Applied
1. Every user in the game is unique.
2. Users can send 1 gift per day to every other users.
3. Users can claim unlimited gifts.
4. Gifts are expired after 1 week.
5. Add more than 1 gift support. ( Just add a row to gifts table )
6. Create a user interface.
7. Do not use any framework.
8. Deliver working application online.



```
CREATE DATABASE `giftworld` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `gifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `gift_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gift_id` int(11) NOT NULL,
  `gift_request_type` tinyint(4) NOT NULL COMMENT '1 SEND 2 CLAIM',
  `gift_count` int(11) DEFAULT NULL,
  `user_id` tinyint(4) NOT NULL,
  `gift_sender_user_id` tinyint(4) NOT NULL,
  `is_accepted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 WAITING 1 ACCEPTED 2 REJECTED',
  `request_time` datetime DEFAULT NULL,
  `response_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```
