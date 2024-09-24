/*events table*/
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_description TEXT,
    event_start_date DATE NOT NULL,
    event_end_date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    event_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*destinations table*/
CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    district VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price VARCHAR(50) NOT NULL,
    hotel_name VARCHAR(255) NOT NULL,
    hotel_url VARCHAR(255) NOT NULL,
    uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/*user table*/
create table userreg(name varchar(500),
    email varchar(500), 
    password varchar(500),
    filename varchar(500)
);

/*REVIEW TABLE*/
create table reviews(
    id int AUTO_INCREMENT primary key,
    name varchar(100) not null,
    email varchar(100) not null,
    title varchar(255) not null,
    review text not null,
);

CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    price_per_night DECIMAL(10, 2) NOT NULL,
    rating DECIMAL(3, 1) NOT NULL,
    picture_url VARCHAR(255) 
);

CREATE TABLE hotel_attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    attractions_info TEXT NOT NULL, 
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
);