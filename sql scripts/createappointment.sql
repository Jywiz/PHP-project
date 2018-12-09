CREATE TABLE `appointment` (
	`title` varchar(100) DEFAULT NULL,
	`date` date DEFAULT NULL,
	`id` INT NOT NULL,
	`appointmentid` INT NOT NULL AUTO_INCREMENT,
	
	PRIMARY KEY(`appointmentid`),
	FOREIGN KEY(`id`) REFERENCES user(`id`)

);