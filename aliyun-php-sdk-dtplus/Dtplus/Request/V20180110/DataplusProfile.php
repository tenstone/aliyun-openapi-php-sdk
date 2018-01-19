<?php
/**
 * Created by PhpStorm.
 * User: liuyuancheng
 * Date: 18/01/2018
 * Time: 6:26 PM
 */

namespace Dtplus\Request\V20180110;

class DataplusProfile extends \DefaultProfile
{

    private $dplusHost;
    private $apiPath;
    private $method;
    private $query;
    private $signature;

    private $dplusOrgCode;
    private $token;
    private $accessId;
    private $accessSecret;

    private $headers;

    protected $queryParameters;

    function __construct($accessId,$accessSecret, $request, $overLan=false)
    {
        $this->accessId = $accessId;
        $this->accessSecret = $accessSecret;

        if($overLan){
            $this->dplusHost = "http://dtplus-lan-cn-shanghai.data.aliyuncs.com";
        }
        $this->dplusHost = "http://dtplus-cn-shanghai.data.aliyuncs.com";
        $this->apiPath = "{$this->dplusHost}/{$this->dplusOrgCode}/";
        $this->queryParameters = array();
    }

    function initialize(){
    }

    function buildHeaders(){
        $this->headers = array(
            'Accept'=> "application/json",
            'Content-Type' => "application/json",
            'Content-Encoding' => "gzip",
            'Date' => gmdate("D, d M Y H:i:s \G\M\T"),
            'Authorization' => "Dataplus "."{$this->accessId}".":"."{$this->signature}",
        );
    }

    function buildHttpQuery(){
        $this->query = http_build_query($this->queryParameters);
    }

    function getRequestUrl(){
        return $this->apiPath .'?'. $this->query;
    }

    /**
     * generate signature
     *
     * @param $opt
     * @return
     */
     private function getSignature($opt){
        $body = gzencode(json_encode($opt['data']));
        if (empty($body)) {
            $bodymd5 = $body;
        } else {
            $bodymd5 = base64_encode(md5($body, true));
        }
        $stringToSign = $opt['method'] . "\n" . $this->headers['Accept'] . "\n" . $bodymd5 . "\n". $this->headers['Content-Type'] .
            "\n" . $this->headers['Date'] . "\n" . $this->getRequestUrl();
        $this->signature = base64_encode(hash_hmac("sha1", $stringToSign, $this->accessSecret, true));
    }

    function setMethod($method){
        $this->method = $method;
    }

    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    public function doAction(){
        $this->buildHeaders();
    }

    public function addHeader($headerKey, $headerValue)
    {
        $this->headers[$headerKey] = $headerValue;
    }

    public function getResponse(){
        $curl_opt = array(
            CURLOPT_URL => $this->getRequestUrl(),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $this->headers
        );
        if ($this->request->method == 'POST') {
            $curl_opt[CURLOPT_POST] = true;
            $curl_opt[CURLOPT_POSTFIELDS] = $body;
        } else {
            $curl_opt[CURLOPT_HTTPGET] = true;
        }
        $request = curl_init();
        curl_setopt_array($request, $curl_opt);
        $res = curl_exec($request);
        curl_close($request);
    }

}