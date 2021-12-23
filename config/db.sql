CREATE TABLE IF NOT EXISTS Users(
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    mail VARCHAR(255) NOT NULL UNIQUE,
    image VARCHAR(255) NOT NULL default "./content/default/default.png",
    description TEXT,
    joinDate DATE NOT NULL,
    pass VARCHAR(255) NOT NULL,
    admin BOOLEAN NOT NULL default 0
);
INSERT INTO Users (id, username, email, image, description, pass, admin) 
    VALUES (0, 'admin', 'admin@gmail.com', "./content/default/admin.png", "I'm the master of this world",'$2y$12$RaC3ZOdXCv.M5mOOmqZ4dORfvOSTyEOwSqs.5hfqQkRC9e9Ldq6ZC',1)
CREATE TABLE IF NOT EXISTS Articles(
    id INTEGER PRIMARY KEY  AUTO_INCREMENT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    category TEXT NOT NULL,
    date DATE NOT NULL,
    userID INTEGER NOT NULL,
    pinned BOOLEAN NOT NULL,
	FOREIGN KEY (userID) REFERENCES Users(id)
);
CREATE TABLE IF NOT EXISTS Token(
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    token TEXT NOT NULL,
    exp TEXT NOT NULL,
    mail VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS Favs(
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    postID INTEGER NOT NULL,
    userID INTEGER NOT NULL,
	FOREIGN KEY (postID) REFERENCES Articles(id),
	FOREIGN KEY (userID) REFERENCES Users(id)
);
CREATE TABLE IF NOT EXISTS Comments(
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    content VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    postID INTEGER NOT NULL,
    userID INTEGER NOT NULL,
	FOREIGN KEY (postID) REFERENCES Articles(id),
	FOREIGN KEY (userID) REFERENCES Users(id)
);