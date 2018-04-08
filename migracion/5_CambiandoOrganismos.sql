update organismos set estado = 'CIUDAD DE MÉXICO' where estado = 'CIUDAD DE MÉXICO';
update organismos set tema = replace(tema, '\n',',');
