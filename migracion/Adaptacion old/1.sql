
ALTER TABLE consejeros DROP PRIMARY KEY;
ALTER TABLE consejeros ADD `id_persona` int(11) NOT NULL DEFAULT 1 FIRST;
ALTER TABLE consejeros ADD `id_usuario` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST; 
UPDATE consejeros SET `id_persona` = `id_usuario`;
ALTER TABLE consejeros ADD `password2` varchar(100) NULL;
UPDATE consejeros SET `password2` = `password`;
UPDATE consejeros SET `password` = '$2y$10$QSCFi/r/5HQFGcRZ31obY.Rbbi9w8mOVALOZufFFrpUGmxNn2D7Ki';
ALTER TABLE consejeros ADD `status` tinyint(1) NOT NULL DEFAULT 1;
ALTER TABLE consejeros ADD `remember_token` varchar(100) DEFAULT NULL;
ALTER TABLE consejeros ADD created_at timestamp;
ALTER TABLE consejeros ADD `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE consejeros ADD `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


 (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL DEFAULT '1',
    `nombre` varchar(45) NOT NULL,
    `password` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
    `NivelSeguridad` int(1) DEFAULT NULL,
    `acceso` int(1) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE casos ADD created_at timestamp;
