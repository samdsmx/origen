ALTER TABLE `llamadas` ADD COLUMN `id` INTEGER UNSIGNED NOT NULL DEFAULT NULL AUTO_INCREMENT AFTER `Violentometro`, ADD PRIMARY KEY (`id`);

ALTER TABLE  `casos` ADD  `CExito` TEXT NULL ;

ALTER TABLE  `llamadas` ADD  `MPrincipal` TEXT NULL ;
ALTER TABLE  `llamadas` ADD  `Metas` TEXT NULL ;
ALTER TABLE  `llamadas` ADD  `OClinico` TEXT NULL ;
ALTER TABLE  `llamadas` ADD  `Intervencion` TEXT NULL ;
ALTER TABLE  `llamadas` ADD  `Canalizacion` TEXT NULL ;
ALTER TABLE  `llamadas` ADD  `Avances` TEXT NULL ;
