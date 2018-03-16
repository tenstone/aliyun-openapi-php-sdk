<?php

namespace MetrichubCms\Request\V20180208;


class MetricName
{
    protected $name;
    protected $dimensions;

    static function build($name){
        return new MetricName();
    }

}