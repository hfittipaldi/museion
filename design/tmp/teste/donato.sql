# MySQL-Front 3.1  (Build 14.3)


# Host: 192.168.0.135    Database: donato
# ------------------------------------------------------
# Server version 4.1.14-nt

#
# Table structure for table colecao
#

CREATE TABLE `colecao` (
  `colecao` int(6) NOT NULL default '0',
  `nome` varchar(50) NOT NULL default '',
  `responsavel` tinyint(4) NOT NULL default '0',
  `tecnico` tinyint(4) NOT NULL default '0',
  `thesaurus` varchar(18) NOT NULL default '',
  PRIMARY KEY  (`colecao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table colecao
#


#
# Table structure for table menu_item
#

CREATE TABLE `menu_item` (
  `menu_item` int(6) NOT NULL auto_increment,
  `menu_nome` varchar(25) default NULL,
  `chamada` varchar(25) default NULL,
  `posicao` int(2) default NULL,
  `ordenacao` int(6) default NULL,
  PRIMARY KEY  (`menu_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table menu_item
#

INSERT INTO `menu_item` VALUES (1,'Biblioteca',NULL,0,1);
INSERT INTO `menu_item` VALUES (2,'Livros',NULL,1,2);
INSERT INTO `menu_item` VALUES (3,'Emprestimos',NULL,2,3);
INSERT INTO `menu_item` VALUES (4,'Doacoes',NULL,2,2);
INSERT INTO `menu_item` VALUES (5,'Compra',NULL,2,6);
INSERT INTO `menu_item` VALUES (6,'Ongs',NULL,4,6);
INSERT INTO `menu_item` VALUES (7,'Entidades',NULL,4,7);
INSERT INTO `menu_item` VALUES (8,'Acervos',NULL,0,2);
INSERT INTO `menu_item` VALUES (9,'Institutos',NULL,0,3);
INSERT INTO `menu_item` VALUES (10,'Ong1',NULL,6,1);
INSERT INTO `menu_item` VALUES (11,'Ong2',NULL,6,2);
INSERT INTO `menu_item` VALUES (12,'Entidade1',NULL,7,1);
INSERT INTO `menu_item` VALUES (13,'Entidade2',NULL,7,2);

#
# Table structure for table usuario
#

CREATE TABLE `usuario` (
  `usuario` int(6) NOT NULL default '0',
  `nome` varchar(40) default NULL,
  `login` varchar(20) default NULL,
  `senha` varchar(15) default NULL,
  `dianiver` int(2) default NULL,
  `mesniver` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table usuario
#

INSERT INTO `usuario` VALUES (1,'guilherme',NULL,NULL,NULL,0);
INSERT INTO `usuario` VALUES (2,'Itamar',NULL,NULL,NULL,0);

#
# Table structure for table usuario_colecao
#

CREATE TABLE `usuario_colecao` (
  `usuario` int(6) NOT NULL default '0',
  `colecao` int(6) NOT NULL default '0',
  PRIMARY KEY  (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table usuario_colecao
#


#
# Table structure for table usuario_menu_item
#

CREATE TABLE `usuario_menu_item` (
  `usuario_menu_item` int(2) NOT NULL auto_increment,
  `usuario` int(6) default '0',
  `item` int(6) default '0',
  PRIMARY KEY  (`usuario_menu_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Dumping data for table usuario_menu_item
#

INSERT INTO `usuario_menu_item` VALUES (20,1,2);
INSERT INTO `usuario_menu_item` VALUES (21,2,1);
INSERT INTO `usuario_menu_item` VALUES (22,2,2);
INSERT INTO `usuario_menu_item` VALUES (23,2,3);
INSERT INTO `usuario_menu_item` VALUES (24,2,4);
INSERT INTO `usuario_menu_item` VALUES (25,2,5);
INSERT INTO `usuario_menu_item` VALUES (26,2,6);
INSERT INTO `usuario_menu_item` VALUES (27,2,7);
INSERT INTO `usuario_menu_item` VALUES (28,2,10);
INSERT INTO `usuario_menu_item` VALUES (29,2,11);
INSERT INTO `usuario_menu_item` VALUES (30,2,12);
INSERT INTO `usuario_menu_item` VALUES (31,2,13);

