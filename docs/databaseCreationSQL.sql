-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema domein_zoeker
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema domein_zoeker
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `domein_zoeker` DEFAULT CHARACTER SET utf8mb4 ;
USE `domein_zoeker` ;

-- -----------------------------------------------------
-- Table `domein_zoeker`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `domein_zoeker`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `domein_zoeker`.`tlds`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `domein_zoeker`.`tlds` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `domain` VARCHAR(255) NOT NULL,
  `status` VARCHAR(45) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `currency` VARCHAR(3) NOT NULL,
  `order_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `order_id` (`order_id` ASC) VISIBLE,
  CONSTRAINT `order_id`
    FOREIGN KEY (`order_id`)
    REFERENCES `domein_zoeker`.`orders` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 48
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
