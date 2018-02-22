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

class UploadCustomMetricRequest extends \RpcAcsRequest
{
    # http://php.net/manual/zh/class.iteratoraggregate.php
    # http://docs.amazonaws.cn/AWSEC2/latest/WindowsGuide/GetSingleMetricAllDimensions.html 聚合

	function  __construct()
	{
		parent::__construct("MetrichubCms", "2018-02-08", "UploadCustomMetric", "metrichub-cms", "openAPI");
		$this->setMethod('POST');
		$this->setPath('/metric/custom/upload');
	}

    private $groupId;

	private $metricName;

	private $time;

	private $type;

	private $period;

    private $dimensions;

    private $values;


    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function getMetricName() {
        return $this->metricName;
    }

    public function setMetricName($metricName) {
        $this->metricName = $metricName;
    }

    public function getDimensions() {
        return $this->dimensions;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->dimensions = $time;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->dimensions = $type;
    }

    public function getPeriod(){
        return $this->period;
    }

    public function setPeriod($period){
        $this->period = $period;
    }


    public function getValues(){
        return $this->values;
    }

    public function setValues($values){
        $this->values = $values;
    }

    public function setDimensions($dimensions) {
        $this->dimensions = $dimensions;
    }

    public function appendValue($value){
        array_push($this->values,$value);
    }

    public function appendDimension($dimension) {
        array_push($this->dimensions, $dimension);
    }

    public function build() {
        $buildData = json_encode(array(
            "groupId"=>$this->getGroupId(),
            "metricName"=>$this->getMetricName(),
            "dimensions"=>$this->getDimensions(),
            "time"=>$this->getTime(),
            "type"=>$this->getType(),
            "period"=>$this->getPeriod(),
            "values"=>$this->getValues()
        ));
        $this->setContent($buildData);
        $this->addHeader('Content-Type','application/json');
        $this->addHeader('Content-MD5',strtoupper(md5($buildData)));
        $this->addHeader('Authorization','LTAIsk0qFRkhyL2Q:xi7FP7EFafFV3CNUO0G2HAOzvSRAPi');
        $this->addHeader('Date',gmdate("D, d M Y H:i:s \G\M\T"));
        $this->addHeader('x-cms-api-version','1.0');
        $this->addHeader('x-cms-signature','hmac-sha1');
        $this->addHeader('x-cms-ip','127.0.0.1');
    }
}