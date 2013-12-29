SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `loginsystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `loginsystem` ;

-- -----------------------------------------------------
-- Table `loginsystem`.`register`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `loginsystem`.`register` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fastname` VARCHAR(50) NOT NULL,
  `lastname` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `passcode` VARCHAR(100) NOT NULL,
  `loginwith` VARCHAR(20) NOT NULL,
  `status` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `userid` (`id` ASC))
ENGINE = MyISAM
AUTO_INCREMENT = 4;


-- -----------------------------------------------------
-- Table `loginsystem`.`projects`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `loginsystem`.`projects` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `summary` VARCHAR(140) NULL,
  `details` TEXT NULL,
  `type` VARCHAR(60) NULL,
  `box_price` VARCHAR(45) NULL,
  `location` VARCHAR(45) NULL,
  `ratio` INT NULL,
  `payment_plan` VARCHAR(40) NULL,
  `use` VARCHAR(100) NULL,
  `agent_connection_count` TINYINT NULL,
  `buyer_seller_connection_count` TINYINT NULL,
  `projectscol` VARCHAR(45) NULL,
  `register_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `register_id`),
  INDEX `fk_projects_register1_idx` (`register_id` ASC),
  CONSTRAINT `fk_projects_register1`
    FOREIGN KEY (`register_id`)
    REFERENCES `loginsystem`.`register` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `loginsystem`.`connection`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `loginsystem`.`connection` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `projects_id` INT NOT NULL,
  `register_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `projects_id`, `register_id`),
  INDEX `fk_connection_projects1_idx` (`projects_id` ASC),
  INDEX `fk_connection_register1_idx` (`register_id` ASC),
  CONSTRAINT `fk_connection_projects1`
    FOREIGN KEY (`projects_id`)
    REFERENCES `loginsystem`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_connection_register1`
    FOREIGN KEY (`register_id`)
    REFERENCES `loginsystem`.`register` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
