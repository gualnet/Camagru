<?php

require_once "database.php";

try
{
	echo "test connexion bdd : ";
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
	echo "ERROOR -> ";
	die($e->getMessage());
}
echo "OK</br>";

$sql = "CREATE SCHEMA IF NOT EXISTS `db_camagru` DEFAULT CHARACTER SET utf8 ;
USE `db_camagru` ;";
$pdo->exec($sql);

echo "<br>create db : ok\n</br>";


$sql = "CREATE TABLE IF NOT EXISTS `db_camagru`.`users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(20) NULL DEFAULT NULL,
	`nom` VARCHAR(20) NULL DEFAULT NULL,
	`prenom` VARCHAR(20) NULL DEFAULT NULL,
	`mail` VARCHAR(100) NULL DEFAULT NULL,
	`password` VARCHAR(255) NULL DEFAULT NULL,
	`activated` INT(11) NOT NULL DEFAULT '0',
	`activation_hash` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC))
	ENGINE = InnoDB
	AUTO_INCREMENT = 2
	DEFAULT CHARACTER SET = utf8;";
$pdo->exec($sql);

echo "<br>create USERS table : ok</br>";


$sql = "CREATE TABLE IF NOT EXISTS `db_camagru`.`pictures` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`file_url` VARCHAR(255) NULL DEFAULT NULL,
	`user_id` INT(11) NULL DEFAULT NULL,
	`crea_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
	`nbr_post` INT(11) NULL DEFAULT '0',
	`nbr_like` INT(11) NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC),
	INDEX `fk_pictures_users1_idx` (`user_id` ASC),
	CONSTRAINT `fk_pictures_users1`
		FOREIGN KEY (`user_id`)
		REFERENCES `db_camagru`.`users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
	ENGINE = InnoDB
	AUTO_INCREMENT = 7
	DEFAULT CHARACTER SET = utf8;";
$pdo->exec($sql);

echo "<br>create PICTURES table : ok</br>";


$sql = "CREATE TABLE IF NOT EXISTS `db_camagru`.`comments` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NULL DEFAULT NULL,
	`content` TEXT NULL DEFAULT NULL,
	`date` DATETIME NULL DEFAULT NULL,
	`type` VARCHAR(100) NULL DEFAULT NULL,
	`com_owner_id` INT(11) NULL DEFAULT NULL COMMENT 'Détermine le user qui a ecrit le commentaire',
	`picture_id` INT(11) NULL DEFAULT NULL COMMENT 'determine la liaison a une photo',
	`pic_owner_id` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC),
	INDEX `fk_comments_users_idx` (`com_owner_id` ASC),
	INDEX `fk_comments_users1_idx` (`pic_owner_id` ASC),
	INDEX `fk_comments_pictures1_idx` (`picture_id` ASC),
	CONSTRAINT `fk_comments_pictures1`
		FOREIGN KEY (`picture_id`)
		REFERENCES `db_camagru`.`pictures` (`id`)
		ON DELETE CASCADE
		ON UPDATE NO ACTION,
	CONSTRAINT `fk_comments_users`
		FOREIGN KEY (`com_owner_id`)
		REFERENCES `db_camagru`.`users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT `fk_comments_users1`
		FOREIGN KEY (`pic_owner_id`)
		REFERENCES `db_camagru`.`users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
	ENGINE = InnoDB
	AUTO_INCREMENT = 3
	DEFAULT CHARACTER SET = utf8;";
$pdo->exec($sql);

echo "<br>create COMMENTS table : ok</br>";


$sql = "CREATE TABLE IF NOT EXISTS `db_camagru`.`likes` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`pic_id` INT(11) NOT NULL,
	UNIQUE INDEX `id_UNIQUE` (`id` ASC),
	INDEX `fk_likes_pictures1_idx` (`pic_id` ASC),
	INDEX `fk_likes_users1_idx` (`user_id` ASC),
	CONSTRAINT `fk_likes_pictures1`
		FOREIGN KEY (`pic_id`)
		REFERENCES `db_camagru`.`pictures` (`id`)
		ON DELETE CASCADE
		ON UPDATE NO ACTION,
	CONSTRAINT `fk_likes_users1`
		FOREIGN KEY (`user_id`)
		REFERENCES `db_camagru`.`users` (`id`)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION)
	ENGINE = InnoDB
	AUTO_INCREMENT = 2
	DEFAULT CHARACTER SET = utf8;";
$pdo->exec($sql);

echo "<br>create LIKES table : ok</br>";


$sql = "CREATE TABLE IF NOT EXISTS `db_camagru`.`calcs` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NULL DEFAULT NULL,
	`file_url` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id` ASC))
	ENGINE = InnoDB
	AUTO_INCREMENT = 7
	DEFAULT CHARACTER SET = utf8;";
$pdo->exec($sql);

echo "<br>create CALCS table : ok</br>";

header('Location: ../pages/index');

?>
