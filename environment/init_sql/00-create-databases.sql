CREATE DATABASE IF NOT EXISTS guestbook;
CREATE DATABASE IF NOT EXISTS guestbook_test;
CREATE USER 'guestbook'@'localhost' IDENTIFIED BY 'guestbook';
GRANT ALL PRIVILEGES ON guestbook.* TO 'guestbook'@'localhost';
GRANT ALL PRIVILEGES ON guestbook_test.* TO 'guestbook'@'localhost';