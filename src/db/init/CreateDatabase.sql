Use PHPCLIPS;

CREATE TABLE Users(
    id int AUTO_INCREMENT, 
    username varchar(20) not null,
    email varchar(50) not null,
    password varchar(10) not null,
    about varchar(250) not null,
    profileUrl varchar(50),
    PRIMARY KEY(id)
);

CREATE TABLE Posts(
    id int AUTO_INCREMENT, 
    author_id int not null,
    body varchar(250) not null,
    created_date date not null,
    videoUrl varchar(250) not null,
    PRIMARY KEY(id),
    FOREIGN KEY(author_id) REFERENCES Users(id)
);


SET character_set_client = utf8;
SET character_set_connection = utf8;
SET character_set_results = utf8;
SET collation_connection = utf8_general_ci;