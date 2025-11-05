*** REQUISITOS ***

PHP 8.0 o superior

MySQL 8 o superior


[ PASOS DE INSTALACIÓN ]

1. Clonar el repositorio a la carpeta correspondiente de tu servidor web ( Generalmente htdocs ). Esto lo haces abriendo una terminal y tecleando el siguiente comando: 
git clone linkdelrepositorio "rutaDeLaCarpeta"
Por ejemplo, si usas xampp : git clone linkdelrepositorio "cd:/xampp/htdocs"

2. Importar el archivo poasDemoBD.sql en tu manejador de bases de datos de MySQL.
   NOTA: El sistema supone que la base de datos se llama "poas", entonces, si creas una base de datos con los datos importados, deberás llamarla así. También, el sistema supone que estás montando la base de datos en el host local ( localhost o 127.0.0.1 )


3. Ingresar al enlace dependiendo de tu servidor web. Por ejemplo, si lo montas en un entorno local, podrías acceder desde:
   
   localhost/poas/public 

4. ¡ Disfruta de la demo !


// USO DE LA API //

Supongamos que instalaste este repositorio en tu entorno local. Entonces, deberías poder acceder a la APi de esta forma:

http://localhost/poas/public/api.php

Ahora bien, el endpoint para consultar los POAS es el siguiente:

Método GET : => http://localhost/poas/public/api.php?poaId=ID_POA


Donde ID_POA es el número del ID del POA que quieres consultar.

Si se consulta un ID de POA válido ( Que exista ), entonces se obtiene la información del mismo. Caso contrario, se obtiene un mensaje alusivo de que no se encontró el POA y un status 404 ( No encontrado )

