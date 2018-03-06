<?php
/**
 * Created by PhpStorm.
 * User: liuyuancheng
 * Date: 05/03/2018
 * Time: 10:36 PM
 */

namespace MetrichubCms\Request\V20180208;


class CustomMetric
{
    const PERIOD_15S = 15;

    const PERIOD_1M = 60;

    const PERIOD_5M = 300;

    const TYPE_VALUE = 0;

    const TYPE_AGG = 1;

    private $groupId;

    private $metricName;

    private $dimensions = array();

    private $time;

    private $type;

    private $period;

    private $values = array();


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

    public function setDimensions($dimensions) {
        if(!is_array($dimensions)){
            throw new \Exception('dimensions must be an array.');
        }
        $this->dimensions = $dimensions;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }


    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
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
        if(!is_array($values)){
            throw new \Exception('values must be an array.');
        }
        $this->values = $values;
    }

    public function appendDimension($key, $value){
        array_push($this->dimensions,array($key => $value));
    }

    public function appendValue($key, $value){
        array_push($this->values,array($key=>$value));
    }

    function buildArr(){
        return [
            'groupId' => $this->getGroupId(),
            'period'  => $this->getPeriod(),
            'values'  => $this->getValues(),
            'type'    => $this->getType(),
            'time'    => $this->getTime(),
            'dimensions'=>$this->getDimensions(),
            'metricName'=>$this->getMetricName()
        ];
    }
}