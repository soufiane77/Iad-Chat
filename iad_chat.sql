CREATE DATABASE IF NOT EXISTS iad_chat;

CREATE TABLE iad_chat.users
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL
);

CREATE TABLE iad_chat.messages
(
    id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id int(11),
    text varchar(255) NOT NULL,
    createdAt datetime,
    CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id)
    REFERENCES users (id)
);
