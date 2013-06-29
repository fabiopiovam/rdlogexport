<?php
require('rdlogexport.class.php');

$rdlogexport = new RDLogExport();
$rdlogexport->export_files();
// echo ($rdlogexport->export_files()) ? 'Arquivos exportados com sucesso!' : 'Falha!';