<?php

namespace BaoKim\BaokimSdk;

require_once(__DIR__ . '/../config/config.php');

use BaoKim\BaokimSdk\Helpers\Common;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class Connect {

    public function createOrder($data) {
        $Common = new Common();
        $jwt = getRequirement::$_jwt;
        try{
            $header = [
                'jwt' => 'Bearer '.$jwt,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $rs = $Common->requestAPI('POST', API_URL.'/payment/api/v5/order/send', $header, [], $data);
            $responseMassage = $rs->body->message;
            $dataRespone = [
                'responseCode' => 01,
                'responseMessage' => ($responseMassage) ? $responseMassage: ''
            ];
            if ($rs->body->code == 0) {
                $dataRespone['data']['order_id'] = $rs->body->data->order_id;
                $dataRespone['data']['paymentUrl'] = $rs->body->data->payment_url;
            }
            return $dataRespone;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getBpmList($data) {
        $Common = new Common();
        $jwt = getRequirement::$_jwt;
        try{
            $header = [
                'jwt' => 'Bearer '.$jwt,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $rs = $Common->requestAPI('GET', API_URL.'/payment/api/v5/bpm/list', $header, [], $data);
            $responseMassage = $rs->body->message;
            $dataRespone = [
                'responseCode' => 01,
                'responseMessage' => ($responseMassage) ? $responseMassage: ''
            ];
            if ($rs->body->code == 0) {
                $dataRespone['data'] = $rs->body->data;
            }
            return $dataRespone;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
