ALTER TABLE  `llamadas` ADD  `Violentometro` TEXT NULL ;

INSERT INTO CAMPOS VALUES 
('1. Bromas hirientes','Violentometro',1),
('1. Chantajear','Violentometro',1),
('1. Mentir/ Engañar','Violentometro',1),
('1. Ignorar/ Ley del hielo','Violentometro',1),
('1. Celar','Violentometro',1),
('1. Culpabilizar','Violentometro',1),
('1. Descalificar','Violentometro',1),
('1. Ridiculizar/ Ofender','Violentometro',1),
('1. Humillar en público','Violentometro',1),
('1. Intimidar/ Amenazar','Violentometro',1),
('1. Controlar/ Prohibir','Violentometro',1),
('2. Destruir artículos personales','Violentometro',1),
('2. Manosear','Violentometro',1),
('2. Caricias agresivas','Violentometro',1),
('2. Golpear “jugando”','Violentometro',1),
('2. Pellizcar/ Arañar','Violentometro',1),
('2. Empujar/ Jalonear','Violentometro',1),
('2. Cachetear','Violentometro',1),
('2. Patear','Violentometro',1),
('3. Encerrar/ Aislar','Violentometro',1),
('3. Amenazar con objetos o armas','Violentometro',1),
('3. Amenazar de muerte','Violentometro',1),
('3. Forzar a una relación sexual','Violentometro',1),
('3. Abuso sexual','Violentometro',1),
('3. Violar','Violentometro',1),
('3. Mutilar','Violentometro',1),
('3. Asesinar','Violentometro',1);

ALTER TABLE  `casos` ADD  `NivelViolencia` VARCHAR( 10 ) NULL ;

ALTER TABLE  `llamadas` ADD  `AcudeInstitucion` VARCHAR( 2 ) NULL ;