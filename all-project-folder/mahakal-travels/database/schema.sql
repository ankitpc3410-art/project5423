CREATE DATABASE IF NOT EXISTS mahakal_travels CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mahakal_travels;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS settings;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE admins (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE destinations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    state VARCHAR(120) DEFAULT NULL,
    category VARCHAR(80) DEFAULT NULL,
    image VARCHAR(500) DEFAULT NULL,
    short_description VARCHAR(500) DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_destinations_active_sort (is_active, sort_order)
) ENGINE=InnoDB;

CREATE TABLE packages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    destination_id BIGINT UNSIGNED DEFAULT NULL,
    title VARCHAR(180) NOT NULL,
    category VARCHAR(80) NOT NULL DEFAULT 'Tour',
    duration VARCHAR(80) DEFAULT NULL,
    price DECIMAL(10,2) DEFAULT NULL,
    image VARCHAR(500) DEFAULT NULL,
    short_description VARCHAR(500) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_packages_active_featured (is_active, is_featured),
    CONSTRAINT fk_packages_destination FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(40) NOT NULL,
    destination_id BIGINT UNSIGNED DEFAULT NULL,
    package_id BIGINT UNSIGNED DEFAULT NULL,
    travel_date DATE DEFAULT NULL,
    travelers SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    message TEXT DEFAULT NULL,
    status ENUM('new','contacted','confirmed','cancelled','completed') NOT NULL DEFAULT 'new',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_bookings_status_created (status, created_at),
    CONSTRAINT fk_bookings_destination FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE SET NULL,
    CONSTRAINT fk_bookings_package FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(40) DEFAULT NULL,
    subject VARCHAR(190) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read','replied','closed') NOT NULL DEFAULT 'new',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_messages_status_created (status, created_at)
) ENGINE=InnoDB;

CREATE TABLE settings (
    setting_key VARCHAR(120) PRIMARY KEY,
    setting_value TEXT NOT NULL
) ENGINE=InnoDB;

INSERT INTO destinations (name,state,category,image,short_description,sort_order,is_active) VALUES
('Ujjain','Madhya Pradesh','Spiritual Journey','assets/images/mahakaleshwar.svg','Experience the divine atmosphere of Mahakaleshwar Jyotirlinga.',1,1),
('Varanasi','Uttar Pradesh','Sacred Heritage','assets/images/varanasi.svg','Discover historic ghats, temples and the Ganga Aarti.',2,1),
('Ayodhya','Uttar Pradesh','Devotional Escape','assets/images/ayodhya.svg','Explore sacred landmarks and the spiritual heritage of Ayodhya.',3,1),
('Rishikesh','Uttarakhand','Nature & Wellness','assets/images/rishikesh.svg','Enjoy riverside scenery and Himalayan foothill experiences.',4,1),
('Agra','Uttar Pradesh','Historic Wonders','assets/images/tajmahal.svg','Visit the iconic Taj Mahal and explore Mughal heritage.',5,1);

INSERT INTO packages (destination_id,title,category,duration,price,image,short_description,description,is_featured,is_active) VALUES
(1,'Divine Ujjain Darshan','Pilgrimage','Customizable duration',NULL,'assets/images/mahakaleshwar.svg','Visit sacred temples and experience the spiritual charm of Ujjain.','A customizable Ujjain trip enquiry. Confirm temple timings, transport, lodging and inclusions with the travel team.',1,1),
(2,'Varanasi Spiritual Retreat','Heritage','Customizable duration',NULL,'assets/images/varanasi.svg','Discover ancient temples, sacred ghats and the Ganga Aarti.','A customizable Varanasi trip enquiry. Confirm boat rides, local transport, lodging and inclusions with the travel team.',1,1),
(3,'Ayodhya Divine Journey','Religious Tour','Customizable duration',NULL,'assets/images/ayodhya.svg','Explore sacred landmarks and Ayodhya’s spiritual heritage.','A customizable Ayodhya trip enquiry. Confirm transport, lodging and inclusions with the travel team.',1,1);

INSERT INTO settings (setting_key,setting_value) VALUES
('business_phone','Add your business phone number'),
('business_email','hello@example.com'),
('business_address','Add your office address'),
('whatsapp_number','910000000000'),
('facebook_url','#'),
('instagram_url','#');
