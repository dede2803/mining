<?php
system('clear');
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
    //curl_setopt($ch, CURLOPT_COOKIEFILE,"cookieAdaAPAYU.txt");
    //curl_setopt($ch, CURLOPT_COOKIEJAR,"cookieAdaAPAYU.txt");

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
    //===========================================================================================================================
    //===========================================================================================================================
    //===========================================================================================================================
    function headIndex()
    {
        // $cookie = json_decode(file_get_contents('cookie.json'),1);
        $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
        $h[] = "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Mobile Safari/537.36";
        $h[] = "Content-Type: application/x-www-form-urlencoded";
        $h[] = "Cookie: PHPSESSID=resls22vveo27ivcqmuiehlt6g; _ga_G5W0QT39CX=GS1.1.1703466530.1.0.1703466530.0.0.0; _ga=GA1.1.1264282648.1703466531;";
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

    while (true) {
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
    }
    //AKHIR KONEKSI TERHUBUNG
} else {
    echo $WhiteTebal . "Koneksi internet " . $RedTebal . "TERPUTUS," . $WhiteTebal . " Coba periksa kembali WiFi anda..!!!";
    sleep(2);
    echo "\r                                                                                                            \r";
    sleep(2);
}
