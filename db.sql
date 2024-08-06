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