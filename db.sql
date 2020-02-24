/*
SQLyog Ultimate v9.50 
MySQL - 5.6.43 : Database - burgers
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`burgers` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `burgers`;

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `order_date` datetime NOT NULL,
  `address` varchar(200) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `need_change` tinyint(1) unsigned DEFAULT NULL,
  `card_payment` tinyint(1) unsigned DEFAULT NULL,
  `not_call` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `orders` */

insert  into `orders`(`id`,`user_id`,`order_date`,`address`,`comment`,`need_change`,`card_payment`,`not_call`) values (1,1,'2020-02-24 17:23:06','Улица: Инициативная, Дом: 32, Квартира: 8, Этаж: 3','Срочный заказ!',0,1,1),(2,2,'2020-02-24 17:23:34','Улица: Инициативная, Дом: 30, Квартира: 4, Этаж: 2','',1,0,0),(3,2,'2020-02-24 17:23:58','Улица: Инициативная, Дом: 30, Квартира: 4, Этаж: 2','Еще бургер, больше бургеров!!!',0,0,0),(4,2,'2020-02-24 17:24:19','Улица: Инициативная, Дом: 30, Квартира: 4, Этаж: 2','Можете не торопиться',0,0,0),(5,2,'2020-02-24 17:32:06','Улица: Инициативная, Дом: 30, Квартира: 4, Этаж: 2','',0,0,0);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dt_reg` datetime NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `house` varchar(15) DEFAULT NULL,
  `building` varchar(15) DEFAULT NULL,
  `apartment` varchar(5) DEFAULT NULL,
  `floor` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`dt_reg`,`first_name`,`phone`,`mail`,`street`,`house`,`building`,`apartment`,`floor`) values (1,'2020-02-24 17:23:06','Sergey','+7 (777) 999 66 66','ololo@mail.ru','Инициативная','32','','8','3'),(2,'2020-02-24 17:23:34','Илья','+7 (777) 888 66 66','kek4ik@mail.ru','Инициативная','30','','4','2');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
