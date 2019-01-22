INSERT INTO `guestbook`.`entry_type` (`id`,`code`)
  VALUES
    (1,"text"),
    (2,"image");

INSERT INTO `guestbook`.`user_role` (`id`,`code`)
  VALUES
    (1,"admin"),
    (2,"guest");

INSERT INTO `guestbook`.`user` (`id`, `login`, `password_hash`, `role_id`)
  VALUES
    (1, 'admin1', '$2y$10$KaHIZI/jDGLZEPe82eygjuj5BLKFpoqSm6XxkkTAJbCOF6MQ46L1u', 1),
    (2, 'guest1', '$2y$10$1P03ib7lI4Dx.9C/BwAVx./8hGovdtEjOxTGDc418kg0tyiWj3poO', 2);

