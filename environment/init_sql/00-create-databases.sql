CREATE DATABASE IF NOT EXISTS guestbook;
CREATE DATABASE IF NOT EXISTS guestbook_test;
CREATE USER 'guestbook'@'localhost' IDENTIFIED BY 'guestbook';
grant all privileges on guestbook.* to guestbook;
grant all privileges on guestbook_test.* to guestbook;