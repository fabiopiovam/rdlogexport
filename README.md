rdlogexport
===========

This is a [Rivendell Radio](http://www.rivendellaudio.org/ "Access") Extension to export Audio Cards.

Rivendell is a Open Source Radio Automation

If you are a Rivendell developer contributor, sorry by this developed in PHP, but it's more easily for me =/

### Requeriments

PHP 5.3 >=

### Preparing to execution

Alter the rdlogexport.class.php

```php
$this->origin = 'path_origin';
$this->destination = 'path_destination';
$this->format = 'mp3';
...
$link = mysql_connect('localhost', 'root', '***');
```

### Executing
    `# php rdlogexport.php`