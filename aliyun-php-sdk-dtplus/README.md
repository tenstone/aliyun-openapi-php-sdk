# 介绍
## 当前版本局限
数加平台的接口规范与阿里云OpenAPI不同，此版本（V20180110）在DataplusClient类中重新实现了aliyun-php-sdk-core的某些功能，待未来数加API纳入阿里云OpenAPI体系后，会按OpenAPI规范重新实现。

## 代码示例

```php
include_once './aliyun-php-sdk-core/Config.php';
use Dtplus\Request\V20180110 as Dtplus;
$ak_id = '<填写你的AccessKeyID>';
$ak_secret = '<填写你的AccessKeySecret>';
$dplusOrgCode = '<填写你的dplusOrgCode>';

function testUpdatelog(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\UploadlogRequest();
    $logs = array(
        json_encode(array("action" => "login", "user_id" => "0", "tags" =>"{'age':'1','gender':'1'}")),
        json_encode(array("action" => "item", "item_id" => "1", "category" =>"1")),
        json_encode(array("action" => "click", "user_id" => "0", "item_id" =>"0")),
    );
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret,$dplusOrgCode);
    $request->setBusinessName('recommend');
    $request->setCustomerName('movie_recommend');
    $request->setToken('alidata91c57337f6d0d84f677d2e3ac');
    $request->setContent($logs);
    $response = $client->getResponse($request);
    print_r($response);
}

function testDoRec(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\DoRecRequest();
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret, $dplusOrgCode);
    $request->setBizCode('movie_recommend');
    $request->setScnCode('Movie_recommend');
    $request->setRecnum('10');
    $response = $client->getResponse($request);
    print_r($response);
}

function testEtl(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\EtlRequest();
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret, $dplusOrgCode);
    $request->setBizCode('movie_recommend');
    $request->setDs("");
    $response = $client->getResponse($request);
    print_r($response);
}

function testTask(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\TasksRequest();
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret, $dplusOrgCode);
    $request->setBizCode('movie_recommend');
    $request->setDs("");
    $request->setScnCode("Movie_recommend");
    $request->setContainImport(true);
    $response = $client->getResponse($request);
    print_r($response);
}

function testStatus(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\StatusRequest();
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret, $dplusOrgCode);
    $request->setTaskId('63469');
    $response = $client->getResponse($request);
    print_r($response);
}

function testIndex(){
    global $ak_id;
    global $ak_secret;
    global $dplusOrgCode;
    $request = new Dtplus\IndexRequest();
    $client = new Dtplus\DataplusClient($ak_id, $ak_secret, $dplusOrgCode);
    $request->setBizCode('movie_recommend');
    $request->setDs("");
    $response = $client->getResponse($request);
    print_r($response);
}
echo "\ntesting doRec\n";
testDoRec();
echo "\ntesting Updatelog\n";
testUpdatelog(); //pass
echo "\ntesting Etl\n";
testEtl();
echo "\ntesting Task\n";
testTask();
echo "\ntesting Status\n";
testStatus();
echo "\ntesting Index\n";
testIndex();
echo "\n";
```

## 参考文档
[1][数加API鉴权规范](https://help.aliyun.com/document_detail/30245.html)

[2][推荐引擎API说明3.0](https://help.aliyun.com/document_detail/54472.html?spm=5176.doc54456.6.569.UTpGIx)