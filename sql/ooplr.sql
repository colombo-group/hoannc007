CREATE TABLE users (
	ID				int 		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username		varchar(20) NOT NULL,
	password		varchar(64) NOT NULL,
	salt			varchar(32) NOT NULL,
	name			varchar(50) NOT NULL,
	joined			datetime	NOT NULL,
	userGroup		int 		NOT NULL
);

CREATE TABLE groups (
	ID				int 		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name			varchar(20) NOT NULL,
	permissions		text 		NOT NULL
);

CREATE TABLE usersSessions (
	ID				int 		NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userID			int 		NOT NULL,
	hash			varchar(50) NOT NULL
);