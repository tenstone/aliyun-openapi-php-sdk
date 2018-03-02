<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace MetrichubCms\Request\V20180208;


class MetrichubCmsClient
{
    private $host;
    private $signature;

    private $accessId;
    private $accessSecret;

    private $headers;

    private $request;

    protected $queryParameters;


    function __construct($regionId, $accessId,$accessSecret)
    {
        $this->accessId = $accessId;
        $this->accessSecret = $accessSecret;

        $this->host = "metrichub-cms-cn-hangzhou.aliyuncs.com";
        $this->queryParameters = array();
    }

    protected function setRequest($request){
        $this->request = $request;
    }

    private function getRequestUrl(){
        return 'https://'.$this->host.$this->request->path;
    }

    private function computeSignature(){

        $bodymd5 = strtoupper(md5($this->request->getContent()));
        $stringToSign = $this->request->getMethod() . "\n" .
            $bodymd5 . "\n".
            $this->headers['Content-Type'] . "\n" .
            $this->headers['Date'] . "\n" .
            'x-cms-api-version:1.0'."\n".'x-cms-ip:192.168.1.1'."\n".'x-cms-signature:hmac-sha1'.
            $this->request->path;
        $this->signature = base64_encode(hash_hmac("sha1", $stringToSign, $this->accessSecret, true));
    }

    protected function getPostParameters(){
        return $this->postParameters;
    }

    protected function buildHeaders(){
        $this->headers = array(
            'Accept'=> "application/json",
            'Content-Type' => "application/json",
            'Content-Encoding' => "gzip",
            'x-cms-api-version' => '1.0',
            'Date' => gmdate("D, d M Y H:i:s \G\M\T"),
            'x-cms-signature' => 'hmac-sha1',
            'x-cms-ip'=>'192.168.1.1',
            'Content-MD5'=>md5($this->request->getContent()),
            'User-Agent'=>'metrichub-cms-php-sdk-v-1.0',
            'Authorization' => ''
        );
        $this->computeSignature();
        $this->headers['Authorization'] = "{$this->accessId}".":"."{$this->signature}";
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
            CURLOPT_URL => $this->getRequestUrl(),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => $headers
        );
        if ($this->request->getMethod() == 'POST') {
            $curl_opt[CURLOPT_POST] = true;
            $curl_opt[CURLOPT_POSTFIELDS] = $this->request->getContent();
        } else {
            $curl_opt[CURLOPT_HTTPGET] = true;
        }
        $request = curl_init();
        curl_setopt_array($request, $curl_opt);
        $res = curl_exec($request);
        curl_close($request);
        return $res;
    }

    public function getResponse($request){
        $this->setRequest($request);
        $this->buildHeaders();
        print_r($this->headers);
        return $this->httpRequest();
    }
}