<?php
namespace MetrichubCms\Request\V20180208\Wrapper;


class MetricWrapper
{
    protected $metricList;



    public function __construct($levels)
    {
        $this->metricList = array(count($levels));
    }

    protected function getMetricList(){
        return $this->metricList;
    }

    public function getMetricByRecordLevel(){

    }

}