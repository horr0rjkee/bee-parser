<?php
error_reporting(E_ERROR | E_PARSE);

include "../base.php";
include "../vendor/simple_html_dom.php";

//$_METHOD = $_GET;



class BeBooClient {
    private $userID;
    private $token;

    function __construct($token, $userid) {
        $this->token = $token;
        $this->userID = $userid;
    }
    function __destruct() {

    }
    function getDialogsList($mode='', $filter='', $search='', $limit='', $openUser='') {
        $content = curl_get_contents("https://beboo.ru/fast/msg/corr?userId=".$this->userID."&s=".$this->token, "windows-1251");
        $content = iconv("windows-1251", "UTF-8", $content);
        $html = str_get_html($content);
        $info = array();



        foreach($html->find('li') as $li) {

            $photourl =  $li->find('a.user-item span.avatar-list img', 0)->attr['src'];
            if(!mb_strlen($photourl)) $photourl = '';

            array_push($info, array(
                'userID' => $li->attr['data-id'],
                'name'=> $li->find('a.user-item span.user-info span.user-name', 0)->plaintext,
                'age' => trim(str_replace(',', '', $li->find('a.user-item span.user-info span.user-age', 0)->plaintext)),
                'photourl' => $photourl
            ));
        }
        return $info;
    }
    function getMessagesList($fromUserId) {
        $content = curl_get_contents("https://beboo.ru/fast/msg/join?userId=".$this->userID."&s=".$this->token."&id=".$fromUserId, "windows-1251");
        $content = iconv("windows-1251", "UTF-8", $content);
        $html = str_get_html($content);

    }
}

$BeBooCli = new BeBooClient('023b8f59c3746ea92058dd7bb3ce35ca', '13271572');
echo json_encode($BeBooCli->getDialogsList());