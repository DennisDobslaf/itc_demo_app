-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user`
(
    `id`       INT          NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(150) NOT NULL,
    `password` VARCHAR(60)  NOT NULL,
    `email`    VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
);


-- -----------------------------------------------------
-- Table `category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `category`
(
    `id`    INT          NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
);


-- -----------------------------------------------------
-- Table `article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `article`
(
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `title`       VARCHAR(100) NOT NULL,
    `content`     TEXT         NOT NULL,
    `created`     DATETIME     NOT NULL,
    `category_id` INT          NOT NULL,
    `user_id`     INT          NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_article_category_idx` (`category_id` ASC),
    INDEX `fk_article_user1_idx` (`user_id` ASC),
    CONSTRAINT `fk_article_category`
        FOREIGN KEY (`category_id`)
            REFERENCES `category` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_article_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `user` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
);