-- -----------------------------------------------------
-- Table `guestbook`.`user_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guestbook`.`user_role` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guestbook`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guestbook`.`user` (
  `id` INT NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `password_hash` VARCHAR(300) NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) ,
  INDEX `fk_user_role1_idx` (`role_id` ASC) ,
  CONSTRAINT `fk_user_role1`
    FOREIGN KEY (`role_id`)
    REFERENCES `guestbook`.`user_role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guestbook`.`entry_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guestbook`.`entry_type` (
  `id` INT UNSIGNED NOT NULL,
  `code` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `guestbook`.`entry`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `guestbook`.`entry` (
  `id` INT NOT NULL,
  `content` VARCHAR(45) NULL,
  `is_approved` VARCHAR(45) NULL,
  `owner_id` INT NOT NULL,
  `approver_id` INT NOT NULL,
  `entry_type_id` INT UNSIGNED NOT NULL,
  `updated_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_note_user_idx` (`owner_id` ASC) ,
  INDEX `fk_entry_user1_idx` (`approver_id` ASC) ,
  INDEX `fk_entry_entry_type1_idx` (`entry_type_id` ASC) ,
  CONSTRAINT `fk_note_user`
    FOREIGN KEY (`owner_id`)
    REFERENCES `guestbook`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entry_user1`
    FOREIGN KEY (`approver_id`)
    REFERENCES `guestbook`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_entry_entry_type1`
    FOREIGN KEY (`entry_type_id`)
    REFERENCES `guestbook`.`entry_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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

