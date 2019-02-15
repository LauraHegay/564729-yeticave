CREATE DATABASE yeticave_db
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
USE yeticave_db;

CREATE TABLE users (
	id INT(11) NOT NULL AUTO_INCREMENT,
	name CHAR(255) NOT NULL,
	date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	email CHAR(128) NOT NULL,
	password CHAR(255) NOT NULL,
	avatar_path CHAR(128),
	contact TEXT,
	PRIMARY KEY(id)
);

CREATE TABLE lots (
	id INT(11) NOT NULL AUTO_INCREMENT,
	date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	date_end TIMESTAMP,
	title CHAR(255) NOT NULL,
	description TEXT ,
	image_path CHAR(255),
	start_price INT(11) NOT NULL,
	step_rate INT(11) NOT NULL,
	category_id INT(11) NOT NULL,
	user_id INT(11) NOT NULL,
	win_user_id INT(11) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE categories (
	id INT(11) NOT NULL AUTO_INCREMENT,
	name CHAR(50) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE rates (
	id INT(11) NOT NULL AUTO_INCREMENT,
	date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	sum_price CHAR(50),
	id_user INT(11) NOT NULL,
	id_lot INT(11) NOT NULL,
	PRIMARY KEY(id)
);

CREATE INDEX c_title ON lots(title);
CREATE INDEX c_category ON lots(category_id);
;