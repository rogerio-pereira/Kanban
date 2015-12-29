SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `kanban` ;
CREATE SCHEMA IF NOT EXISTS `kanban` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `kanban` ;

-- -----------------------------------------------------
-- Table `kanban`.`kanban_situacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban`.`kanban_situacao` (
  `codigo` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(25) NOT NULL,
  `ordem` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban`.`kanban_tarefas_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban`.`kanban_tarefas_categoria` (
  `codigo` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(30) NOT NULL,
  `cor` VARCHAR(7) NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban`.`kanban_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban`.`kanban_usuario` (
  `codigo` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `usuario` VARCHAR(15) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `cor` VARCHAR(7) NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  UNIQUE INDEX `usuario_UNIQUE` (`usuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban`.`kanban_tarefas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban`.`kanban_tarefas` (
  `codigo` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `criacao` DATE NOT NULL,
  `categoria` BIGINT UNSIGNED NULL,
  `prioridade` INT(1) NULL,
  `link` VARCHAR(100) NULL,
  `descricao` LONGTEXT NULL,
  `situacao` BIGINT UNSIGNED NULL,
  `usuario` BIGINT UNSIGNED NULL,
  `data_inicio` DATE NULL,
  `tempo_estimado` TIME NULL,
  `data_conclusao` DATE NULL,
  `concluido` TINYINT(1) NOT NULL DEFAULT false,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  INDEX `fk_tarefas_categoria_idx` (`categoria` ASC),
  INDEX `fk_tarefas_usuario_idx` (`usuario` ASC),
  INDEX `fk_tarefas_situacao_idx` (`situacao` ASC),
  CONSTRAINT `fk_tarefas_categoria`
    FOREIGN KEY (`categoria`)
    REFERENCES `kanban`.`kanban_tarefas_categoria` (`codigo`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tarefas_usuario`
    FOREIGN KEY (`usuario`)
    REFERENCES `kanban`.`kanban_usuario` (`codigo`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tarefas_situacao`
    FOREIGN KEY (`situacao`)
    REFERENCES `kanban`.`kanban_situacao` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kanban`.`kanban_tarefas_subtarefas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kanban`.`kanban_tarefas_subtarefas` (
  `codigo` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_tarefa` BIGINT UNSIGNED NOT NULL,
  `nome` VARCHAR(50) NOT NULL,
  `concluido` TINYINT(1) NOT NULL DEFAULT false,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
  INDEX `fk_subtarefa_codigo_tarefa_idx` (`codigo_tarefa` ASC),
  CONSTRAINT `fk_subtarefa_codigo_tarefa`
    FOREIGN KEY (`codigo_tarefa`)
    REFERENCES `kanban`.`kanban_tarefas` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `kanban`.`kanban_situacao`
-- -----------------------------------------------------
START TRANSACTION;
USE `kanban`;
INSERT INTO `kanban`.`kanban_situacao` (`codigo`, `nome`, `ordem`) VALUES (1, 'A Fazer', 1);
INSERT INTO `kanban`.`kanban_situacao` (`codigo`, `nome`, `ordem`) VALUES (2, 'Em Progresso', 2);
INSERT INTO `kanban`.`kanban_situacao` (`codigo`, `nome`, `ordem`) VALUES (3, 'Testes', 3);
INSERT INTO `kanban`.`kanban_situacao` (`codigo`, `nome`, `ordem`) VALUES (4, 'ConcluÃ­do', 4);

COMMIT;


-- -----------------------------------------------------
-- Data for table `kanban`.`kanban_usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `kanban`;
INSERT INTO `kanban`.`kanban_usuario` (`codigo`, `nome`, `usuario`, `senha`, `cor`) VALUES (1, 'SUPORTE', 'suporte', '98da3351cf2455b93f98fc7fd1722fa6', NULL);

COMMIT;

