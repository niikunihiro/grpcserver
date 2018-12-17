CREATE database grpcserver character set utf8mb4 COLLATE utf8mb4_general_ci;

-- For MySQL 5.7
GRANT ALL PRIVILEGES ON `grpcserver`.* TO 'muscle-user'@'%';
