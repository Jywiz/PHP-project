CREATE TABLE `appointment` (
	`Title` varchar(100) DEFAULT NULL,
	`Date` date DEFAULT NULL,
	`UserID` int(10),
	`AppointmentID` int(10) NOT NULL AUTO_INCREMENT,
	
	PRIMARY KEY(`AppointmentID`),
	FOREIGN KEY(`UserID`) REFERENCES user(`UserID`)

);