-- Create development databases & users
-- Note: This is executed on first container initialization
CREATE DATABASE IF NOT EXISTS `symfony`;
CREATE USER IF NOT EXISTS 'symfony'@'%' IDENTIFIED BY 'symfony_password';
GRANT ALL PRIVILEGES ON `symfony`.* TO 'symfony'@'%';
FLUSH PRIVILEGES;