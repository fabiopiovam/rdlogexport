rdlogexport
===========

Essa é uma extensão do [Rivendell Radio](http://www.rivendellaudio.org/ "Acesse") para exportar os audios catalogados.

### Requerimentos

PHP 5.3 >=

### Configuração

Altere o arquivo `rdlogexport.class.php`

```php
$this->origin = 'path_origin';
$this->destination = 'path_destination';
$this->format = 'mp3';
...
$link = mysql_connect('localhost', 'root', '***');
```

### Executar
    # php rdlogexport.php