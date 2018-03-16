<?php

namespace MetrichubCms\Request\V20180208;
use MetrichubCms\Request\V20180208\MetricName;
use MetrichubCms\Request\V20180208\Wrapper as Wrapper;

class MetricRegistry
{

    const RECORD_LEVEL_15S = 15;

    const RECORD_LEVEL_60S = 60;

    const RECORD_LEVEL_300S = 300;

    protected $counter;

    protected $timer;

    protected $levels;

    private function getLevels()
    {
        return [self::RECORD_LEVEL_60S,self::RECORD_LEVEL_300S];
    }

    function setLevel($levels)
    {
        $this->levels = $levels;
    }

    function counter(MetricName $metricName)
    {
        if(!is_object($this->counter)){
            $this->counter = new Wrapper\CounterWrapper($this->getLevels());
        }
        return $this->counter;
    }

    function build(MetricName $metricName)
    {

    }

    function histogram(MetricName $metricName)
    {

    }

    function timer(MetricName $metricName)
    {
        if(!is_object($this->timer)){
            $this->timer = new Wrapper\TimerWrapper($this->getLevels());
        }
        return $this->timer;
    }

    function meter(MetricName $metricName)
    {

    }

    function value(MetricName $metricName)
    {

    }

    function getMetrics()
    {

    }
}