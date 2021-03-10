/*
SQLyog Ultimate v12.14 (64 bit)
MySQL - 10.4.17-MariaDB : Database - teste_care
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`teste_care` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `teste_care`;

/*Table structure for table `aux_tipo_usuario` */

DROP TABLE IF EXISTS `aux_tipo_usuario`;

CREATE TABLE `aux_tipo_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `super_admin` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `aux_tipo_usuario` */

insert  into `aux_tipo_usuario`(`id`,`descricao`,`deleted_at`,`created_at`,`updated_at`,`super_admin`) values 
(1,'Desenvolvedor',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S'),
(2,'Suporte',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2018_01_31_130214_cria_tabela_tipo_rota',1),
(2,'2018_01_31_130215_cria_tabela_rota',1),
(3,'2018_01_31_130216_create_aux_tipo_usuario_table',1),
(4,'2018_01_31_130217_create_sis_usuario_table',1),
(5,'2018_01_31_130218_create_rl_rota_tipo_usuario_table',1),
(6,'2021_03_09_190203_create_table_xml_upload',1),
(7,'2021_03_09_190355_create_table_xml',2),
(8,'2021_03_09_192858_create_table_pessoas',2),
(9,'2021_03_09_193905_create_table_nota_pessoas',2),
(10,'2021_03_09_194308_create_table_produtos',2),
(11,'2021_03_09_194818_create_table_nota_produtos',2),
(12,'2021_03_09_225442_remove_column_xml_uplod',2),
(13,'2021_03_09_232243_add_column_complemento_pessoas',2),
(14,'2021_03_09_234607_add_column_deleted_at_produtos',2),
(15,'2021_03_10_013900_remove-coluns-nota-produtos',2);

/*Table structure for table `nota_pessoas` */

DROP TABLE IF EXISTS `nota_pessoas`;

CREATE TABLE `nota_pessoas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_nota` int(10) unsigned NOT NULL,
  `id_pessoa` int(10) unsigned NOT NULL,
  `tipo` enum('E','C') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'E',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nota_pessoas_id_nota_foreign` (`id_nota`),
  KEY `nota_pessoas_id_pessoa_foreign` (`id_pessoa`),
  CONSTRAINT `nota_pessoas_id_nota_foreign` FOREIGN KEY (`id_nota`) REFERENCES `xml_upload` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_pessoas_id_pessoa_foreign` FOREIGN KEY (`id_pessoa`) REFERENCES `pessoas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `nota_pessoas` */

insert  into `nota_pessoas`(`id`,`id_nota`,`id_pessoa`,`tipo`,`created_at`,`updated_at`) values 
(1,1,1,'E','2021-03-10 14:20:22','2021-03-10 14:20:22'),
(2,1,2,'C','2021-03-10 14:20:22','2021-03-10 14:20:22'),
(3,2,1,'E','2021-03-10 14:36:17','2021-03-10 14:36:17'),
(4,2,2,'C','2021-03-10 14:36:17','2021-03-10 14:36:17');

/*Table structure for table `nota_produtos` */

DROP TABLE IF EXISTS `nota_produtos`;

CREATE TABLE `nota_produtos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_nota` int(10) unsigned NOT NULL,
  `id_produto` int(10) unsigned NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nota_produtos_id_nota_foreign` (`id_nota`),
  KEY `nota_produtos_id_produto_foreign` (`id_produto`),
  CONSTRAINT `nota_produtos_id_nota_foreign` FOREIGN KEY (`id_nota`) REFERENCES `xml_upload` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nota_produtos_id_produto_foreign` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `nota_produtos` */

insert  into `nota_produtos`(`id`,`id_nota`,`id_produto`,`valor`,`quantidade`,`created_at`,`updated_at`) values 
(1,1,1,'840.00',1,'2021-03-10 14:20:22','2021-03-10 14:20:22'),
(2,2,1,'840.00',1,'2021-03-10 14:36:17','2021-03-10 14:36:17');

/*Table structure for table `pessoas` */

DROP TABLE IF EXISTS `pessoas`;

