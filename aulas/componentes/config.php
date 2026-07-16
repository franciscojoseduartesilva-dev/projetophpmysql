<?php
declare(strict_types=1);
define('BASEPATH', true);
header('Content-Type: text/html; charset=utf-8');
?>

<?php

define('SESSION_TTL', 60 * 60 * 5);

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.gc_maxlifetime', (string) SESSION_TTL);
    ini_set('session.cookie_lifetime', (string) SESSION_TTL);

    session_set_cookie_params([
        'path'     => '/',
        'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}


?>

<?php
setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Fortaleza');
$hr = "0";
$hora = date("H:i:s", time() - ($hr));
$data = date("Y-m-d");

?>


<?php

function databr($data = null)
{
    // Define o fuso horário
    date_default_timezone_set('America/Fortaleza');

    // Se nenhuma data for informada, usa a data atual
    if ($data === null) {
        return date('d/m/Y');
    }

    // Converte a data informada para o padrão brasileiro
    return date('d/m/Y', strtotime($data));
}

// Exemplo com data atual
//echo databr();

// Exemplo com data específica
//echo databr('2026-07-03');
?>



<?php

function horabr($hora = null)
{
    // Define o fuso horário
    date_default_timezone_set('America/Fortaleza');

    // Se nenhuma hora for informada, usa a hora atual
    if ($hora === null) {
        return date('H:i');
    }

    // Converte a hora informada para o padrão brasileiro
    return date('H:i', strtotime($hora));
}

// Exemplo com hora atual
//echo horabr();
// Exemplo com hora específica
//echo horabr('15:12:45');
?>





<?php

function encrypt_secure($value, $action = 'e')
{
    $secret_key = 'mickey';
    $secret_iv = 'pateta';
    $cipher = 'AES-256-CBC';

    $key = hash('sha256', $secret_key, true);
    $macKey = hash('sha256', $secret_key . '|' . $secret_iv, true);

    if ($action === 'e') {
        $value = (string) $value;
        $ivLen = openssl_cipher_iv_length($cipher);
        $iv = random_bytes($ivLen);

        $cipherRaw = openssl_encrypt($value, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($cipherRaw === false) {
            return false;
        }

        $mac = hash_hmac('sha256', $iv . $cipherRaw, $macKey, true);

        return base64_encode($iv . $mac . $cipherRaw);
    }

    if ($action === 'd') {
        $value = (string) $value;
        $data = base64_decode($value, true);

        if ($data === false) {
            return false;
        }

        $ivLen = openssl_cipher_iv_length($cipher);
        $macLen = 32;

        if (strlen($data) < ($ivLen + $macLen + 1)) {
            return false;
        }

        $iv = substr($data, 0, $ivLen);
        $mac = substr($data, $ivLen, $macLen);
        $cipherRaw = substr($data, $ivLen + $macLen);

        $calcMac = hash_hmac('sha256', $iv . $cipherRaw, $macKey, true);

        if (!hash_equals($mac, $calcMac)) {
            return false;
        }

        $plain = openssl_decrypt($cipherRaw, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        return ($plain === false) ? false : $plain;
    }

    return false;
}

// $enc = encrypt_secure("123456",'e');
// $dec = encrypt_secure($enc,'d');
?>


<?php

function gerachave()
{
    $min = "1";
    $max = "10";
    $count = 10;

    $list = range($min, $max);
    shuffle($list);
    $list = array_slice($list, 0, $count);

    $length = 520;

    $list1 = array_merge(range('A', 'Z'), range(0, 3));
    shuffle($list1);
    $pass1 = substr(join($list1), 3, $length);

    $list2 = array_merge(range('0', '0'), range(0, 6));
    shuffle($list2);
    $pass2 = substr(join($list2), 0, $length);

    $rand = $pass1 . $pass2;

    return $rand;
}


?>


<?php

function gerachaveshorttag()
{
    $length = 5;

    $list1 = array_merge(range('A', 'Z'), range('a', 'z'), range(0, 9));
    shuffle($list1);
    $pass1 = substr(join($list1), 0, $length);

    $list2 = array_merge(range(0, 9), range(0, 9));
    shuffle($list2);
    $pass2 = substr(join($list2), 0, $length);

    $rand = $pass1 . $pass2;

    return $rand;
}


?>


<?php


function somardias($data, $dias)
{
    $datanew = new DateTime($data);
    $datanew->modify('+ ' . $dias . ' days');

    return $datanew->format('Y-m-d');
}

//$vencimento = somardias('2026-07-02', 20);


?>


<?php

function diferencadedata($data, $hora)
{
    $publicationDateTimeString = $data . ' ' . $hora;
    $publicationDateTime = new DateTime($publicationDateTimeString);
    $currentDateTime = new DateTime();

    $interval = $publicationDateTime->diff($currentDateTime);

    $seg = $interval->s;

    return $seg;
}

//$difrenca =diferencadedata('2026-07-02', $hora)

?>

<?php

function gerarChaveUnica($tamanho = 8)
{
    return bin2hex(random_bytes($tamanho / 2));
}

$chave = gerarChaveUnica();



?>

<?php
function pegarIp(): string
{
    $keys = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = trim((string) $_SERVER[$key]);
            if ($key === 'HTTP_X_FORWARDED_FOR') {
                $partes = explode(',', $ip);
                $ip = trim($partes[0]);
            }
            return mb_substr($ip, 0, 45, 'UTF-8');
        }
    }
    return 'IP não identificado';
}
?>