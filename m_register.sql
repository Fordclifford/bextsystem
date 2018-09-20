/*
SQLyog Community v13.0.1 (64 bit)
MySQL - 10.1.32-MariaDB : Database - bext_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bext_system` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bext_system`;

/*Table structure for table `actual_income` */

DROP TABLE IF EXISTS `actual_income`;

CREATE TABLE `actual_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_name` varchar(255) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `church_id` int(11) NOT NULL,
  `financial_year_id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `church_id` (`church_id`),
  KEY `financial_year_id` (`financial_year_id`),
  KEY `id` (`id`),
  CONSTRAINT `actual_income_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  CONSTRAINT `actual_income_ibfk_2` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `actual_income` */

insert  into `actual_income`(`id`,`source_name`,`amount`,`date_added`,`date_updated`,`church_id`,`financial_year_id`,`balance`) values 
(6,'Sabbath School Collections',6000,'2018-09-16 15:01:56','2018-09-16 15:01:56',27,79,0.00),
(19,'Welfare Fund',700,'2018-09-16 15:09:34','2018-09-16 15:09:34',27,79,0.00),
(20,'Welfare Fund',70,'2018-09-16 15:09:36','2018-09-16 23:09:41',27,79,70.00),
(30,'Welfare Fund',7009,'2018-09-16 15:09:42','2018-09-16 23:06:49',27,79,6509.00),
(39,'Combined(church) Budget',808,'2018-09-16 15:20:34','2018-09-16 22:51:02',27,79,0.00),
(44,'Church Fund For Needy',798,'2018-09-16 15:22:56','2018-09-19 12:58:18',27,79,798.00);

/*Table structure for table `bill` */

DROP TABLE IF EXISTS `bill`;

CREATE TABLE `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `church_id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(200) NOT NULL DEFAULT 'no-image.png',
  `description` varchar(255) NOT NULL,
  `financial_year` int(11) NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mode_of_payment` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `church_id` (`church_id`),
  KEY `financial_year` (`financial_year`),
  KEY `source` (`source`),
  CONSTRAINT `bill_ibfk_3` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  CONSTRAINT `bill_ibfk_4` FOREIGN KEY (`financial_year`) REFERENCES `financial_year` (`id`),
  CONSTRAINT `bill_ibfk_5` FOREIGN KEY (`source`) REFERENCES `actual_income` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `bill` */

insert  into `bill`(`id`,`church_id`,`source`,`amount`,`date`,`image`,`description`,`financial_year`,`last_update`,`mode_of_payment`) values 
(1,27,30,500.00,'2018-09-16','no-image.png','test',79,'2018-09-16 23:06:27','cash');

/*Table structure for table `church` */

DROP TABLE IF EXISTS `church`;

CREATE TABLE `church` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `conference_id` int(11) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `union_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user_id` (`user_id`),
  KEY `conference_id` (`conference_id`),
  KEY `union_id` (`union_id`),
  CONSTRAINT `church_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `church_ibfk_2` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`id`),
  CONSTRAINT `church_ibfk_3` FOREIGN KEY (`union_id`) REFERENCES `union_mission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `church` */

insert  into `church`(`id`,`name`,`conference_id`,`mobile`,`date`,`union_id`,`updated_at`,`user_id`) values 
(27,'testing',2,'07114011988','2018-09-05 16:11:42',1,'2018-09-05 22:57:04',19),
(28,'Clifford ',3,'721982500565','2018-09-08 22:44:15',1,'2018-09-09 11:12:52',7),
(29,'central',16,'765678909','2018-09-09 11:55:30',1,'2018-09-09 12:56:21',7),
(30,'church',7,'8789999','2018-09-19 12:03:40',2,'2018-09-19 13:03:40',7),
(35,'tets',7,'973452358794','2018-09-19 18:29:43',2,'2018-09-19 18:29:43',25);

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `comment` varchar(300) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `subject` varchar(300) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sender` int(11) NOT NULL,
  `recipient` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `comments` */

