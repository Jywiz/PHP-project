INSERT INTO `appointment` VALUES ('Dentist', '2019-12-02', (SELECT `id` FROM user WHERE `id`=1), '01');
