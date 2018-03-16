<?php
namespace MetrichubCms\Request\V20180208\Wrapper;

use MetrichubCms\Request\V20180208\Wrapper\MetricWrapper;

class CounterWrapper extends MetricWrapper
{
    protected $count;

    public function inc($num){
        $this->count += $num;
    }

    public function dec($num){
        $this->count -= $num;
    }

    public function getCount(){
        $count = $this->count;
        $this->resetCount();
        return $count;
    }

    public function resetCount(){
        $this->count = 0;
    }


}