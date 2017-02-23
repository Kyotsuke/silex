DROP DATABASE IF EXISTS map;

CREATE DATABASE map DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

use map;

CREATE TABLE default_settings (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(100),
    content TEXT,
    nb SMALLINT,
    PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                        
INSERT INTO default_settings (title, content, nb)
VALUES
('name', 'Map', NULL),
('width', NULL, 250),
('height', NULL, 250),
('nb_tree', NULL, 50);