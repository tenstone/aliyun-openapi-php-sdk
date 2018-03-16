<?php
namespace MetrichubCms\Request\V20180208\Wrapper;


use MetrichubCms\Request\V20180208\Wrapper\MetricWrapper;

class TimerWrapper extends MetricWrapper
{

    function get_percentile($percentile, $array) {
        sort($array);
        $index = ($percentile/100) * count($array);
        if (floor($index) == $index) {
            $result = ($array[$index-1] + $array[$index])/2;
        }
        else {
            $result = $array[floor($index)];
        }
        return $result;    }

    function update($duration, $unit)
    {
        foreach ($this->metricList as $timer)
        {
            if(!is_null($timer)){
                $timer->update($duration, $unit);
            }
        }
    }

}