<?php



function curl_get_contents($url, $charset="windows-1251", $proxy=false) {
    $ch = curl_init();
    if($ch) {
        curl_setopt($ch, CURLOPT_URL, $url);
        if($proxy != false) curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/html; charset=".$charset));
        $curl_scraped_page = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if(!strlen($err)) {
            return $curl_scraped_page;
        }
        else {
            return json_encode(array('ok'=> false, 'msg' => $err));
        }
    }
    return '';
}
?>