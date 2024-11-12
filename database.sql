/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET SQL_NOTES=0 */;
DROP TABLE IF EXISTS authors;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS books;
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(255) DEFAULT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `books_ibfk_2` (`publisher_id`),
  KEY `fk_books_image` (`image_id`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `books_ibfk_2` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`),
  CONSTRAINT `fk_books_image` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS book_authors;
CREATE TABLE `book_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `book_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `book_authors_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `book_authors_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS categories;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS images;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `entity_id` int(11) NOT NULL,
  `entity_type` enum('book','author') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `upload_time` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `entity_id` (`entity_id`),
  CONSTRAINT `images_ibfk_1` FOREIGN KEY (`entity_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS loans;
CREATE TABLE `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `book_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `loan_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `loans_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `loans_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS members;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `membership_date` date DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS publishers;
CREATE TABLE `publishers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `publisher_name` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT 'Create Time',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS reservations;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `book_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `reservation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`book_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`),
  CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO categories (id, category_name) VALUES
(1, 'Fiction'),
(2, 'Classic Literature'),
(3, 'Dystopian'),
(4, 'Romance'),
(5, 'Adventure');

INSERT INTO `publishers` (`publisher_name`, `bio`, `create_time`) VALUES
('Penguin Books', 'A global publisher', '2024-01-01 10:00:00'),
('HarperCollins', 'A large publishing company', '2024-01-02 11:00:00'),
('Random House', 'An American book publisher', '2024-01-03 12:00:00'),
('Oxford University Press', 'Publisher of academic texts', '2024-01-04 13:00:00'),
('Macmillan Publishers', 'British publishing company', '2024-01-05 14:00:00');


INSERT INTO book_authors (book_id, author_id) VALUES
(1, 5),
(2, 4),
(3, 3),
(4, 2),
(5, 1);

INSERT INTO `books` (`title`, `isbn`, `publication_year`, `publisher_id`, `category_id`, `create_time`) VALUES
('To Kill a Mockingbird', '9780061120084', 1960, 1, 2, '2024-01-01 10:00:00'),
('1984', '9780451524935', 1949, 2, 3, '2024-01-02 11:00:00'),
('Pride and Prejudice', '9780141040349', 1813, 1, 1, '2024-01-03 12:00:00'),
('The Great Gatsby', '9780743273565', 1925, 3, 2, '2024-01-04 13:00:00'),
('Moby Dick', '9781503280786', 1851, 2, 4, '2024-01-05 14:00:00'),
('War and Peace', '9780199232765', 1869, 4, 5, '2024-01-06 15:00:00'),
('The Catcher in the Rye', '9780316769488', 1951, 3, 3, '2024-01-07 16:00:00'),
('The Hobbit', '9780547928227', 1937, 5, 2, '2024-01-08 17:00:00'),
('Ulysses', '9780199535675', 1922, 4, 1, '2024-01-09 18:00:00'),
('Madame Bovary', '9780140449129', 1856, 1, 4, '2024-01-10 19:00:00');
