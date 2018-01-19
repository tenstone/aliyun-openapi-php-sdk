<?php
/**
 * Created by PhpStorm.
 * User: liuyuancheng
 * Date: 18/01/2018
 * Time: 6:26 PM
 */

namespace Dtplus\Request\V20180110;


class DataPlusSigner
{
    /**
     * generate signature
     *
     * @param $opt
     * @param $accessId
     * @param $accessSecret
     * @return
     */
    static function getSignature($opt,$header ,$accessSecret){
        $header = array(
            'Accept'=> "application/json",
            'Content-Type' => "application/json",
            'Content-Encoding' => "gzip",
            'Date' => gmdate("D, d M Y H:i:s \G\M\T"),
        );
        $url = parse_url($opt['url']);
        parse_str($url['query'], $query);
        if ($opt['query']) {
            $query = array_merge($query, $opt['query']);
        }
        $url['query'] = http_build_query($query);
        $body = gzencode(json_encode($opt['data']));
        if (empty($body)) {
            $bodymd5 = $body;
        } else {
            $bodymd5 = base64_encode(md5($body, true));
        }
        $path = $url['path'];
        if (!empty($query)) {
            $path = $path . '?' . $url['query'];
        }
        $stringToSign = $opt['method'] . "\n" . $header['Accept'] . "\n" . $bodymd5 . "\n". $header['Content-Type'] .
            "\n" . $header['Date'] . "\n" . $path;
        return base64_encode(hash_hmac("sha1", $stringToSign, $accessSecret, true));
    }
}