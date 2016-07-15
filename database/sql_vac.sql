SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `VACDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `VACDB` ;

-- -----------------------------------------------------
-- Table `VACDB`.`USUARIO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VACDB`.`USUARIO` (
  `usuario_id` INT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(13) NOT NULL,
  `idade` INT(3) NOT NULL,
  `sexo` CHAR(1) NOT NULL,
  PRIMARY KEY (`usuario_id`))
ENGINE = InnoDB
COMMENT = 'Alex';


-- -----------------------------------------------------
-- Table `VACDB`.`DOENCA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VACDB`.`DOENCA` (
  `doenca_id` INT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`doenca_id`))
ENGINE = InnoDB
COMMENT = 'Hugo';


-- -----------------------------------------------------
-- Table `VACDB`.`VACINA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VACDB`.`VACINA` (
  `vacina_id` INT NULL AUTO_INCREMENT,
  `doenca_id` INT NOT NULL,
  `validade` DATE NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`vacina_id`),
  INDEX `fk_VACINA_DOENCA1_idx` (`doenca_id` ASC),
  CONSTRAINT `fk_VACINA_DOENCA1`
    FOREIGN KEY (`doenca_id`)
    REFERENCES `VACDB`.`DOENCA` (`doenca_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Laleska';


-- -----------------------------------------------------
-- Table `VACDB`.`TIPO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VACDB`.`TIPO` (
  `tipo_id` INT NULL AUTO_INCREMENT,
  `vacina_id` INT NOT NULL,
  `nome_tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`tipo_id`),
  INDEX `fk_TIPO_VACINA1_idx` (`vacina_id` ASC),
  CONSTRAINT `fk_TIPO_VACINA1`
    FOREIGN KEY (`vacina_id`)
    REFERENCES `VACDB`.`VACINA` (`vacina_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Hugo';


-- -----------------------------------------------------
-- Table `VACDB`.`CARTEIRA_DE_VACINACAO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `VACDB`.`CARTEIRA_DE_VACINACAO` (
  `carteira_id` INT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `vacina_id` INT NOT NULL,
  `data_vacinacao` DATE NOT NULL,
  PRIMARY KEY (`carteira_id`),
  INDEX `fk_CARTEIRA_DE_VACINACAO_USUARIO1_idx` (`usuario_id` ASC),
  INDEX `fk_CARTEIRA_DE_VACINACAO_VACINA1_idx` (`vacina_id` ASC),
  CONSTRAINT `fk_CARTEIRA_DE_VACINACAO_USUARIO1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `VACDB`.`USUARIO` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CARTEIRA_DE_VACINACAO_VACINA1`
    FOREIGN KEY (`vacina_id`)
    REFERENCES `VACDB`.`VACINA` (`vacina_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
