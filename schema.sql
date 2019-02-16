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

CREATE TABLE categories (
	id INT(11) NOT NULL AUTO_INCREMENT,
	name CHAR(50) NOT NULL,
	PRIMARY KEY(id)
);


CREATE TABLE lots (
	id INT(11) NOT NULL AUTO_INCREMENT,
	date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	date_end TIMESTAMP,
	title CHAR(255) NOT NULL,
	description TEXT ,
	image_path CHAR(255),
	start_price INT(11),
	step_rate INT(11),
	category_id INT(11),
	user_id INT(11),
	win_user_id INT(11),
	PRIMARY KEY(id),
	CONSTRAINT FK_lots_categories FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_lots_users FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_lots_users_2 FOREIGN KEY (win_user_id) REFERENCES users(id)
);


CREATE TABLE rates (
	id INT(11) NOT NULL AUTO_INCREMENT,
	date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	sum_price CHAR(50),
	id_user INT(11) NOT NULL,
	id_lot INT(11) NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT FK_rates_users FOREIGN KEY (id_user) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT FK_rates_lots FOREIGN KEY (id_lot) REFERENCES lots(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE INDEX date_create_title ON lots (date_create, title);