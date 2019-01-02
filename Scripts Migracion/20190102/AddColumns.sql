ALTER TABLE `llamadas` ADD COLUMN `id` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT AFTER `Violentometro`, ADD PRIMARY KEY (`id`);

ALTER TABLE  `casos` ADD  `MPrincipal` TEXT NULL ;
ALTER TABLE  `casos` ADD  `Metas` TEXT NULL ;
ALTER TABLE  `casos` ADD  `OClinico` TEXT NULL ;
ALTER TABLE  `casos` ADD  `Intervencion` TEXT NULL ;
ALTER TABLE  `casos` ADD  `Canalizacion` TEXT NULL ;
ALTER TABLE  `casos` ADD  `Avances` TEXT NULL ;
ALTER TABLE  `casos` ADD  `CExito` VARCHAR(1) NULL ;