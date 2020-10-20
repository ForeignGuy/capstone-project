-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Marv_Related_Information
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Marv_Related_Information` DEFAULT CHARACTER SET utf8 ;
USE `Marv_Related_Information` ;

-- -----------------------------------------------------
-- Table `Marv_Related_Information`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Marv_Related_Information`.`users` (
  `User_Number` INT(255) NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(30) NOT NULL,
  `Password` VARCHAR(30) NOT NULL,
  `Email_Address` VARCHAR(45) NOT NULL,
  `Phone_Number` CHAR(10) NULL,
  PRIMARY KEY (`User_Number`),
  UNIQUE INDEX `User_Number_UNIQUE` (`User_Number` ASC),
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC),
  UNIQUE INDEX `Email_Address_UNIQUE` (`Email_Address` ASC),
  UNIQUE INDEX `Phone_Number_UNIQUE` (`Phone_Number` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Marv_Related_Information`.`User_Account_Type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Marv_Related_Information`.`User_Account_Type` (
  `users_User_Number` INT(255) NOT NULL,
  `Admin_Account` TINYINT NOT NULL,
  PRIMARY KEY (`users_User_Number`),
  UNIQUE INDEX `users_User_Number_UNIQUE` (`users_User_Number` ASC),
  CONSTRAINT `fk_User_Account_Type_users`
    FOREIGN KEY (`users_User_Number`)
    REFERENCES `Marv_Related_Information`.`users` (`User_Number`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Marv_Related_Information`.`User_Comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Marv_Related_Information`.`User_Comments` (
  `User_Message_Number` INT(255) NOT NULL AUTO_INCREMENT,
  `Comment_Text` LONGTEXT NOT NULL,
  `users_User_Number` INT(255) NOT NULL,
  PRIMARY KEY (`User_Message_Number`, `users_User_Number`),
  UNIQUE INDEX `User_Message_Number_UNIQUE` (`User_Message_Number` ASC),
  INDEX `fk_User_Comments_users1_idx` (`users_User_Number` ASC),
  CONSTRAINT `fk_User_Comments_users1`
    FOREIGN KEY (`users_User_Number`)
    REFERENCES `Marv_Related_Information`.`users` (`User_Number`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;