/*
SQLyog Enterprise - MySQL GUI v8.14 
MySQL - 5.1.41 : Database - nlog
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`nlog` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `nlog`;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `commentable_id` int(11) DEFAULT NULL,
  `commentable_type` varchar(40) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `body` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `comments` */

insert  into `comments`(`id`,`commentable_id`,`commentable_type`,`user_id`,`body`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'posts',1,'wtf fuckin comment','2011-02-20 19:22:22','2011-02-20 19:22:22',NULL),(2,1,'posts',1,'ololo commentos','2011-02-20 19:23:22','2011-02-20 19:23:22',NULL),(4,1,'posts',2,'Ñ„Ñ‹Ð²Ñ„Ñ‹Ð²Ñ„Ñ‹Ð²','2011-02-20 12:49:23','2011-02-20 12:49:23',NULL),(9,1,'posts',2,'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum','2011-02-20 19:19:09','2011-02-20 19:19:09',NULL),(6,1,'posts',2,'34','2011-02-20 12:51:37','2011-02-20 12:51:37',NULL),(7,1,'posts',2,'34','2011-02-20 12:52:39','2011-02-20 12:52:39',NULL),(8,1,'posts',2,'Ñ„Ñ‹Ð²Ñ„Ñ‹Ð²','2011-02-20 12:52:42','2011-02-20 12:52:42',NULL),(10,2,'posts',2,'First One','2011-02-20 19:23:14','2011-02-20 19:23:14',NULL),(11,2,'posts',2,'Second comment','2011-02-20 19:59:06','2011-02-20 19:59:06',NULL),(12,1,'posts',2,'sd','2011-02-21 00:31:14','2011-02-21 00:31:14',NULL),(13,1,'posts',2,'Also','2011-02-21 01:02:33','2011-02-21 01:02:33',NULL),(14,5,'posts',2,'configurable','2011-02-21 01:16:22','2011-02-21 01:16:22',NULL);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `body` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `posts` */

insert  into `posts`(`id`,`user_id`,`title`,`body`,`created_at`,`updated_at`,`deleted_at`) values (1,2,'first post','bbbody','2011-02-19 19:22:22','2011-02-19 19:22:22',NULL),(2,2,'second post','trololo','2011-02-20 19:22:22','2011-02-20 19:22:22',NULL),(3,2,'3rd','asdasdasdasdasd','2011-02-21 00:39:01','2011-02-21 00:39:01',NULL),(4,2,'3rd','asdasdasdasdasd','2011-02-21 00:39:27','2011-02-21 00:39:27',NULL),(5,2,'3rd','asdasdasdasdasd','2011-02-21 00:39:33','2011-02-21 00:39:33',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(40) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `nickname` varchar(40) DEFAULT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`login`,`password`,`nickname`,`salt`,`created_at`,`updated_at`,`deleted_at`) values (1,'guest','2f8e9675d940d63dd25f7561dcea29a2','Anonimous','45953125799f45918112111b6a9f5efe611f59d0',NULL,NULL,NULL),(2,'ololo','37f62f1363b04df4370753037853fe88','Big Ban','da39a3ee5e6b4b0d3255bfef95601890afd80709','2011-02-19 18:22:22','2011-02-19 18:22:22',NULL);

/*Table structure for table `users_roles` */

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_roles` */

insert  into `users_roles`(`user_id`,`role`) values (1,'guest'),(2,'editor'),(2,'admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
