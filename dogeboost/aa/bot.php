<?php

system('rm cookie.txt');
system('cls');
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");


//WARNA
$RedTebal    = "\33[1;31m";
$GreenTebal  = "\33[1;32m";
$YellowTebal = "\33[1;33m";
$PurpleTebal = "\33[1;34m";
$PinkTebal   = "\33[1;35m";
$CyanTebal   = "\33[1;36m";
$WhiteTebal  = "\33[1;37m";
$NormalTebal = "\33[1m";

if (!file_exists("email.json")) {
    $a = readline("Alamat Email Faucet Pay = ");
    $data = ["email" => $a];
    save("email.json", $data);
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

/* //NETWORKING
function is_connected()
{
    $connected = fopen("https://ltcpayu.top/:443","r"); 
                                        //website, port  (try 80 or 443)
    if($connected)
  {
     //return true;
     echo "connected";
  } else {
   //return false;
   echo "no connected";
  }

}

echo is_connected();
echo http_response_code(404);
*/

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
    curl_setopt($ch, CURLOPT_COOKIEFILE, "a.txt");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "a.txt");

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
//===========================================================================================================================
//===========================================================================================================================
//===========================================================================================================================
//MULTI TOP DOGE
function head()
{
    $h[] = "accept: text/html,application/xhtml+xml,application/xml;";
    $h[] = "user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 (KHTML, like Gecko) Chrome/100.0.3239.111 Safari/537.1";
    $h[] = "content-type: application/x-www-form-urlencoded";
    //$h[] = "content-type: application/x-www-form-urlencoded; charset=UTF-8";
    return $h;
}


function get()
{
    $url = "https://dogeboost.pro/";
    return curl($url, '', head())[1];
}

function login($token, $wallet, $pass, $ref, $header)
{
    $url = "https://dogeboost.pro/login";
    $data = http_build_query(array("_token" => $token, "wallet" => $wallet, "password" => $pass, "referrer" => $ref));
    return curl($url, $data, $header)[1];
}


function getDashboard()
{
    $url = "https://dogeboost.pro/dashboard";
    return curl($url, '', head())[1];
}

function claim($token, $header)
{
    $url  = "https://dogeboost.pro/collect";
    $data = http_build_query(array('_token' => $token));
    return curl($url, $data, $header)[1];
}

while (true) {
    $get = get();
    $token = explode('">', explode('<input type="hidden" name="_token" value="', $get)[1])[0];
    $wallet = "D86WhgxPXgdZqAs7cnbATvpd6CeC4mDLsB";
    $pass = "221209";
    $ref = "";
    $login = login($token, $wallet, $pass, $ref, array_merge(head(), array("referer: https://dogeboost.pro/")));

    while (true) :
        sleep(5);
        $getDashboard = getDashboard();
        $mining = explode('</span>', explode('<span id="profit" class="fw-bold">', $getDashboard)[1])[0];
        $pendapatan = explode(' <span class="text-theme">', explode('<div class="h5 mb-0 font-weight-bold text-gray-800">', $getDashboard)[1])[0];
        $token2 = explode("'", explode("_token = '", $getDashboard)[1])[0];



        echo $WhiteTebal . "Server             = " . $YellowTebal . "DOGE BOOST\n";
        sleep(2);
        echo $WhiteTebal . "Pendapatan         = " . $GreenTebal . "" . $pendapatan . " Doge\n";
        sleep(2);
        echo $WhiteTebal . "Pendapatan Mining  = " . $CyanTebal . "" . $mining . " Doge" . $White . " /Detik\n";
        sleep(2);
        echo $PinkTebal . "" . str_repeat("_", 50) . "\n\n";
        sleep(2);

        if ($mining > "0.001000") {
            wktClaim(5);
            $cl = claim($token2, array_merge(head(), array("referer: https://dogeboost.pro/dashboard")));
            sleep(2);
            echo $WhiteTebal . "Proses Claim " . $GreenTebal . "BERHASIL.!!!";
            sleep(2);
            echo "\r                                               \r";
            sleep(2);
        }

    endwhile;
}


