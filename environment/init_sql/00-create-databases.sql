CREATE DATABASE IF NOT EXISTS guestbook;
CREATE DATABASE IF NOT EXISTS guestbook_test;
CREATE USER 'guestbook'@'%' IDENTIFIED BY 'guestbook';
GRANT ALL PRIVILEGES ON guestbook.* TO 'guestbook'@'%';
GRANT ALL PRIVILEGES ON guestbook_test.* TO 'guestbook'@'%';