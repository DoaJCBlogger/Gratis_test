/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 10.4.32-MariaDB : Database - mysql
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mysql` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `mysql`;

/*Table structure for table `cars` */

DROP TABLE IF EXISTS `cars`;

CREATE TABLE `cars` (
  `VehicleID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Title` text DEFAULT NULL,
  `Make` text NOT NULL,
  `Model` text NOT NULL,
  `ModelYear` year(4) NOT NULL,
  `VehicleCondition` text DEFAULT NULL,
  `Color` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `StockNumber` text NOT NULL,
  `Miles` bigint(20) unsigned NOT NULL,
  `VIN` text NOT NULL,
  `Engine` text DEFAULT NULL,
  `Transmission` text DEFAULT NULL,
  `Location` text DEFAULT NULL,
  `FuelType` text DEFAULT NULL,
  `ShouldDisplay` tinyint(1) DEFAULT NULL,
  `MPG` text DEFAULT NULL,
  PRIMARY KEY (`VehicleID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `cars` */

insert  into `cars`(`VehicleID`,`Title`,`Make`,`Model`,`ModelYear`,`VehicleCondition`,`Color`,`Price`,`StockNumber`,`Miles`,`VIN`,`Engine`,`Transmission`,`Location`,`FuelType`,`ShouldDisplay`,`MPG`) values 
(1,'2023 Buick Envision','Buick','Envision',2023,'New','White',37240.00,'024279',3427,'LRBAZLR47PD024279','Gas','9-Speed Automatic','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'23/31'),
(2,'2023 GMC Envision','Buick','Envision',2023,'New','White',38120.00,'022183',3191,'LRBFZNR44PD022183','Gas','9-Speed Automatic','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'23/31'),
(3,'2023 GMC Sierra 1500','GMC','Sierra',2023,'New','Red',68135.00,'272971',6,'1GTUUCE88PZ272971	','Gas','10-Speed Automatic','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'22/27'),
(4,'2023 Buick Encore GX','Buick','Encore',2023,'New','Red',29130.00,'099937',7071,'KL4MMDS27PB099937','Gas','CVT','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'29/31'),
(5,'2023 Buick Encore GX','Buick','Encore',2023,'New','Red',27730.00,'144675',9,'KL4MMBS24OB144675','Gas','CVT','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'29/31'),
(6,'2023 GMC Terrain','GMC','Terrain',2023,'New','White',40980.00,'269100',5,'3GKALVEG9PL269100','Gas','9-Speed Automatic','Dealer Lot: Long Chevrolet Buick GMC','Gas',1,'24/28');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `UserID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `passwordHash` text NOT NULL,
  `passwordSalt` text NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `users` */

insert  into `users`(`UserID`,`username`,`passwordHash`,`passwordSalt`) values 
(00000000000000000001,'admin','6045d1a7d339bb0ac504a9c8aa0921e1ab79677e23f9ca509258f77080c25545','1704435144');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
