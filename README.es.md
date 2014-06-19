rdlogexport
===========

Ese es una extensión del [Rivendell Radio](http://www.rivendellaudio.org/ "Acceder") para exportar los audios catalogados.

### Requerimientos

PHP 5.3 >=

### Configuración

Cambiar el archivo `rdlogexport.class.php`

```php
$this->origin = 'path_origin';
$this->destination = 'path_destination';
$this->format = 'mp3';
...
$link = mysql_connect('localhost', 'root', '***');
```

### Ejecutar
    `# php rdlogexport.php`