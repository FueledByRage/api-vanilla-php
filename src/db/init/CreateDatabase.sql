Use PHPCLIPS;

CREATE TABLE Users(
    username varchar(20) not null,
    email varchar(50) not null,
    password varchar(10) not null,
    about varchar(250) not null,
    profileUrl varchar(50)
);

CREATE TABLE Posts(
    author varchar(20) not null,
    body varchar(250) not null,
    created_date date not null,
    videoUrl varchar(250) not null,
);


SET character_set_client = utf8;
SET character_set_connection = utf8;
SET character_set_results = utf8;
SET collation_connection = utf8_general_ci;