insert  into `comments`(`id`,`comment`,`status`,`subject`,`date`,`sender`,`recipient`) values 
(7,'djfv jdfv',1,'jshdcvsjdvc','2018-09-07 17:36:29',1,1),
(8,'djfv jdfv',1,'jshdcvsjdvc','2018-09-07 17:36:48',1,1),
(9,'hsdfvshd',1,'chetaaa','2018-09-07 17:37:47',1,19),
(10,'tesss',1,'rtterer','2018-09-07 17:58:36',1,1),
(11,'cliffkaka',1,'test','2018-09-07 18:21:11',1,19),
(12,'i sent to myself',1,'testing','2018-09-07 18:23:50',1,19),
(13,'tttttte',1,'test to cliffkaka','2018-09-07 18:30:51',1,19),
(14,'teer',1,'tey','2018-09-11 09:35:37',1,19),
(15,'new',1,'new one','2018-09-11 10:01:11',1,19),
(16,'ererererererer',1,'fghyfgthyfghfghfgh','2018-09-19 13:01:15',1,19);

/*Table structure for table `conference` */

DROP TABLE IF EXISTS `conference`;

CREATE TABLE `conference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `conf_name` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `union_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `union_id` (`union_id`),
  CONSTRAINT `conference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `conference_ibfk_2` FOREIGN KEY (`union_id`) REFERENCES `union_mission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `conference` */

insert  into `conference`(`id`,`user_id`,`conf_name`,`date_created`,`date_updated`,`union_id`) values 
(1,18,'Central Kenya Conference','2018-09-05 14:24:40','2018-09-05 14:24:40',1),
(2,18,'Central Rift Valley Conference','2018-09-05 14:25:08','2018-09-05 14:25:08',1),
(3,18,'Kenya Coast Field','2018-09-05 14:25:42','2018-09-05 14:25:42',1),
(5,18,'Nyamira Conference','2018-09-05 14:26:18','2018-09-05 14:26:18',1),
(6,18,'South Kenya Conference','2018-09-05 14:26:37','2018-09-05 14:26:37',1),
(7,18,'Central Nyanza Conference','2018-09-05 14:27:08','2018-09-05 14:27:08',2),
(8,18,'Greater Rift Valley Conference','2018-09-05 14:27:40','2018-09-05 14:28:49',2),
(11,18,'Kenya Lake Conference','2018-09-05 14:28:11','2018-09-05 14:28:54',2),
(13,20,'North West Kenya Conference','2018-09-05 14:28:33','2018-09-09 11:48:14',2),
(16,18,'Ranen Conference','2018-09-09 12:34:46','2018-09-09 12:35:58',2);

/*Table structure for table `estimated_expenses` */

DROP TABLE IF EXISTS `estimated_expenses`;

CREATE TABLE `estimated_expenses` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `church_id` int(11) NOT NULL,
  `expense_name` varchar(255) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `financial_year` int(11) NOT NULL,
  `balance` decimal(13,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`sid`),
  KEY `church_id` (`church_id`),
  KEY `financial_year` (`financial_year`),
  CONSTRAINT `estimated_expenses_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  CONSTRAINT `estimated_expenses_ibfk_2` FOREIGN KEY (`financial_year`) REFERENCES `financial_year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `estimated_expenses` */

insert  into `estimated_expenses`(`sid`,`church_id`,`expense_name`,`amount`,`date`,`financial_year`,`balance`) values 
(9,27,'Fuel',6000.00,'2018-09-05 16:27:10',79,4000.00);

/*Table structure for table `estimated_income` */

DROP TABLE IF EXISTS `estimated_income`;

