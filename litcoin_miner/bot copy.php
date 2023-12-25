<?php
system('clear');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");
//•
//echo str_repeat("◼",66)."\n"; panjang barisan 66


//================ warna ====================
$Red    = "\33[0;31m";
$Green  = "\33[0;32m";
$Yellow = "\33[0;33m";
$Purple = "\33[0;34m";
$Pink   = "\33[0;35m";
$Cyan   = "\33[0;36m";
$White  = "\33[0;37m";
$Normal = "\33[0m";

$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

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
        $lama = "        " . $menit . " Menit " . number_format($detik, 2) . " detik";
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

function timerSukses($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                   \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1mProses Pencairan \33[1;32mBERHASIL.!!! \33[1;31m" . date($res) . " ";
        sleep(1);
    endwhile;
}

function timerClaim($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                   \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mTunggu Sebentar Sedang Proses Pencairan \33[1;31m" . date('s', $res) . " \33[1m";
        sleep(1);
    endwhile;
}

function timerWeb($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                   \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mTunggu Sebentar Sedang Mengambil Data Website \33[1;31m" . date('s', $res);
        sleep(1);
    endwhile;
}

function timerData($tmr)
{
    $timr = time() + $tmr;
    while (true) :
        echo "\r                                                   \r";
        $res = $timr - time();
        if ($res < 1) {
            break;
        }
        echo "\33[1;37mHarap Tunggu Sedang Mengambil Data \33[1;31m" . date($res) . " ";
        sleep(1);
    endwhile;
}

//============================ CURL =============================================
function curl($url, $post = 0, $httpheader = 0, $proxy = 0)
{ // url, postdata, http headers, proxy, uagent
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_COOKIE, TRUE);
    //curl_setopt($ch, CURLOPT_COOKIEFILE,"cookie.txt");
    //curl_setopt($ch, CURLOPT_COOKIEJAR,"cookie.txt");
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

// AWALAN UNTUK PARSING JSON
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

//Menyimpan data dengan format JSON
function save($data, $data_post)
{
    if (!file_get_contents($data)) {
        file_put_contents($data, "[]");
    }

    $json = json_decode(file_get_contents($data), 1);
    $arr = array_merge($json, $data_post);
    file_put_contents($data, json_encode($arr, JSON_PRETTY_PRINT));
}

timerWeb(5);
sleep(3);
system('clear');

function headIndex()
{
    $cookie = json_decode(file_get_contents('cookie.json'), 1);
    $h[] = "Accept: text/html,application/xhtml+xml,application/xml";
    $h[] = "Cookie: cf_clearance=CShIi2s7viI1HlvP2iAliwgqeKvYQHwGTz9BD1Ckf_w-1703075551-0-1-27d53512.e8906b76.c9daa1c5-0.2.1703075551; PHPSESSID=5fvv8ps18mkfj2dgb4qi4j1f0k; _ga_G5W0QT39CX=GS1.1.1703075548.2.1.1703076119.0.0.0; evercookie_png=987b20aaf186bf093ac66c3634dd1cb5; evercookie_etag=987b20aaf186bf093ac66c3634dd1cb5; evercookie_cache=987b20aaf186bf093ac66c3634dd1cb5; hash=987b20aaf186bf093ac66c3634dd1cb5";
    $h[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
    return $h;
}

function getIndex()
{
    $url = "https://ltcminer.com/";
    return curl($url, '', headIndex())[1];
}

echo $WhiteTebal . "Website " . $GreenTebal . "BERHASIL " . $WhiteTebal . "Di Akses !!!";
sleep(3);
timerData(5);
echo $WhiteTebal . "Data " . $GreenTebal . "BERHASIL " . $WhiteTebal . "Di Akses !!!";
sleep(3);
system('clear');

function wd($task, $wallet, $header)
{
    $url  = "https://ltcminer.com/task/?";
    $data = http_build_query(array('task' => $task, 'address' => $wallet));
    return curl($url, $data, $header)[1];
}


echo $WhiteTebal . str_repeat("◼", 42) . "\n";
sleep(2);
echo $Red . "Catatan : " . $Cyan . "Pencairan Setiap Setiap Hari\n         Dengan Nominal Sebesar " . $GreenTebal . "0.0001" . $WhiteTebal . " LTC\n";
sleep(2);
echo $WhiteTebal . str_repeat("◼", 42) . "\n\n";
sleep(2);

while (true) :

    $getIndex = getIndex();
    $balance = explode('"', explode('<input type="text" id="amountValue" disabled="disabled" value="', $getIndex)[1])[0];

    $time = json_decode(file_get_contents('timeWD.json'), 1);
    $timeNow = date('d-m-Y H:i');
    $server = $time['timeWD'];

    echo $WhiteTebal . "SERVER                = " . $YellowTebal . "LITECOIN MINER\n";
    sleep(2);
    echo $WhiteTebal . "Pendapatan Mining     = " . $GreenTebal . "" . $balance . "" . $WhiteTebal . " LTC\n";
    sleep(2);
    echo $WhiteTebal . "Tanggal & Jam         = " . $PurpleTebal . "" . $timeNow . "\n";
    sleep(2);
    echo $WhiteTebal . "Pencairan             = " . $GreenTebal . "" . $server . "\n";
    sleep(2);
    echo $WhiteTebal . str_repeat("_", 42) . "\n";
    sleep(2);

    if ($balance == "") {
        system("xdg-open https://ltcminer.com/");
        sleep(30);
    }

    if ($server < $timeNow) {
        $task1 = "validateAddress";
        $task2 = "withdrawal";
        $wallet = "MEgLjvsgqVT1T7Kzk6YXSbXvKBnD2pSdta";
        timerClaim(10);
        $wd1 = wd($task1, $wallet, array_merge(headIndex(), array("referer: https://ltcminer.com/")));
        sleep(2);
        $wd2 = wd($task2, $wallet, array_merge(headIndex(), array("referer: https://ltcminer.com/")));
        $tglSkrg = date('d-m-Y H:i');
        $tglClaim = date('d-m-Y H:i', strtotime('+1 days', strtotime($tglSkrg)));

        /*
        wd1 = 'task=validateAddress&address=MEgLjvsgqVT1T7Kzk6YXSbXvKBnD2pSdta'
        wd2 = 'task=withdrawal&address=MEgLjvsgqVT1T7Kzk6YXSbXvKBnD2pSdta'
        */
        if (!file_exists("timeWD.json")) {
            $data = ["timeWD" => $tglClaim];
            save("timeWD.json", $data);
        } else {
            system('rm timeWD.json');
            $data = ["timeWD" => $tglClaim];
            save("timeWD.json", $data);
        }

        timerSukses(4);
        sleep(10);
    }
    sleep(10);
    echo "\n";
endwhile;