CREATE TABLE `pessoas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome_fantasia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cpf_cnpj` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `logradouro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cod_municipio` int(11) NOT NULL,
  `municipio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `codigo_pais` int(11) NOT NULL,
  `inscricao_estadual` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inscricao_municipal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `crt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `complemento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pessoas_cpf_cnpj_unique` (`cpf_cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pessoas` */

insert  into `pessoas`(`id`,`nome`,`nome_fantasia`,`cpf_cnpj`,`logradouro`,`numero`,`bairro`,`cod_municipio`,`municipio`,`uf`,`cep`,`codigo_pais`,`inscricao_estadual`,`inscricao_municipal`,`crt`,`email`,`created_at`,`updated_at`,`deleted_at`,`complemento`) values 
(1,'B2X CARE SERVICOS TECNOLOGICOS LTDA.','B2X - Filial Moema','09066241000884','ALAMEDA DOS MARACATINS','398','INDIANOPOLIS',3550308,'SAO PAULO','SP','04089000',1058,'128904030117','65964870','3',NULL,'2021-03-10 14:20:22','2021-03-10 14:20:22',NULL,NULL),
(2,'Leonardo da Silva Diuncanse',NULL,'44269295805','Rua Geraldo Vieira','068','Jardim Aquarius',3549904,'Sao Jose dos Campos','SP','12246024',1058,NULL,NULL,NULL,'leonardo.diuncanse@care-br.com','2021-03-10 14:20:22','2021-03-10 14:20:22',NULL,'Apto 96');

/*Table structure for table `produtos` */

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE `produtos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_produto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `produtos` */

insert  into `produtos`(`id`,`codigo_produto`,`descricao`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'SM-G935FZBLZTO','APARELHO SAMSUNG SM-G935FZBLZTO','2021-03-10 14:20:22','2021-03-10 14:20:22',NULL);

/*Table structure for table `rl_rota_tipo_usuario` */

DROP TABLE IF EXISTS `rl_rota_tipo_usuario`;

CREATE TABLE `rl_rota_tipo_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_usuario` int(10) unsigned NOT NULL,
  `id_rota` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rl_rota_tipo_usuario_id_tipo_usuario_foreign` (`id_tipo_usuario`),
  KEY `rl_rota_tipo_usuario_id_rota_foreign` (`id_rota`),
  CONSTRAINT `rl_rota_tipo_usuario_id_rota_foreign` FOREIGN KEY (`id_rota`) REFERENCES `rota` (`id`),
  CONSTRAINT `rl_rota_tipo_usuario_id_tipo_usuario_foreign` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `aux_tipo_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rl_rota_tipo_usuario` */

/*Table structure for table `rota` */

DROP TABLE IF EXISTS `rota`;

CREATE TABLE `rota` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_rota` int(10) unsigned NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acesso_liberado` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desenv` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rota_id_tipo_rota_foreign` (`id_tipo_rota`),
  CONSTRAINT `rota_id_tipo_rota_foreign` FOREIGN KEY (`id_tipo_rota`) REFERENCES `tipo_rota` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `rota` */

insert  into `rota`(`id`,`id_tipo_rota`,`descricao`,`slug`,`deleted_at`,`created_at`,`updated_at`,`acesso_liberado`,`desenv`) values 
(1,1,'Visualizar dashboard','home',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(2,7,'Usuarios - Visualizar os registros','sis_usuario.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(3,7,'Usuarios - Adicionar um registro','sis_usuario.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(4,7,'Usuarios - Alterar um registro','sis_usuario.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(5,7,'Usuarios - Excluir um registro','sis_usuario.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(6,7,'Usuarios - Filtrar um registro','sis_usuario.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(7,7,'Usuarios - Filtrar um registro pelo id','sis_usuario.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(8,2,'Tipo de Usuarios - Visualizar os registros','aux_tipo_usuario.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(9,2,'Tipo de Usuarios - Adicionar um registro','aux_tipo_usuario.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(10,2,'Tipo de Usuarios - Alterar um registro','aux_tipo_usuario.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(11,2,'Tipo de Usuarios - Excluir um registro','aux_tipo_usuario.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(12,2,'Tipo de Usuarios - Filtrar um registro','aux_tipo_usuario.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(13,2,'Tipo de Usuarios - Filtrar um registro pelo id','aux_tipo_usuario.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(14,4,'Rotas - Visualizar os registros','rota.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(15,4,'Rotas - Adicionar um registro','rota.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(16,4,'Rotas - Alterar um registro','rota.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(17,4,'Rotas - Excluir um registro','rota.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(18,4,'Rotas - Filtrar um registro','rota.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(19,4,'Rotas - Filtrar um registro pelo id','rota.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(20,2,'Tipo de Rota - Visualizar os registros','tipo_rota.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(21,2,'Tipo de Rota - Adicionar um registro','tipo_rota.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(22,2,'Tipo de Rota - Alterar um registro','tipo_rota.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(23,2,'Tipo de Rota - Excluir um registro','tipo_rota.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(24,2,'Tipo de Rota - Filtrar um registro','tipo_rota.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(25,2,'Tipo de Rota - Filtrar um registro pelo id','tipo_rota.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(26,5,'Alterar imagem pelo usuario','usuario.alterar_imagem',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(27,5,'Deletar imagem pelo usuario','usuario.delete_img',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(28,5,'Alterar senha pelo usuario','usuario.alterar_senha',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(29,5,'Alterar cadastro pelo usuario','usuario.alterar_cadastro',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(30,5,'Cadastro do usuario','usuario.cadastro',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(31,6,'Visualizar os registros','tipo_usuario.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','S'),
(32,6,'Adicionar um registro','tipo_usuario.adicionar',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','S'),
(33,6,'Alterar um registro','tipo_usuario.alterar',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','S'),
(34,6,'Excluir um registro','tipo_usuario.excluir',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','S'),
(35,4,'Gerenciar','tipo_usuario.gerenciar_permissoes',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(36,4,'Carregar permissões de um tipo de usuário','tipo_usuario.carregar_permissoes',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','S','N'),
(37,3,'Upload XML - Visualizar os registros','xml_upload.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(38,3,'Upload XML - Detalhes do XML','xml_upload.detalhes',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(39,3,'Upload XML - Adicionar um registro','xml_upload.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(40,3,'Upload XML - Gerar PDF Nota','xml_upload.print_nota',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(41,3,'Upload XML - Alterar um registro','xml_upload.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(42,3,'Upload XML - Excluir um registro','xml_upload.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(43,3,'Upload XML - Filtrar um registro','xml_upload.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(44,3,'Upload XML - Filtrar um registro pelo id','xml_upload.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(45,3,'Pessoas - Visualizar os registros','pessoas.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(46,3,'Pessoas - Adicionar um registro','pessoas.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(47,3,'Pessoas - Alterar um registro','pessoas.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(48,3,'Pessoas - Excluir um registro','pessoas.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(49,3,'Pessoas - Filtrar um registro','pessoas.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(50,3,'Pessoas - Filtrar um registro pelo id','pessoas.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(51,3,'Nota Pessoas - Visualizar os registros','nota_pessoas.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(52,3,'Nota Pessoas - Adicionar um registro','nota_pessoas.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(53,3,'Nota Pessoas - Alterar um registro','nota_pessoas.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(54,3,'Nota Pessoas - Excluir um registro','nota_pessoas.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(55,3,'Nota Pessoas - Filtrar um registro','nota_pessoas.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(56,3,'Nota Pessoas - Filtrar um registro pelo id','nota_pessoas.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(57,3,'Produtos - Visualizar os registros','produtos.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(58,3,'Produtos - Adicionar um registro','produtos.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(59,3,'Produtos - Alterar um registro','produtos.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(60,3,'Produtos - Excluir um registro','produtos.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(61,3,'Produtos - Filtrar um registro','produtos.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(62,3,'Produtos - Filtrar um registro pelo id','produtos.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(63,3,'Nota Produtos - Visualizar os registros','nota_produtos.index',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(64,3,'Nota Produtos - Adicionar um registro','nota_produtos.create',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(65,3,'Nota Produtos - Alterar um registro','nota_produtos.edit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(66,3,'Nota Produtos - Excluir um registro','nota_produtos.destroy',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(67,3,'Nota Produtos - Filtrar um registro','nota_produtos.fill',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N'),
(68,3,'Nota Produtos - Filtrar um registro pelo id','nota_produtos.getedit',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40','N','N');

/*Table structure for table `sis_usuario` */

DROP TABLE IF EXISTS `sis_usuario`;

CREATE TABLE `sis_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `telefone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_tipo_usuario` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sis_usuario_email_unique` (`email`),
  KEY `sis_usuario_id_tipo_usuario_foreign` (`id_tipo_usuario`),
  CONSTRAINT `sis_usuario_id_tipo_usuario_foreign` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `aux_tipo_usuario` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sis_usuario` */

insert  into `sis_usuario`(`id`,`nome`,`senha`,`remember_token`,`email`,`email_verified_at`,`telefone`,`photo`,`id_tipo_usuario`,`deleted_at`,`created_at`,`updated_at`) values 
(1,'Administrador','$2y$10$PITgNFbS0s6fMozNZ47Rv.YJyWYrWBaj4JBRiSFFnaoipwWN4Qb22',NULL,'adm@gmail.com',NULL,'67999999999',NULL,1,NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40');

/*Table structure for table `tipo_rota` */

DROP TABLE IF EXISTS `tipo_rota`;

CREATE TABLE `tipo_rota` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `icone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tipo_rota` */

insert  into `tipo_rota`(`id`,`descricao`,`icone`,`deleted_at`,`created_at`,`updated_at`) values 
(1,'Dashboard','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(2,'Auxiliares','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(3,'Cadastros','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(4,'Permissoes','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(5,'Usuário','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(6,'Tipo de usuário','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40'),
(7,'Sistema','icone',NULL,'2021-03-10 16:47:40','2021-03-10 16:47:40');

/*Table structure for table `xml` */

DROP TABLE IF EXISTS `xml`;

CREATE TABLE `xml` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cuf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `xml` */

/*Table structure for table `xml_upload` */

DROP TABLE IF EXISTS `xml_upload`;

CREATE TABLE `xml_upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cnf` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `natop` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mod` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `numero_nota` int(11) NOT NULL,
  `data_nota` datetime NOT NULL,
  `valor_total` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `xml_upload` */

insert  into `xml_upload`(`id`,`path`,`cuf`,`cnf`,`natop`,`mod`,`serie`,`numero_nota`,`data_nota`,`valor_total`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'notas/75Tm6M1mWiWFvVoFAcmPjfLnfrVkEkx8mHukCse5.xml','35','44261153','RETORNO DE MERCADORIA RECEBIDA PARA CONSERTO',55,1,24755,'2021-01-22 18:25:52','840.00','2021-03-10 14:20:22','2021-03-10 14:20:22',NULL),
(2,'notas/iei5I8pEmvSD01lswq63VMbXF7HtITaT9z4YaUO3.xml','35','44261153','RETORNO DE MERCADORIA RECEBIDA PARA CONSERTO',55,1,24755,'2021-01-22 18:25:52','840.00','2021-03-10 14:36:17','2021-03-10 14:36:17',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