CREATE TABLE `estimated_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `church_id` int(11) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `financial_year` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `church_id` (`church_id`),
  KEY `financial_year` (`financial_year`),
  CONSTRAINT `estimated_income_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  CONSTRAINT `estimated_income_ibfk_2` FOREIGN KEY (`financial_year`) REFERENCES `financial_year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `estimated_income` */

insert  into `estimated_income`(`id`,`church_id`,`source_name`,`amount`,`date`,`financial_year`) values 
(1,28,'Sabbath School Collections',6777.00,'2018-09-05 16:27:25',79),
(2,27,'Church Fund For Needy',8999.00,'2018-09-06 13:05:17',79),
(3,27,'Welfare Fund',899.00,'2018-09-06 13:14:08',79);

/*Table structure for table `financial_year` */

DROP TABLE IF EXISTS `financial_year`;

CREATE TABLE `financial_year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `total_actual_income` decimal(10,2) DEFAULT '0.00',
  `total_expenses` decimal(10,2) DEFAULT '0.00',
  `total_estimated_income` decimal(10,2) DEFAULT '0.00',
  `total_bills` decimal(10,2) DEFAULT '0.00',
  `balance` decimal(10,2) DEFAULT '0.00',
  `church_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `church_id` (`church_id`),
  CONSTRAINT `financial_year_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

/*Data for the table `financial_year` */

insert  into `financial_year`(`id`,`year`,`total_actual_income`,`total_expenses`,`total_estimated_income`,`total_bills`,`balance`,`church_id`) values 
(79,2018,15385.00,6000.00,0.00,2000.00,14885.00,27);

/*Table structure for table `pending_users` */

DROP TABLE IF EXISTS `pending_users`;

CREATE TABLE `pending_users` (
  `token` char(40) NOT NULL,
  `username` varchar(45) NOT NULL,
  `tstamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `pending_users` */

/*Table structure for table `reset` */

DROP TABLE IF EXISTS `reset`;

CREATE TABLE `reset` (
  `token` char(40) NOT NULL,
  `username` varchar(45) NOT NULL,
  `tstamp` int(10) unsigned NOT NULL,
  PRIMARY KEY (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `reset` */

insert  into `reset`(`token`,`username`,`tstamp`) values 
('c7f7ae6d1822e9d65a83e48918c355696984b841','cliffk',1537372859),
('66756ead35d7bd24a1b63c387d834c80635705df','cliffk',1537374462),
('8c1da47a24023a2f7cf6f86fe54c38ab6efd1191','cliffk',1537374792),
('f7fa9414a1fde6eabc19c01bbda5000edba10e95','cliffk',1537374822);

/*Table structure for table `union_mission` */

DROP TABLE IF EXISTS `union_mission`;

CREATE TABLE `union_mission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `union_name` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `union_mission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `union_mission` */

insert  into `union_mission`(`id`,`union_name`,`date_created`,`date_updated`,`user_id`) values 
(1,'East Kenya Union Conference','2018-09-05 14:21:43','2018-09-05 14:21:43',4),
(2,'West Kenya Union Conference','2018-09-05 14:21:51','2018-09-05 14:21:51',4);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` enum('Approved','Pending') NOT NULL DEFAULT 'Pending',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`user_name`,`passwd`,`user_type`,`email`,`status`,`date_created`) values 
(1,'chetan','3b8ebe34e784a3593693a37baaacb016','super','chetan@gmail.com','Approved','2018-09-04 17:59:19'),
(4,'union','8bda8e915e629a9fd1bbca44f8099c81','union_auditor','cliffordmasi07@gmail.co','Pending','2018-09-04 17:59:19'),
(7,'treasurer','91f77942403e9859ff6711f3d15fe233','treasurer','cmasi@safaricom.co.ke','Approved','2018-09-04 17:59:19'),
(18,'conference','91f77942403e9859ff6711f3d15fe233','auditor','conference','Approved','2018-09-05 14:23:58'),
(19,'cliffkaka','91f77942403e9859ff6711f3d15fe233','treasurer','cliffordmasi07@gmail.comm','Approved','2018-09-05 16:11:42'),
(20,'cliff','3b8ebe34e784a3593693a37baaacb016','auditor','cliffordmasi07@gmail.comh','Approved','2018-09-08 22:44:15'),
(24,'cliffka','91f77942403e9859ff6711f3d15fe233','treasurer','cliffordmasi07@gmail.comj','Pending','2018-09-19 18:22:11'),
(25,'cliffk','91f77942403e9859ff6711f3d15fe233','treasurer','cliffordmasi07@gmail.com','Approved','2018-09-19 18:29:43');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
