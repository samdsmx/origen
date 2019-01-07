Update casos SET estado = 'NINGUNO' where estado = ''

Update casos SET estado = 'Michoacán de Ocampo' where estado = 'Michoacán ';
Update casos SET estado = 'Michoacán de Ocampo' where estado = 'Michoacán';
Update casos SET estado = 'Nuevo Leon' where estado = 'Nuevo';
Update casos SET estado = 'Distrito Federal' where estado = 'Distrito';
Update casos SET estado = 'Quintana Roo' where estado = 'Quintana';
Update casos SET estado = 'San Luis Potosí' where estado = 'San Luis Potosi';
Update casos SET estado = 'San Luis Potosí' where estado = 'San';
Update casos SET estado = 'Baja California Sur' where estado = 'Baja';
Update casos SET estado = 'Veracruz de Ignacio' where estado = 'VERACRUZ';
Update casos SET estado = 'Veracruz de Ignacio' where estado = 'Veracruz';
Update casos SET estado = 'Veracruz de Ignacio' where estado = 'Veracruz de Ignacio de la Llave';
Update casos SET estado = 'Veracruz de Ignacio' where estado = 'Veracruz de Ignacio ';
Update casos SET estado = 'Ciudad de México' where estado = 'Distrito Federal';

SELECT CAST(Estado as BINARY) AS Estado_cs, count(*)
FROM `origencallcenter`.`casos`
group by Estado_cs
