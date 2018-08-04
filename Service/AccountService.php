<?php
namespace zys5210\baiduSem\Service;
use yii\base\Component;

class AccountService extends Component
{
    public $token;
    public $manager;
    public $subAccount;

    const BASE_API_URL = 'https://api.baidu.com/json/sms/v3/AccountService/getAccountInfo';
    public function send($mobile, $content)
    {
        $data = [
            'apikey' => $this->apikey,
            'mobile' => $mobile,
            'text' => $content
        ];

        $result = $this->httpCurl(self::SINGLE_SEND_URL, $data);
        $json = json_decode($result);
        if ($json && is_object($json)) {
            $this->state = isset($json->code) ? (string) $json->code : null;
            $this->message = isset($json->msg) ? (string) $json->msg : null;
        }
        return $this->state === '0';
    }

    public static function httpCurl($url, $data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.baidu.com/json/product/version/ServiceName/MethodName" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_POST,           true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $data );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=utf-8'));
		$result=curl_exec ($ch);
		curl_close($ch);
        return $result;
    }

}
