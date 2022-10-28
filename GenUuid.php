<?php

namespace NCentral_GLPI\inc\Geracao;

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

require_once $baseDir . DIRECTORY_SEPARATOR . 'autoload.php';

use NCentral_GLPI\inc\Geracao\Log;

class GenUuid {
    public static function gen_uuid() {       
        $log = new Log();
        $log->writeLog("Gerando UUID V4 Timestamp first");
        
        $date = date_create();
        $hexadate = dechex(date_timestamp_get($date));
        return $hexadate . sprintf('-%04x-%04x-%04x-%04x%04x%04x',
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
  
    public static function is_valid($uuid) {
        return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
    }
}