/*
value="https://dogeboost.pro?referrer=34648"

https://dogeboost.pro/login" class="text-center" method="post" id="login">
                        <input type="hidden" name="_token" value="aREKrC9yW84UgG1YIFNBLyJtF6JzPkiXMlQqmvl9">                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="wallet" name="wallet" placeholder="Dogecoin Wallet" pattern="^\S+$" title="No spaces" required />
                            <label for="wallet" class="form-label">Dogecoin Wallet</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Password" />
                            <label for="password" class="form-label">Password</label>
                            <div id="validationServerPassword" class="invalid-feedback">
                                Invalid credentials
                            </div>
                        </div>
                        <button class="w-100 mb-2 btn btn-lg rounded-3 bg-theme fw-bold" type="submit">Login</button>
                        <small class="text-body-secondary">By clicking you agree to the terms of use.</small>
                        <input type="hidden" id="referrer" name="referrer" value="">

task=sign&json=eyJjdCI6IjhmUC9FVW96c1dNNE13enFyQlVNY0ZhbU1RVG80ak5peWpjcUcrY3MrUFpPQmwveWNrNlJ6dEVwUlVUeGkwZjd1eHh4cE5yTzdHRUw3WVM5ejNlMjd6RkRuRUI0YVhYMEtKRzM5dGp0UlVVVWdyWUY1bmtyZmhhR0VMU200VkNNZDB2WDRKUWlhTU5xanlmWFlvMDdMRG9FWU5ra29NUVVQQVJoUXc3MDQwZHlwTG1jSnNyOTRIeDFnQklDM3VZMDJ5YW00N2RHbkJZVGI5S281QVplMmFjamxRc21PT2cxTDRtUHBBTlFkV1ExQzFybzlmVzNWVU0veExiekFweFRTQzNrWkM0RzNJTC84ajY3emJFUnhjRUJBdC8xMjFxcCsvVGxzcE1GTlVPZ3ZSeHIxVkU4NW4wNVcwSlU1b09xQUNWNlZmdmI4b1JEbkhSYldjZW5NTExDZFB6UHluUTNDM1czTUp5QkpGZjVhRmphRXROT1hLR2lkNWVoTXozWjZnaDl4dHg3bjVzR2pJNnVCdzhubXc9PSIsIml2IjoiMWU1ZGY1ZDQ2NjNhZjYzODU4NjY1MGZiMzYyYjhkM2MiLCJzIjoiMDIwZDJiYjc5ZGJjYTI4YiJ9

task=sign&json=eyJjdCI6IldvOGV2Sm9WVDkrZzVtaUJMTERUSDNrWEg0K0xsblJva3lWR2Vkb01JZjRycEFybXgwcFM1eVhEY3RhakJETXhzeGVaamVDNStKTmZqWmN2TDJRYUhYTitteXhSRGxUWk1nYVQxWGNkUU1EblJuN3gxLzQ2cEZ2Y3FtbnNFTGlkVmtOTEdZaGFuZ2VqZ2g2ZUFPdFdTTk9zbGM5L1NMT1NGenNpbmoxQ0YrWmV1WG5YRW83azYvcVJBZGxYdDU0QjVqRXIwbmRiZTgwbCs3R05iK1FVYUdiWkxRczNDTUFvNU9jNFpQQ1NoWitTMjRrcHRKbEh0ZncyQ1owL1hXMDUyYmNuU2xzMC9WbHJjU3J2dTZoekswR0tzN3Y4OE1JVnRnSC8rN0FJUVZlMFVKSmlHWkx0ZVNJOU5GeFhQaHp1dFlIK0M3NFl3SVIrbUFBdThIZUhUbXU0TmcwUy9QYmRCWkt5Zitad28xWkE3dk81VGJvSG9hUGNGeGx3RjFYNkdHQlNxYkorM1BOcDdEYVRrZStEalE9PSIsIml2IjoiOThmMmQ0Yzc1YWU4MDc5Yjg3ZTZjYzBlYWFlNzU5NzciLCJzIjoiM2I2NWMzZWI4YmFmNzVlMCJ9




function test() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://ltcpayu.top/faucet/currency/ltc");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    $server_output = curl_exec ($ch);
    curl_close ($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return $httpcode;
}

function currency(){
    $url = "https://ltcpayu.top/faucet/currency/ltc";
    return curl($url,'',head())[1];
}

function claim($aft,$ctn,$tkn,$header){
    $url = "https://ltcpayu.top/faucet/verify/ltc";
    $data = http_build_query(array('auto_faucet_token'=>$aft,'csrf_token_name'=>$ctn,'token'=>$tkn));
    return curl($url,$data,$header)[1];
}


    $get = get();
    $email="dede.sulaiman2803@gmail.com";
    $token = explode('">',explode('<input type="hidden" name="csrf_token_name" id="token" value="',$get)[1])[0];
    $login=login($email,$token,array_merge(head(),array("referer: https://ltcpayu.top/")));
    sleep(5);
    $check = test();
    //echo $check;

if($check=="404"){
    echo $WhiteTebal. "Situs Website". $RedTebal." Tidak ada,".$WhiteTebal." coba periksa kembali". $YellowTebal."SITUS LINK WEBSITE..!!! ";
}else{
    while(true){
        for ($adaSolXyz = 0; $adaSolXyz < 25; $adaSolXyz++) {
            session_start();
            $currency = currency();
            echo $currency;
            
            $sttsBal = explode('</span></h6>',explode('<span class="badge badge-danger">',$currency)[1])[0];
            if($sttsBal == "Empty"){
                echo $WhiteTebal. "Server ". $YellowTebal . "PAYU TOP ". $WhiteTebal. "Coin Crypto ". $YellowTebal . "DOGE ". $RedTebal. "Sedang Kosong.".$WhiteTebal. "Tunggu Besok Lagi !!!";
                session_destroy();
            }
                    
            //===================================================================================================
            //===================================================================================================
            //===================================================================================================
                    
            $alert = explode(' text-center">',explode('<div class="alert alert-',$currency)[1])[0];
            if($alert == "danger"){
            echo $WhiteTebal. "Server ". $YellowTebal . "PAYU TOP ". $WhiteTebal. "Coin Crypto ". $YellowTebal . "DOGE ". $RedTebal. "Habis.".$WhiteTebal. "Tunggu Besok Lagi !!!\n\n";
                break;
            }else{
                    
                //====================================================================================================
                //====================================================================================================
                //====================================================================================================
                
                $aft = explode('">',explode('<input type="hidden" name="auto_faucet_token" value="',$currency)[1])[0];
                $ctn = explode('">',explode('<input type="hidden" name="csrf_token_name" id="token" value="',$currency)[1])[0];
                $tkn = explode('">',explode('<input type="hidden" name="token" value="',$currency)[1])[0];
                $timeClaim = explode(',',explode('let timer = ',$currency)[1])[0];
                $balance = explode('</p>',explode('<p class="lh-1 mb-1 font-weight-bold">',$currency)[1])[0];
                $totClaim = explode('</p>',explode('<p class="lh-1 mb-1 font-weight-bold">',$currency)[3])[0];
            
                echo $WhiteTebal ."SERVER        = ". $YellowTebal. "FEY PAYU TOP\n";
                sleep(2);
                wktClaim($timeClaim);
                sleep(2);
                $claim = claim($aft,$ctn,$tkn,array_merge(head(),array("Referer: https://ltcpayu.top/faucet/currency/ltc")));
                sleep(2);
                echo $WhiteTebal ."Selamat, claim ".$GreenTebal."BERHASIL.!!!";
                sleep(2);
                echo "\r                                                                \r";
                sleep(2);
                echo $WhiteTebal ."Telah dikirim = ". $GreenTebal. "".$balance."\n";
                sleep(2);
                echo $WhiteTebal ."Jumlah claim  = ". $CyanTebal. "".$totClaim."".$WhiteTebal." claim\n";
                sleep(2);
                echo $PurpleTebal ."". str_repeat("_",50)."\n\n";
            }
        }
        break;
    }
}
sleep(10);
*/
