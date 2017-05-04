create database data1;
use data1;
create table table1(
	id int(10) NOT NULL auto_increment,
	username varchar(50) NOT NULL,
	password varchar(100) NOT NULL,
	history int(10) NOT NULL DEFAULT 0,
	primary key(id,username)
);