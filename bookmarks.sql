CREATE TABLE `bookmark` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `unique_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

CREATE TABLE `comment` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) NOT NULL,
  `text` varchar(500) NOT NULL,
  `bookmark_uid` int(11) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `unique_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
