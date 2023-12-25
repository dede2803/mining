<?php
//system('clear');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
session_start();

//WARNA
$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

echo $WhiteTebal . "Menghubungkan Server ";
sleep(4);

//============================ CONVERT WAKTU =====================================
function timer($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                                         \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mSedang Mengambil Waktu Claim \33[1;31m" . date($res) . " Detik ";
        sleep(1);
    endwhile;
}

function wktClaim($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                                         \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mHarap Tunggu Claim Sedang Berlangsung \33[1;31m" . date($res) . " Detik ";
        sleep(1);
    endwhile;
}

//============================ CONVERT WAKTU =====================================
function waktu($waktu)
{
    if (($waktu > 0) and ($waktu < 60)) {
        $lama = number_format($waktu, 2) . " detik";
        return $lama;
    }
    if (($waktu > 60) and ($waktu < 3600)) {
        $detik = fmod($waktu, 60);
        $menit = $waktu - $detik;
        $menit = $menit / 60;
        $lama = $menit . " Menit " . number_format($detik, 2) . " detik";
        return $lama;
    } elseif ($waktu > 3600) {
        $detik = fmod($waktu, 60);
        $tempmenit = ($waktu - $detik) / 60;
        $menit = fmod($tempmenit, 60);
        $jam = ($tempmenit - $menit) / 60;
        $lama = $jam . " Jam " . $menit . " Menit " . number_format($detik, 2) . " detik";
        return $lama;
    }
}


//PARSING JSON
function fetch_value($str, $find_start, $find_end)
{
    $start = @strpos($str, $find_start);
    if ($start === false) {
        return "";
    }
    $length = strlen($find_start);
    $end = strpos(substr($str, $start + $length), $find_end);
    return trim(substr($str, $start + $length, $end));
}


//SAVE JSON
function save($data, $data_post)
{
    if (!file_get_contents($data)) {
        file_put_contents($data, "[]");
    }

    $json = json_decode(file_get_contents($data), 1);
    $arr = array_merge($json, $data_post);
    file_put_contents($data, json_encode($arr, JSON_PRETTY_PRINT));
}


//============================ CURL =============================================
function curl($url, $post = 0, $httpheader = 0, $proxy = 0)
{
    // url, postdata, http headers, proxy, uagent
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_COOKIE, TRUE);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");

    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    if ($httpheader) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }

    if ($proxy) {
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    }

    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode) return "Curl Error : " . curl_error($ch);
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array($header, $body);
    }
}

function headIP()
{
    $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
    return $h;
}

function getIP()
{
    $url = "https://ipsaya.com/";
    return curl($url, '', headIP())[1];
}

$getIP = getIP();
$IP = explode('">', explode('<input type="hidden" name="lihatip" id="lihatip"  value="', $getIP)[1])[0];
if ($IP != "") {
    echo $WhiteTebal . "Sedang mengambil Data Website ";

    //============================================================================================
    //============================================================================================
    function head()
    {
        $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
        $h[] = "user-agent: Mozilla/5.0 (Linux; Android 8.1.0; ASUS_X00TD Build/OPM1; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/120.0.6099.43 Mobile Safari/537.36";
        return $h;
    }

    function get()
    {
        $url = "https://minerbig.com/";
        return curl($url, '', head())[1];
    }

    $get = get();
    echo $get;

    /*
    <div wire:id="xsuB2IgsskvO8Kx8R1lc" wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;xsuB2IgsskvO8Kx8R1lc&quot;,&quot;name&quot;:&quot;login&quot;,&quot;locale&quot;:&quot;en&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[]},&quot;serverMemo&quot;:{&quot;children&quot;:[],&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;ddf2758b&quot;,&quot;data&quot;:{&quot;wallet&quot;:null,&quot;response&quot;:null,&quot;referral&quot;:null},&quot;dataMeta&quot;:[],&quot;checksum&quot;:&quot;53651dcdd8fccc0a1003171db206574da495316152beef9064d112f2d03d12f4&quot;}}">
    */

    /*
    {"fingerprint":{"id":"tLhIIb43RsXWtlXCoi9T","name":"login","locale":"en","path":"/","method":"GET"},"serverMemo":{"children":[],"errors":[],"htmlHash":"ddf2758b","data":{"wallet":null,"response":null,"referral":null},"dataMeta":[],"checksum":"ce45174258b104f9c768f0e14064f57ab9d4938edcfdf6b33c3b4c7ffcee3496"},"updates":[{"type":"syncInput","payload":{"id":"2pe6","name":"wallet","value":"TTqx5BN6kGaGbtWABGgGpTbHy87JgPfYiT"}},{"type":"callMethod","payload":{"id":"p13ai","method":"start","params":[]}}]}
    */
    //AKHIR KONEKSI TERHUBUNG
} else {
    echo $WhiteTebal . "Koneksi internet " . $RedTebal . "TERPUTUS," . $WhiteTebal . " Coba periksa kembali WiFi anda..!!!";
    sleep(2);
    echo "\r                                                                                                            \r";
    sleep(2);
}
