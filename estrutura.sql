SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `sgc` DEFAULT CHARACTER SET utf8 ;
USE `sgc` ;

-- -----------------------------------------------------
-- Table `sgc`.`ESTADOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`ESTADOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`ESTADOS` (
  `ESTA_ID` INT NOT NULL AUTO_INCREMENT ,
  `ESTA_NOME` VARCHAR(45) NOT NULL ,
  `ESTA_UF` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`ESTA_ID`) )
ENGINE = InnoDB
PACK_KEYS = Default;


-- -----------------------------------------------------
-- Table `sgc`.`CIDADES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`CIDADES` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`CIDADES` (
  `CIDA_ID` INT NOT NULL AUTO_INCREMENT ,
  `CIDA_NOME` VARCHAR(45) NOT NULL ,
  `ESTA_ID` INT NOT NULL ,
  PRIMARY KEY (`CIDA_ID`, `ESTA_ID`) ,
  INDEX `fk_CIDADES_ESTADOS1_idx` (`ESTA_ID` ASC) ,
  CONSTRAINT `fk_CIDADES_ESTADOS1`
    FOREIGN KEY (`ESTA_ID` )
    REFERENCES `sgc`.`ESTADOS` (`ESTA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`BAIRROS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`BAIRROS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`BAIRROS` (
  `BAIRRO_ID` INT NOT NULL AUTO_INCREMENT ,
  `BAIRRO_NOME` VARCHAR(45) NULL ,
  `CIDA_ID` INT NOT NULL ,
  PRIMARY KEY (`BAIRRO_ID`, `CIDA_ID`) ,
  INDEX `fk_BAIRROS_CIDADES1_idx` (`CIDA_ID` ASC) ,
  CONSTRAINT `fk_BAIRROS_CIDADES1`
    FOREIGN KEY (`CIDA_ID` )
    REFERENCES `sgc`.`CIDADES` (`CIDA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ENDERECOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`ENDERECOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`ENDERECOS` (
  `END_ID` INT NOT NULL AUTO_INCREMENT ,
  `END_LOGRA` VARCHAR(45) NOT NULL ,
  `END_NUMERO` INT NOT NULL ,
  `END_CEP` INT NOT NULL ,
  `END_REFERENCIA` VARCHAR(45) NULL ,
  `BAIRRO_ID` INT NOT NULL ,
  PRIMARY KEY (`END_ID`, `BAIRRO_ID`) ,
  INDEX `fk_ENDERECOS_BAIRROS1_idx` (`BAIRRO_ID` ASC) ,
  CONSTRAINT `fk_ENDERECOS_BAIRROS1`
    FOREIGN KEY (`BAIRRO_ID` )
    REFERENCES `sgc`.`BAIRROS` (`BAIRRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`PESSOAS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`PESSOAS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`PESSOAS` (
  `PES_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_NOME` VARCHAR(45) NOT NULL ,
  `PES_CPF_CNPJ` VARCHAR(15) NOT NULL ,
  `PES_NOME_PAI` VARCHAR(45) NOT NULL ,
  `PES_NOME_MAE` VARCHAR(45) NOT NULL ,
  `PES_NASC_DATA` DATE NOT NULL ,
  `PES_FONE` VARCHAR(10) NOT NULL ,
  `PES_CEL1` VARCHAR(10) NULL ,
  `PES_CEL2` VARCHAR(10) NULL ,
  `END_ID` INT NOT NULL ,
  `PES_TIPO` VARCHAR(1) NOT NULL ,
  `PES_ESPECIFICA` VARCHAR(1) NOT NULL ,
  `PES_ESTATUS` VARCHAR(1) NOT NULL ,
  `PES_DATA` DATETIME NOT NULL ,
  PRIMARY KEY (`PES_ID`, `END_ID`) ,
  INDEX `fk_PESSOAS_ENDERECOS1_idx` (`END_ID` ASC) ,
  CONSTRAINT `fk_PESSOAS_ENDERECOS1`
    FOREIGN KEY (`END_ID` )
    REFERENCES `sgc`.`ENDERECOS` (`END_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
ROW_FORMAT = Default;


-- -----------------------------------------------------
-- Table `sgc`.`PRODUTOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`PRODUTOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`PRODUTOS` (
  `PRO_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_DESCRICAO` VARCHAR(45) NOT NULL ,
  `PRO_CARAC_TEC` TEXT NULL ,
  `PRO_VAL_CUST` DECIMAL(10,2) NULL ,
  `PRO_VAL_VEND` DECIMAL(10,2) NULL ,
  `PRO_SITUACAO` ENUM('a','d') NOT NULL ,
  `PRO_IMG` VARCHAR(10) NULL ,
  PRIMARY KEY (`PRO_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ESTOQUES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`ESTOQUES` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`ESTOQUES` (
  `EST_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_ID` INT NOT NULL ,
  `EST_ATUAL` INT NOT NULL ,
  `EST_MIN` INT NULL ,
  PRIMARY KEY (`EST_ID`, `PRO_ID`) ,
  INDEX `fk_ESTOQUES_PRODUTOS1_idx` (`PRO_ID` ASC) ,
  CONSTRAINT `fk_ESTOQUES_PRODUTOS1`
    FOREIGN KEY (`PRO_ID` )
    REFERENCES `sgc`.`PRODUTOS` (`PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`LISTA_PROD`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`LISTA_PROD` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`LISTA_PROD` (
  `LIST_PRO_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_ID` INT NOT NULL ,
  `LIST_PRO_QNT` INT NOT NULL ,
  `LIST_PRO_DIF` INT NULL ,
  PRIMARY KEY (`LIST_PRO_ID`, `PRO_ID`) ,
  INDEX `fk_LISTA_PROD_PRODUTOS1_idx` (`PRO_ID` ASC) ,
  CONSTRAINT `fk_LISTA_PROD_PRODUTOS1`
    FOREIGN KEY (`PRO_ID` )
    REFERENCES `sgc`.`PRODUTOS` (`PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`CARGOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`CARGOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`CARGOS` (
  `CARG_ID` INT NOT NULL AUTO_INCREMENT ,
  `CARG_NOME` VARCHAR(45) NOT NULL ,
  `CARG_NIVEL` VARCHAR(1) NULL ,
  PRIMARY KEY (`CARG_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`USUARIO`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`USUARIO` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`USUARIO` (
  `USU_ID` INT NOT NULL AUTO_INCREMENT ,
  `CARG_ID` INT NOT NULL ,
  `PES_ID` INT NOT NULL ,
  `USU_LOGIN` VARCHAR(45) NOT NULL ,
  `USU_SENHA` VARCHAR(45) NOT NULL ,
  `USU_STATUS` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`USU_ID`, `CARG_ID`, `PES_ID`) ,
  INDEX `fk_USUARIO_CARGOS1_idx` (`CARG_ID` ASC) ,
  INDEX `fk_USUARIO_PESSOAS1_idx` (`PES_ID` ASC) ,
  CONSTRAINT `fk_USUARIO_CARGOS1`
    FOREIGN KEY (`CARG_ID` )
    REFERENCES `sgc`.`CARGOS` (`CARG_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIO_PESSOAS1`
    FOREIGN KEY (`PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`VENDAS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`VENDAS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`VENDAS` (
  `VEND_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_ID` INT NOT NULL ,
  `LIST_PRO_ID` INT NOT NULL ,
  `USU_ID` INT NOT NULL ,
  `VEND_DATA` DATETIME NOT NULL ,
  `VEND_STATUS` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`VEND_ID`, `PES_ID`, `LIST_PRO_ID`, `USU_ID`) ,
  INDEX `fk_VENDAS_PESSOAS1_idx` (`PES_ID` ASC) ,
  INDEX `fk_VENDAS_LISTA_PROD1_idx` (`LIST_PRO_ID` ASC) ,
  INDEX `fk_VENDAS_USUARIO1_idx` (`USU_ID` ASC) ,
  CONSTRAINT `fk_VENDAS_PESSOAS1`
    FOREIGN KEY (`PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_VENDAS_LISTA_PROD1`
    FOREIGN KEY (`LIST_PRO_ID` )
    REFERENCES `sgc`.`LISTA_PROD` (`LIST_PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_VENDAS_USUARIO1`
    FOREIGN KEY (`USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USU_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ORDEM_SERV`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`ORDEM_SERV` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`ORDEM_SERV` (
  `OS_ID` INT NOT NULL AUTO_INCREMENT ,
  `CLI_PES_ID` INT NOT NULL ,
  `LIST_PRO_ID` INT NULL ,
  `RECEB_USU_ID` INT NOT NULL ,
  `TECN_USU_ID` INT NULL ,
  `OS_PRODUTO` VARCHAR(45) NULL ,
  `OS_DSC_DEFEIT` TEXT NOT NULL ,
  `OS_DSC_SOLUC` TEXT NULL ,
  `OS_DATA_ENT` DATETIME NOT NULL ,
  `OS_DATA_SAI` DATETIME NULL ,
  `OS_STATUS` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`OS_ID`, `CLI_PES_ID`, `LIST_PRO_ID`, `RECEB_USU_ID`, `TECN_USU_ID`) ,
  INDEX `fk_ORDEM_SERV_LISTA_PROD1_idx` (`LIST_PRO_ID` ASC) ,
  INDEX `fk_ORDEM_SERV_PESSOAS1_idx` (`CLI_PES_ID` ASC) ,
  INDEX `fk_ORDEM_SERV_USUARIO1_idx` (`RECEB_USU_ID` ASC) ,
  INDEX `fk_ORDEM_SERV_USUARIO2_idx` (`TECN_USU_ID` ASC) ,
  CONSTRAINT `fk_ORDEM_SERV_LISTA_PROD1`
    FOREIGN KEY (`LIST_PRO_ID` )
    REFERENCES `sgc`.`LISTA_PROD` (`LIST_PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ORDEM_SERV_PESSOAS1`
    FOREIGN KEY (`CLI_PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ORDEM_SERV_USUARIO1`
    FOREIGN KEY (`RECEB_USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USU_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ORDEM_SERV_USUARIO2`
    FOREIGN KEY (`TECN_USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USU_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`SERVICOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`SERVICOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`SERVICOS` (
  `SERV_ID` INT NOT NULL AUTO_INCREMENT ,
  `SERV_DESC` VARCHAR(45) NOT NULL ,
  `SERV_VALOR` DECIMAL(10,2) NOT NULL ,
  PRIMARY KEY (`SERV_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`LISTA_SERVICOS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`LISTA_SERVICOS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`LISTA_SERVICOS` (
  `LIST_SRV_ID` VARCHAR(45) NOT NULL ,
  `SERV_ID` INT NOT NULL ,
  `OS_ID` INT NOT NULL ,
  `LIST_QNT` INT NOT NULL ,
  PRIMARY KEY (`LIST_SRV_ID`, `SERV_ID`, `OS_ID`) ,
  INDEX `fk_LISTA_SERVICOS_SERVICOS1_idx` (`SERV_ID` ASC) ,
  INDEX `fk_LISTA_SERVICOS_ORDEM_SERV1_idx` (`OS_ID` ASC) ,
  CONSTRAINT `fk_LISTA_SERVICOS_SERVICOS1`
    FOREIGN KEY (`SERV_ID` )
    REFERENCES `sgc`.`SERVICOS` (`SERV_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LISTA_SERVICOS_ORDEM_SERV1`
    FOREIGN KEY (`OS_ID` )
    REFERENCES `sgc`.`ORDEM_SERV` (`OS_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`AVARIA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`AVARIA` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`AVARIA` (
  `AVA_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_ID` INT NOT NULL ,
  `USU_ID` INT NOT NULL ,
  `AVA_QNT` INT NOT NULL ,
  `AVA_MOTIVO` TEXT NOT NULL ,
  `AVA_DATA` DATETIME NOT NULL ,
  PRIMARY KEY (`AVA_ID`, `PRO_ID`, `USU_ID`) ,
  INDEX `fk_AVARIA_PRODUTOS1_idx` (`PRO_ID` ASC) ,
  INDEX `fk_AVARIA_USUARIO1_idx` (`USU_ID` ASC) ,
  CONSTRAINT `fk_AVARIA_PRODUTOS1`
    FOREIGN KEY (`PRO_ID` )
    REFERENCES `sgc`.`PRODUTOS` (`PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AVARIA_USUARIO1`
    FOREIGN KEY (`USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USU_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`COMPRAS`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sgc`.`COMPRAS` ;

CREATE  TABLE IF NOT EXISTS `sgc`.`COMPRAS` (
  `COMP_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_ID` INT NOT NULL ,
  `LIST_PRO_ID` INT NOT NULL ,
  `COMP_DT_CMP` DATETIME NOT NULL ,
  `COMP_DT_ENT` DATETIME NULL ,
  `COMP_ESTATUS` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`COMP_ID`, `PES_ID`, `LIST_PRO_ID`) ,
  INDEX `fk_ENTRADA_PESSOAS1_idx` (`PES_ID` ASC) ,
  INDEX `fk_ENTRADA_LISTA_PROD1_idx` (`LIST_PRO_ID` ASC) ,
  CONSTRAINT `fk_ENTRADA_PESSOAS1`
    FOREIGN KEY (`PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ENTRADA_LISTA_PROD1`
    FOREIGN KEY (`LIST_PRO_ID` )
    REFERENCES `sgc`.`LISTA_PROD` (`LIST_PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
