use data1;
CREATE TABLE table2 (
id int( 10 ) NOT NULL AUTO_INCREMENT ,
dt timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
username varchar( 50 ) NOT NULL ,
type int( 10 ) NOT NULL ,
query varchar( 100 ) DEFAULT NULL ,
page int( 10 ) DEFAULT NULL ,
qlink varchar( 100 ) ,
PRIMARY KEY ( id )
);