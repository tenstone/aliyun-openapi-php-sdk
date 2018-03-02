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
    public $path;

	function  __construct()
	{
		parent::__construct("MetrichubCms", "2018-02-08", "UploadCustomMetric", "metrichub-cms", "openAPI");
        $this->path = "/metric/custom/upload";
        $this->setMethod('POST');
        $this->setContent('[{"groupId":101,"metricName":"","dimensions":{"sampleName1":"value1","sampleName2":"value2"},"time":"","type":0,"period":60,"values":{"value":10.5,"Sum":100}}]');
    }

    private $groupId;

	private $metricName;

	private $dimensions;

	private $time;

	private $type;

	private $period;

	private $values;


    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
        $this->queryParameters["GroupId"]=$groupId;
    }

    public function getMetricName() {
        return $this->metricName;
    }

    public function setMetricName($metricName) {
        $this->metricName = $metricName;
        $this->queryParameters["metricName"]=$metricName;
    }

    public function getDimensions() {
        return $this->dimensions;
    }

    public function setDimensions($dimensions) {
        $this->dimensions = $dimensions;
        $this->queryParameters["dimensions"]=$dimensions;
    }


    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->dimensions = $time;
        $this->queryParameters["time"]=$time;
    }


    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->dimensions = $type;
        $this->queryParameters["type"]=$type;
    }

    public function getPeriod(){
        return $this->period;
    }

    public function setPeriod($period){
        $this->period = $period;
        $this->queryParameters["period"]=$period;
    }


    public function getValues(){
        return $this->values;
    }

    public function setValues($values){
        $this->period = $values;
        $this->queryParameters["values"]=$values;
    }
}