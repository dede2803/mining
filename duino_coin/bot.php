<?php
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

function wktClaim($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                            \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mTunggu, sedang melakukan claim \33[1;31m" . date('s', $res) . "\33[1;37m detik.";
        sleep(1);
    endwhile;
}

function timer($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                            \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mTunggu, proses selanjutnya selama \33[1;31m" . date($res) . "\33[1;37m detik.";
        sleep(1);
    endwhile;
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

function headConnect()
{
    $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
    return $h;
}

function getConnect()
{
    $url = "https://ipsaya.com/";
    return curl($url, '', headConnect())[1];
}

$connect = getConnect();



$getConnect = explode('">', explode('<input type="hidden" name="lihatip" id="lihatip"  value="', $connect)[1])[0];
if ($getConnect != "") {

    function head()
    {
        $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
        $h[] = "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
        $h[] = "content-type: text/plain;charset=UTF-8";
        return $h;
    }

    function get()
    {
        $url = "https://pastelfaucet.com/";
        return curl($url, '', head())[1];
    }

    function claim($ip, $header)
    {
        $url = "https://pastelfaucet.com/send.php?q=coolarray28@$ip";
        $data = "coolarray28";
        return curl($url, $data, $header)[1];
    }

    while (true) {
        $time = json_decode(file_get_contents('timeWD.json'), 1);
        $timeNow = date('d-m-Y H:i');
        $server = $time['timeWD'];

        if ($server < $timeNow) {
            wktClaim(5);
            $ip = explode('";', explode('var ip = "', get())[1])[0];
            $claim = claim($ip, array_merge(head(), array("referer: https://pastelfaucet.com/")));
            echo $WhiteTebal . "Berhasil" . $GreenTebal . " Claim";
            sleep(2);
            echo "\r                                                          \r";

            $tglSkrg = date('d-m-Y H:i');
            $tglClaim = date('d-m-Y H:i', strtotime('+1 days', strtotime($tglSkrg)));
            $detikClaim = "86400";

            if (!file_exists("timeWD.json")) {
                $data = ["timeWD" => $tglClaim];
                save("timeWD.json", $data);
            } else {
                $data = ["timeWD" => $tglClaim];
                save("timeWD.json", $data);
            }

            timer($detikClaim);
        }
        sleep(10);
        echo "\n";
        // $warning = "You already claimed your DUCO. Please try again next day";       
        /*if ($warning == "You already claimed your DUCO. Please try again next day") {
            echo "Claim Besok lagi";
        }*/
    }
    //AKHIR KONEKSI TERHUBUNG
} else {
    echo $WhiteTebal . "Koneksi internet " . $RedTebal . "TERPUTUS," . $WhiteTebal . " Coba periksa kembali WiFi anda..!!!";
    sleep(2);
    echo "\r                                                                                                            \r";
    sleep(2);
}
