CREATE TABLE `user` (
	`FirstName` varchar(100) DEFAULT NULL,
	`Email` varchar(100) DEFAULT NULL,
	`Password` varchar(40) DEFAULT NULL,
	`UserID` int(10) NOT NULL AUTO_INCREMENT,
	
	PRIMARY KEY(`UserID`)

);