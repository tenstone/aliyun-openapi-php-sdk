<?php
/**
 * Created by PhpStorm.
 * User: liuyuancheng
 * Date: 18/01/2018
 * Time: 6:26 PM
 */

namespace Dtplus\Request\V20180110;

class DataplusClient
{

    private $dplusHost;
    private $query;
    private $signature;

    private $dplusOrgCode;
    private $accessId;
    private $accessSecret;

    private $headers;

    protected $queryParameters;
    private $request;
    private $requestBody;

    function __construct($accessId,$accessSecret, $dplusOrgCode,$overLan=false)
    {
        $this->accessId = $accessId;
        $this->accessSecret = $accessSecret;
        $this->dplusOrgCode = $dplusOrgCode;

        if($overLan){
            $this->dplusHost = "dtplus-lan-cn-shanghai.data.aliyuncs.com";
        }
        $this->dplusHost = "dtplus-cn-shanghai.data.aliyuncs.com";
        $this->queryParameters = array();
    }

    protected function setRequest($request){
        $this->request = $request;
    }

    protected function getPostParameters(){
        return $this->postParameters;
    }

    protected function buildHeaders(){
        $this->headers = array(
            'Accept'=> "application/json",
            'Content-Type' => "application/json",
            'Content-Encoding' => "gzip",
            'Date' => gmdate("D, d M Y H:i:s \G\M\T")
        );
        $this->computeSignature();
        $this->headers['Authorization'] = "Dataplus "."{$this->accessId}".":"."{$this->signature}";
    }

    private function getRequestUrl(){
        if(empty($this->request)){
            throw new \Exception('request cannot be null.');
        }
        $this->query = http_build_query($this->request->getQueryParameters());
        return empty($this->query) ? $this->request->path : $this->request->path.'?'. $this->query;
    }

    /**
     * generate signature
     *
     * @param $opt
     * @return
     */
     private function computeSignature(){

        if (empty($this->requestBody)) {
            $bodymd5 = '';
        } else {
            $this->requestBody = gzencode(json_encode($this->requestBody));
            $bodymd5 = base64_encode(md5($this->requestBody, true));
        }
        $stringToSign = $this->request->getMethod() . "\n" . $this->headers['Accept'] . "\n" . $bodymd5 . "\n". $this->headers['Content-Type'] .
            "\n" . $this->headers['Date'] . "\n" . $this->getRequestUrl();
        $this->signature = base64_encode(hash_hmac("sha1", $stringToSign, $this->accessSecret, true));
    }

    private function httpRequest(){
        $headers = array_map(
            function($key, $val){
                return $key.":".$val;
            },
            array_keys($this->headers),
            $this->headers
        );
        $curl_opt = array(
            CURLOPT_URL => $this->request->getProtocol().'://'.$this->dplusHost.$this->getRequestUrl(),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $headers
        );
        if ($this->request->getMethod() == 'POST') {
            $curl_opt[CURLOPT_POST] = true;
            $curl_opt[CURLOPT_POSTFIELDS] = $this->requestBody;
        } else {
            $curl_opt[CURLOPT_HTTPGET] = true;
        }
        $request = curl_init();
        curl_setopt_array($request, $curl_opt);
        $res = curl_exec($request);
        curl_close($request);
        return $res;
    }

    function setRequestBody(){
        $this->requestBody = $this->request->getContent();
    }

    public function getResponse($request){
        $this->setRequest($request);
        $this->setRequestBody();
        $this->buildHeaders();
        return $this->httpRequest();
    }

}