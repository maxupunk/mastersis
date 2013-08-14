SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `sgc` DEFAULT CHARACTER SET utf8 ;
USE `sgc` ;

-- -----------------------------------------------------
-- Table `sgc`.`ESTADOS`
-- -----------------------------------------------------
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
CREATE  TABLE IF NOT EXISTS `sgc`.`CIDADES` (
  `CIDA_ID` INT NOT NULL AUTO_INCREMENT ,
  `CIDA_NOME` VARCHAR(45) NOT NULL ,
  `ESTA_ID` INT NOT NULL ,
  PRIMARY KEY (`CIDA_ID`) ,
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
CREATE  TABLE IF NOT EXISTS `sgc`.`BAIRROS` (
  `BAIRRO_ID` INT NOT NULL AUTO_INCREMENT ,
  `BAIRRO_NOME` VARCHAR(45) NULL ,
  `CIDA_ID` INT NOT NULL ,
  PRIMARY KEY (`BAIRRO_ID`) ,
  INDEX `fk_BAIRROS_CIDADES1_idx` (`CIDA_ID` ASC) ,
  CONSTRAINT `fk_BAIRROS_CIDADES1`
    FOREIGN KEY (`CIDA_ID` )
    REFERENCES `sgc`.`CIDADES` (`CIDA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`RUA`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`RUA` (
  `RUA_ID` INT NOT NULL AUTO_INCREMENT ,
  `RUA_NOME` VARCHAR(45) NULL ,
  `RUA_CEP` VARCHAR(45) NULL ,
  `BAIRRO_ID` INT NOT NULL ,
  PRIMARY KEY (`RUA_ID`) ,
  INDEX `fk_RUA_BAIRROS1_idx` (`BAIRRO_ID` ASC) ,
  CONSTRAINT `fk_RUA_BAIRROS1`
    FOREIGN KEY (`BAIRRO_ID` )
    REFERENCES `sgc`.`BAIRROS` (`BAIRRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ENDERECOS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`ENDERECOS` (
  `END_ID` INT NOT NULL AUTO_INCREMENT ,
  `END_NUMERO` INT NULL ,
  `END_REFERENCIA` VARCHAR(45) NULL ,
  `RUA_ID` INT NOT NULL ,
  PRIMARY KEY (`END_ID`) ,
  INDEX `fk_ENDERECOS_RUA1_idx` (`RUA_ID` ASC) ,
  CONSTRAINT `fk_ENDERECOS_RUA1`
    FOREIGN KEY (`RUA_ID` )
    REFERENCES `sgc`.`RUA` (`RUA_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`PESSOAS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`PESSOAS` (
  `PES_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_NOME` TEXT NOT NULL ,
  `PES_CPF_CNPJ` VARCHAR(18) NOT NULL ,
  `PES_NOME_PAI` TEXT NULL ,
  `PES_NOME_MAE` TEXT NULL ,
  `PES_NASC_DATA` DATE NULL ,
  `PES_FONE` VARCHAR(13) NULL ,
  `PES_CEL1` VARCHAR(13) NOT NULL ,
  `PES_CEL2` VARCHAR(13) NULL ,
  `END_ID` INT NOT NULL ,
  `PES_TIPO` ENUM('f','j') NOT NULL COMMENT 'f = fisica\\nj = juridica' ,
  `PES_ESTATUS` ENUM('a','d') NULL ,
  `PES_DATA` DATETIME NOT NULL ,
  `PES_EMAIL` VARCHAR(120) NULL ,
  PRIMARY KEY (`PES_ID`) ,
  INDEX `fk_PESSOAS_ENDERECOS1_idx` (`END_ID` ASC) ,
  UNIQUE INDEX `PES_CPF_CNPJ_UNIQUE` (`PES_CPF_CNPJ` ASC) ,
  CONSTRAINT `fk_PESSOAS_ENDERECOS1`
    FOREIGN KEY (`END_ID` )
    REFERENCES `sgc`.`ENDERECOS` (`END_ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
ROW_FORMAT = Default;


-- -----------------------------------------------------
-- Table `sgc`.`CATEGORIA`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`CATEGORIA` (
  `CATE_ID` INT NOT NULL AUTO_INCREMENT ,
  `CATE_NOME` VARCHAR(20) NOT NULL ,
  `CATE_DESCRIC` TEXT NULL ,
  `CATE_IMG` VARCHAR(20) NULL ,
  `CATE_ESTATUS` ENUM('a','d') NULL ,
  PRIMARY KEY (`CATE_ID`) ,
  UNIQUE INDEX `CATE_NOME_UNIQUE` (`CATE_NOME` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`MEDIDAS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`MEDIDAS` (
  `MEDI_ID` INT NOT NULL AUTO_INCREMENT ,
  `MEDI_NOME` VARCHAR(45) NOT NULL ,
  `MEDI_SIGLA` VARCHAR(4) NOT NULL ,
  PRIMARY KEY (`MEDI_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`PRODUTOS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`PRODUTOS` (
  `PRO_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_DESCRICAO` VARCHAR(100) NOT NULL ,
  `PRO_CARAC_TEC` TEXT NULL ,
  `PRO_ESTATUS` ENUM('d','a') NOT NULL ,
  `CATE_ID` INT NULL ,
  `MEDI_ID` INT NOT NULL ,
  `PRO_IMG` VARCHAR(10) NULL ,
  `PRO_PESO` DECIMAL(10,2) NULL ,
  PRIMARY KEY (`PRO_ID`) ,
  INDEX `fk_PRODUTOS_CATEGORIA1_idx` (`CATE_ID` ASC) ,
  UNIQUE INDEX `PRO_DESCRICAO_UNIQUE` (`PRO_DESCRICAO` ASC) ,
  INDEX `fk_PRODUTOS_UNIDADE1_idx` (`MEDI_ID` ASC) ,
  CONSTRAINT `fk_PRODUTOS_CATEGORIA1`
    FOREIGN KEY (`CATE_ID` )
    REFERENCES `sgc`.`CATEGORIA` (`CATE_ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_PRODUTOS_UNIDADE1`
    FOREIGN KEY (`MEDI_ID` )
    REFERENCES `sgc`.`MEDIDAS` (`MEDI_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ESTOQUE`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`ESTOQUE` (
  `ESTOQ_ID` INT NOT NULL AUTO_INCREMENT ,
  `PRO_ID` INT NOT NULL ,
  `ESTOQ_ATUAL` DECIMAL(10,2) NOT NULL ,
  `ESTOQ_MIN` DECIMAL(10,2) NULL ,
  `ESTOQ_CUSTO` DECIMAL(10,2) NULL ,
  `ESTOQ_PRECO` DECIMAL(10,2) NOT NULL ,
  PRIMARY KEY (`ESTOQ_ID`) ,
  INDEX `fk_ESTOQUES_PRODUTOS1_idx` (`PRO_ID` ASC) ,
  CONSTRAINT `fk_ESTOQUES_PRODUTOS1`
    FOREIGN KEY (`PRO_ID` )
    REFERENCES `sgc`.`PRODUTOS` (`PRO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`CARGOS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`CARGOS` (
  `CARG_ID` INT NOT NULL AUTO_INCREMENT ,
  `CARG_NOME` VARCHAR(45) NOT NULL ,
  `CARG_NIVEL` VARCHAR(1) NULL ,
  PRIMARY KEY (`CARG_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`USUARIO`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`USUARIO` (
  `USUARIO_ID` INT NOT NULL AUTO_INCREMENT ,
  `CARG_ID` INT NOT NULL ,
  `PES_ID` INT NOT NULL ,
  `USUARIO_LOGIN` VARCHAR(45) NOT NULL ,
  `USUARIO_SENHA` VARCHAR(45) NOT NULL ,
  `USUARIO_ESTATUS` ENUM('a','d') NOT NULL ,
  PRIMARY KEY (`USUARIO_ID`) ,
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
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`PEDIDO`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`PEDIDO` (
  `PEDIDO_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_ID` INT NOT NULL ,
  `USU_ID` INT NULL ,
  `PEDIDO_DATA` DATETIME NOT NULL ,
  `PEDIDO_ESTATUS` ENUM('1','2','3','4','5') NOT NULL COMMENT 'PEDIDO_ESTATUS PODE SER\\n1 = EM ABERTA\\n2 = AGUARDANDO PAGAMENTO\\n3 = ENVIADO\\n4 = CONCLUIDO\\n5 = CANCELADA' ,
  `PEDIDO_TIPO` ENUM('v','c') NOT NULL ,
  `PEDIDO_OBS` TEXT NULL ,
  PRIMARY KEY (`PEDIDO_ID`) ,
  INDEX `fk_VENDAS_PESSOAS1_idx` (`PES_ID` ASC) ,
  INDEX `fk_VENDAS_USUARIO1_idx` (`USU_ID` ASC) ,
  CONSTRAINT `fk_VENDAS_PESSOAS1`
    FOREIGN KEY (`PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_VENDAS_USUARIO1`
    FOREIGN KEY (`USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USUARIO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`LISTA_PEDIDO`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`LISTA_PEDIDO` (
  `LiST_PED_ID` INT NOT NULL AUTO_INCREMENT ,
  `PEDIDO_ID` INT NULL ,
  `ESTOQ_ID` INT NOT NULL ,
  `LIST_PED_QNT` DECIMAL(10,2) NOT NULL ,
  `LIST_PED_PRECO` DECIMAL(10,2) NOT NULL ,
  PRIMARY KEY (`LiST_PED_ID`) ,
  INDEX `fk_LISTA_PRODUTO_ESTOQUE1_idx` (`ESTOQ_ID` ASC) ,
  INDEX `fk_LISTA_PEDIDO_PEDIDO1_idx` (`PEDIDO_ID` ASC) ,
  CONSTRAINT `fk_LISTA_PRODUTO_ESTOQUE1`
    FOREIGN KEY (`ESTOQ_ID` )
    REFERENCES `sgc`.`ESTOQUE` (`ESTOQ_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LISTA_PEDIDO_PEDIDO1`
    FOREIGN KEY (`PEDIDO_ID` )
    REFERENCES `sgc`.`PEDIDO` (`PEDIDO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`ORDEM_SERV`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`ORDEM_SERV` (
  `OS_ID` INT NOT NULL AUTO_INCREMENT ,
  `PES_ID` INT NOT NULL ,
  `USUARIO_ID` INT NOT NULL ,
  `OS_EQUIPAMENT` VARCHAR(45) NOT NULL COMMENT 'DADOS DO EQUIPAMENTO DO CLIENTE' ,
  `OS_DSC_DEFEIT` TEXT NOT NULL ,
  `OS_DSC_SOLUC` TEXT NULL ,
  `OS_DATA_ENT` DATETIME NOT NULL ,
  `OS_DATA_SAI` DATETIME NULL ,
  `OS_OBSERVACAO` TEXT NULL ,
  `OS_ESTATUS` ENUM('1','2','3','4') NOT NULL COMMENT 'OS_ESTATUS PODE SER\\n1=EM ABERTO\\n2=EM ANALISE\\n3=EM ANDAMENTO\\n4=CONCLUIDO' ,
  PRIMARY KEY (`OS_ID`) ,
  INDEX `fk_ORDEM_SERV_PESSOAS1_idx` (`PES_ID` ASC) ,
  INDEX `fk_ORDEM_SERV_USUARIO1_idx` (`USUARIO_ID` ASC) ,
  CONSTRAINT `fk_ORDEM_SERV_PESSOAS1`
    FOREIGN KEY (`PES_ID` )
    REFERENCES `sgc`.`PESSOAS` (`PES_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ORDEM_SERV_USUARIO1`
    FOREIGN KEY (`USUARIO_ID` )
    REFERENCES `sgc`.`USUARIO` (`USUARIO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`SERVICOS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`SERVICOS` (
  `SERV_ID` INT NOT NULL AUTO_INCREMENT ,
  `SERV_NOME` VARCHAR(45) NOT NULL ,
  `SERV_DESC` TEXT NOT NULL ,
  `SERV_VALOR` DECIMAL(10,2) NOT NULL ,
  `SERV_ESTATUS` ENUM('a','d') NOT NULL ,
  PRIMARY KEY (`SERV_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`LISTA_SERVICO_OS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`LISTA_SERVICO_OS` (
  `LIST_SRV_ID` VARCHAR(45) NOT NULL ,
  `SERV_ID` INT NOT NULL ,
  `OS_ID` INT NOT NULL ,
  `LIST_QNT` INT NOT NULL ,
  PRIMARY KEY (`LIST_SRV_ID`) ,
  INDEX `fk_LISTA_SERVICOS_SERVICOS1_idx` (`SERV_ID` ASC) ,
  INDEX `fk_LISTA_SERVICOS_ORDEM_SERV1_idx` (`OS_ID` ASC) ,
  CONSTRAINT `fk_LISTA_SERVICOS_SERVICOS1`
    FOREIGN KEY (`SERV_ID` )
    REFERENCES `sgc`.`SERVICOS` (`SERV_ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_LISTA_SERVICOS_ORDEM_SERV1`
    FOREIGN KEY (`OS_ID` )
    REFERENCES `sgc`.`ORDEM_SERV` (`OS_ID` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`AVARIA`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`AVARIA` (
  `AVA_ID` INT NOT NULL AUTO_INCREMENT ,
  `USU_ID` INT NOT NULL ,
  `ESTOQ_ID` INT NOT NULL ,
  `AVA_QNT` INT NOT NULL ,
  `AVA_MOTIVO` TEXT NOT NULL ,
  `AVA_DATA` DATETIME NOT NULL ,
  PRIMARY KEY (`AVA_ID`) ,
  INDEX `fk_AVARIA_USUARIO1_idx` (`USU_ID` ASC) ,
  INDEX `fk_AVARIA_ESTOQUE1_idx` (`ESTOQ_ID` ASC) ,
  CONSTRAINT `fk_AVARIA_USUARIO1`
    FOREIGN KEY (`USU_ID` )
    REFERENCES `sgc`.`USUARIO` (`USUARIO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AVARIA_ESTOQUE1`
    FOREIGN KEY (`ESTOQ_ID` )
    REFERENCES `sgc`.`ESTOQUE` (`ESTOQ_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`METODOS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`METODOS` (
  `METOD_ID` INT NOT NULL AUTO_INCREMENT ,
  `METOD_CLASSE` VARCHAR(45) NULL ,
  `METOD_METODO` VARCHAR(45) NULL ,
  `METOD_APELIDO` VARCHAR(45) NULL ,
  `METOD_PRIVADO` TINYINT NULL ,
  PRIMARY KEY (`METOD_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`PERMICOES`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`PERMICOES` (
  `PERM_P` INT NOT NULL AUTO_INCREMENT ,
  `USUARIO_ID` INT NOT NULL ,
  `METOD_ID` INT NOT NULL ,
  PRIMARY KEY (`PERM_P`) ,
  INDEX `fk_USUARIO_has_PERMICOES_PERMICOES1_idx` (`METOD_ID` ASC) ,
  INDEX `fk_USUARIO_has_PERMICOES_USUARIO1_idx` (`USUARIO_ID` ASC) ,
  CONSTRAINT `fk_USUARIO_has_PERMICOES_USUARIO1`
    FOREIGN KEY (`USUARIO_ID` )
    REFERENCES `sgc`.`USUARIO` (`USUARIO_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_USUARIO_has_PERMICOES_PERMICOES1`
    FOREIGN KEY (`METOD_ID` )
    REFERENCES `sgc`.`METODOS` (`METOD_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sgc`.`LISTA_PRODUTO_OS`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `sgc`.`LISTA_PRODUTO_OS` (
  `LIST_PDT_ID` INT NOT NULL AUTO_INCREMENT ,
  `ESTOQ_ID` INT NOT NULL ,
  `OS_ID` INT NOT NULL ,
  `LIST_CNT` INT NOT NULL ,
  `LIST_PDT_PRECO` DECIMAL(10,2) NOT NULL ,
  PRIMARY KEY (`LIST_PDT_ID`) ,
  INDEX `fk_LISTA_PRODUTO_OS_ESTOQUE1_idx` (`ESTOQ_ID` ASC) ,
  INDEX `fk_LISTA_PRODUTO_OS_ORDEM_SERV1_idx` (`OS_ID` ASC) ,
  CONSTRAINT `fk_LISTA_PRODUTO_OS_ESTOQUE1`
    FOREIGN KEY (`ESTOQ_ID` )
    REFERENCES `sgc`.`ESTOQUE` (`ESTOQ_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_LISTA_PRODUTO_OS_ORDEM_SERV1`
    FOREIGN KEY (`OS_ID` )
    REFERENCES `sgc`.`ORDEM_SERV` (`OS_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
