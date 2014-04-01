<?php
class RDLogExport {
    public $origin;
    public $destination;
    public $format;
    public $files;

    private $_conn;

    function __construct() {
        $this->_conn = $this->_connect();
        $this->origin = 'path_origin';
        $this->destination = 'path_destination';
        $this->format = 'mp3';

        $this->files = $this->list_files();
    }

    private function _connect() {
        $link = mysql_connect('localhost', 'root', '***');
        if (!$link) {
            die('Não foi possível conectar: ' . mysql_error());
        }
        mysql_select_db('rivendell');

        return $link;
    }

    public function list_files() {
        $dir = opendir($this->origin);
        $files = array();

        while ($nome_itens = readdir($dir)) {
            if (in_array($nome_itens, array('.', '..')) || !preg_match('/\.' . $this->format . '$/i', $nome_itens))
                continue;
            $files[] = $nome_itens;
        }

        return $files;
    }

    public function export_files() {

        $sql = "SELECT NUMBER, GROUP_NAME, ARTIST, TITLE FROM CART ORDER BY GROUP_NAME, ARTIST";
        $rs = mysql_query($sql, $this->_conn);
        $total = mysql_num_rows($rs);
        $count = 0;
        while ($row = mysql_fetch_assoc($rs)) {
            $count++;
            $percent = intval(($count * 100) / $total);
            $file_name = array_values(array_filter($this->files, function($value) use ($row) {
                return (preg_match('/' . $row['NUMBER'] . '/i', $value) == 1);
            }));

            if (($file_name = $file_name[0]) && file_exists($this->origin . '/' . $file_name)) {
                $dir = $this->destination . $this->strip_accents(utf8_encode(strtolower("/{$row['GROUP_NAME']}/{$row['ARTIST']}")));
                if ((!is_dir($dir)))
                    mkdir($dir, 0777, true);

                $new_file = $this->strip_accents(utf8_encode("$dir/{$row['ARTIST']}-{$row['TITLE']}.{$this->format}"));
                echo "$percent% - copiando $new_file";
                if (copy($this->origin . '/' . $file_name, $new_file)) {
                    echo " OK \n";
                } else {
                    echo " FAIL! \n";
                    file_put_contents('error.log', "FAIL: copy({$this->origin}/{$file_name}, {$new_file});\r\n", FILE_APPEND);
                }
            }
        }

        return true;
    }

    public function strip_accents($string) {
        return str_replace(array("&", "ñ", "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Ñ", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"), array("e", "n", "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "N", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C"), $string);
    }

}
