<?php
include_once("config.php");
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class FunctionsPHP
{
    public function ConexionBD()
    {
        $ConfigPHP = new Config();
        $NameServer = $ConfigPHP->ConfigPhp("ServerDatabase");
        $BaseDeDatos = $ConfigPHP->ConfigPhp("NameDatabase");
        $User = $ConfigPHP->ConfigPhp("UserDatabase");
        $Password = $ConfigPHP->ConfigPhp("PassDateBase");

        if ($User == "" || $User == null) {
            $connectionInfo = array("Database" => $BaseDeDatos);
        } else {
            $connectionInfo = array("Database" => $BaseDeDatos, "UID" => $User, "PWD" => $Password, "CharacterSet" => "UTF-8");
        }
        $conn = sqlsrv_connect($NameServer, $connectionInfo);

        if ($conn) {
            return $conn;
        } else {
            die(print_r(sqlsrv_errors(), true));
            echo '<script> alert("Conexion fallida al servidor.");</script>';
            exit;
        }
    }
    public function QuitarCaracteresSQL($Texto)
    {
        if (!in_array(gettype($Texto), ["array", "object"])) {
            $ArrayCaracterSQL = ["'"];
            $ReplaceCaracterSQL = [""];
            $Texto = str_replace($ArrayCaracterSQL, $ReplaceCaracterSQL, $Texto);
            return $Texto;
        } else {
            return $Texto;
        }
    }
    function QuitarAcentosSQL($Texto)
    {
        //Reemplazamos la A y a
        $Texto = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $Texto
        );
        //Reemplazamos la E y e
        $Texto = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $Texto
        );
        //Reemplazamos la I y i
        $Texto = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $Texto
        );
        //Reemplazamos la O y o
        $Texto = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $Texto
        );
        //Reemplazamos la U y u
        $Texto = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $Texto
        );
        //Reemplazamos la N, n, C y c
        $Texto = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $Texto
        );
        $Texto = str_replace(
            array("'"),
            array(""),
            $Texto
        );
        return $Texto;
    }
    function InArrayPanda($ArraySearch, $ArrayValidate)
    {
        if (gettype($ArraySearch) == "string") {
            if (in_array($ArraySearch, $ArrayValidate)) {
                return true;
            }
        } elseif (gettype($ArraySearch) == "array") {
            foreach ($ArraySearch as $SearchValue) {
                if (in_array($SearchValue, $ArrayValidate)) {
                    return true;
                }
            }
        }
        return false;
    }
    function encryption($string)
    {
        $ConfigPHP = new Config();
        $KeyHashEncript = $ConfigPHP->ConfigPhp("KeyHashEncript");

        $output = FALSE;
        $key = hash('sha256', $KeyHashEncript);
        $iv = substr(hash('sha256', '0x0852ACF8'), 0, 16);
        $output = openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
    function decryption($string)
    {
        $ConfigPHP = new Config();
        $KeyHashEncript = $ConfigPHP->ConfigPhp("KeyHashEncript");

        $key = hash('sha256', $KeyHashEncript);
        $iv = substr(hash('sha256', '0x0852ACF8'), 0, 16);
        $output = openssl_decrypt(base64_decode($string), 'AES-256-CBC', $key, 0, $iv);
        return $output;
    }
    function getUrlCompletDirectoryApp()
    {
        $base_url = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]";
        $directory = dirname($_SERVER['REQUEST_URI']);
        $directory = ($directory == '/' || $directory == '\\') ? '' : $directory;
        $full_url = $base_url . $directory . "/";
        return $full_url;
    }
    function SendSMS_ApiInfoBip($CURLOPT_URL, $AuthorizationApp, $destinationsTo, $destinationsText, $requiredUrlShort = false, $UrlShort = "")
    {
        $ConfigPHP = new Config();
        $ProxyConfigSettings = $ConfigPHP->ConfigPhp("ProxyConfigSettings");
        $InfomacionUrl = "";
        if ($requiredUrlShort) {
            $ParseUrl = parse_url($UrlShort);
            $InfomacionUrl = ',
                "urlOptions": {
                    "shortenUrl": true,
                    "trackClicks": true,
                    "trackingUrl": "' . $UrlShort . '",
                    "removeProtocol": true,
                    "customDomain": "' . $ParseUrl["host"] . '"
                }';
            //"trackingUrl": "' . $UrlShort . '",
            //"customDomain": "' . $ParseUrl["host"] . '"
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PROXY => $ProxyConfigSettings,
            CURLOPT_PROXYUSERPWD => "default",
            CURLOPT_URL => $CURLOPT_URL . '/sms/2/text/advanced',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "messages":
                [
                    {"destinations":
                        [
                            {
                                "to": "' . $destinationsTo . '"
                            }
                        ],
                        "from": "Atento",
                        "text": "' . $destinationsText . '"
                    }
                ]' . $InfomacionUrl . '
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: App ' . $AuthorizationApp,
                'Content-Type: application/json',
                'Accept: application/json'
            )
        ));
        $Response = curl_exec($curl);
        curl_close($curl);
        return $Response;
    }
    function SendWhatsApp_ApiInfoBip($CURLOPT_URL, $AuthorizationApp, $fromsTo, $destinationsTo, $templateName, $templateData)
    {
        if (!substr($CURLOPT_URL, -1) == "/") {
            $CURLOPT_URL = $CURLOPT_URL . "/";
        }
        $ConfigPHP = new Config();
        $ProxyConfigSettings = $ConfigPHP->ConfigPhp("ProxyConfigSettings");

        $CURLOPT_POSTFIELDS = '{
            "messages": [
                {
                    "from": "' . $fromsTo . '",
                    "to": "' . $destinationsTo . '",
                    "content": {
                        "templateName": "' . $templateName . '",
                        "templateData": {
                            "body": {
                                "placeholders": [
                                    "' . $templateData . '"
                                ]
                            }
                        },
                        "language": "en"
                    }
                }
            ]
        }';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PROXY => $ProxyConfigSettings,
            CURLOPT_PROXYUSERPWD => "default",
            CURLOPT_URL => $CURLOPT_URL . '/whatsapp/1/message/template',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Authorization: App ' . $AuthorizationApp,
                'Content-Type: application/json',
                'Accept: application/json'
            )
        ));
        $Response = curl_exec($curl);
        curl_close($curl);
        return $Response;
    }
    function SendEmail_ApiInfoBip($CURLOPT_URL, $AuthorizationApp, $destinationsTo, $fromsTo, $Subject, $templateData)
    {
        if (!substr($CURLOPT_URL, -1) == "/") {
            $CURLOPT_URL = $CURLOPT_URL . "/";
        }
        $ConfigPHP = new Config();
        $ProxyConfigSettings = $ConfigPHP->ConfigPhp("ProxyConfigSettings");

        $client = new Client([
            'base_uri' => "$CURLOPT_URL",
            'headers' => [
                'Authorization' => "App $AuthorizationApp",
                'Content-Type' => 'multipart/form-data',
                'Accept' => 'application/json',
            ],
            "proxy" => $ProxyConfigSettings,
        ]);

        $response = $client->request(
            'POST',
            'email/2/send',
            [
                RequestOptions::MULTIPART => [
                    ['name' => 'from', 'contents' => "$fromsTo"],
                    ['name' => 'to', 'contents' => "$destinationsTo"],
                    ['name' => 'subject', 'contents' => "$Subject"],
                    ['name' => 'text', 'contents' => "$templateData"],
                ],
            ]
        );
        return $response;
    }
}
$FunctionsPHP = new FunctionsPHP();
