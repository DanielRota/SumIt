CREATE DATABASE IF NOT EXISTS MyDanielRota;

USE MyDanielRota;

CREATE TABLE IF NOT EXISTS Users (
    pkUser INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Description VARCHAR(255) NOT NULL,
    ImagePath VARCHAR(255),
    CreationDate DATE DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE IF NOT EXISTS Categories (
    pkCategory INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Collections (
    pkCollection INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL,
    fkUser INT NOT NULL,
    fkCategory INT NOT NULL,
    FOREIGN KEY (fkUser) REFERENCES Users (pkUser),
    FOREIGN KEY (fkCategory) REFERENCES Categories (pkCategory)
);

CREATE TABLE IF NOT EXISTS Summaries (
    pkSummary INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Description VARCHAR(255) NOT NULL,
    Script MEDIUMTEXT NOT NULL,
    Link VARCHAR(255),
    fkCollection INT NOT NULL,
    FOREIGN KEY (fkCollection) REFERENCES Collections (pkCollection)
);

INSERT INTO Categories (Name, Description) VALUES 
("Music", "Music."),
("Learning", "Learning."),
("Job", "Job."),
("Reading", "Reading."),
("TV Series", "TV Series."),
("Documents", "Documents."),
("Cooking", "Cooking."),
("Films", "Films."),
("Tutorial", "Tutorial."),
("Other", "Other.");