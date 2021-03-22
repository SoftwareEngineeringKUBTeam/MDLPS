create table STUDENT (
	SID INT not null AUTO_INCREMENT,
	name_first VARCHAR(50) not null,
	name_last VARCHAR(50) not null,
	email VARCHAR(50) not null,
	building VARCHAR(50) not null,
	room_num VARCHAR(50) not null,
	bed_letter VARCHAR(50) not null,
    PRIMARY KEY(SID)
);
insert into STUDENT(SID, name_first, name_last, email, building, room_num, bed_letter) values (51, "MDLPS", "CSC", "testMDLPS@gmail.com", "Building 1", "355", "A");
