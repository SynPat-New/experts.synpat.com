DROP TABLE IF EXISTS `#__projects`;
DROP TABLE IF EXISTS `#__survey`;
DROP TABLE IF EXISTS `#__survey_question`;
DROP TABLE IF EXISTS `#__survey_question_answer`;
DROP TABLE IF EXISTS `#__expert`;
DROP TABLE IF EXISTS `#__payment_settings`;
DROP TABLE IF EXISTS `#__transactions`;
 
CREATE TABLE `#__projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `description` TEXT NOT NULL DEFAULT '' ,
  `project_image` varchar(500) NOT NULL DEFAULT '',
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL , 
  `name` varchar(25) NOT NULL,
  `description` TEXT NOT NULL DEFAULT '' ,
  `image` varchar(500) NOT NULL DEFAULT '',
  `amount` int(11) NOT NULL DEFAULT '0',
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__survey_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL , 
  `name` varchar(25) NOT NULL,
  `description` TEXT NOT NULL DEFAULT '' ,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__survey_question_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ques_id` int(11) NOT NULL , 
  `expert_id` varchar(25) NOT NULL,
  `answer` TEXT NOT NULL DEFAULT '' ,
  `supporting_document` varchar(300) NOT NULL DEFAULT '',
  `status` smallint(2) NOT NULL DEFAULT '0',
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__expert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL , 
  `description` TEXT NOT NULL DEFAULT '' ,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__payment_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'Paypal',
  `payment_id` varchar(400) NOT NULL DEFAULT '' , 
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` varchar(50) NOT NULL DEFAULT 'Paypal',
  `success` varchar(200) NOT NULL DEFAULT '' , 
  `message` varchar(200) NOT NULL DEFAULT '' , 
  `create_date` datetime NOT NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
