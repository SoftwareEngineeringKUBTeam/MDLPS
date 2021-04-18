CREATE TABLE IF NOT EXISTS `logininfo` (
  `user` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `accessLevel` varchar(45) NOT NULL,
  `nameFirst` varchar(45) NOT NULL,
  `nameLast` varchar(45) NOT NULL,
  PRIMARY KEY (`user`)
);

CREATE TABLE IF NOT EXISTS `package` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `building` varchar(50) NOT NULL,
  `log_date` varchar(255) DEFAULT NULL,
  `name_first` varchar(50) NOT NULL,
  `name_last` varchar(50) NOT NULL,
  `tracking_ID` varchar(50) NOT NULL,
  `sign_date` varchar(255) DEFAULT NULL,
  `2FA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`,`building`)
);

CREATE TABLE IF NOT EXISTS `student` (
  `SID` int(11) NOT NULL AUTO_INCREMENT,
  `name_first` varchar(50) NOT NULL,
  `name_last` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `building` varchar(50) NOT NULL,
  `room_num` varchar(50) NOT NULL,
  `bed_letter` varchar(50) NOT NULL,
  PRIMARY KEY (`SID`)
);

CREATE TABLE IF NOT EXISTS `archive` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `building` varchar(50) NOT NULL,
  `log_date` varchar(255) DEFAULT NULL,
  `name_first` varchar(50) NOT NULL,
  `name_last` varchar(50) NOT NULL,
  `tracking_ID` varchar(50) NOT NULL,
  `sign_date` varchar(255) DEFAULT NULL,
  `2FA` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`,`building`)
);

delimiter $$
CREATE EVENT IF NOT EXISTS package_archive
ON SCHEDULE EVERY 1 YEAR STARTS "2021-01-01" + INTERVAL 1 YEAR DO

BEGIN
  INSERT INTO archive (ID, bulding, log_date, name_first, name_last, tracking_ID, sign_date, 2FA)
  SELECT L.ID, L.building, L.log_date, L.name_first, L.name_last, L.tracking_ID, L.sign_date, `L.2FA`
  FROM package L
  WHERE sign_date IS NOT NULL;
  DELETE FROM package WHERE sign_date IS NOT NULL;
END$$
delimiter ;