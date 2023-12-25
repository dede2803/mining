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


for ($adaPayuTop = 0; $adaPayuTop < 50; $adaPayuTop++) {
    $getIP = getIP();
    $IP = explode('">', explode('<input type="hidden" name="lihatip" id="lihatip"  value="', $getIP)[1])[0];
    if ($IP != "") {
        //===========================================================================================================================
        //===========================================================================================================================
        //===========================================================================================================================
        function head()
        {
            $h[] = "Accept: text/html,application/xhtml+xml,application/xml;";
            $h[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
            $h[] = "content-type: application/x-www-form-urlencoded";
            return $h;
        }

        function get()
        {
            $url = "https://cryptofuture.co.in/";
            return curl($url, '', head())[1];
        }

        function login($email, $token, $header)
        {
            $url = "https://cryptofuture.co.in/auth/login";
            $data = http_build_query(array("wallet" => $email, "csrf_token_name" => $token));
            return curl($url, $data, $header)[1];
        }

        function currencyDoge()
        {
            $url = "https://cryptofuture.co.in/faucet/currency/doge";
            return curl($url, '', head())[1];
        }


        function fileGetContentsCurl()
        {
            $url = "https://CryptoFuture.co.in/faucet/verify/doge";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $data = curl_exec($ch);
            curl_close($ch);

            return $data;
        }

        /**
         * Build the captcha request URL
         */
        function buildCaptchaUrl()
        {
            $captcha = $_POST['g-recaptcha-response'];
            $secret = '6LeS-zApAAAAANKNBGacJJtsPIq3D4RyYyLx2bY5';
            return "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
        }

        /**
         * Sends the captcha and returns true on success - else false
         */
        function sendCaptchaResponse()
        {
            $response = json_decode(fileGetContentsCurl(buildCaptchaUrl()), true);
            if ($response['success'] == false) {
                return false;
            }
            return true;
        }

        

        function claimDoge($antibotlinks, $tokenClaimDoge, $captcha, $recaptchav3, $wallet, $header)
        {
            $url = "https://cryptofuture.co.in/faucet/verify/doge";
            $data = http_build_query(array("antibotlinks" => $antibotlinks, "csrf_token_name" => $tokenClaimDoge, "captcha" => $captcha, "recaptchav3" => $recaptchav3, "wallet" => $wallet));
            return curl($url, $data, $header)[1];
        }


        $get = get();
        $email = "dede.sulaiman2803@gmail.com";
        $token = explode('">', explode('<input type="hidden" name="csrf_token_name" id="token" value="', $get)[1])[0];
        $login = login($email, $token, array_merge(head(), array("Referer: https://autopayu.top/")));
        sleep(5);

        $currencyDoge = currencyDoge();

        $bot1 = explode('\"><img', explode('<a href=\"#\" rel=\"', $currencyDoge)[1])[0];
        $bot2 = explode('\"><img', explode('<a href=\"#\" rel=\"', $currencyDoge)[2])[0];
        $bot3 = explode('\"><img', explode('<a href=\"#\" rel=\"', $currencyDoge)[3])[0];

        $antibotlinks1 = "+" . $bot2 . "+" . $bot1 . "+" . $bot3;
        $antibotlinks2 = "+" . $bot2 . "+" . $bot3 . "+" . $bot1;

        $tokenClaimDoge = explode('">', explode('<input type="hidden" name="csrf_token_name" id="token" value="', $currencyDoge)[1])[0];
        $captcha = "captcha";
        $recaptchav3 = explode('</div>', explode('<input type="hidden" id="recaptchav3Token" name="recaptchav3">', $currencyDoge)[1])[0];

        
       
        $claimDoge = claimDoge($antibotlinks2, $tokenClaimDoge, $captcha, sendCaptchaResponse(), $email, array_merge(head(), array("Referer: https://cryptofuture.co.in/faucet/currency/doge")));

        sleep(5);
        $ClaimSucces = currencyDoge();
        echo sendCaptchaResponse();
         /*$alert = explode('</h2>', explode('<h2 class="swal2-title" id="swal2-title" style="display: flex;">', $ClaimSucces)[1])[0];

        if ($alert == 'Success!') {
            echo "Berhasil Claim";
        } else {
            echo "Gagal Clam";
        }

        
antibotlinks=+5544+5294+2967&
csrf_token_name=cac9d6c3f250bffc92ea4df0be65ee4b&token=JHIeqRZac34gnur70wy2YCUm6t5WLf&
captcha=captcha&
recaptchav3=03AFcWeA5eDzsK585BngW0i7n4FKYVC9QPu-B_xxohaJ0aSfl9GBWQFUJRql9hCJrSR4_-4o7leZlb0Cd2XV0Ev7ZZRVV6kiMrKyDK0i6rpcv_V-lSMC0C0_NdXo8ibJbB0XYLii77tSAu54E0xriBIWO8L4rlKy8qELOO-0SpIaVvfy627lg0im_PSQLZbE5LvHfbrU4OEKIyycpYSuEnp_qn5tBMV7OS00BASa0NhSmmRHaiUHL6h-ursSOYa5xKFgojufGw4q2CrM5Cp10-lKbyyyb1rlWHjCUsCvb1k4IjymXaW2noIenz4-y8XKOfaQoSx-tKbf8Lg2wRMZTlBMuWFKkbLXc0ZAS0DVPkqhmZP-Pilg29pqlhXNQM0KqxKnKykuBwcQYPRYaWwnRcbz0aHKkW5WsHCp_qHV6iY6KG_EywtkkuLMV1zpgD-tESG6ffb8ZdFvQI2GWJA7JqH9aoPMKZwUElrNvGBnCvMJ7QevOl2-_EFTWF2MobohFFSoBPGWl6j9XC8DIwyPTr414epEtWCA-SPI67lDnR2Fl1AZv5TAEsypY20Q_Q_DZrvWGnrD3cfBHP&
wallet=dede.sulaiman2803%40gmail.com

*/

        //AKHIR KONEKSI TERHUBUNG
    } else {
        echo $WhiteTebal . "Koneksi internet " . $RedTebal . "TERPUTUS," . $WhiteTebal . " Coba periksa kembali WiFi anda..!!!";
        sleep(2);
        echo "\r                                                                                                            \r";
        sleep(2);
    }
}
