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

use MetrichubCms\Request\V20180208\CustomMetric;

class UploadCustomMetricRequest extends \RpcAcsRequest
{
    public $path;

    private $customMetricArr = array();

	function  __construct()
	{
		parent::__construct("MetrichubCms", "2018-02-08", "UploadCustomMetric", "metrichub-cms", "openAPI");
        $this->path = "/metric/custom/upload";
        $this->setMethod('POST');
//        $this->setContent('[{"groupId":101,"metricName":"x","dimensions":{"sampleName1":"value1","sampleName2":"value2"},"time":"","type":0,"period":60,"values":{"value":10.5,"Sum":100}}]');
    }

    function append(CustomMetric $customMetric){
	    array_push($this->customMetricArr, $customMetric->buildArr());
    }

    function buildBody(){
        $this->setContent(json_encode($this->customMetricArr));
    }

}